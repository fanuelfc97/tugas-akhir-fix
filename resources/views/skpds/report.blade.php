<!DOCTYPE html>
<html>
<head>
    <title>Laporan SKPD</title>
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

<h1>Laporan SKPD</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No SKPD</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skpds as $index => $skpd)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $skpd->koordinat_titik }}</td>
                <td>{{ $skpd->no_skpd }}</td>
                <td>{{ $skpd->periode_awalskpd }}</td>
                <td>{{ $skpd->periode_akhirskpd }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $skpd->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>