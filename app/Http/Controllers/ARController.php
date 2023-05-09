<?php

namespace App\Http\Controllers;

use App\Models\Ruko;
use Illuminate\Http\Request;

class ARController extends Controller
{
    public function index()
    {
        $ruko = Ruko::all()->sortBy('kode');

        return view('menu.ar.index', compact('ruko'));
    }
}
