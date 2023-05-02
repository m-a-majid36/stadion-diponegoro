<!DOCTYPE html>
<html>

<head>
    <title>Kuitansi Ruko Stadion Diponegoro</title>
</head>
<style>
    @page {
        size: a4 potrait;
        margin-left: 1cm;
        margin-right: 1cm;
    }

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

    .align-top {
        vertical-align: top
    }
</style>

<body style="margin: 20px 50px">
    <section class="font-cambria">
        <table width="550" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #000;">
            <tr>
                <td colspan="2" class="text-center" style="border-bottom:1px solid #000;">
                    <h2 style="display: flex; justify-content: center">Kuitansi Ruko Stadion Diponegoro</h2>
                </td>
            </tr>
            <tr>
                <td width="150" valign="top"> Nomor </td>
                <td valign="top"> : {{ $pembayaran->kode }} </td>
            </tr>
            <tr>
                <td valign="top"> Telah diterima dari </td>
                <td valign="top"> : {{ $pembayaran->penyewa->nama }} </td>
            </tr>
            <tr>
                <td valign="top"> Uang sebanyak </td>
                <td valign="top"> : {{ $terbilang }}</td>
            </tr>
            <tr>
                <td valign="top"> Guna membayar </td>
                <td valign="top"> : Ruko {{ $pembayaran->ruko->kode }} {{ $pembayaran->keterangan ? '|' : '' }}
                    {{ $pembayaran->keterangan }}</td>
            </tr>
            <tr>
                <td valign="bottom">
                    <h4>Terbilang : </h4>
                    <h3>@rupiah($pembayaran->nominal)</h3>
                </td>
                <td valign="top" align="right" height="100"> {{ $tanggal }} </td>
            </tr>
        </table>
    </section>
</body>

</html>
