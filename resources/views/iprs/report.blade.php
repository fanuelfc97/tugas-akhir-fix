<!DOCTYPE html>
<html>
<head>
    <title>Laporan IPR</title>
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

<h1>Laporan IPR</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No IPR</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($iprs as $index => $ipr)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ipr->koordinat_titik }}</td>
                <td>{{ $ipr->no_ipr }}</td>
                <td>{{ $ipr->periode_awalipr }}</td>
                <td>{{ $ipr->periode_akhiripr }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $ipr->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>