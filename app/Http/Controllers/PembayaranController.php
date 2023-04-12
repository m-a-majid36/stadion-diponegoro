<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Ruko;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::all();
        $ruko = Ruko::where('id_penyewa', '!=', 0)->get();

        return view('menu.pembayaran.index', compact('pembayaran', 'ruko'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruko = Ruko::all();

        return view('menu.pembayaran.add', compact('ruko'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_ruko'       => 'required',
            'id_penyewa'    => 'required',
            'nominal'       => 'required|numeric',
            'deadline'      => 'required|date',
            'status'        => 'required',
            'keterangan'    => ''
        ]);

        $hasil = Pembayaran::create($validatedData);

        if ($hasil) {
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan!');
        } else {
            return redirect()->route('pembayaran.index')->with('error', 'Pembayaran gagal ditambahkan!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getdata($id_ruko)
    {
        $ruko = Ruko::whereId($id_ruko)->first();

        return response()->json(['ruko' => $ruko]);
    }
}
