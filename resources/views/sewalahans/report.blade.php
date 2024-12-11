<!DOCTYPE html>
<html>
<head>
    <title>Laporan Sewa Lahan</title>
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

<h1>Laporan Sewa Lahan</h1>


<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No Kontrak</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sewalahans as $index => $sewalahan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $sewalahan->koordinat_titik }}</td>
                <td>{{ $sewalahan->no_kontrak }}</td>
                <td>{{ $sewalahan->periode_awalsl }}</td>
                <td>{{ $sewalahan->periode_akhirsl }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $sewalahan->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>