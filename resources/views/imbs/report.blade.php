<!DOCTYPE html>
<html>
<head>
    <title>Laporan IMB</title>
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

<h1>Laporan IMB</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>No IMB</th>
            <th>Periode IMB</th>
            <th>Nama Titik Reklame</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($imbs as $index => $imb)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $imb->koordinat_titik }}</td>
                <td>{{ $imb->no_imb }}</td>
                <td>{{ $imb->periode_imb }}</td>
                <td>{{ $titikReklames->firstWhere('koordinat_titik', $imb->koordinat_titik)->nama_titik }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
