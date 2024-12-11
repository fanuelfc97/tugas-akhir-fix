@extends('layouts.master')

@section('title', 'Input Laporan Kegiatan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Laporan Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Input Laporan Kegiatan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row my-5">
    <div class="card card-primary card-outline mb-4">
        <form method="POST" action="{{ route('laporankegiatans.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <!-- Dropdown Nama Titik -->
                <div class="mb-3">
                    <label for="nama_titik" class="form-label">Nama Titik Reklame</label>
                    <select name="nama_titik" class="form-select" id="nama_titik" onchange="updateNamaTitik()">
                        <option value="">Pilih Nama Titik</option>
                        @foreach ($titikReklames as $titik)
                            <option value="{{ $titik->koordinat_titik }}" data-koordinat="{{ $titik->koordinat_titik }}">
                                {{ $titik->nama_titik }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Input Koordinat Titik -->
                <div class="mb-3">
                    <label for="koordinat_titik" class="form-label">Koordinat Titik Reklame</label>
                    <input type="text" name="koordinat_titik" class="form-control" id="koordinat_titik" readonly>
                </div>
                <div class="mb-3">
                    <label for='jenis_kegiatan' class="form-label">Jenis Kegiatan</label>
                    <select name='jenis_kegiatan' id='jenis_kegiatan' class="form-select">
                        <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Revisual">Revisual</option>
                        <option value="Controlling">Controlling</option>
                        <option value="Produksi">Produksi</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tanggal_kegiatan" class="form-label">Tangggal Kegiatan</label>
                    <input type="date" name="tanggal_kegiatan" class="form-control" id="tanggal_kegiatan">
                </div>
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <select name="nama_pegawai" class="form-select" id="nama_pegawai" onchange="updateNamaPegawai()">
                        <option value=""disabled selected>Pilih Nama Pegawai</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id_pegawai }}" data-pegawai="{{ $pegawai->id_pegawai }}">
                                {{ $pegawai->nama_pegawai }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Input Koordinat Titik -->
                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">ID Pegawai</label>
                    <input type="text" name="id_pegawai" class="form-control" id="id_pegawai" readonly>
                </div>
                <div class="mb-3">
                    <label for="laporan">Laporan</label>
                    <textarea name="laporan" id="laporan" class="form-control" rows="4" required></textarea>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
        function updateNamaTitik() {
        const selectedTitik = document.getElementById('nama_titik').selectedOptions[0];
        document.getElementById('koordinat_titik').value = selectedTitik.getAttribute('data-koordinat') || '';
        }

        function updateNamaPegawai() {
        const selectedPegawai = document.getElementById('nama_pegawai').selectedOptions[0];
        document.getElementById('id_pegawai').value = selectedPegawai.getAttribute('data-pegawai') || '';
        }

</script>

@endsection
