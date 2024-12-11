@extends('layouts.master')

@section('title', 'Edit Sewa Lahan')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Sewa Lahan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sewalahans.index') }}">Data Sewa Lahan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Sewa Lahan
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
                <form action="{{ route('sewalahans.update', $sewalahan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Titik Reklame (dropdown) -->
                    <div class="form-group">
                        <label for="koordinat_titik">Nama Titik Reklame</label>
                        <select name="koordinat_titik" id="koordinat_titik" class="form-control">
                            @foreach($titikReklames as $titik)
                                <option value="{{ $titik->koordinat_titik }}"
                                    {{ $titik->koordinat_titik == $sewalahan->koordinat_titik ? 'selected' : '' }}>
                                    {{ $titik->nama_titik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_kontrak">No Sewa Lahan</label>
                        <input type="text" name="no_kontrak" id="no_kontrak" class="form-control" value="{{ $sewalahan->no_kontrak }}" required>
                    </div>

                    <!-- Periode Awal -->
                    <div class="form-group">
                        <label for="periode_awal">Periode Awal</label>
                        <input type="date" name="periode_awal" id="periode_awal" class="form-control" value="{{ $sewalahan->periode_awalsl }}" required>
                    </div>

                    <!-- Periode Akhir -->
                    <div class="form-group">
                        <label for="periode_akhir">Periode Akhir</label>
                        <input type="date" name="periode_akhir" id="periode_akhir" class="form-control" value="{{ $sewalahan->periode_akhirsl }}" required>
                    </div>

                    <!-- Ukuran Reklame -->
                    <div class="form-group">
                        <label for="UkuranReklame">Ukuran Reklame</label>
                        @php
                            $selectedReklame = $titikReklames->firstWhere('koordinat_titik', $sewalahan->koordinat_titik);
                            $ukuranReklame = $selectedReklame
                                ? "{$selectedReklame->panjang} x {$selectedReklame->lebar} m, Muka: {$selectedReklame->muka}"
                                : "Tidak ada data ukuran";
                        @endphp
                        <input type="text" name="UkuranReklame" id="UkuranReklame" class="form-control" value="{{ $ukuranReklame }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dokumen_sl">Dokumen Sewa Lahan</label>
                        <input type="file" name="dokumen_sl" id="dokumen_sl" class="form-control">
                        @if ($sewalahan->dokumen_sl)
                            <p><a href="{{ Storage::url($sewalahan->dokumen_sl) }}" target="_blank">Lihat Dokumen</a></p>
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
