@extends('layout.app')
@section('title', 'Edit Ruko')
@section('content')
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Edit Ruko</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ruko.index') }}">Data Ruko</a></li>
                    <li class="breadcrumb-item active">Edit Ruko</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Ruko</h5>
                        @if (session()->has('success'))
                            <div class="mt-3 alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="mt-3 alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('ruko.update', ['ruko' => $ruko->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mt-2">
                                <label for="kode" class="col-form-label col-2">Kode Ruko <span
                                        class="text-danger">*</span></label>
                                <div class="col-10">
                                    <input type="text" id="kode" name="kode" required
                                        class="form-control @error('kode') is-invalid @enderror"
                                        value="{{ old('kode') ? old('kode') : $ruko->kode }}">
                                    @error('kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="tarif" class="col-form-label col-2">Tarif Ruko <span
                                        class="text-danger">*</span></label>
                                <div class="col-10">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="text" id="tarif" name="tarif" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
                                            class="form-control @error('tarif') is-invalid @enderror"
                                            value="{{ old('tarif') ? old('tarif') : $ruko->tarif }}">
                                        <span class="input-group-text">.00</span>
                                        @error('tarif')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="keterangan" class="col-form-label col-2">Keterangan</label>
                                <div class="col-10">
                                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                        style="height: 100px"></textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Perbarui Ruko</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
