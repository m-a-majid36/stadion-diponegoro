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
                                <i class="bi bi-person-plus text-white"></i>&nbsp; Tambah Ruko
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
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruko as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->kode }}</td>
                                        <td style="vertical-align: middle" class="text-end">@rupiah($data->tarif)
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa)
                                                Nama Penyewa
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->status == 'kosong')
                                                <span class="badge bg-secondary">Kosong</span>
                                            @elseif ($data->status == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif ($data->status == 'nunggak')
                                                <span class="badge bg-danger">Menunggak</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $data->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $data->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('menu.ruko.modal')
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
