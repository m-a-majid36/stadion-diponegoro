<?php

namespace App\Http\Controllers;

use App\Models\Ruko;
use Illuminate\Http\Request;

class RukoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruko = Ruko::all();

        return view('menu.ruko.index', compact('ruko'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.ruko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
