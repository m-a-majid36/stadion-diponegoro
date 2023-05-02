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

        $bulanini = Pembayaran::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 2;

        $validatedData['kode'] = 'Ruko-' . date('m') . '-' . $bulanini;

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

    public function print(string $id)
    {
        if (date('m') == "01") {
            $bulan = 'Januari';
        } elseif (date('m') == "02") {
            $bulan = 'Februari';
        } elseif (date('m') == "03") {
            $bulan = 'Maret';
        } elseif (date('m') == "04") {
            $bulan = 'April';
        } elseif (date('m') == "05") {
            $bulan = 'Mei';
        } elseif (date('m') == "06") {
            $bulan = 'Juni';
        } elseif (date('m') == "07") {
            $bulan = 'Juli';
        } elseif (date('m') == "08") {
            $bulan = 'Agustus';
        } elseif (date('m') == "09") {
            $bulan = 'September';
        } elseif (date('m') == "10") {
            $bulan = 'Oktober';
        } elseif (date('m') == "11") {
            $bulan = 'November';
        } elseif (date('m') == "12") {
            $bulan = 'Desember';
        }
        
        $pembayaran = Pembayaran::findOrFail(decrypt($id));
        
        $terbilang = ucwords(''.$this->Terbilang($pembayaran->nominal).'')." Rupiah"; 

        return view('menu.pembayaran.print', [
            'pembayaran'    => $pembayaran,
            'tanggal'       => 'Semarang, ' . date('d') . ' ' . $bulan . ' ' . date('Y'),
            'terbilang'     => $terbilang,
        ]);
    }

    public function Terbilang($x)
    {
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        if ($x < 12) {
            return ' ' . $bilangan[$x];
        } elseif ($x < 20) {
            return $this->Terbilang($x - 10) . ' Belas';
        } elseif ($x < 100) {
            return $this->Terbilang($x / 10) . ' Puluh' . $this->Terbilang($x % 10);
        } elseif ($x < 200) {
            return ' seratus' . $this->Terbilang($x - 100);
        } elseif ($x < 1000) {
            return $this->Terbilang($x / 100) . ' Ratus' . $this->Terbilang($x % 100);
        } elseif ($x < 2000) {
            return ' seribu' . $this->Terbilang($x - 1000);
        } elseif ($x < 1000000) {
            return $this->Terbilang($x / 1000) . ' Ribu' . $this->Terbilang($x % 1000);
        } elseif ($x < 1000000000) {
            return $this->Terbilang($x / 1000000) . ' Juta' . $this->Terbilang($x % 1000000);
        }
    }

    public function getdata($id_ruko)
    {
        $ruko = Ruko::whereId($id_ruko)->first();
        $penyewa = Penyewa::whereId($ruko->id_penyewa)->first();

        return response()->json(['penyewa' => $penyewa]);
    }
}
