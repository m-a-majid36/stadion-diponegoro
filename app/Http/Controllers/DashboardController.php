<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembukuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $pembukuans = Pembukuan::latest();

        $debit = clone $pembukuans;
        $kredit = clone $pembukuans;

        $debit = $debit->where('jenis', 'D')->get();
        $kredit = $kredit->where('jenis', 'K')->get();

        $total_tmasuk = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->sum('nominal');
        $total_tmasuk = "Rp." . number_format($total_tmasuk,0,',','.') . ",-";
        $total_tkeluar = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->sum('nominal');
        $total_tkeluar = "Rp." . number_format($total_tkeluar,0,',','.') . ",-";

        $total_bmasuk = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', date('m'))->sum('nominal');
        $total_bkeluar = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', date('m'))->sum('nominal');

        // Data Transaksi Perbulan
        $janm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '01')->sum('nominal');
        $jank = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '01')->sum('nominal');
        $febm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '02')->sum('nominal');
        $febk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '02')->sum('nominal');
        $marm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '03')->sum('nominal');
        $mark = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '03')->sum('nominal');
        $aprm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '04')->sum('nominal');
        $aprk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '04')->sum('nominal');
        $maym = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '05')->sum('nominal');
        $mayk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '05')->sum('nominal');
        $junm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '06')->sum('nominal');
        $junk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '06')->sum('nominal');
        $julm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '07')->sum('nominal');
        $julk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '07')->sum('nominal');
        $augm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '08')->sum('nominal');
        $augk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '08')->sum('nominal');
        $sepm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '09')->sum('nominal');
        $sepk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '09')->sum('nominal');
        $octm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '10')->sum('nominal');
        $octk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '10')->sum('nominal');
        $novm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '11')->sum('nominal');
        $novk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '11')->sum('nominal');
        $desm = Pembukuan::where('jenis', 'D')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '12')->sum('nominal');
        $desk = Pembukuan::where('jenis', 'K')->whereYear('tgl_transaksi', date('Y'))->whereMonth('tgl_transaksi', '12')->sum('nominal');

        $pembukuans = $pembukuans->get();

        if (date('M') == 'Jan') {
            $bulan = 'Januari';
        } elseif (date('M') == 'Feb') {
            $bulan = 'Februari';
        } elseif (date('M') == 'Mar') {
            $bulan = 'Maret';
        } elseif (date('M') == 'Apr') {
            $bulan = 'April';
        } elseif (date('M') == 'May') {
            $bulan = 'Mei';
        } elseif (date('M') == 'Jun') {
            $bulan = 'Juni';
        } elseif (date('M') == 'Jul') {
            $bulan = 'Juli';
        } elseif (date('M') == 'Aug') {
            $bulan = 'Agustus';
        } elseif (date('M') == 'Sept') {
            $bulan = 'September';
        } elseif (date('M') == 'Oct') {
            $bulan = 'Oktober';
        } elseif (date('M') == 'Nov') {
            $bulan = 'November';
        } elseif (date('M') == 'Dec') {
            $bulan = 'Desember';
        }

        return view('menu.dashboard', [
            'pembukuans'    => $pembukuans,
            'saldo'         => $debit->sum('nominal') - $kredit->sum('nominal'),
            'totalDebit'    => $debit->sum('nominal'),
            'totalKredit'   => $kredit->sum('nominal'),      
            'bulan'         => $bulan,
            'total_bmasuk'  => $total_bmasuk,
            'total_bkeluar' => $total_bkeluar,
            'total_tmasuk'  => $total_tmasuk,
            'total_tkeluar' => $total_tkeluar,
            'janm'          => $janm,
            'jank'          => $jank,
            'febm'          => $febm,
            'febk'          => $febk,
            'marm'          => $marm,
            'mark'          => $mark,
            'aprm'          => $aprm,
            'aprk'          => $aprk,
            'maym'          => $maym,
            'mayk'          => $mayk,
            'junm'          => $junm,
            'junk'          => $junk,
            'julm'          => $julm,
            'julk'          => $julk,
            'augm'          => $augm,
            'augk'          => $augk,
            'sepm'          => $sepm,
            'sepk'          => $sepk,
            'octm'          => $octm,
            'octk'          => $octk,
            'novm'          => $novm,
            'novk'          => $novk,
            'desm'          => $desm,
            'desk'          => $desk,
        ]);
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);

        return view('menu.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name'      => 'required',
            'email'     => 'required|unique:users,email,' . Auth::user()->id,
            'username'  => 'required|unique:users,username,' . Auth::user()->id,
        ]);

        User::findOrFail(Auth::user()->id)->update($validatedData);

        return redirect()->route('dashboard.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function password(Request $request)
    {
        $validatedData = $request->validate([
            'password_old'      => 'required',
            'password_new'      => 'required',
            'password_confirm'  => 'required',
        ]);

        if (!Hash::check($validatedData['password_old'], Auth::user()->password)) {
            return redirect()->route('dashboard.profile')->with('error', 'Password lama Anda salah!');
        }

        if (Hash::check($validatedData['password_new'], Auth::user()->password)) {
            return redirect()->route('dashboard.profile')->with('warning', 'Password baru Anda sama dengan password lama!');
        }

        if ($validatedData['password_new'] != $validatedData['password_confirm']) {
            return redirect()->route('dashboard.profile')->with('error', 'Konfirmasi Password Anda berbeda!');
        }
        
        User::whereId(Auth::user()->id)->update(['password' => Hash::make($validatedData['password_new'])]);

        return redirect()->route('dashboard.profile')->with('success', 'Password Anda berhasil diperbarui!');
    }
}
