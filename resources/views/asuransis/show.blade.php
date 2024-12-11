@extends('layouts.master')

@section('title', 'Detail Polis Asuransi')

@section('content')
<div class="app-content-header"> <!--begin::Header-->
    <div class="container-fluid"> <!--begin::Container-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Polis Asuransi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('asuransis.index') }}">Data Polis Asuransi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Polis Asuransi
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline"> <!--begin::Card-->
        <div class="card-body">
            <!-- Nama Titik Reklame -->
            <div class="mb-3">
                <label for="nama_titik" class="form-label">Nama Titik Reklame</label>
            @php
            $titikReklame = $titikReklames->firstWhere('koordinat_titik', $asuransi->koordinat_titik);
            @endphp
            <input type="text" id="nama_titik" class="form-control" value="{{ $titikReklame->nama_titik }}" readonly>
            </div>

            <!-- No Polis -->
            <div class="mb-3">
                <label for="no_polis" class="form-label">No Polis</label>
                <input type="text" id="no_polis" class="form-control" value="{{ $asuransi->no_polis }}" readonly>
            </div>

            <!-- Periode Awal -->
            <div class="mb-3">
                <label for="periode_awal" class="form-label">Periode Awal</label>
                <input type="text" id="periode_awal" class="form-control" value="{{ $asuransi->periode_awalas }}" readonly>
            </div>

            <!-- Periode Akhir -->
            <div class="mb-3">
                <label for="periode_akhir" class="form-label">Periode Akhir</label>
                <input type="text" id="periode_akhir" class="form-control" value="{{ $asuransi->periode_akhiras }}" readonly>
            </div>

            <!-- Ukuran Reklame -->
            <div class="mb-3">
                <label for="ukuran_reklame" class="form-label">Ukuran Reklame</label>
                @php
                    $selectedReklame = $titikReklames->firstWhere('koordinat_titik', $asuransi->koordinat_titik);
                    $ukuranReklame = $selectedReklame
                        ? "{$selectedReklame->panjang} x {$selectedReklame->lebar} m, Muka: {$selectedReklame->muka}"
                        : "Tidak ada data ukuran";
                @endphp
                <input type="text" id="ukuran_reklame" class="form-control" value="{{ $ukuranReklame }}" readonly>
            </div>

            <!-- Dokumen Polis -->
            <div class="mb-3">
                <label for="dokumen_polis" class="form-label">Dokumen Polis</label>
                @if ($asuransi->dokumen_polis)
                    <p><a href="{{ Storage::url($asuransi->dokumen_polis) }}" target="_blank">Lihat Dokumen</a></p>
                @else
                    <p class="form-text">Tidak ada dokumen</p>
                @endif
            </div>
        </div>
        </div>

        <!--begin::Footer-->
        <div class="card-footer">
            <a href="{{ route('asuransis.index') }}" class="btn btn-danger">Kembali</a>
        </div>
        <!--end::Footer-->
    </div> <!--end::Card-->
</div> <!--end::Row-->
@endsection
