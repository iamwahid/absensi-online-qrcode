<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Santri;
use App\Repositories\Frontend\AbsensiRepository;
use App\Repositories\Frontend\SantriRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected $absensi;

    public function __construct(AbsensiRepository $absensi)
    {
        $this->absensi = $absensi;
    }

    public function index()
    {
        $date = request()->get('date') ?: '';
        $kelas = request()->get('kelas') ?: '';
        $date_string = $date ? 'Tanggal : '.Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') : 'Hari ini : '.Carbon::now()->format('d M Y');
        $absensi = $this->absensi->getPresenceOnDate($date, $kelas);
        return view('frontend.absensi.index', ['absensi' => $absensi, 'date_string' => $date_string, 'date' => $date ? $date : Carbon::now()->format('Y-m-d')]);
    }
}
