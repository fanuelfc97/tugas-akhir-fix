<!DOCTYPE html>
<html>
<head>
    <title>Laporan Asuransi</title>
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

<h1>Laporan Asuransi</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No Polis</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asuransis as $index => $asuransi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $asuransi->koordinat_titik }}</td>
                <td>{{ $asuransi->no_polis }}</td>
                <td>{{ $asuransi->periode_awalas }}</td>
                <td>{{ $asuransi->periode_akhiras }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $asuransi->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>