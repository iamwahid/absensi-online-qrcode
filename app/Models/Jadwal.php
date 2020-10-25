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
        // 'room',
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

    public function hasMhsAbsensi($mahasiswa_id)
    {
        return $this->absensi()->where('mahasiswa_id', '=', $mahasiswa_id)->first();
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

    public function getDaynameAttribute()
    {
        return dayname($this->day);
    }

    public function getActionsAttribute()
    {
        $show = route('admin.jadwal.show', $this->id);
        $edit = route('admin.jadwal.edit', $this->id);
        $delete = route('admin.jadwal.delete', $this->id);
        $mahasiswa = route('admin.jadwal.mahasiswa', $this->id);
        $absensi = route('admin.jadwal.absensi.index', $this->id);
        $genqr = route('frontend.genqr', $this->qr_code->plain);
        $html = '';
        $html = '<div class="btn-group">'.
        '<a href="'.$absensi.'" class="btn btn-sm btn-primary">Absensi</a>'.
        '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"></button>'.
        '<ul class="dropdown-menu" role="menu">'.
        '<a href="'.$genqr.'" target="_blank" class="dropdown-item">QR link</a>'.
        '<a href="'.$mahasiswa.'" class="dropdown-item">Atur Mahasiswa</a>'.
        '<a href="'.$edit.'" class="dropdown-item">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="dropdown-item">Delete</button>'.
        '</ul></div>';

        if (!auth()->user()->isAdmin()) {
            $html = '<a href="'.$genqr.'" target="_blank" class="btn btn-sm btn-primary">QR Link</a>';
        }

        return $html;
    }

    public function isAvailable(\Carbon\Carbon $date = null) : bool
    {
        $date = $date ? $date : \Carbon\Carbon::now();
        if ($this->day != $date->formatLocalized('%w')) return false;// %A %a for day name
        $jadwaltime = [\Carbon\Carbon::createFromFormat("H:i", $this->start_time), \Carbon\Carbon::createFromFormat("H:i", $this->finish_time)];
        if (!($jadwaltime[0] < $date && $jadwaltime[1] > $date)) return false;
        return true;
    }

    public function generateKode()
    {
        if ($this->isAvailable()) {
            $this->attributes['kode_absen'] = \Str::random(10);
            $this->save();
        }
    }

    public function getStrigableAttribute()
    {
        $string = "[$this->matkul_id => $this->dosen_id] $this->room at $this->start_time - $this->finish_time";
        return $string;
    }

    public function getAsTextAttribute()
    {
        $string = $this->matkul->nama .', '. $this->dosen->user->name .', '.$this->dayname.' '."$this->start_time - $this->finish_time";
        return $string;
    }

    public function getQrCodeAttribute()
    {
        $string_code = base64_encode($this->id .'_'. $this->matkul_id .'_'. $this->kode_absen);
        return barcode_class($string_code, 'QRCODE', 5, 5);
    }
}
