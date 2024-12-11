@extends('layouts.master')

@section('title', 'Input Data Pegawai')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Input Data Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Input Data Pegawai
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<div class="row my-5"> <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
        <form method="POST" action="{{ route('pegawais.store') }}" enctype="multipart/form-data"> <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">ID Pegawai</label>
                    <input type="text" name="id_pegawai" class="form-control" id="id_pegawai">
                </div>
                <div class="mb-3">
                    <label for='jabatan' class="form-label">Jabatan</label>
                    <select name='jabatan' id='jabatan' class="form-select">
                        <option value="" disabled selected>Pilih Jabatan</option>
                        <option value="Manager EMS">Manager EMS</option>
                        <option value="Manager Administrasi">Manager Administrasi</option>
                        <option value="Manager Operasional">Manager Operasional</option>
                        <option value="Staff Administrasi">Staff Administrasi</option>
                        <option value="Staff Operasional">Staff Operasional</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" name="nama_pegawai" class="form-control" id="nama_pegawai">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tangggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir">
                </div>
                <div class="mb-3">
                    <label for='no_hp', class="form-label">No HP</label>
                    <input type="number" name='no_hp' class="form-control" id='no_hp',>
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
