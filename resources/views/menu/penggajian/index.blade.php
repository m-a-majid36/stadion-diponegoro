@extends('layout.app')
@section('title', 'Penggajian')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Penggajian</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Penggajian</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Penggajian Ruko</h5>
                        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus-circle text-white"></i>&nbsp; Tambah Penggajian
                        </button>
                        @include('menu.penggajian.modal-add')
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
                                    <th scope="col" class="text-center">Nama Karyawan</th>
                                    <th scope="col" width="160" class="text-center">Nominal</th>
                                    <th scope="col" class="text-center">Periode Penggajian</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" width="180" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggajian as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->karyawan->nama }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-end">@rupiah($data->nominal)</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ date('d-m-Y', strtotime($data->awal)) . ' s/d ' . date('d-m-Y', strtotime($data->akhir)) }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->keterangan }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $data->id }}">
                                                <i class="bi bi-eye-fill text-white"></i>
                                            </button>
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $data->id }}">
                                                <i class="bi bi-pencil-square text-white"></i>
                                            </button>
                                            <a href="{{ route('penggajian.print', ['id' => encrypt($data->id)]) }}"
                                                target="blank" class="btn btn-primary text-white"><i
                                                    class="bi bi-printer"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @include('menu.penggajian.modal')
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
    <script type="text/javascript">
        var nominal = document.getElementById('nominal');
        nominal.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatNominal() untuk mengubah angka yang di ketik menjadi format angka
            nominal.value = formatNominal(this.value, 'Rp. ');
        });

        /* Fungsi formatNominal */
        function formatNominal(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                nominal = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                nominal += separator + ribuan.join('.');
            }

            nominal = split[1] != undefined ? nominal + ',' + split[1] : nominal;
            return prefix == undefined ? nominal : (nominal ? 'Rp. ' + nominal : '');
        }
    </script>
@endsection
