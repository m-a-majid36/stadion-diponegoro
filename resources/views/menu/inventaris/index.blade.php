@extends('layout.app')
@section('title', 'Inventaris')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Inventaris</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Inventaris</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Inventaris</h5>
                        <div>
                            <a href="{{ route('inventaris.create') }}" class="btn btn-success mb-3"><i
                                    class="bi bi-plus-circle text-white"></i>&nbsp; Tambah Inventaris</a>
                        </div>
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
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width="65">No.</th>
                                    <th scope="col" width="150" class="text-center">Tanggal Pengadaan</th>
                                    <th scope="col" width="160" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Kode Inventaris</th>
                                    <th scope="col" class="text-center">Harga Satuan</th>
                                    <th scope="col" class="text-center">Jumlah Barang</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" width="180" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventaris as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ date('d-m-Y', strtotime($data->tanggal)) }}</td>
                                        <td style="vertical-align: middle">{{ $data->nama }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->kode }}</td>
                                        <td style="vertical-align: middle" class="text-end">@rupiah($data->harga)</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->jumlah }}</td>
                                        <td style="vertical-align: middle">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $data->id }}">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </button>
                                            <a href="{{ route('inventaris.edit', ['inventaris' => encrypt($data->id)]) }}"
                                                class="btn btn-primary"><i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $data->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('menu.inventaris.modal')
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
