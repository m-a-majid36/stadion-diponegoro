@extends('layout.app')
@section('title', 'Pembukuan')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Data Pembukuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pembukuan.index') }}">Pembukuan</a></li>
                    <li class="breadcrumb-item active">Data Pembukuan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-16">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Data Pembukuan</h5>
                            <div style="display: flex">
                                <a href="{{ route('pembukuan.index') }}" class="btn btn-warning mb-3"
                                    style="margin-right: 5px">
                                    <i class="fas fa-angle-double-left"></i>&nbsp; {{ 'Kembali' }}
                                </a>
                                <form action="{{ route('pembukuan.show') }}" method="get" target="blank">
                                    <input type="hidden" name="print" value="1">
                                    <input type="hidden" name="bulanAwal" value="{{ $bulanAwal }}">
                                    <input type="hidden" name="tahunAwal" value="{{ $tahunAwal }}">
                                    <input type="hidden" name="bulanAkhir" value="{{ $bulanAkhir }}">
                                    <input type="hidden" name="tahunAkhir" value="{{ $tahunAkhir }}">
                                    <button type="submit" class="btn btn-info mb-3" style="margin-left: 5px"><i
                                            class="bi bi-printer"></i>&nbsp; Print</button>
                                </form>
                            </div>
                            <h3 class="text-center mb-0" style="color: black">PEMBUKUAN</h3>
                            @if ($bulanAwal == $bulanAkhir && $tahunAwal == $tahunAkhir)
                                <h5 class="card-title text-center mt-0"> Pada Bulan <strong>{{ $bulanAwalNama }}</strong>
                                    Tahun <strong>{{ $tahunAwal }}</strong>
                                </h5>
                            @else
                                <h5 class="card-title text-center mt-0">Pada Bulan <strong>{{ $bulanAwalNama }}</strong>
                                    Tahun
                                    <strong>{{ $tahunAwal }}</strong> sampai Bulan
                                    <strong>{{ $bulanAkhirNama }}</strong>
                                    Tahun <strong>{{ $tahunAkhir }}</strong>
                                </h5>
                            @endif

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" scope="col" style="vertical-align: middle" width="65"
                                            class="text-center">No.</th>
                                        <th rowspan="2" scope="col" style="vertical-align: middle" width="150"
                                            class="text-center">Tanggal</th>
                                        <th rowspan="2" scope="col" style="vertical-align: middle"
                                            class="text-center">
                                            Deskripsi</th>
                                        <th rowspan="2" scope="col" style="vertical-align: middle"
                                            class="text-center">
                                            Keterangan Tambahan</th>
                                        <th colspan="3" scope="col" style="vertical-align: middle"
                                            class="text-center">
                                            Transaksi</th>

                                    <tr>
                                        <th scope="col" style="vertical-align: middle" width="160"
                                            class="text-center">
                                            Debit</th>
                                        <th scope="col" style="vertical-align: middle" width="160"
                                            class="text-center">
                                            Kredit</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembukuans as $pembukuan)
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
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak Ada Data!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-center" style="vertical-align: middle">Total Debit /
                                            Kredit</th>
                                        <th class="text-end" style="vertical-align: middle">@rupiah($totalDebit)</th>
                                        <th class="text-end" style="vertical-align: middle">@rupiah($totalKredit)</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-center" style="vertical-align: middle">Total Saldo
                                        </th>
                                        <th colspan="2" class="text-center" style="vertical-align: middle">
                                            @rupiah($saldo)
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- / Content -->
@endsection
