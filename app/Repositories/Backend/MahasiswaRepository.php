<?php

namespace App\Repositories\Backend;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Repositories\BaseRepository;

/**
 * Class MahasiswaRepository.
 */
class MahasiswaRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Mahasiswa::class;
    }

    public function filterByMatkul(Jadwal $jadwal, $matkul_id)
    {
        return $this->model->whereHas('jadwals', function($q) use ($jadwal){
            return $q->where('id', $jadwal->id);
        })
        ->orWhereDoesntHave('jadwals', function($q) use($matkul_id) {
            return $q->where('matkul_id', '=', $matkul_id);
        })->orderBy('kelas')->get();
    }
}
