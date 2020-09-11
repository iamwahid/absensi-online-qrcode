<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Str;

class MateriController extends Controller
{
    public function index()
    {
        return view('frontend.materi.index');
    }
}
