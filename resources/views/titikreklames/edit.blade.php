@extends('layouts.master')

@section('title', 'Edit Titik Reklame')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Titik Reklame</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('titikreklames.index') }}">Data Titik Reklame</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Titik Reklame
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<!-- Form Section -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">        <form method="POST" action="{{ route('titikreklames.update', $titikReklame->koordinat_titik) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Error Display -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">

                <!-- Koordinat Titik Reklame -->
                <div class="mb-3">
                    <label for="koordinat_titik" class="form-label">Koordinat Titik Reklame</label>
                    <input type="text" name="koordinat_titik" id="koordinat_titik"
                           class="form-control" value="{{ old('koordinat_titik', $titikReklame->koordinat_titik) }}"
                           required>
                </div>

                <!-- Alamat Titik Reklame -->
                <div class="mb-3">
                    <label for="nama_titik" class="form-label">Alamat Titik Reklame</label>
                    <input type="text" name="nama_titik" id="nama_titik"
                           class="form-control" value="{{ old('nama_titik', $titikReklame->nama_titik) }}"
                           required>
                </div>

                <!-- Gambar Ilustrasi -->
                <div class="mb-3">
                    <label for="ilustrasi_titik" class="form-label">Gambar Ilustrasi Titik Reklame</label>
                    <div class="input-group">
                        <input type="file" name="ilustrasi_titik" id="ilustrasi_titik" class="form-control">
                        <label class="input-group-text" for="ilustrasi_titik">Upload</label>
                    </div>
                    @if($titikReklame->ilustrasi_titik)
                        <small>Current Image: <a href="{{ asset('storage/' . $titikReklame->ilustrasi_titik) }}" target="_blank">View Image</a></small>
                    @endif
                </div>

                <!-- Status Titik Reklame -->
                <div class="mb-3">
                    <label class="form-label">Status Titik Reklame</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="status_titik" id="status_available" value="available"
                               class="form-check-input" {{ $titikReklame->status_titik == 'available' ? 'checked' : '' }}>
                        <label for="status_available" class="form-check-label">Available</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="status_titik" id="status_sold" value="sold"
                               class="form-check-input" {{ $titikReklame->status_titik == 'sold' ? 'checked' : '' }}>
                        <label for="status_sold" class="form-check-label">Sold</label>
                    </div>
                </div>

                <!-- Jenis Penerangan -->
                <div class="mb-3">
                    <label for="jenis_penerangan" class="form-label">Jenis Penerangan</label>
                    <select name="jenis_penerangan" id="jenis_penerangan" class="form-select" required>
                        <option value="" disabled selected>Pilih Jenis Penerangan</option>
                        @foreach(['Frontlight', 'BackLight', 'NonLight'] as $jenis)
                            <option value="{{ $jenis }}" {{ $titikReklame->jenis_penerangan == $jenis ? 'selected' : '' }}>
                                {{ ucfirst($jenis) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah Lampu -->
                <div class="mb-3">
                    <label for="jumlah_lampu" class="form-label">Jumlah Lampu</label>
                    <input type="number" name="jumlah_lampu" id="jumlah_lampu"
                           class="form-control" value="{{ old('jumlah_lampu', $titikReklame->jumlah_lampu) }}">
                </div>

                <!-- Ukuran Reklame -->
                <div class="mb-3">
                    <label class="form-label">Ukuran Reklame (m)</label>
                    <div class="input-group">
                        <input type="number" name="panjang" class="form-control" placeholder="Panjang (m)"
                               value="{{ old('panjang', $titikReklame->panjang) }}" required>
                        <span class="input-group-text">Meter</span>

                        <input type="number" name="lebar" class="form-control" placeholder="Lebar (m)"
                               value="{{ old('lebar', $titikReklame->lebar) }}" required>
                        <span class="input-group-text">Meter</span>

                        <input type="number" name="muka" class="form-control" placeholder="Muka (m²)"
                               value="{{ old('muka', $titikReklame->muka) }}">
                        <span class="input-group-text">Muka</span>
                    </div>
                </div>

            </div>

            <!-- Footer Section -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('titikreklames.index') }}" class="btn btn-danger">Kembali</a>

            </div>
        </form>
            </div>
        </div>
    </div>
</div>

@endsection
