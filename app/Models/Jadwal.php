<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'matkul_id',
        'dosen_id',
        'start_at',
        'finish_at',
        'room',
        'deskripsi',
        'kode_absen'
    ];

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'mahasiswa_has_jadwals', 'jadwal_id', 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function matkul()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'jadwal_id');
    }

    public function getStartTimeAttribute()
    {
        return explode(' ', $this->attributes['start_at'])[1]; 
    }

    public function getFinishTimeAttribute()
    {
        return explode(' ', $this->attributes['finish_at'])[1]; 
    }

    public function getDayAttribute()
    {
        return explode(' ', $this->attributes['start_at'])[0];
    }

    public function getActionsAttribute()
    {
        $show = route('admin.jadwal.show', $this->id);
        $edit = route('admin.jadwal.edit', $this->id);
        $delete = route('admin.jadwal.delete', $this->id);
        $mahasiswa = route('admin.jadwal.mahasiswa', $this->id);
        $html = '';
        $html = '<div class="btn-group">'.
        '<a href="'.$mahasiswa.'" class="btn btn-sm btn-primary">Atur Mahasiswa</a>'.
        '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"></button>'.
        '<ul class="dropdown-menu" role="menu">'.
        '<a href="'.$edit.'" class="dropdown-item">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="dropdown-item">Delete</button>'.
        '</ul></div>';

        return $html;
    }

    public function generateKode()
    {
        $this->attributes['kode_absen'] = \Str::random(10);
        $this->save();
    }

    public function getStrigableAttribute()
    {
        $string = "[$this->matkul_id => $this->dosen_id] $this->room at $this->start_time - $this->finish_time";
        return $string;
    }

    public function getQrCodeAttribute()
    {
        return barcode_class($this->attributes['kode_absen'], 'QRCODE', 5, 5);
    }
}
