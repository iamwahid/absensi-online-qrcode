<?php

namespace App\Models;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mahasiswa.
 */
class Mahasiswa extends Model
{

  protected $fillable = [
    'user_id',
    'nim',
    'tahun',
    'kelas',
    'gender',
    'alamat'
  ];

  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function absensi()
  {
    return $this->hasMany(Absensi::class, 'mahasiswa_id')->orderBy('created_at', 'desc');
  }

  public function jadwals()
  {
    return $this->belongsToMany(Jadwal::class, 'mahasiswa_has_jadwals', 'mahasiswa_id', 'jadwal_id');
  }

  public function getJadwalTodayAttribute()
  {
    $day = (string) \Carbon\Carbon::now()->dayOfWeek;
    return $this->jadwals->filter(function($d) use($day){
      return (string) $d->day == $day;
    });
  }

  public function scopeBulan($query, $bulan = 1)
  {
      return $query->where('created_at', now());
  }

  public function getActionsAttribute()
    {
        $show = route('admin.mahasiswa.show', $this->id);
        $edit = route('admin.mahasiswa.edit', $this->id);
        $delete = route('admin.mahasiswa.delete', $this->id);
        $html = '';
        $html = '<div class="btn-group">'.
        // '<a href="'.$show.'" class="btn btn-primary">Lihat</a>'.
        '<a href="'.$edit.'" class="btn btn-sm btn-pill btn-success">Edit</a>'.
        '<button type="button" onclick="deleteItem(\''.$delete.'\')" class="btn btn-sm btn-pill btn-danger">Delete</button>'.
        '</div>';

        return $html;
    }

    public function getTodayPresenceAttribute()
    {
      return $this->absensi()->whereDate('created_at', Carbon::today())->get()->first();
    }
}
