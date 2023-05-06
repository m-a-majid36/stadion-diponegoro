<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use App\Models\Ruko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::latest()->get();
        $rukos = Ruko::where('id_penyewa', '!=', '0')->orderBy('kode', 'asc')->get();

        return view('menu.penyewa.index', compact('penyewa', 'rukos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();

        return view('menu.penyewa.add', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'          => 'required',
            'nik'           => 'required|unique:penyewas|numeric',
            'telepon'       => 'required|unique:penyewas|min:8|max:20',
            'toko'          => 'required',
            'alamat'        => 'required',
            'province_id'   => 'required',
            'regency_id'    => 'required',
            'district_id'   => 'required',
            'village_id'    => 'required',
            'ktp'           => 'required|image|file',
            'keterangan'    => '',
        ]);
        $validatedData['mulai'] = date('Y-m-d H:i:s');
        $validatedData['selesai'] = null;
        $validatedData['status'] = 'nonaktif';

        $validatedData['ktp'] = $request->file('ktp')->store('ktp');

        $hasil = Penyewa::create($validatedData);

        if ($hasil) {
            return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil ditambahkan!');
        } else {
            return redirect()->route('penyewa.index')->with('error', 'Penyewa gagal ditambahkan!');
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
        $penyewa = Penyewa::findorFail(decrypt($id));
        $provinces = Province::all();
        $regencies = Regency::where('province_id', $penyewa->regency->province_id)->get();
        $districts = District::where('regency_id', $penyewa->district->regency_id)->get();
        $villages = Village::where('district_id', $penyewa->village->district_id)->get();

        return view('menu.penyewa.edit', compact('penyewa', 'provinces', 'regencies', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama'          => 'required',
            'nik'           => 'required|numeric|unique:penyewas,nik,' . $id,
            'telepon'       => 'required|min:8|max:20|unique:penyewas,telepon,' . $id,
            'toko'          => 'required',
            'alamat'        => 'required',
            'province_id'   => 'required',
            'regency_id'    => 'required',
            'district_id'   => 'required',
            'village_id'    => 'required',
            'ktp'           => 'image|file|max:2048',
            'keterangan'    => '',
        ]);

        if ($request->file('ktp')) {
            if ($request->oldKTP) {
                Storage::delete($request->oldKTP);
            }
            $validatedData['ktp'] = $request->file('ktp')->store('ktp');
        }

        $hasil = Penyewa::whereId($id)->update($validatedData);

        if ($hasil) {
            return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil diperbarui!');
        } else {
            return redirect()->route('penyewa.index')->with('error', 'Penyewa gagal diperbarui!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penyewa = Penyewa::findorFail($id);
        if ($penyewa->ktp) {
            Storage::delete($penyewa->ktp);
        }

        $hasil = $penyewa->delete();

        if ($hasil) {
            return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil dihapus!');
        } else {
            return redirect()->route('penyewa.index')->with('error', 'Penyewa gagal dihapus!');
        }
    }

    public function get_regencies(Request $request)
    {
        $id_province = $request->id_province;

        $regencies = Regency::where('province_id', $id_province)->get();

        $option = "<option selected disabled>Pilih Kota/Kabupaten...</option>";
        foreach($regencies as $regency){
            $option .= "<option value='$regency->id'>$regency->name</option>";
        }

        echo $option;
    }

    public function get_districts(Request $request)
    {
        $id_regency = $request->id_regency;

        $districts = District::where('regency_id', $id_regency)->get();

        $option = "<option selected disabled>Pilih Kecamatan...</option>";
        foreach($districts as $district){
            $option .= "<option value='$district->id'>$district->name</option>";
        }

        echo $option;
    }
    
    public function get_villages(Request $request)
    {
        $id_district = $request->id_district;

        $villages = Village::where('district_id', $id_district)->get();

        $option = "<option selected disabled>Pilih Kelurahan/Desa...</option>";
        foreach($villages as $village){
            $option .= "<option value='$village->id'>$village->name</option>";
        }

        echo $option;
    }
}
