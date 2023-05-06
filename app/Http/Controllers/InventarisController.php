<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventaris = Inventaris::latest()->get();

        return view('menu.inventaris.index', compact('inventaris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.inventaris.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'      => 'required',
            'tanggal'   => 'required|date',
            'kode'      => 'required|unique:inventaris',
            'harga'     => 'required',
            'jumlah'    => 'required|numeric',
        ]);

        $harga = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['harga']);

        $validatedData['harga'] = $harga;

        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('inventaris');
        }
        if ($request->keterangan) {
            $validatedData['keterangan'] = $request->keterangan;
        }

        $hasil = Inventaris::create($validatedData);

        if ($hasil) {
            return redirect()->route('inventaris.index')->with('success', 'Inventaris berhasil ditambahkan!');
        } else {
            return redirect()->route('inventaris.index')->with('error', 'Inventaris gagal ditambahkan!');
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
            'nama'      => 'required',
            'tanggal'   => 'required|date',
            'kode'      => 'required|unique:inventaris,kode,' . $id,
            'harga'     => 'required',
            'jumlah'    => 'required|numeric',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
