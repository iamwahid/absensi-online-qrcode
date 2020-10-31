<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Repositories\Backend\DosenRepository;
use App\Repositories\Backend\MataKuliahRepository;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    protected $mata_kuliah;
    protected $dosens;

    public function __construct(MataKuliahRepository $mata_kuliah, DosenRepository $dosens)
    {
        $this->mata_kuliah = $mata_kuliah;
        $this->dosens = $dosens;
    }

    public function index()
    {
        $mata_kuliah = $this->mata_kuliah->get();
        return view('backend.mata_kuliah.index', ['mata_kuliah' => $mata_kuliah]);
    }

    public function create()
    {
        return view('backend.mata_kuliah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'sks' => 'required',
            'deskripsi' => 'string'
        ]);

        $this->mata_kuliah->create($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function dosen(Request $request, MataKuliah $mata_kuliah)
    {
        if (strtolower($request->method()) == 'post') {
            $data = $request->validate([
                'dosen' => 'required'
            ]);
            $this->mata_kuliah->giveMatkulToDosens($data['dosen'], $mata_kuliah);
        }
        $dosen = $this->dosens->get();
        return view('backend.mata_kuliah.dosen', ['mata_kuliah' => $mata_kuliah, 'dosen' => $dosen]);
    }

    public function dosenJson(MataKuliah $mata_kuliah)
    {
        return response()->json($mata_kuliah->dosens->pluck('user.name', 'id'), 200);
    }

    public function edit(MataKuliah $mata_kuliah)
    {
        return view('backend.mata_kuliah.edit', ['mata_kuliah' => $mata_kuliah]);
    }

    public function update(Request $request, MataKuliah $mata_kuliah)
    {
        if (!$mata_kuliah->id) return;
        $data = $request->validate([
            'nama' => 'required',
            'sks' => 'required',
            'deskripsi' => 'string'
        ]);

        $mata_kuliah->update($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function destroy(MataKuliah $mata_kuliah)
    {
        $this->mata_kuliah->deleteById($mata_kuliah->id);
        return;
    }
}
