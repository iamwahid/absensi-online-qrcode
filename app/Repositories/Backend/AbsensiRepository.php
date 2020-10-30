<?php

namespace App\Repositories\Backend;

use App\Export\AbsensiExport;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class AbsensiRepository.
 */
class AbsensiRepository extends BaseRepository
{
    protected $total_pertemuan = 14;
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
                mahasiswas.id as mahasiswa_id, mahasiswas.nim, CONCAT(users.first_name, ' ', users.last_name) as mahasiswa_nama, mahasiswas.tahun, 
                mahasiswas.kelas, mahasiswas.gender, 
                matkuls.nama, 
                jadwals.id as jadwal_id, jadwals.start_at, jadwals.finish_at
                FROM (SELECT * FROM absensi WHERE created_at BETWEEN '$date 00:00:00' AND '$date 23:59:00' AND jadwal_id = $jadwal_id) AS absensi 
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

    public function absensiData($jadwal_id, $kelas = '')
    {
        $jadwal = Jadwal::find($jadwal_id);
        $total_pertemuan = $this->total_pertemuan;

        $added = $jadwal->created_at;
        $days = [];
        
        //find start day
        while ($added->dayOfWeek !== (int)$jadwal->day) {
            $added = $added->addDay();
        }

        $whereBetweens = '';
        for ($i=0; $i < $total_pertemuan; $i++) { 
            $added = $added->addDays(7);
            $days[] = $added;
            $start = $added->startOfDay()->format('Y-m-d H:i:s');
            $end = $added->endOfDay()->format('Y-m-d H:i:s');
            if ($i>0) $whereBetweens .= " UNION ALL ";
            $whereBetweens .= "SELECT absensi.id, absensi.keterangan, absensi.created_at,
            mahasiswas.id as mahasiswa_id, mahasiswas.nim, CONCAT(users.first_name, ' ', users.last_name) as nama_mahasiswa,
            mahasiswas.tahun, mahasiswas.kelas, mahasiswas.gender, 
            matkuls.nama as mata_kuliah, 
            jadwals.start_at, jadwals.finish_at
            FROM (SELECT * FROM absensi WHERE created_at BETWEEN '$start' AND '$end' AND jadwal_id = $jadwal_id) AS absensi 
            RIGHT OUTER JOIN mahasiswas ON mahasiswas.id = absensi.mahasiswa_id
            LEFT JOIN users ON users.id = mahasiswas.user_id
            LEFT JOIN mahasiswa_has_jadwals ON mahasiswas.id = mahasiswa_has_jadwals.mahasiswa_id
            LEFT JOIN jadwals ON mahasiswa_has_jadwals.jadwal_id = jadwals.id
            LEFT JOIN matkuls ON jadwals.matkul_id = matkuls.id
            WHERE jadwals.id = $jadwal_id AND mahasiswas.kelas LIKE '%$kelas%'";
        }

        $whereBetweens .= " ORDER BY mahasiswa_id";

        $absensi_jadwal = DB::select($whereBetweens);

        $absensi_grouped = [];
        $hari = 1;
        $prev_id = -1;
        $idx = 0;
        foreach ($absensi_jadwal as $row) {
            if ($row->mahasiswa_id != $prev_id && $prev_id > -1) {
                $hari = 1;
                $idx++;
            }

            if ($hari === 1) {
                $absensi_grouped[$idx]['mahasiswa_id'] = $row->mahasiswa_id;
                $absensi_grouped[$idx]['nim'] = $row->nim;
                $absensi_grouped[$idx]['nama_mahasiswa'] = $row->nama_mahasiswa;
                $absensi_grouped[$idx]['mata_kuliah'] = $row->mata_kuliah;
                $absensi_grouped[$idx]['start_at'] = $row->start_at;
                $absensi_grouped[$idx]['finish_at'] = $row->finish_at;
            }

            $absensi_grouped[$idx]['p_'.$hari] = $row->keterangan;
            $hari++;
            $prev_id = $row->mahasiswa_id;
        }

        return collect($absensi_grouped);

    }

    public function exportExcel($jadwal, $kelas='')
    {
        $matkul = $jadwal->matkul->nama;
        return Excel::download(new AbsensiExport($this->absensiData($jadwal->id, $kelas), $this->total_pertemuan), 'Data Absensi-'.$matkul.'-'.\Carbon\Carbon::now()->format('d-m-Y').'.xlsx');
    }

    public function setPresenceOnDate(Jadwal $jadwal, Mahasiswa $mahasiswa, $keterangan, $kode, $date = '')
    {
        if (!$jadwal->mahasiswas->contains('id', $mahasiswa->id)) return;
        if ($jadwal->kode_absen != $kode) return;

        $date = $date ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();
        if (in_array((int) $date->formatLocalized('%w'), [0, 6])) return;

        $isAvail = $jadwal->isAvailable($date);
        $keterangan = '';
        if ($isAvail === 0) {
            $keterangan = 'hadir';
        } else if ($isAvail > 0) {
            $keterangan = 'terlambat';
        } else return;

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
