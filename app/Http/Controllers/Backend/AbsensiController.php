<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Repositories\Backend\AbsensiRepository;
use App\Repositories\Backend\JadwalRepository;
use App\Repositories\Backend\MahasiswaRepository;
use App\Repositories\Backend\MataKuliahRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected $absensi;
    protected $mahasiswa;
    protected $jadwals;
    protected $matkuls;

    public function __construct(AbsensiRepository $absensi, MahasiswaRepository $mahasiswa, JadwalRepository $jadwals, MataKuliahRepository $matkuls)
    {
        $this->absensi = $absensi;
        $this->mahasiswa = $mahasiswa;
        $this->jadwals = $jadwals;
        $this->matkuls = $matkuls;
    }

    public function index()
    {
        return redirect()->route('admin.dashboard');
        $date = request()->get('date') ?: '';
        $kelas = request()->get('kelas') ?: '';
        $jadwal_id = request()->get('jadwal_id') ?: 1;

        $date_string = $date ? 'Tanggal : '.Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') : 'Hari ini : '.Carbon::now()->format('d M Y');
        $absensi = $this->absensi->getPresenceOnDate($jadwal_id);
        return view('backend.absensi.index', ['absensi' => $absensi, 'date_string' => $date_string, 'date' => $date ? $date : Carbon::now()->format('Y-m-d')]);
    }

    public function absen(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $request->validate([
            'keterangan' => 'required',
            'date' => 'nullable',
            'jadwal_id' => 'required',
            'kode' => 'required'
        ]);

        $jadwal = $this->jadwals->getById($data['jadwal_id']);
        $this->absensi->setPresenceOnDate($jadwal, $mahasiswa, $data['keterangan'], $data['kode'], $data['date']);
        return response('', 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([]);

        $this->absensi->create($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function show(Absensi $absensi)
    {
        
    }

    public function edit(Absensi $absensi)
    {
        return view('backend.absensi.edit', ['absensi' => $absensi]);
    }

    public function update(Request $request, Absensi $absensi)
    {
        if (!$absensi->id) return;
        $data = $request->validate([]);

        $absensi->update($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function destroy(Absensi $absensi)
    {
        $this->absensi->deleteById($absensi->id);
        return;
    }
}
