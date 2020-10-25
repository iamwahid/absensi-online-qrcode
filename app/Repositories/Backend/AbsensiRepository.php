<?php

namespace App\Repositories\Backend;

use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;

/**
 * Class AbsensiRepository.
 */
class AbsensiRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Absensi::class;
    }

    public function getPresenceOnDate($jadwal_id, $date = '', $kelas = '')
    {
        $date = $date ?: now()->toDateString();
        $absens = DB::select("SELECT absensi.id, absensi.keterangan, absensi.created_at,
                mahasiswas.id as mahasiswa_id, mahasiswas.nim, users.first_name, users.last_name, mahasiswas.tahun, 
                mahasiswas.kelas, mahasiswas.gender, 
                matkuls.nama, 
                jadwals.id as jadwal_id, jadwals.start_at, jadwals.finish_at
                FROM (SELECT * FROM absensi WHERE created_at BETWEEN '$date 00:00:00' AND '$date 23:59:00') AS absensi 
                RIGHT OUTER JOIN mahasiswas ON mahasiswas.id = absensi.mahasiswa_id
                LEFT JOIN users ON users.id = mahasiswas.user_id
                LEFT JOIN mahasiswa_has_jadwals ON mahasiswas.id = mahasiswa_has_jadwals.mahasiswa_id
                LEFT JOIN jadwals ON mahasiswa_has_jadwals.jadwal_id = jadwals.id
                LEFT JOIN matkuls ON jadwals.matkul_id = matkuls.id
                WHERE jadwals.id = $jadwal_id AND mahasiswas.kelas LIKE '%$kelas%'
                ORDER BY mahasiswa_id
                ");
        return $absens;
    }

    public function getPresenceOnJadwal($jadwal_id, $mhs_id)
    {
        $absens = DB::select("SELECT absensi.id, absensi.keterangan, absensi.created_at,
                mahasiswas.id as mahasiswa_id, mahasiswas.nim, users.first_name, users.last_name, mahasiswas.tahun, 
                mahasiswas.kelas, mahasiswas.gender, 
                matkuls.nama, 
                jadwals.start_at, jadwals.finish_at
                FROM absensi 
                RIGHT JOIN mahasiswas ON mahasiswas.id = absensi.mahasiswa_id
                RIGHT JOIN users ON users.id = mahasiswas.user_id
                RIGHT JOIN jadwals ON absensi.jadwal_id = jadwals.id
                RIGHT JOIN matkuls ON jadwals.matkul_id = matkuls.id
                WHERE jadwals.id = $jadwal_id AND mahasiswa_id = $mhs_id
                ORDER BY mahasiswa_id
                ");
        return $absens;
    }

    public function setPresenceOnDate(Jadwal $jadwal, Mahasiswa $mahasiswa, $keterangan, $kode, $date = '')
    {
        if (!$jadwal->mahasiswas->contains('id', $mahasiswa->id)) return;
        if ($jadwal->kode_absen != $kode) return;
        
        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();
        
        if ($jadwal->isAvailable($date)) {
            $keterangan = 'hadir';
        } else $keterangan = '';

        $absen = $this->model->whereDate('created_at', $date)
        ->where('mahasiswa_id', '=', $mahasiswa->id)
        ->where('jadwal_id', '=', $jadwal->id)
        ->get()->first();

        if ($absen) {
            $absen->update(['keterangan' => $keterangan]);
        } else {
            $absen = $this->create([
                'mahasiswa_id' => $mahasiswa->id,
                'jadwal_id' => $jadwal->id,
                'keterangan' => $keterangan,
            ]);
        }

        return $absen;
    }
}
