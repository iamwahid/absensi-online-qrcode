<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Dosen extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'alamat',
        'gender',
        'no_hp'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matkuls()
    {
        return $this->belongsToMany(MataKuliah::class, 'dosen_has_matkuls', 'dosen_id', 'matkul_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'dosen_id');
    }

    public function getActionsAttribute()
    {
        $show = route('admin.dosen.show', $this->id);
        $edit = route('admin.dosen.edit', $this->id);
        $delete = route('admin.dosen.delete', $this->id);
        $html = '';
        $html = '<div class="btn-group">'.
        // '<a href="'.$show.'" class="btn btn-primary">Lihat</a>'.
        '<a href="'.$edit.'" class="btn btn-sm btn-pill btn-success">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-sm btn-pill btn-danger">Delete</button>'.
        '</div>';

        return $html;
    }
}
