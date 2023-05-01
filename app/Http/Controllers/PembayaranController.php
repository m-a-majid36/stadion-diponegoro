<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pembukuan;
use App\Models\Penyewa;
use App\Models\Ruko;
use Illuminate\Http\Request;
use Whoops\Run;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::latest()->get();
        $ruko = Ruko::where('id_penyewa', '!=', 0)->get();

        return view('menu.pembayaran.index', compact('pembayaran', 'ruko'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['id_ruko'] == 0) {
            return redirect()->route('pembayaran.index')->with('error', 'Pilih kode Ruko!');
        }

        $validatedData = $request->validate([
            'id_ruko'       => 'required',
            'id_penyewa'    => 'required',
            'nominal'       => 'required|numeric',
            'deadline'      => 'required|date',
            'status'        => 'required',
            'keterangan'    => ''
        ]);

        $hasil = Pembayaran::create($validatedData);
        $ruko = Ruko::findOrFail($validatedData['id_ruko']);
        $penyewa = Penyewa::findOrFail($ruko->id_penyewa);

        if ($validatedData['status'] == 'cicil') {
            $deskripsi = 'Pembayaran sebagian';
            $ruko->update([
                'deadline' => $validatedData['deadline'],
                'status' => 'cicil'
            ]);
            $penyewa->update([
                'selesai' => $validatedData['deadline'],
                'status' => 'cicil',
            ]);
        } elseif ($validatedData['status'] == 'baru') {
            $deskripsi = 'Tanda Jadi';
            $ruko->update([
                'deadline' => $validatedData['deadline'],
                'status' => 'baru'
            ]);
            $penyewa->update([
                'selesai' => $validatedData['deadline'],
                'status' => 'baru',
            ]);
        } elseif ($validatedData['status'] == 'lunas') {
            $deskripsi = 'Pelunasan';
            $ruko->update([
                'deadline' => $validatedData['deadline'],
                'status' => 'lunas'
            ]);
            $penyewa->update([
                'selesai' => $validatedData['deadline'],
                'status' => 'lunas',
            ]);
        }

        Pembukuan::create([
            'jenis'         => 'D',
            'nominal'       => $validatedData['nominal'],
            'deskripsi'     => $deskripsi . ' Ruko ' . $ruko->kode,
            'keterangan'    => $validatedData['keterangan'],
            'tgl_transaksi' => date('Y-m-d H:i:s')
        ]);

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

    public function getdata($id_ruko)
    {
        $ruko = Ruko::whereId($id_ruko)->first();
        $penyewa = Penyewa::whereId($ruko->id_penyewa)->first();

        return response()->json(['penyewa' => $penyewa]);
    }
}
