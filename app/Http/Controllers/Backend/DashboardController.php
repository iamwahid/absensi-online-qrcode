<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\AbsensiRepository;
use App\Repositories\Backend\MahasiswaRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{

    protected $absensi;
    protected $mahasiswa;

    public function __construct(AbsensiRepository $absensi, MahasiswaRepository $mahasiswa)
    {
        $this->absensi = $absensi;
        $this->mahasiswa = $mahasiswa;
    }
    
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }
}
