<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\DosenRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    protected $dosen;
    protected $user;

    public function __construct(DosenRepository $dosen, UserRepository $user)
    {
        $this->dosen = $dosen;
        $this->user = $user;
    }

    public function index()
    {
        $dosen = $this->dosen->get();
        return view('backend.dosen.index', ['dosen' => $dosen]);
    }

    public function create()
    {
        return view('backend.dosen.create');
    }

    public function store(Request $request)
    {
        $duser = $request->validate([
            'name' => ['required'],
            'email' => ['required', Rule::unique('users')],
            'password' => ['required','confirmed'],
        ]);

        $duser['first_name'] = explode(' ', $duser['name'])[0];
        $duser['last_name'] = explode(' ', $duser['name'])[1] ?? '';
        unset($duser['name']);
        $duser['roles'] = [config('access.users.executive_role')];
        $duser['active'] = "1";
        $duser['confirmed'] = "1";
        $ddosen = $request->validate([
            'nik' => ['string'],
            'alamat' => ['string'],
            'gender' => ['string'],
            'no_hp' => ['string'],
        ]);
        
        $user = $this->user->create($duser);
        $user->dosen()->create($ddosen);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function show(Dosen $dosen)
    {
        
    }

    public function edit(Dosen $dosen)
    {
        return view('backend.dosen.edit', ['dosen' => $dosen]);
    }

    public function update(Request $request, Dosen $dosen)
    {
        if (!$dosen->id) return;
        $data = $request->validate([]);

        $dosen->update($data);
        return redirect()->back()->withFlashSuccess('success');
    }

    public function destroy(Dosen $dosen)
    {
        $this->dosen->deleteById($dosen->id);
        return;
    }
}
