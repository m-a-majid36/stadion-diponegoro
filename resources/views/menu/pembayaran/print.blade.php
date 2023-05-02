<!DOCTYPE html>
<html>

<head>
    <title>Kuitansi Ruko Stadion Diponegoro</title>
</head>

<body>
    <h2 style="display: flex; justify-content: center">Kuitansi Ruko Stadion Diponegoro</h2>
    <hr>
    <table width="800" border="0" cellpadding="4" cellspacing="0" style="border: 1px solid #000;">
        <tr>
            <td width="150" valign="top"> Nomor </td>
            <td valign="top"> : {{ $pembayaran->kode }} </td>
        </tr>
        <tr>
            <td valign="top"> Telah diterima dari </td>
            <td valign="top"> : {{ $pembayaran->penyewa->nama }} </td>
        </tr>
        <tr>
            <td valign="top"> Uang sejumlah </td>
            <td valign="top"> : {{ $terbilang }}</td>
        </tr>
        <tr>
            <td valign="top"> Untuk pembayaran </td>
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
</body>

</html>
