@extends('layouts.master')

@section('title', 'Detail Laporan Kegiatan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Laporan Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a 1  href="{{ route('laporankegiatans.index') }}">Data Laporan Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Laporan Kegiatan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="mb-3">
                    <label for="nama_titik" class="form-label">Nama Titik Reklame</label>
                    <input
                        type="text"
                        id="nama_titik"
                        class="form-control"
                        value="{{ $laporankegiatan->titikReklame ? $laporankegiatan->titikReklame->nama_titik : 'Tidak ada data titik reklame' }}"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="jenis_kegiatan" class="form-label">Jenis Kegiatan</label>
                    <input
                        type="text"
                        id="jenis_kegiatan"
                        class="form-control"
                        value="{{ $laporankegiatan->jenis_kegiatan }}"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                    <input
                        type="text"
                        id="tanggal_kegiatan"
                        class="form-control"
                        value="{{ $laporankegiatan->tanggal_kegiatan }}"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="laporan" class="form-label">Laporan</label>
                    <textarea
                        id="laporan"
                        class="form-control"
                        rows="4"
                        readonly
                    >{{ $laporankegiatan->laporan }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input
                        type="text"
                        id="nama_pegawai"
                        class="form-control"
                        value="{{ $laporankegiatan->pegawai ? $laporankegiatan->pegawai->nama_pegawai : 'Tidak ada data pegawai' }}"
                        readonly
                    >
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('laporankegiatans.index') }}" class="btn btn-danger">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
