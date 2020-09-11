<?php

namespace App\Repositories\Backend;

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
}
