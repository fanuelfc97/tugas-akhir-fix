<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kegiatan</title>
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

<h1>Laporan Kegiatan</h1>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID Pegawai</th>
            <th>Tanggal Kegiatan</th>
            <th>Uraian Kegiatan</th>
            <th>Hasil Kegiatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporanKegiatans as $index => $laporan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $laporan->id_pegawai }}</td>
                <td>{{ $laporan->tgl_kegiatan }}</td>
                <td>{{ $laporan->uraian_kegiatan }}</td>
                <td>{{ $laporan->hasil_kegiatan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>