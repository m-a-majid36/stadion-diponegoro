@extends('layout.app')
@section('title', 'Pemabayaran')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Pembayaran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Pembayaran</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Pembayaran Ruko</h5>
                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-circle text-white"></i>&nbsp; Tambah Pembayaran
                        </button>
                        @include('menu.pembayaran.modal-add')
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
                                    <th scope="col" width="150" class="text-center">Tanggal</th>
                                    <th scope="col" width="150" class="text-center">Kode Ruko</th>
                                    <th scope="col" width="160" class="text-center">Tarif</th>
                                    <th scope="col" class="text-center">Nama Penyewa</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" width="100" class="text-center">Status</th>
                                    <th scope="col" width="150" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->ruko->kode }}</td>
                                        <td style="vertical-align: middle" class="text-center">@rupiah($data->nominal)</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->penyewa->nama }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->status == 'baru')
                                                <span class="badge bg-primary">DP (Tanda Jadi)</span>
                                            @elseif ($data->status == 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @elseif ($data->status == 'cicil')
                                                <span class="badge bg-info">Sebagian</span>
                                            @elseif ($data->status == 'telat')
                                                <span class="badge bg-warning">Telat</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $data->id }}">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </button>
                                            <a href="#" class="btn btn-info"><i class="bi bi-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @include('menu.pembayaran.modal')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </main>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $("#id_ruko").change(function() {
                var id_ruko = $(this).val();
                $.ajax({
                    url: "/pembayaran/ruko/" + id_ruko,
                    type: "GET",
                    success: function(data) {
                        var ruko = data.ruko;
                        var html_nama = ``
                    }
                })
            });
        });
    </script>
@endsection
