@extends('layouts.master')

@section('title', 'Detail Imb')

@section('content')
<div class="app-content-header"> <!--begin::Header-->
    <div class="container-fluid"> <!--begin::Container-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Imb</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('imbs.index') }}">Data Imb</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Imb
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
            $titikReklame = $titikReklames->firstWhere('koordinat_titik', $imb->koordinat_titik);
            @endphp
            <input type="text" id="nama_titik" class="form-control" value="{{ $titikReklame->nama_titik }}" readonly>
            </div>

            <!-- No Imb -->
            <div class="mb-3">
                <label for="no_imb" class="form-label">No Imb</label>
                <input type="text" id="no_imb" class="form-control" value="{{ $imb->no_imb }}" readonly>
            </div>

            <!-- Periode Akhir -->
            <div class="mb-3">
                <label for="periode_imb" class="form-label">Periode IMB</label>
                <input type="date" name="periode_imb" class="form-control" value="{{ $imb->periode_imb}}" required>
            </div>


            <!-- Ukuran Reklame -->
            <div class="mb-3">
                <label for="ukuran_reklame" class="form-label">Ukuran Reklame</label>
                @php
                    $selectedReklame = $titikReklames->firstWhere('koordinat_titik', $imb->koordinat_titik);
                    $ukuranReklame = $selectedReklame
                        ? "{$selectedReklame->panjang} x {$selectedReklame->lebar} m, Muka: {$selectedReklame->muka}"
                        : "Tidak ada data ukuran";
                @endphp
                <input type="text" id="ukuran_reklame" class="form-control" value="{{ $ukuranReklame }}" readonly>
            </div>

            <!-- Dokumen Imb -->
            <div class="mb-3">
                <label for="dokumen_imb" class="form-label">Dokumen Imb</label>
                @if ($imb->dokumen_imb)
                    <p><a href="{{ Storage::url($imb->dokumen_imb) }}" target="_blank">Lihat Dokumen</a></p>
                @else
                    <p class="form-text">Tidak ada dokumen</p>
                @endif
            </div>
        </div>
        </div>

        <!--begin::Footer-->
        <div class="card-footer">
            <a href="{{ route('imbs.index') }}" class="btn btn-danger">Kembali</a>
        </div>
        <!--end::Footer-->
    </div> <!--end::Card-->
</div> <!--end::Row-->
@endsection
