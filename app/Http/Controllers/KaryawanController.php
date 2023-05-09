<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Karyawan;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::latest()->get();

        return view('menu.karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();

        return view('menu.karyawan.add', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'          => 'required',
            'nik'           => '',
            'ktp'           => 'image|file',
            'telepon'       => '',
            'alamat'        => '',
            'province_id'   => 'required',
            'regency_id'    => 'required',
            'district_id'   => 'required',
            'village_id'    => 'required',
            'status'        => 'required',
            'mulai'         => '',
            'selesai'       => '',
            'keterangan'    => '',
        ]);

        if ($validatedData['mulai'] == null) {
            $validatedData['mulai'] = date('Y-m-d H:i:s');
        }

        $validatedData['selesai'] = null;

        if ($request->file('ktp')) {
            $validatedData['ktp'] = $request->file('ktp')->store('ktpkaryawan');
        }

        Karyawan::create($validatedData);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = Karyawan::findOrFail(decrypt($id));
        $provinces = Province::all();
        $regencies = Regency::where('province_id', $karyawan->regency->province_id)->get();
        $districts = District::where('regency_id', $karyawan->district->regency_id)->get();
        $villages = Village::where('district_id', $karyawan->village->district_id)->get();

        return view('menu.karyawan.edit', compact('karyawan', 'provinces', 'regencies', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validatedData = $request->validate([
            'nama'          => 'required',
            'nik'           => '',
            'ktp'           => 'image|file',
            'telepon'       => '',
            'alamat'        => '',
            'province_id'   => 'required',
            'regency_id'    => 'required',
            'district_id'   => 'required',
            'village_id'    => 'required',
            'status'        => 'required',
            'mulai'         => '',
            'keterangan'    => '',
        ]);

        if ($request->file('ktp')) {
            if ($request->oldKtp) {
                Storage::delete($request->oldKtp);
            }
            $validatedData['ktp'] = $request->file('ktp')->store('ktpkaryawan');
        }

        if ($karyawan->status == 'A' && $validatedData['status'] == 'N') {
            $validatedData['selesai'] = date('Y-m-d H:i:s');
        }

        if ($karyawan->status == 'N' && $validatedData['status'] == 'A') {
            $validatedData['selesai'] = null;
        }

        $karyawan->update($validatedData);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->ktp) {
            Storage::delete($karyawan->ktp);
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil dihapus!');
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
