<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Repositories\Backend\DosenRepository;
use App\Repositories\Backend\JadwalRepository;
use App\Repositories\Backend\MahasiswaRepository;
use App\Repositories\Backend\MataKuliahRepository;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected $jadwals;
    protected $matkuls;
    protected $dosens;
    protected $mahasiswas;

    public function __construct(JadwalRepository $jadwals, MataKuliahRepository $matkuls, DosenRepository $dosens, MahasiswaRepository $mahasiswas)
    {
        $this->jadwals = $jadwals;
        $this->matkuls = $matkuls;
        $this->dosens = $dosens;
        $this->mahasiswas = $mahasiswas;
    }

    public function index()
    {
        $jadwals = $this->jadwals->get();
        return view('backend.jadwal.index', ['jadwal' => $jadwals]);
    }

    public function create()
    {
        $matkul = $this->matkuls->get();
        return view('backend.jadwal.create', ['matkul' => $matkul]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'start_at' => 'required',
            'finish_at' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'room' => 'string'
        ]);
        $data['matkul_id'] = explode('_', $data['matkul_id'])[0];
        $data['kode_absen'] = \Str::random(10);

        $this->jadwals->create($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function edit(Jadwal $jadwal)
    {
        $matkul = $this->matkuls->get();
        return view('backend.jadwal.edit', ['jadwal' => $jadwal, 'matkul' => $matkul, 'dosen' => $jadwal->dosen]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        if (!$jadwal->id) return;
        $data = $request->validate([
            'start_at' => 'required',
            'finish_at' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'room' => 'string'
        ]);
        $data['matkul_id'] = explode('_', $data['matkul_id'])[0];

        $jadwal->update($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function mahasiswa(Request $request, Jadwal $jadwal)
    {
        if (strtolower($request->method()) == 'post') {
            $data = $request->validate([
                'mahasiswa' => 'required'
            ]);
            $jadwal->mahasiswas()->sync($data['mahasiswa']);
        }

        return view('backend.jadwal.mahasiswa', ['jadwal' => $jadwal, 'mahasiswa' => $this->mahasiswas->get()]);
    }

    public function destroy(Jadwal $jadwals)
    {
        $this->jadwals->deleteById($jadwals->id);
        return;
    }
}
