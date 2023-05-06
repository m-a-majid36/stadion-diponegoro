@extends('layout.app')
@section('title', 'Semua Pembukuan')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Pembukuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pembukuan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Semua Pembukuan</h5>
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
                        <!-- Revenue Card -->
                        <div class="row">
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Saldo Akhir</h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>@rupiah($saldo)</h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">8%</span> --}}
                                                <span class="text-primary small pt-1 fw-bold">Saldo Sekarang</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Revenue Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Debit</h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>@rupiah($totalDebit)</h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">8%</span> --}}
                                                <span class="text-success small pt-1 fw-bold">Total Debit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Revenue Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card customers-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Kredit</h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>@rupiah($totalKredit)</h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">8%</span> --}}
                                                <span class="text-danger small pt-1 fw-bold">Total Debit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Revenue Card -->
                        </div>
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width="65">No.</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center">Keterangan Tambahan</th>
                                    <th scope="col" class="text-center">Debit</th>
                                    <th scope="col" class="text-center">Kredit</th>
                                    <th scope="col" width="200" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembukuans as $pembukuan)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ date('d-m-Y', strtotime($pembukuan->tgl_transaksi)) }}</td>
                                        <td style="vertical-align: middle">{{ $pembukuan->deskripsi }}</td>
                                        <td style="vertical-align: middle">{{ $pembukuan->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-end">
                                            @if ($pembukuan->jenis == 'D')
                                                @rupiah($pembukuan->nominal)
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-end">
                                            @if ($pembukuan->jenis == 'K')
                                                @rupiah($pembukuan->nominal)
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $pembukuan->id }}">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </button>
                                            @if ($pembukuan->id_pembayaran == 0)
                                                <a href="{{ route('pembukuan.edit', ['id' => encrypt($pembukuan->id)]) }}"
                                                    class="btn btn-warning">
                                                    <i class="bi bi-pencil-square text-white"></i>
                                                </a>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $pembukuan->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('menu.pembukuan.modal')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- / Content -->
@endsection
