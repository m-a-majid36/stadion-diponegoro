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
                            <a href="{{ route('ruko.create') }}" class="btn btn-success mb-3">
                                <i class="bi bi-person-plus text-white"></i>&nbsp; Tambah Ruko
                            </a>
                            {{-- <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="bi bi-file-earmark-excel"></i>&nbsp; Export Excel
                            </button> --}}
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
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col" width="65">No.</th>
                                    <th scope="col" class="text-center">Kode Ruko</th>
                                    <th scope="col" class="text-center">Tarif</th>
                                    <th scope="col" class="text-center">Nama Penyewa</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="95" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruko as $data)
                                    <tr>
                                        <td style="vertical-align: middle"><strong>{{ $loop->iteration }}</strong></td>
                                        <td style="vertical-align: middle">{{ $data->kode }}</td>
                                        <td style="vertical-align: middle">{{ $data->tarif }}</td>
                                        <td style="vertical-align: middle">Nama Penyewa</td>
                                        <td style="vertical-align: middle">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            status
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <a class="btn btn-info mx-2" href="#">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </a>
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
    <script>
        let table = new DataTable('#datatab');
    </script>
@endsection
