<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class MataKuliah extends Model
{
    public $table = 'matkuls';
    protected $fillable = [
        'nama',
        'sks',
        'deskripsi'
    ];

    public $timestamps = false;

    public function dosens()
    {
        return $this->belongsToMany(Dosen::class, 'dosen_has_matkuls', 'matkul_id', 'dosen_id');
    }

    public function getActionsAttribute()
    {
        $show = route('admin.mata_kuliah.show', $this->id);
        $edit = route('admin.mata_kuliah.edit', $this->id);
        $delete = route('admin.mata_kuliah.delete', $this->id);
        $dosen = route('admin.mata_kuliah.dosen', $this->id);
        $html = '';
        $html = '<div class="btn-group">'.
        // '<a href="'.$show.'" class="btn btn-primary">Lihat</a>'.
        '<a href="'.$dosen.'" class="btn btn-sm btn-pill btn-primary">Atur Dosen</a>'.
        '<a href="'.$edit.'" class="btn btn-sm btn-pill btn-success">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-sm btn-pill btn-danger">Delete</button>'.
        '</div>';

        return $html;
    }
}
