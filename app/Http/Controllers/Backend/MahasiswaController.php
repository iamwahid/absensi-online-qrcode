<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Repositories\Backend\AbsensiRepository;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\MahasiswaRepository;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    protected $mahasiswa;
    protected $absensi;
    protected $user;

    public function __construct(MahasiswaRepository $mahasiswa, AbsensiRepository $absensi, UserRepository $user)
    {
        $this->mahasiswa = $mahasiswa;
        $this->absensi = $absensi;
        $this->user = $user;
    }

    public function index()
    {
        $kelas = request()->get('kelas') ?: '';
        $mahasiswa = $this->mahasiswa->get();
        return view('backend.mahasiswa.index', ['mahasiswa' => $mahasiswa]);
    }

    public function create()
    {
        return view('backend.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $duser = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required','confirmed'],
        ]);

        $duser['first_name'] = explode(' ', $duser['name'])[0];
        $duser['last_name'] = explode(' ', $duser['name'])[1] ?? '';
        unset($duser['name']);
        $duser['roles'] = [config('access.users.default_role')];
        $duser['active'] = "1";
        $duser['confirmed'] = "1";
        $dmhs = $request->validate([
            'nim' => ['string'],
            'tahun' => ['string'],
            'kelas' => ['string'],
            'gender' => ['string'],
            'alamat' => ['string'],
        ]);
        
        $user = $this->user->create($duser);
        $user->mahasiswa()->create($dmhs);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('backend.mahasiswa.edit', ['mahasiswa' => $mahasiswa]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        if (!$mahasiswa->id) return;
        $data = $request->validate([
            'nim' => ['string'],
            'tahun' => ['string'],
            'kelas' => ['string'],
            'gender' => ['string'],
            'alamat' => ['string'],
        ]);

        $mahasiswa->update($data);
        return redirect()->route('admin.mahasiswa.index')->withFlashSuccess('success');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $this->user->deleteById($mahasiswa->user->id);
        return;
    }

}
