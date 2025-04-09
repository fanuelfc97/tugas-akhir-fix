@extends('layouts.master')

@section('title', 'Data Laporan Kegiatan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Laporan Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Laporan Kegiatan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display error messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Button to create new report -->
                @if (Auth::user()->jabatan == 'Manager Operasional')
                    <a href="{{ route('laporankegiatans.create') }}" class="btn btn-primary mb-2">Tambah Laporan Kegiatan</a>
                    <a href="#" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#filterModal">Generate Report</a>

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('laporankegiatans.generateReport') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Awal:</label> 
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}"> 
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir:</label> 
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
                @endif
                

                <!-- Table to display reports -->
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Titik Reklame</th>
                                        <th>Koordinat Titik</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Laporan</th>
                                        <th>Nama Pegawai</th>
                                        <th>ID Pegawai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laporankegiatans as $index => $laporan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <!-- Nama Titik Reklame -->
                                            <td>
                                                @php
                                                    $titikReklame = $titikReklames->firstWhere('koordinat_titik', $laporan->koordinat_titik);
                                                @endphp
                                                {{ $titikReklame ? $titikReklame->nama_titik : 'Tidak ada data nama titik' }}
                                            </td>

                                            <td>{{ $laporan->koordinat_titik }}</td>
                                            <td>{{ $laporan->jenis_kegiatan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal_kegiatan)->format('d-m-Y') }}</td>
                                            <td>{{ $laporan->laporan }}</td>

                                            <!-- Nama Pegawai -->
                                            @php
                                                $pegawai = $pegawais->firstWhere('id_pegawai', $laporan->id_pegawai);
                                            @endphp
                                            <td>{{ $pegawai ? $pegawai->nama_pegawai : 'Tidak ada data pegawai' }}</td>
                                            <td>{{ $laporan->id_pegawai }}</td>
                                            <td>
                                                <!-- Detail button -->
                                                <a href="{{ route('laporankegiatans.show', str_replace('/', '', $laporan->no_laporan)) }}" class="btn btn-info btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination links -->
                            {{ $laporankegiatans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
