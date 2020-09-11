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

    public function getPresenceOnDate($jadwal_id, $mhs_tahun = '', $date = '')
    {
        $date = $date ?: now()->toDateString();
        $absens = DB::select("SELECT absensi.id, absensi.keterangan, absensi.created_at,
                mahasiswas.id as mahasiswa_id, mahasiswas.nim, users.first_name, users.last_name, mahasiswas.tahun, 
                mahasiswas.kelas, mahasiswas.gender, 
                matkuls.nama, 
                jadwals.start_at, jadwals.finish_at
                FROM (SELECT * FROM absensi WHERE created_at BETWEEN '$date 00:00:00' AND '$date 23:59:00') AS absensi 
                RIGHT JOIN mahasiswas ON mahasiswas.id = absensi.mahasiswa_id
                RIGHT JOIN users ON users.id = mahasiswas.user_id
                RIGHT JOIN jadwals ON absensi.jadwal_id = jadwals.id
                RIGHT JOIN matkuls ON jadwals.matkul_id = matkuls.id
                WHERE jadwals.id = $jadwal_id AND mahasiswas.tahun LIKE '%$mhs_tahun%'
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

    public function setPresenceToday(Jadwal $jadwal, Mahasiswa $mahasiswa, $kode)
    {
        if (!$jadwal->mahasiswas->contains('id', $mahasiswa->id)) return;
        if ($jadwal->kode_absen != $kode) return;

        $today = Carbon::today();
        
        if ($jadwal->day != $today->formatLocalized('%w')) return;// %A %a for day name
        $jadwaltime = [Carbon::createFromFormat("H:i", $jadwal->start_time), Carbon::createFromFormat("H:i", $jadwal->finish_time)];
        $now = Carbon::now();
        if ($jadwaltime[0] < $now && $jadwaltime[1] > $now) {
            $keterangan = 'hadir';
        } else $keterangan = '';

        $absen = $this->model->whereDate('created_at', $today)
        ->where('mahasiswa_id', '=', $mahasiswa->id)
        ->where('jadwal_id', '=', $jadwal->id)
        ->get()->first();

        // return $keterangan;

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

    public function setPresenceOnDate(Mahasiswa $mahasiswa, $keterangan, $date)
    {
        // $date = Carbon::createFromFormat('Y-m-d', $date);
        // $today = $this->model->whereDate('created_at', $date)
        // ->where('mahasiswa_id', '=', $mahasiswa->id)
        // ->get()->first();
        // // override keterangan
        // if ($today) {
        //     $today->update(['keterangan' => $keterangan]);
        // } else {
        //     $today = $this->model->insert([
        //         'mahasiswa_id' => $mahasiswa->id,
        //         'keterangan' => $keterangan,
        //         'created_at' => $date
        //     ]);
        // }
        // return $today;
    }
}
