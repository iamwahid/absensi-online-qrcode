<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Repositories\Backend\AbsensiRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    protected $absensi;

    public function __construct(AbsensiRepository $absensi)
    {
        $this->absensi = $absensi;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.user.dashboard');
    }

    public function scanAbsen()
    {   
        if (strtolower(request()->method()) == 'post') {
            $decoded = base64_decode(request()->code);
            if ($decoded) {
                $decoded = explode('_', $decoded);
                $jadwal = Jadwal::find($decoded[0]);
                $mahasiswa = auth()->user()->mahasiswa;
                if ($jadwal && $mahasiswa) $this->absensi->setPresenceOnDate($jadwal, $mahasiswa, '', $decoded[2]);
                return $decoded;
            }
        }
        return view('frontend.absensi.scan');
    }
}
