<?php

namespace App\Repositories\Backend;

use App\Models\Jadwal;
use App\Repositories\BaseRepository;

/**
 * Class JadwalRepository.
 */
class JadwalRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Jadwal::class;
    }

    public function giveMatkulToDosens(array $dosen_ids, Jadwal $matkul)
    {
        // $matkul->dosens()->sync($dosen_ids);
    }
}
