@extends('layouts.master')

@section('title', 'Edit Polis Asuransi')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Polis Asuransi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('asuransis.index') }}">Data Polis Asuransi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Polis Asuransi
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
                <form action="{{ route('asuransis.update', $asuransi) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Titik Reklame (dropdown) -->
                    <div class="form-group">
                        <label for="koordinat_titik">Nama Titik Reklame</label>
                        <select name="koordinat_titik" id="koordinat_titik" class="form-control">
                            @foreach($titikReklames as $titik)
                                <option value="{{ $titik->koordinat_titik }}"
                                    {{ $titik->koordinat_titik == $asuransi->koordinat_titik ? 'selected' : '' }}>
                                    {{ $titik->nama_titik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_polis">No Polis</label>
                        <input type="text" name="no_polis" id="no_polis" class="form-control" value="{{ $asuransi->no_polis }}" required>
                    </div>

                    <!-- Periode Awal -->
                    <div class="form-group">
                        <label for="periode_awal">Periode Awal</label>
                        <input type="date" name="periode_awal" id="periode_awal" class="form-control" value="{{ $asuransi->periode_awalas }}" required>
                    </div>

                    <!-- Periode Akhir -->
                    <div class="form-group">
                        <label for="periode_akhir">Periode Akhir</label>
                        <input type="date" name="periode_akhir" id="periode_akhir" class="form-control" value="{{ $asuransi->periode_akhiras }}" required>
                    </div>

                    <!-- Ukuran Reklame -->
                    <div class="form-group">
                        <label for="UkuranReklame">Ukuran Reklame</label>
                        @php
                            $selectedReklame = $titikReklames->firstWhere('koordinat_titik', $asuransi->koordinat_titik);
                            $ukuranReklame = $selectedReklame
                                ? "{$selectedReklame->panjang} x {$selectedReklame->lebar} m, Muka: {$selectedReklame->muka}"
                                : "Tidak ada data ukuran";
                        @endphp
                        <input type="text" name="UkuranReklame" id="UkuranReklame" class="form-control" value="{{ $ukuranReklame }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dokumen_polis">Dokumen Polis</label>
                        <input type="file" name="dokumen_polis" id="dokumen_polis" class="form-control">
                        @if ($asuransi->dokumen_polis)
                            <p><a href="{{ Storage::url($asuransi->dokumen_polis) }}" target="_blank">Lihat Dokumen</a></p>
                        @else
                            <p>Tidak ada dokumen</p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
