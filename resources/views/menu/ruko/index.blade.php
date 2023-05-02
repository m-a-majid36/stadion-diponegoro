@extends('layout.app')
@section('title', 'Ruko')
@section('css')

@endsection
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Ruko</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Ruko</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Ruko</h5>
                        <div>
                            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="bi bi-plus-circle text-white"></i>&nbsp; Tambah Ruko
                            </button>
                            {{-- <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="bi bi-file-earmark-excel"></i>&nbsp; Export Excel
                            </button> --}}
                        </div>
                        @include('menu.ruko.modal-add')
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
                                    <th scope="col" width="150" class="text-center">Kode Ruko</th>
                                    <th scope="col" width="160" class="text-center">Tarif</th>
                                    <th scope="col" class="text-center">Nama Penyewa</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Batas Pembayaran</th>
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="180" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruko as $data)
                                    @include('menu.ruko.modal')
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->kode }}</td>
                                        <td style="vertical-align: middle" class="text-end">@rupiah($data->tarif)
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                -
                                            @else
                                                {{ $data->penyewa->nama }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->deadline != null)
                                                {{ date('d-m-Y', strtotime($data->deadline)) }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->status == 'kosong')
                                                <span class="badge bg-secondary">Kosong</span>
                                            @elseif ($data->status == 'baru')
                                                @if (date('Y-m-d H:i:s') < $data->deadline)
                                                    <span class="badge bg-info">Tanda Jadi</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->deadline)
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @endif
                                            @elseif ($data->status == 'cicil')
                                                @if (date('Y-m-d H:i:s') < $data->deadline)
                                                    <span class="badge bg-warning">Sebagian</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->deadline)
                                                    <span class="badge bg-danger">Belum Bayar Sebagian</span>
                                                @endif
                                            @else
                                                @if (date('Y-m-d H:i:s') < $data->deadline)
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->deadline)
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#sewaModal{{ $data->id }}">
                                                    <i class="bi bi-plus-square text-white"></i>
                                                </button>
                                            @endif
                                            @if ($data->id_penyewa)
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#lepasModal{{ $data->id }}">
                                                    <i class="bi bi-x-square text-white"></i>
                                                </button>
                                                @include('menu.ruko.lepas')
                                            @endif
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $data->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            @if ($data->id_penyewa == 0)
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $data->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
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
@section('script')
@endsection
