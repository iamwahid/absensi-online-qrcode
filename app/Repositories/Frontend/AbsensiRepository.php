<?php

namespace App\Repositories\Frontend;

use App\Models\Absensi;
use App\Models\Santri;
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

    public function getPresenceOnDate($date = '', $kelas = '')
    {
        // $date = $date ?: now()->toDateString();
        // $today = DB::select("SELECT absensi.id, santris.id as santri_id, santris.nama, santris.no, santris.kelas, santris.kelas_umum, santris.gender, santris.jilid, absensi.keterangan, absensi.created_at 
        //         FROM (SELECT * FROM absensi WHERE created_at BETWEEN '$date 00:00:00' AND '$date 23:59:00') AS absensi 
        //         RIGHT JOIN santris ON santris.id = absensi.santri_id
        //         WHERE santris.kelas LIKE '%$kelas%'
        //         ORDER BY kelas, santri_id
        //         ");

        // return $today;
    }
}
