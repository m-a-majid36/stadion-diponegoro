@extends('layout.app')
@section('title', 'Pembukuan')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Pembukuan Per Periode</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pembukuan Per Periode</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pembukuan Per Periode</h5>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('pembukuan.show') }}" method="GET" class="row">
                            <div class="col-lg-6">
                                <div class="col-12 mt-3 text-center">
                                    <strong>Pilih Waktu Awal</strong>
                                </div>
                                <div class="col-12">
                                    <label for="bulanAwal" class="form-label">Bulan Awal <span
                                            class="text-danger">*</span></label>
                                    <select id="bulanAwal" name="bulanAwal" required
                                        class="form-select @error('bulanAwal') is-invalid @enderror">
                                        <option selected disabled value="0">Pilih Bulan Awal...</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    @error('bulanAwal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="tahunAwal" class="form-label">Tahun Awal <span
                                            class="text-danger">*</span></label>
                                    <select id="tahunAwal" name="tahunAwal" required
                                        class="form-select @error('tahunAwal') is-invalid @enderror">
                                        <option selected disabled value="0">Pilih Tahun Awal...</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahunAwal')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12 mt-3 text-center">
                                    <strong>Pilih Waktu Akhir</strong>
                                </div>
                                <div class="col-12">
                                    <label for="bulanAkhir" class="form-label">Bulan Akhir <span
                                            class="text-danger">*</span></label>
                                    <select id="bulanAkhir" name="bulanAkhir" required
                                        class="form-select @error('bulanAkhir') is-invalid @enderror">
                                        <option selected disabled value="0">Pilih Bulan Akhir...</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    @error('bulanAkhir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="tahunAkhir" class="form-label">Tahun Akhir <span
                                            class="text-danger">*</span></label>
                                    <select id="tahunAkhir" name="tahunAkhir" required
                                        class="form-select @error('tahunAkhir') is-invalid @enderror">
                                        <option selected disabled value="0">Pilih Tahun Akhir...</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahunAkhir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary text-center">Lihat Pembukuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- / Content -->
@endsection
