<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembukuan</title>
    <style>
        * {
            line-height: 1.2em;
            font-size: 12pt;
            margin: 0;

        }

        body {
            margin-left: 4;
        }

        .font-arial {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif
        }

        .font-cambria {
            font-family: Cambria, Georgia, serif
        }

        .text-center {
            text-align: center
        }

        .margin-bottom {
            margin-bottom: 1.2em
        }

        table {
            border-collapse: collapse;
            width: 100%
        }

        table.line-height-table {
            line-height: 2em
        }

        table .col-center {
            text-align: center
        }

        #header table td {
            padding: 5px
        }

        img.center {
            display: block;
            margin: 0 auto
        }

        img.logo {
            width: 93px;
            height: 123px
        }

        img.certificate {
            padding: 0 10px;
            width: 110px;
            height: 64px
        }

        .head-info td {
            vertical-align: top;
            font-size: 8pt
        }

        .yth {
            padding: 20px 0
        }

        .align-top {
            vertical-align: top
        }
    </style>
</head>

<body style="margin: 20px 50px">
    <section class="font-cambria text-center">
        <div class="yth">
            <h2>PEMBUKUAN<br>Stadion Diponegoro - Semarang</h2>
            @if ($pbulanAwal == $pbulanAkhir && $ptahunAwal == $ptahunAkhir)
                <h3>Pada Bulan <strong>{{ $pbulanAwalNama }}</strong> Tahun <strong>{{ $ptahunAwal }}</strong></h3>
            @else
                <h3>Pada Bulan <strong>{{ $pbulanAwalNama }}</strong> Tahun <strong>{{ $ptahunAwal }}</strong> sampai
                    Bulan <strong>{{ $pbulanAkhirNama }}</strong> Tahun <strong>{{ $ptahunAkhir }}</strong>
                </h3>
            @endif
        </div>
    </section>
    <section>
        <table width="500" border="1" style="border: 1px solid #000;">
            <thead>
                <tr>
                    <th rowspan="2" scope="col" style="vertical-align: middle" class="text-center">
                        No.</th>
                    <th rowspan="2" scope="col" style="vertical-align: middle" width="50" class="text-center">
                        Tanggal</th>
                    <th rowspan="2" scope="col" style="vertical-align: middle" class="text-center">
                        Deskripsi</th>
                    <th rowspan="2" scope="col" style="vertical-align: middle" class="text-center">
                        Keterangan Tambahan</th>
                    <th colspan="2" scope="col" style="vertical-align: middle" class="text-center">
                        Transaksi</th>

                <tr>
                    <th scope="col" style="vertical-align: middle" width="100" class="text-center">
                        Debit</th>
                    <th scope="col" style="vertical-align: middle" width="100" class="text-center">
                        Kredit</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                @forelse ($ppembukuans as $pembukuan)
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
                            @endif
                        </td>
                        <td style="vertical-align: middle" class="text-end">
                            @if ($pembukuan->jenis == 'K')
                                @rupiah($pembukuan->nominal)
                            @else
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
                    <th class="text-end" style="vertical-align: middle">@rupiah($ptotalDebit)</th>
                    <th class="text-end" style="vertical-align: middle">@rupiah($ptotalKredit)</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center" style="vertical-align: middle">Total Saldo
                    </th>
                    <th colspan="2" class="text-center" style="vertical-align: middle">
                        @rupiah($psaldo)
                    </th>
                </tr>
            </tfoot>
        </table>
    </section>
</body>

</html>
