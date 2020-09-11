<?php

namespace App\Repositories\Backend;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Repositories\BaseRepository;

/**
 * Class DosenRepository.
 */
class DosenRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Dosen::class;
    }

    public function giveMatkulToDosens(array $dosen_ids, MataKuliah $matkul)
    {
        foreach ($dosen_ids as $d) {
            $dosen = $this->getById($d);

            // if ($dosen->matkuls->count() > 0)  {
            //     if (!$dmatkul = $dosen->matkuls->where('matkul_id', $matkul->id)->first()) {
            //         $dosen->matkuls()->create(['matkul_id' => $matkul->id]);
            //     }
            // } else {
            // }
            $dosen->matkuls()->sync(['matkul_id' => $matkul->id]);
            $dosen->save();
        }
    }
}
