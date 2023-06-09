@extends('layout.app')
@section('title', 'Accounts Receivable')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Accounts Receivable</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Accounts Receivable</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Accounts Receivable</h5>
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width="65">No.</th>
                                    <th scope="col" width="150" class="text-center">Kode Ruko</th>
                                    <th scope="col" class="text-center">Nama Penyewa</th>
                                    <th scope="col" class="text-center">Nama Toko</th>
                                    <th scope="col" class="text-center">Due Date</th>
                                    <th scope="col" width="100" class="text-center">Status Pembayaran</th>
                                    <th scope="col" class="text-center">Payment Overdue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruko as $data)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">{{ $data->kode }}</td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                -
                                            @else
                                                {{ $data->penyewa->nama }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                -
                                            @else
                                                {{ $data->penyewa->toko }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->deadline != null)
                                                {{ date('d-m-Y', strtotime($data->deadline)) }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                <span class="badge bg-secondary">Kosong</span>
                                            @else
                                                @if (now() <= $data->deadline)
                                                    @if (now()->diffInDays($data->deadline) <= 7)
                                                        <span class="badge bg-warning">Waiting</span>
                                                    @elseif (now()->diffInDays($data->deadline) > 7)
                                                        <span class="badge bg-success">Paid</span>
                                                    @endif
                                                @elseif (now() > $data->deadline)
                                                    <span class="badge bg-danger">Unpaid</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            @if ($data->id_penyewa == 0)
                                                Kosong
                                            @else
                                                @if (now() <= $data->deadline)
                                                    @if (now()->diffInDays($data->deadline) == 0)
                                                        -1
                                                    @else
                                                        {{ '-' . now()->diffInDays($data->deadline) }}
                                                    @endif
                                                @elseif (now() > $data->deadline)
                                                    {{ now()->diffInDays($data->deadline) }}
                                                @endif
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
