@extends('layouts.master')

@section('title', 'Input Imb')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Imb</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Input Imb</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row my-5">
    <div class="card card-primary card-outline mb-4">
        <form method="POST" action="{{ route('imbs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="mb-3">
                    <label for="no_imb" class="form-label">No IMB</label>
                    <input type="text" name="no_imb" class="form-control" id="no_imb" placeholder="Masukkan No IMB">
                </div>

                <!-- Dropdown Nama Titik -->
                <div class="mb-3">
                    <label for="nama_titik" class="form-label">Nama Titik Reklame</label>
                    <select name="nama_titik" class="form-select" id="nama_titik" onchange="updateUkuranReklame()">
                        <option value="">Pilih Nama Titik</option>
                        @foreach ($titikReklames as $titik)
                            <option value="{{ $titik->koordinat_titik }}" data-koordinat="{{ $titik->koordinat_titik }}"
                                    data-panjang="{{ $titik->panjang }}" data-lebar="{{ $titik->lebar }}" data-muka="{{ $titik->muka }}">
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

                <!-- Sisa form tetap sama -->
                <div class="mb-3">
                    <label for="periode_imb" class="form-label">Periode IMB</label>
                    <input type="date" name="periode_imb" class="form-control" id="periode_imb">
                </div>

                <div class="mb-3">
                    <label for="dokumen_imb" class="form-label">Dokumen Imb</label>
                    <div class="input-group mb-3">
                        <input type="file" name="dokumen_imb" class="form-control" id="dokumen_imb" required>
                        <label class="input-group-text" for="dokumen_imb">Upload</label>
                    </div>
                </div>

                <!-- Ukuran Reklame fields will update based on nama_titik -->
                <div class="form-group">
                    <label>Ukuran Reklame</label>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="panjang">Panjang (Meter)</label>
                            <input type="number" name="panjang" class="form-control" id="panjang" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="lebar">Lebar (Meter)</label>
                            <input type="number" name="lebar" class="form-control" id="lebar" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="muka">Muka</label>
                            <input type="number" name="muka" class="form-control" id="muka" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateUkuranReklame() {
        const selectedTitik = document.getElementById('nama_titik').selectedOptions[0];
        document.getElementById('koordinat_titik').value = selectedTitik.getAttribute('data-koordinat') || '';
        document.getElementById('panjang').value = selectedTitik.getAttribute('data-panjang') || '';
        document.getElementById('lebar').value = selectedTitik.getAttribute('data-lebar') || '';
        document.getElementById('muka').value = selectedTitik.getAttribute('data-muka') || '';
    }
</script>

@endsection
