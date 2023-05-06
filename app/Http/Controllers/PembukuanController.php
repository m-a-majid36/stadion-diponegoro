<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pembukuan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Svg\Gradient\Stop;

class PembukuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = Pembukuan::selectRaw('year(tgl_transaksi) year')
            ->groupBy('year')
            ->get();

        return view('menu.pembukuan.index', compact('years'));
    }

    public function all()
    {
        $pembukuans = Pembukuan::latest();

        $debit = clone $pembukuans;
        $kredit = clone $pembukuans;

        $pembukuans = $pembukuans->get();

        $debit = $debit->where('jenis', 'D')->get();
        $kredit = $kredit->where('jenis', 'K')->get();        

        return view('menu.pembukuan.all', [
            'pembukuans'    => $pembukuans,
            'saldo'         => $debit->sum('nominal') - $kredit->sum('nominal'),
            'totalDebit'    => $debit->sum('nominal'),
            'totalKredit'   => $kredit->sum('nominal'),
        ]);
    }

    public function create()
    {
        return view('menu.pembukuan.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tgl_transaksi' => 'required',
            'jenis'         => 'required',
            'nominal'       => 'required',
            'deskripsi'     => 'required',
            'gambar'        => 'file',
            'keterangan'    => ''
        ]);

        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);

        $validatedData['nominal'] = $nominal;
        $validatedData['id_pembayaran'] = 0;

        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('gambar');
        } else {
            $validatedData['gambar'] = null;
        }

        $hasil = Pembukuan::create($validatedData);
        if ($hasil) {
            return redirect()->route('pembukuan.all')->with('success', 'Transaksi berhasil ditambahkan!');
        } else {
            return redirect()->route('pembukuan.all')->with('error', 'Transaksi gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->bulanAwal == 0 || $request->bulanAkhir == 0) {
            return redirect()->route('pembukuan.index')->with('error', 'Bulan tidak boleh kosong!');
        }

        if ($request->tahunAwal == 0 || $request->tahunAkhir == 0) {
            return redirect()->route('pembukuan.index')->with('error', 'Tahun tidak boleh kosong!');
        }

        if ($request->tahunAwal > $request->tahunAkhir) {
            return redirect()->route('pembukuan.index')->with('error', 'Tahun Awal tidak boleh lebih besar dari Tahun Akhir!');
        }

        if ($request->tahunAwal == $request->tahunAkhir) {
            if ($request->bulanAwal > $request->bulanAkhir) {
                return redirect()->route('pembukuan.index')->with('error', 'Bulan Awal tidak boleh lebih besar dari Bulan Akhir!');
            }
        }

        $pembukuans = Pembukuan::oldest();

        $from = Carbon::parse($request->tahunAwal . '-' . $request->bulanAwal . '-01')->format('Y-m-d');
        $to = Carbon::parse($request->tahunAkhir . '-' . $request->bulanAkhir . '-01')->endOfMonth()->format('Y-m-d');

        $pembukuans->whereBetween('tgl_transaksi', [$from, $to]);

        $kredit = clone $pembukuans;
        $debit = clone $pembukuans;

        $pembukuans = $pembukuans->get();

        $debit = $debit->where('jenis', 'D')->get();
        $kredit = $kredit->where('jenis', 'K')->get();

        if ($request->bulanAwal == "01") {
            $bulanAwalNama = 'Januari';
        } elseif ($request->bulanAwal == "02") {
            $bulanAwalNama = 'Februari';
        } elseif ($request->bulanAwal == "03") {
            $bulanAwalNama = 'Maret';
        } elseif ($request->bulanAwal == "04") {
            $bulanAwalNama = 'April';
        } elseif ($request->bulanAwal == "05") {
            $bulanAwalNama = 'Mei';
        } elseif ($request->bulanAwal == "06") {
            $bulanAwalNama = 'Juni';
        } elseif ($request->bulanAwal == "07") {
            $bulanAwalNama = 'Juli';
        } elseif ($request->bulanAwal == "08") {
            $bulanAwalNama = 'Agustus';
        } elseif ($request->bulanAwal == "09") {
            $bulanAwalNama = 'September';
        } elseif ($request->bulanAwal == "10") {
            $bulanAwalNama = 'Oktober';
        } elseif ($request->bulanAwal == "11") {
            $bulanAwalNama = 'November';
        } elseif ($request->bulanAwal == "12") {
            $bulanAwalNama = 'Desember';
        }

        if ($request->bulanAkhir == "01") {
            $bulanAkhirNama = 'Januari';
        } elseif ($request->bulanAkhir == "02") {
            $bulanAkhirNama = 'Februari';
        } elseif ($request->bulanAkhir == "03") {
            $bulanAkhirNama = 'Maret';
        } elseif ($request->bulanAkhir == "04") {
            $bulanAkhirNama = 'April';
        } elseif ($request->bulanAkhir == "05") {
            $bulanAkhirNama = 'Mei';
        } elseif ($request->bulanAkhir == "06") {
            $bulanAkhirNama = 'Juni';
        } elseif ($request->bulanAkhir == "07") {
            $bulanAkhirNama = 'Juli';
        } elseif ($request->bulanAkhir == "08") {
            $bulanAkhirNama = 'Agustus';
        } elseif ($request->bulanAkhir == "09") {
            $bulanAkhirNama = 'September';
        } elseif ($request->bulanAkhir == "10") {
            $bulanAkhirNama = 'Oktober';
        } elseif ($request->bulanAkhir == "11") {
            $bulanAkhirNama = 'November';
        } elseif ($request->bulanAkhir == "12") {
            $bulanAkhirNama = 'Desember';
        }

        if ($request->print) {
            $ppembukuans    = $pembukuans;
            $psaldo         = $debit->sum('nominal') - $kredit->sum('nominal');
            $ptotalDebit    = $debit->sum('nominal');
            $ptotalKredit   = $kredit->sum('nominal');
            $pbulanAwal     = $request->bulanAwal;
            $pbulanAwalNama = $bulanAwalNama;
            $pbulanAkhir    = $request->bulanAkhir;
            $pbulanAkhirNama= $bulanAkhirNama;
            $ptahunAwal     = $request->tahunAwal;
            $ptahunAkhir    = $request->tahunAkhir;

            $pdf = Pdf::loadView('menu.pembukuan.print',
                compact('ppembukuans', 'psaldo', 'ptotalDebit', 'ptotalKredit', 'pbulanAwal', 'pbulanAwalNama', 'pbulanAkhir', 'pbulanAkhirNama', 'ptahunAwal', 'ptahunAkhir'))
                ->setPaper('a4', 'potrait');

            return $pdf->download("Pembukuan Periode " . $pbulanAwalNama . " " . $ptahunAwal . " hingga " . $pbulanAkhirNama . " " . $ptahunAkhir . ".pdf");
        }

        return view('menu.pembukuan.show', [
            'pembukuans'    => $pembukuans,
            'saldo'         => $debit->sum('nominal') - $kredit->sum('nominal'),
            'totalDebit'    => $debit->sum('nominal'),
            'totalKredit'   => $kredit->sum('nominal'),
            'bulanAwal'     => $request->bulanAwal,
            'bulanAwalNama' => $bulanAwalNama,
            'bulanAkhir'    => $request->bulanAkhir,
            'bulanAkhirNama'=> $bulanAkhirNama,
            'tahunAwal'     => $request->tahunAwal,
            'tahunAkhir'    => $request->tahunAkhir,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembukuan = Pembukuan::findOrFail(decrypt($id));

        return view('menu.pembukuan.edit', compact('pembukuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tgl_transaksi' => 'required',
            'jenis'         => 'required',
            'nominal'       => 'required',
            'deskripsi'     => 'required',
            'gambar'        => 'file',
            'keterangan'    => ''
        ]);

        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);
        $validatedData['nominal'] = $nominal;

        if($request->file('gambar')) {
            if($request->oldGambar) {
                Storage::delete($request->oldGambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('gambar');
        }

        Pembukuan::findOrFail($id)->update($validatedData);

        return redirect()->route('pembukuan.all')->with('success', 'Data Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembukuan = Pembukuan::findOrFail($id);

        if ($pembukuan->gambar) {
            Storage::delete($pembukuan->gambar);
        }

        $pembukuan->delete();

        return redirect()->route('pembukuan.all')->with('success', 'Data Transaksi berhasil dihapus!');
    }
}
