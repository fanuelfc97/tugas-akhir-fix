<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bank Garansi</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Laporan Bank Garansi</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No Jaminan</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bankgaransis as $index => $bankgaransi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $bankgaransi->koordinat_titik }}</td>
                <td>{{ $bankgaransi->no_jaminan }}</td>
                <td>{{ $bankgaransi->periode_awalbg }}</td>
                <td>{{ $bankgaransi->periode_akhirbg }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $bankgaransi->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>