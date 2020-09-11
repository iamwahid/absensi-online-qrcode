<?php

namespace App\Repositories\Backend;

use App\Models\MataKuliah;
use App\Repositories\BaseRepository;

/**
 * Class MataKuliahRepository.
 */
class MataKuliahRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return MataKuliah::class;
    }

    public function giveMatkulToDosens(array $dosen_ids, MataKuliah $matkul)
    {
        $matkul->dosens()->sync($dosen_ids);
    }
}
