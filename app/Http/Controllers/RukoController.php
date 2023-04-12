<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Ruko;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Whoops\Run;

class RukoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruko = Ruko::orderBy('kode', 'asc')->get();
        $penyewa = Penyewa::all();

        return view('menu.ruko.index', compact('ruko', 'penyewa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('menu.ruko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode'          => 'required',
            'tarif'         => 'required|numeric'
        ]);

        $validatedData['status'] = 'kosong';
        $validatedData['id_penyewa'] = 0;
        $validatedData['keterangan'] = $request->keterangan;

        $hasil = Ruko::create($validatedData);

        if ($hasil) {
            return redirect()->route('ruko.index')->with('success', 'Ruko berhasil ditambahkan!');
        } else {
            return redirect()->route('ruko.create')->with('error', 'Ruko gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'kode'  => 'required',
            'tarif' => 'required|numeric'
        ]);

        $validatedData['keterangan'] = $request->keterangan;

        $hasil = Ruko::whereId($id)->update($validatedData);

        if ($hasil) {
            return redirect()->route('ruko.index')->with('success', 'Ruko berhasil diperbarui!');
        } else {
            return redirect()->route('ruko.index')->with('error', 'Ruko gagal diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ruko = Ruko::whereId($id)->first();

        $hasil = Ruko::destroy($ruko->id);

        if ($hasil) {
            return redirect()->route('ruko.index')->with('success', 'Ruko berhasil dihapus!');
        } else {
            return redirect()->route('ruko.index')->with('error', 'Ruko gagal dihapus!');
        }
    }

    public function sewa(Request $request, string $id)
    {
        Ruko::whereId($id)->update(['id_penyewa' => $request['id_penyewa'], ['status' => 'baru']]);
        
        return redirect()->route('ruko.index')->with('success', 'Ruko berhasil disewakan!');
    }

    public function lepas($id)
    {
        Ruko::whereId($id)->update(['id_penyewa' => 0]);

        return redirect()->route('ruko.index')->with('success', 'Ruko berhasil dilepas sewa!');
    }
}
