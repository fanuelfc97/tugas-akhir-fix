@extends('layouts.master')

@section('title', 'Input Titik Reklame')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Titik Reklame</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Input Titik Reklame
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<div class="row my-5"> <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
        <form method="POST" action="{{ route('titikreklames.store') }}" enctype="multipart/form-data"> <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="koordinat_titik" class="form-label">Koordinat Titik Reklame</label>
                    <input type="text" name="koordinat_titik" class="form-control" id="koordinat_titik">
                </div>
                <div class="mb-3">
                    <label for='nama_titik' class="form-label">Alamat Titik Reklame</label>
                    <input type="text" name='nama_titik' class="form-control" id='nama_titik'>
                </div>
                <div class="mb-3">
                    <label for='ilustrasi_titik' class="form-label">Gambar Ilustrasi Titik Reklame</label>
                    <div class="input-group mb-3">
                        <input type="file" name='ilustrasi_titik' class="form-control" id='ilustrasi_titik' required>
                        <label class="input-group-text" for='ilustrasi_titik'>Upload</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Status Titik Reklame</label><br>
                    <div>
                        <input type="radio" name='status_titik', id='status_titik', value="available">
                        <label for="active">Available</label><br>
                        <input type="radio" name='status_titik', id='status_titik', value="sold">
                        <label for="inactive">Sold</label><br>
                    </div>
                </div>
                <div class="mb-3">
                    <label for='jenis_penerangan' class="form-label">Jenis Penerangan</label>
                    <select name='jenis_penerangan' id='jenis_penerangan' class="form-select">
                        <option value="" disabled selected>Pilih Jenis Penerangan</option>
                        <option value="Frontlight">Front Light</option>
                        <option value="BackLight">Back Light</option>
                        <option value="NonLight">Non Light</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for='jumlah_lampu', class="form-label">Jumlah Lampu</label>
                    <input type="number" name='jumlah_lampu', class="form-control" id='jumlah_lampu',>
                </div>
                <div class="mb-3">
                    <label for="UkuranReklame" class="form-label">Ukuran Reklame</label>
                    <div class="input-group mb-3">
                        <input type="number" name="panjang" class="form-control" placeholder="Panjang (m)" aria-label="panjang" required>
                        <span class="input-group-text">Meter</span>

                        <input type="number" name="lebar" class="form-control" placeholder="Lebar (m)" aria-label="lebar" required>
                        <span class="input-group-text">Meter</span>

                        <input type="number" name="muka" class="form-control" placeholder="Muka (m²)" aria-label="muka">
                        <span class="input-group-text">Muka</span>
                    </div>
                </div>
            </div> <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!--end::Footer-->
        </form> <!--end::Form-->
    </div> <!--end::Quick Example-->
</div> <!--end::Col-->

@endsection
