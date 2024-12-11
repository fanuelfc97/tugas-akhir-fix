<head>
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

<h1>{{ $judul }}</h1> 

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Koordinat Titik</th>
            <th>Nama Titik</th>
            <th>Jenis Penerangan</th>
            <th>Ukuran Reklame (m²)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($titikReklames as $index => $titikReklame)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $titikReklame->koordinat_titik }}</td>
                <td>{{ $titikReklame->nama_titik }}</td>
                <td>{{ $titikReklame->jenis_penerangan }}</td>
                <td>{{ $titikReklame->panjang }}M x {{ $titikReklame->lebar}}M x {{ $titikReklame->muka}} Muka</td>
            </tr>
        @endforeach
    </tbody>
</table>