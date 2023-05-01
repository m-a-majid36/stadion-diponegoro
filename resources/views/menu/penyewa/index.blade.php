@extends('layout.app')
@section('title', 'Penyewa')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Penyewa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Penyewa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Penyewa</h5>
                        <div>
                            <a href="{{ route('penyewa.create') }}" class="btn btn-success mb-3"><i
                                    class="bi bi-person-plus text-white"></i>&nbsp; Tambah Penyewa</a>
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
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Nomor Telepon</th>
                                    <th scope="col" class="text-center">Nama Toko</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="200" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penyewa as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->nama }}</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->telepon }}</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->toko }}</td>
                                        <td style="vertical-align: middle">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->status == 'nonaktif')
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @elseif ($data->status == 'baru')
                                                @if (date('Y-m-d H:i:s') < $data->selesai)
                                                    <span class="badge bg-info">Tanda Jadi</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @endif
                                            @elseif ($data->status == 'cicil')
                                                @if (date('Y-m-d H:i:s') < $data->selesai)
                                                    <span class="badge bg-warning">Sebagian</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                                    <span class="badge bg-danger">Belum Bayar Sebagian</span>
                                                @endif
                                            @else
                                                @if (date('Y-m-d H:i:s') < $data->selesai)
                                                    <span class="badge bg-success">Lunas</span>
                                                @elseif (date('Y-m-d H:i:s') > $data->selesai)
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $data->id }}">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </button>
                                            <a href="{{ route('penyewa.edit', ['penyewa' => encrypt($data->id)]) }}"
                                                class="btn btn-primary"><i class="bi bi-pencil-square"></i>
                                            </a>
                                            @if ($data->status == 'nonaktif')
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $data->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @include('menu.penyewa.modal')
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
