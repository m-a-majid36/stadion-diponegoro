@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Content -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <div class="text-center">
                <h1 class="m-4"><strong>Stadion Diponegoro Semarang</strong></h1>
            </div>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <!-- Row 1 -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
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
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
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

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-12">

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

                        </div><!-- End Customers Card -->
                    </div>
                </div>
            </div><!-- End Row 1 -->

            <!-- Row 2 -->
            <div class="row">
                <!-- Diagram Bulet -->
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                Statistik Transaksi di Bulan {{ $bulan . ' ' . date('Y') }}
                            </h5>
                            <input type="hidden" id="bmasuk" value="{{ $total_bmasuk }}">
                            <input type="hidden" id="bkeluar" value="{{ $total_bkeluar }}">

                            <!-- Pie Chart -->
                            <div id="pieChart" style="min-height: 365px;" class="echart"></div>

                            <script>
                                const bmasuk = document.getElementById("bmasuk").value;
                                const bkeluar = document.getElementById("bkeluar").value;
                                document.addEventListener("DOMContentLoaded", () => {
                                    echarts.init(document.querySelector("#pieChart")).setOption({
                                        // title: {
                                        //     text: 'Referer of a Website',
                                        //     subtext: 'Fake Data',
                                        //     left: 'center'
                                        // },
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            orient: 'vertical',
                                            left: 'left'
                                        },
                                        series: [{
                                            name: 'Total',
                                            type: 'pie',
                                            radius: '50%',
                                            data: [{
                                                    value: bmasuk,
                                                    name: 'Debit'
                                                },
                                                {
                                                    value: bkeluar,
                                                    name: 'Kredit'
                                                }
                                            ],
                                            emphasis: {
                                                itemStyle: {
                                                    shadowBlur: 10,
                                                    shadowOffsetX: 0,
                                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                }
                                            }
                                        }]
                                    });
                                });
                            </script>
                            <!-- End Pie Chart -->
                        </div>
                    </div>
                </div> <!-- End Diagram Bulet -->

                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                Statistik Transaksi Sepanjang Tahun {{ date('Y') }}
                            </h5>
                            <input type="hidden" id="total_tmasuk" value="{{ $total_tmasuk }}">
                            <input type="hidden" id="total_tkeluar" value="{{ $total_tkeluar }}">
                            <input type="hidden" id="janm" value="{{ $janm }}">
                            <input type="hidden" id="jank" value="{{ $jank }}">
                            <input type="hidden" id="febm" value="{{ $febm }}">
                            <input type="hidden" id="febk" value="{{ $febk }}">
                            <input type="hidden" id="marm" value="{{ $marm }}">
                            <input type="hidden" id="mark" value="{{ $mark }}">
                            <input type="hidden" id="aprm" value="{{ $aprm }}">
                            <input type="hidden" id="aprk" value="{{ $aprk }}">
                            <input type="hidden" id="maym" value="{{ $maym }}">
                            <input type="hidden" id="mayk" value="{{ $mayk }}">
                            <input type="hidden" id="junm" value="{{ $junm }}">
                            <input type="hidden" id="junk" value="{{ $junk }}">
                            <input type="hidden" id="julm" value="{{ $julm }}">
                            <input type="hidden" id="julk" value="{{ $julk }}">
                            <input type="hidden" id="augm" value="{{ $augm }}">
                            <input type="hidden" id="augk" value="{{ $augk }}">
                            <input type="hidden" id="sepm" value="{{ $sepm }}">
                            <input type="hidden" id="sepk" value="{{ $sepk }}">
                            <input type="hidden" id="octm" value="{{ $octm }}">
                            <input type="hidden" id="octk" value="{{ $octk }}">
                            <input type="hidden" id="novm" value="{{ $novm }}">
                            <input type="hidden" id="novk" value="{{ $novk }}">
                            <input type="hidden" id="desm" value="{{ $desm }}">
                            <input type="hidden" id="desk" value="{{ $desk }}">

                            <!-- Column Chart -->
                            <div id="columnChart"></div>

                            <script>
                                const tmasuk = document.getElementById("total_tmasuk").value;
                                const tkeluar = document.getElementById("total_tkeluar").value;
                                const janm = document.getElementById("janm").value;
                                const jank = document.getElementById("jank").value;
                                const febm = document.getElementById("febm").value;
                                const febk = document.getElementById("febk").value;
                                const marm = document.getElementById("marm").value;
                                const mark = document.getElementById("mark").value;
                                const aprm = document.getElementById("aprm").value;
                                const aprk = document.getElementById("aprk").value;
                                const maym = document.getElementById("maym").value;
                                const mayk = document.getElementById("mayk").value;
                                const junm = document.getElementById("junm").value;
                                const junk = document.getElementById("junk").value;
                                const julm = document.getElementById("julm").value;
                                const julk = document.getElementById("julk").value;
                                const augm = document.getElementById("augm").value;
                                const augk = document.getElementById("augk").value;
                                const sepm = document.getElementById("sepm").value;
                                const sepk = document.getElementById("sepk").value;
                                const octm = document.getElementById("octm").value;
                                const octk = document.getElementById("octk").value;
                                const novm = document.getElementById("novm").value;
                                const novk = document.getElementById("novk").value;
                                const desm = document.getElementById("desm").value;
                                const desk = document.getElementById("desk").value;
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#columnChart"), {
                                        series: [{
                                            name: 'Debit',
                                            data: [janm, febm, marm, aprm, maym, junm, julm, augm, sepm, octm, novm, desm]
                                        }, {
                                            name: 'Kredit',
                                            data: [jank, febk, mark, aprk, mayk, junk, julk, augk, sepk, octk, novk, desk]
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350
                                        },
                                        plotOptions: {
                                            bar: {
                                                horizontal: false,
                                                columnWidth: '55%',
                                                endingShape: 'rounded'
                                            },
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                        },
                                        xaxis: {
                                            categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                                                'September', 'Oktober', 'November', 'Desember'
                                            ],
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'Nominal (Rp.)'
                                            }
                                        },
                                        fill: {
                                            opacity: 1
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function(val) {
                                                    return "Rp. " + val + ",-"
                                                }
                                            }
                                        }
                                    }).render();
                                });
                            </script>
                            <!-- End Column Chart -->
                        </div>
                    </div>
                </div>

            </div> <!-- End Row 2 -->
        </section>

    </main>
    <!-- / Content -->
@endsection
@section('script')

@endsection
