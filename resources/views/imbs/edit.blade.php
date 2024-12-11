@extends('layouts.master')

@section('title', 'Edit Imb')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Imb</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('imbs.index') }}">Data Imb</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Imb
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
                <form action="{{ route('imbs.update', $imb) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Titik Reklame (dropdown) -->
                    <div class="form-group">
                        <label for="koordinat_titik">Nama Titik Reklame</label>
                        <select name="koordinat_titik" id="koordinat_titik" class="form-control">
                            @foreach($titikReklames as $titik)
                                <option value="{{ $titik->koordinat_titik }}"
                                    {{ $titik->koordinat_titik == $imb->koordinat_titik ? 'selected' : '' }}>
                                    {{ $titik->nama_titik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_imb">No Imb</label>
                        <input type="text" name="no_imb" id="no_imb" class="form-control" value="{{ $imb->no_imb }}" required>
                    </div>

                    <!-- Periode Awal -->
                    <div class="form-group">
                        <label for="periode_imb">Periode IMB</label>
                        <input type="date" name="periode_imb" class="form-control" value="{{ $imb->periode_imb}}" required>
                    </div>

                    <!-- Ukuran Reklame -->
                    <div class="form-group">
                        <label for="UkuranReklame">Ukuran Reklame</label>
                        @php
                            $selectedReklame = $titikReklames->firstWhere('koordinat_titik', $imb->koordinat_titik);
                            $ukuranReklame = $selectedReklame
                                ? "{$selectedReklame->panjang} x {$selectedReklame->lebar} m, Muka: {$selectedReklame->muka}"
                                : "Tidak ada data ukuran";
                        @endphp
                        <input type="text" name="UkuranReklame" id="UkuranReklame" class="form-control" value="{{ $ukuranReklame }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="dokumen_imb">Dokumen Imb</label>
                        <input type="file" name="dokumen_imb" id="dokumen_imb" class="form-control">
                        @if ($imb->dokumen_imb)
                            <p><a href="{{ Storage::url($imb->dokumen_imb) }}" target="_blank">Lihat Dokumen</a></p>
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
