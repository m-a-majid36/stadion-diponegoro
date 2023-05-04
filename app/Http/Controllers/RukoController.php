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
        $penyewa = Penyewa::orderBy('nama', 'asc')->get();

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
            'kode'          => 'required|unique:rukos',
            'tarif'         => 'required'
        ]);

        $tarif = str_replace(array('R','p','.',' '), '', $validatedData['tarif']);

        $validatedData['tarif'] = $tarif;
        $validatedData['status'] = 'kosong';
        $validatedData['id_penyewa'] = 0;
        $validatedData['keterangan'] = $request->keterangan;

        $hasil = Ruko::create($validatedData);

        if ($hasil) {
            return redirect()->route('ruko.index')->with('success', 'Ruko berhasil ditambahkan!');
        } else {
            return redirect()->route('ruko.index')->with('error', 'Ruko gagal ditambahkan!');
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
        if ($request['id_penyewa'] == 0) {
            return redirect()->route('ruko.index')->with('error', 'Pilih nama penyewa!');
        }

        Ruko::whereId($id)->update(['id_penyewa' => $request['id_penyewa'], 'status' => 'nunggak', 'deadline' => date('Y-m-d H:i:s')]);
        
        $penyewa = Penyewa::findOrFail($request['id_penyewa']);
        if ($penyewa->status == 'nonaktif') {
            $penyewa->update([
                'status' => 'nunggak',
                'mulai' => date('Y-m-d H:i:s')
            ]);
        } else {
            $penyewa->update([
                'status' => 'nunggak'
            ]);
        }

        return redirect()->route('ruko.index')->with('success', 'Ruko berhasil disewakan!');
    }

    public function lepas($id)
    {
        $ruko = Ruko::whereId($id)->first();
        $id_penyewa = $ruko->id_penyewa;

        Ruko::whereId($id)->update(['id_penyewa' => 0, 'status' => 'kosong', 'deadline' => null]);
        
        if ($id_penyewa != 0) {
            $cek_penyewa = Ruko::where('id_penyewa', '=', $id_penyewa)->first();
            if ($cek_penyewa == null) {
                Penyewa::whereId($id_penyewa)->update(['status' => 'nonaktif', 'selesai' => date('Y-m-d H:i:s')]);
            }
        }

        return redirect()->route('ruko.index')->with('success', 'Ruko berhasil dilepas sewa!');
    }
}
