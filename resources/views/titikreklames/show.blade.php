@extends('layouts.master')

@section('title', 'Detail Titik Reklame')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Titik Reklame</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('titikreklames.index') }}">Data Titik Reklame</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Titik Reklame
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
            <div class="mb-3">
                <label for="koordinat_titik" class="form-label">Koordinat</label>
                <input type="text" name="koordinat_titik" class="form-control" id="koordinat_titik" value="{{ $titikReklame->koordinat_titik }}" readonly>
            </div>
            <div class="mb-3">
                <label for="nama_titik" class="form-label">Koordinat Titik Reklame</label>
                <input type="text" name="nama_titik" class="form-control" id="nama_titik" value="{{ $titikReklame->nama_titik }}" readonly>
            </div>
            <div class="mb-3">
                <label for="ilustrasi_titik" class="form-label">Dokumen Polis Asuransi</label>
                @if($titikReklame->ilustrasi_titik)
                <p><small>Current Document: <a href="{{ asset('storage/' . $titikReklame->ilustrasi_titik) }}" target="_blank">View Document</a></small></p>
                @else
                    <p>Tidak ada dokumen yang diunggah.</p>
                @endif
            </div>

            <div class="mb-3">
                <label for="nama_titik" class="form-label">Status Titik Reklame</label>
                <input type="text" name="status_titik" class="form-control" id="status_titik" value="{{ $titikReklame->status_titik }}" readonly>
            </div>
            <div class="mb-3">
                <label for='jenis_penerangan' class="form-label">Jenis Penerangan</label>
                <input type="text" name="jenis_penerangan" class="form-control" id="jenis_penerangan" value="{{ $titikReklame->jenis_penerangan }}" readonly>
            </div>
            <div class="mb-3">
                <label for='jumlah_lampu', class="form-label">Jumlah Lampu</label>
                <input type="number" name='jumlah_lampu' class="form-control" id='jumlah_lampu' value="{{ $titikReklame->jumlah_lampu }}" readonly>
            </div>
            <div class="mb-3">
                <label for="UkuranReklame" class="form-label">Ukuran Reklame</label>
                <div class="input-group mb-3">
                    <input type="number" name="panjang" class="form-control" placeholder="Panjang (m)" id='panjang' value="{{ $titikReklame->panjang }}" readonly aria-label="panjang" required>
                    <span class="input-group-text">Meter</span>

                    <input type="number" name="lebar" class="form-control" placeholder="Lebar (m)" id='lebar' value="{{ $titikReklame->lebar }}" readonly aria-label="lebar" required>
                    <span class="input-group-text">Meter</span>

                    <input type="number" name="muka" class="form-control" placeholder="Muka (m²)" id='muka' value="{{ $titikReklame->muka }}" readonly aria-label="muka">
                    <span class="input-group-text">Muka</span>
                </div>
            </div>
            </div>
        </div> <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer">
            <a href="{{ route('titikreklames.index') }}" class="btn btn-danger">Kembali</a>
        </div>
        <!--end::Footer-->
    </div> <!--end::Quick Example-->
</d iv> <!--end::Col-->

@endsection
