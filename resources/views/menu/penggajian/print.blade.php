<!DOCTYPE html>
<html>

<head>
    <title>Kuitansi Gaji Stadion Diponegoro</title>
</head>
<style>
    @page {
        size: a4 potrait;
        margin-left: 1cm;
        margin-right: 1cm;
    }

    * {
        line-height: 0.8em;
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
        margin-bottom: 0.5em
    }

    table {
        border-collapse: collapse;
        width: 100%
    }

    table.line-height-table {
        line-height: 1em
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
                <td colspan="4" class="text-center" style="border-bottom:1px solid #000;">
                    <h2 style="display: flex; justify-content: center">Kuitansi Gaji Stadion Diponegoro</h2>
                </td>
            </tr>
            <tr>
                <td width="100" valign="top"> Nomor </td>
                <td width="1" valign="top">:</td>
                <td colspan="2" valign="top">{{ $penggajian->kode }}</td>
            </tr>
            <tr>
                <td valign="top"> Nama Karyawan </td>
                <td valign="top">:</td>
                <td colspan="2" valign="top">{{ $penggajian->karyawan->nama }} </td>
            </tr>
            <tr>
                <td valign="top"> Uang sebanyak </td>
                <td valign="top">:</td>
                <td colspan="2" valign="top">{{ $terbilang }}</td>
            </tr>
            <tr>
                <td valign="top"> Periode Penggajian </td>
                <td valign="top">:</td>
                <td colspan="2" valign="top">{{ $periode }}</td>
            </tr>
            <tr>
                <td valign="top"> Guna membayar </td>
                <td valign="top">:</td>
                <td colspan="2" valign="top"> Gaji {{ $penggajian->karyawan->nama }} Periode {{ $periode }}
                    {{ $penggajian->keterangan ? '|' : '' }} {{ $penggajian->keterangan }}</td>
            </tr>
            <tr>
                <td valign="top" colspan="4" align="right" height="80">{{ $tanggal }}</td>
            </tr>
            <tr>
                <td colspan="2" valign="bottom">
                    <h4>Terbilang : </h4>
                    <h3 style="line-height: 1em">@rupiah($penggajian->nominal)</h3>
                </td>
                <td valign="bottom" align="center"> {{ $penggajian->karyawan->nama }}
                    <hr>Karyawan
                </td>
                <td valign="bottom" align="center">
                    <hr>Pengelola Stadion
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
