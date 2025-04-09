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
            <th>Nomor Laporan</th>
            <th>Nama Pegawai</th>
            <th>Lokasi</th>
            <th>Tanggal Kegiatan</th>
            <th>Jenis Kegiatan</th>
            <th>Uraian Kegiatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporankegiatans as $index => $laporan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $laporan->no_laporan }}</td>
                <td>{{ $laporan->pegawai->nama_pegawai }}</td> 
                <td>{{ $laporan->titikreklame->nama_titik }}</td> 
                <td>{{ $laporan->tanggal_kegiatan }}</td>
                <td>{{ $laporan->jenis_kegiatan }}</td>
                <td>{{ $laporan->laporan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>