<?php

namespace App\Http\Controllers;

use App\Models\Ruko;
use App\Models\Penyewa;
use App\Models\Pembukuan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::latest()->get();
        $ruko = Ruko::where('id_penyewa', '!=', 0)->orderBy('kode', 'asc')->get();

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
            'nominal'       => 'required',
            'deadline'      => 'required|date',
            'status'        => 'required',
            'bukti_bayar'   => 'file',
            'keterangan'    => ''
        ]);

        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);

        $validatedData['nominal'] = $nominal;

        $bulanini = Pembayaran::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;

        $validatedData['kode'] = 'Ruko-' . date('m') . '-' . $bulanini;

        if ($request->file('bukti_bayar')) {
            $validatedData['file'] = $request->file('bukti_bayar')->store('bukti_bayar');
        } else {
            $validatedData['file'] = null;
        }

        $hasil = Pembayaran::create($validatedData);
        $pembayaran = Pembayaran::latest()->first();

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

        if ($request->file('bukti_bayar')) {
            Pembukuan::create([
                'id_pembayaran' => $pembayaran->id,
                'jenis'         => 'D',
                'nominal'       => $validatedData['nominal'],
                'deskripsi'     => $deskripsi . ' Ruko ' . $ruko->kode,
                'keterangan'    => $validatedData['keterangan'],
                'tgl_transaksi' => date('Y-m-d H:i:s'),
                'gambar'        => $validatedData['file']
            ]);
        } else {
            Pembukuan::create([
                'id_pembayaran' => $pembayaran->id,
                'jenis'         => 'D',
                'nominal'       => $validatedData['nominal'],
                'deskripsi'     => $deskripsi . ' Ruko ' . $ruko->kode,
                'keterangan'    => $validatedData['keterangan'],
                'tgl_transaksi' => date('Y-m-d H:i:s')
            ]);
        }

        if ($hasil) {
            return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan!');
        } else {
            return redirect()->route('pembayaran.index')->with('error', 'Pembayaran gagal ditambahkan!');
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nominal'       => 'required',
            'status'        => 'required',
            'deadline'      => 'required',
            'keterangan'    => ''
        ]);

        $nominal = str_replace(array('R','p','.',' ',',','-'), '', $validatedData['nominal']);

        $validatedData['nominal'] = $nominal;

        if ($request->file('bukti_bayar')) {
            if ($request->oldGambar) {
                Storage::delete($request->oldGambar);
            }
            $validatedData['file'] = $request->file('bukti_bayar')->store('bukti_bayar');
        }

        Pembayaran::whereId($id)->update($validatedData);
        $pembayaran = Pembayaran::findOrFail($id);
        $ruko = Ruko::findOrFail($pembayaran->id_ruko);
        $penyewa = Penyewa::findOrFail($pembayaran->id_penyewa);

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

        if ($request->file('bukti_bayar')) {
            Pembukuan::where('id_pembayaran', '=', $id)->update([
                'nominal'       => $validatedData['nominal'],
                'deskripsi'     => $deskripsi . ' Ruko ' . $ruko->kode,
                'gambar'        => $validatedData['file'],
                'keterangan'    => $validatedData['keterangan']
            ]);
        } else {
            Pembukuan::where('id_pembayaran', '=', $id)->update([
                'nominal'       => $validatedData['nominal'],
                'deskripsi'     => $deskripsi . ' Ruko ' . $ruko->kode,
                'keterangan'    => $validatedData['keterangan']
            ]);
        }

        return redirect()->route('pembayaran.index')->with('success', 'Data Pembayaran berhasil diperbarui!');
    }

    public function print(string $id)
    {        
        $pembayaran = Pembayaran::findOrFail(decrypt($id));

        if (date('m', strtotime($pembayaran->created_at)) == "01") {
            $bulan = 'Januari';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "02") {
            $bulan = 'Februari';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "03") {
            $bulan = 'Maret';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "04") {
            $bulan = 'April';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "05") {
            $bulan = 'Mei';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "06") {
            $bulan = 'Juni';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "07") {
            $bulan = 'Juli';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "08") {
            $bulan = 'Agustus';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "09") {
            $bulan = 'September';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "10") {
            $bulan = 'Oktober';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "11") {
            $bulan = 'November';
        } elseif (date('m', strtotime($pembayaran->created_at)) == "12") {
            $bulan = 'Desember';
        }

        if (date('m', strtotime($pembayaran->deadline)) == "01") {
            $bulandeadline = 'Januari';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "02") {
            $bulandeadline = 'Februari';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "03") {
            $bulandeadline = 'Maret';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "04") {
            $bulandeadline = 'April';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "05") {
            $bulandeadline = 'Mei';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "06") {
            $bulandeadline = 'Juni';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "07") {
            $bulandeadline = 'Juli';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "08") {
            $bulandeadline = 'Agustus';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "09") {
            $bulandeadline = 'September';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "10") {
            $bulandeadline = 'Oktober';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "11") {
            $bulandeadline = 'November';
        } elseif (date('m', strtotime($pembayaran->deadline)) == "12") {
            $bulandeadline = 'Desember';
        }

        $terbilang = ucwords(''.$this->Terbilang($pembayaran->nominal).'')." Rupiah"; 
        $tanggal = 'Semarang, ' . date('d', strtotime($pembayaran->created_at)) . ' ' . $bulan . ' ' . date('Y', strtotime($pembayaran->created_at));
        $batas = date('d', strtotime($pembayaran->deadline)) . ' ' . $bulandeadline . ' ' . date('Y', strtotime($pembayaran->deadline));

        $pdf = Pdf::loadView('menu.pembayaran.print', compact('pembayaran', 'tanggal', 'terbilang', 'batas'))->setPaper('a4', 'potrait');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->set_opacity(.2,"Multiply");

        $canvas->set_opacity(.2);

        $canvas->page_text($width/7, $height/5, 'STADION DIPONEGORO', null, 38, array(0,1,0),3,3,-20);
        $canvas->page_text($width/3, $height/5, 'SEMARANG', null, 45, array(0,1,0),3,3,-20);

        return $pdf->download("Kuitansi " . $pembayaran->kode . " " . date('d', strtotime($pembayaran->created_at)) . '-' . $bulan . '-' . date('Y', strtotime($pembayaran->created_at)) . ".pdf");
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
