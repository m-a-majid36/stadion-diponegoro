<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembukuan;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggajian = Penggajian::latest()->get();
        $karyawan = Karyawan::where('status', '=', 'A')->orderBy('nama', 'asc')->get();

        return view('menu.penggajian.index', compact('penggajian', 'karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request['id_karyawan'] == 0) {
            return redirect()->route('penggajian.index')->with('error', 'Pilih Karyawan!');
        } elseif ($request['awal'] == null) {
            return redirect()->route('penggajian.index')->with('error', 'Tanggal awal periode tidak boleh kosong!');
        } elseif ($request['akhir'] == null) {
            return redirect()->route('penggajian.index')->with('error', 'Tanggal akhir periode tidak boleh kosong!');
        } elseif ($request['akhir'] > $request['awal']) {
            return redirect()->route('penggajian.index')->with('error', 'Tanggal awal tidak boleh lebih kecil daripada tanggal akhir!');
        }

        $validatedData = $request->validate([
            'id_karyawan'   => 'required',
            'nominal'       => 'required',
            'awal'          => 'required|date',
            'akhir'         => 'required|date|after_or_equal:awal',
            'keterangan'    => '',
        ],[
            'awal.required'         => 'Tanggal awal tidak boleh kosong!',
            'akhir.required'        => 'Tanggal akhir tidak boleh kosong!',
            'akhir.after_or_equal'  => 'Tanggal akhir harus lebih besar dari Tanggal awal!'
        ]);

        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);

        $validatedData['nominal'] = $nominal;

        $bulanini = Penggajian::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;

        $validatedData['kode'] = 'Gaji-' . date('m') . '-' . $bulanini;

        Penggajian::create($validatedData);
        $penggajian = Penggajian::latest()->first();
        $karyawan = Karyawan::findOrFail($validatedData['id_karyawan']);

        Pembukuan::create([
            'id_penggajian' => $penggajian->id,
            'jenis'         => 'K',
            'nominal'       => $validatedData['nominal'],
            'deskripsi'     => 'Penggajian ' . $karyawan->nama,
            'keterangan'    => $validatedData['keterangan'],
            'tgl_transaksi' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Data Penggajian berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request['awal'] == null) {
            return redirect()->route('penggajian.index')->with('error', 'Tanggal awal periode tidak boleh kosong!');
        }
        if ($request['akhir'] == null) {
            return redirect()->route('penggajian.index')->with('error', 'Tanggal akhir periode tidak boleh kosong!');
        }

        $validatedData = $request->validate([
            'nominal'       => 'required',
            'awal'          => 'required|date',
            'akhir'         => 'required|date|after_or_equal:awal',
            'keterangan'    => '',
        ],[
            'awal.required'         => 'Tanggal awal tidak boleh kosong!',
            'akhir.required'        => 'Tanggal akhir tidak boleh kosong!',
            'akhir.after_or_equal'  => 'Tanggal akhir harus lebih besar dari Tanggal awal!'
        ]);
        
        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);

        $validatedData['nominal'] = $nominal;
        
        Penggajian::whereId($id)->update($validatedData);

        Pembukuan::where('id_penggajian', '=', $id)->update([
            'nominal'       => $validatedData['nominal'],
            'keterangan'    => $validatedData['keterangan']
        ]);

        return redirect()->route('penggajian.index')->with('success', 'Data Penggajian berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function print(string $id)
    {
        $penggajian = Penggajian::findOrFail(decrypt($id));

        if (date('m', strtotime($penggajian->created_at)) == "01") {
            $bulan = 'Januari';
        } elseif (date('m', strtotime($penggajian->created_at)) == "02") {
            $bulan = 'Februari';
        } elseif (date('m', strtotime($penggajian->created_at)) == "03") {
            $bulan = 'Maret';
        } elseif (date('m', strtotime($penggajian->created_at)) == "04") {
            $bulan = 'April';
        } elseif (date('m', strtotime($penggajian->created_at)) == "05") {
            $bulan = 'Mei';
        } elseif (date('m', strtotime($penggajian->created_at)) == "06") {
            $bulan = 'Juni';
        } elseif (date('m', strtotime($penggajian->created_at)) == "07") {
            $bulan = 'Juli';
        } elseif (date('m', strtotime($penggajian->created_at)) == "08") {
            $bulan = 'Agustus';
        } elseif (date('m', strtotime($penggajian->created_at)) == "09") {
            $bulan = 'September';
        } elseif (date('m', strtotime($penggajian->created_at)) == "10") {
            $bulan = 'Oktober';
        } elseif (date('m', strtotime($penggajian->created_at)) == "11") {
            $bulan = 'November';
        } elseif (date('m', strtotime($penggajian->created_at)) == "12") {
            $bulan = 'Desember';
        }

        if (date('m', strtotime($penggajian->awal)) == "01") {
            $bulanawal = 'Januari';
        } elseif (date('m', strtotime($penggajian->awal)) == "02") {
            $bulanawal = 'Februari';
        } elseif (date('m', strtotime($penggajian->awal)) == "03") {
            $bulanawal = 'Maret';
        } elseif (date('m', strtotime($penggajian->awal)) == "04") {
            $bulanawal = 'April';
        } elseif (date('m', strtotime($penggajian->awal)) == "05") {
            $bulanawal = 'Mei';
        } elseif (date('m', strtotime($penggajian->awal)) == "06") {
            $bulanawal = 'Juni';
        } elseif (date('m', strtotime($penggajian->awal)) == "07") {
            $bulanawal = 'Juli';
        } elseif (date('m', strtotime($penggajian->awal)) == "08") {
            $bulanawal = 'Agustus';
        } elseif (date('m', strtotime($penggajian->awal)) == "09") {
            $bulanawal = 'September';
        } elseif (date('m', strtotime($penggajian->awal)) == "10") {
            $bulanawal = 'Oktober';
        } elseif (date('m', strtotime($penggajian->awal)) == "11") {
            $bulanawal = 'November';
        } elseif (date('m', strtotime($penggajian->awal)) == "12") {
            $bulanawal = 'Desember';
        }

        if (date('m', strtotime($penggajian->akhir)) == "01") {
            $bulanakhir = 'Januari';
        } elseif (date('m', strtotime($penggajian->akhir)) == "02") {
            $bulanakhir = 'Februari';
        } elseif (date('m', strtotime($penggajian->akhir)) == "03") {
            $bulanakhir = 'Maret';
        } elseif (date('m', strtotime($penggajian->akhir)) == "04") {
            $bulanakhir = 'April';
        } elseif (date('m', strtotime($penggajian->akhir)) == "05") {
            $bulanakhir = 'Mei';
        } elseif (date('m', strtotime($penggajian->akhir)) == "06") {
            $bulanakhir = 'Juni';
        } elseif (date('m', strtotime($penggajian->akhir)) == "07") {
            $bulanakhir = 'Juli';
        } elseif (date('m', strtotime($penggajian->akhir)) == "08") {
            $bulanakhir = 'Agustus';
        } elseif (date('m', strtotime($penggajian->akhir)) == "09") {
            $bulanakhir = 'September';
        } elseif (date('m', strtotime($penggajian->akhir)) == "10") {
            $bulanakhir = 'Oktober';
        } elseif (date('m', strtotime($penggajian->akhir)) == "11") {
            $bulanakhir = 'November';
        } elseif (date('m', strtotime($penggajian->akhir)) == "12") {
            $bulanakhir = 'Desember';
        }

        $terbilang = ucwords(''.$this->Terbilang($penggajian->nominal).'')." Rupiah"; 
        $tanggal = 'Semarang, ' . date('d', strtotime($penggajian->created_at)) . ' ' . $bulan . ' ' . date('Y', strtotime($penggajian->created_at));
        $periode = date('d', strtotime($penggajian->awal)) . ' ' . $bulanawal . ' ' . date('Y', strtotime($penggajian->awal)) . ' sampai ' . date('d', strtotime($penggajian->akhir)) . ' ' . $bulanakhir . ' ' . date('Y', strtotime($penggajian->akhir));

        $pdf = Pdf::loadView('menu.penggajian.print', compact('penggajian', 'terbilang', 'tanggal', 'periode'))->setPaper('a4', 'potrait');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.2,"Multiply");

        $canvas->set_opacity(.2);

        $canvas->page_text($width/7, $height/5, 'STADION DIPONEGORO', null, 38, array(0,0,1),3,3,-20);
        $canvas->page_text($width/3, $height/5, 'SEMARANG', null, 45, array(0,0,1),3,3,-20);

        return $pdf->download("Kuitansi " . $penggajian->kode . " " . date('d', strtotime($penggajian->created_at)) . '-' . $bulan . '-' . date('Y', strtotime($penggajian->created_at)) . ".pdf");
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
}
