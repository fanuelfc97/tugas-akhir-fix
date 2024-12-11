@extends('layouts.master')

@section('title', 'Detail Data Pegawai')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Data Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pegawais.index') }}">Data Pegawai</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Data Pegawai</li>
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
                    <label for="id_pegawai" class="form-label">ID Pegawai</label>
                    <input type="text" class="form-control" id="id_pegawai" value="{{ $pegawai->id_pegawai }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                    <input type="text" class="form-control" id="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" value="{{ $pegawai->jabatan }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" value="{{ $pegawai->tanggal_lahir }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" value="{{ $pegawai->no_hp }}" readonly>
                </div>
            </div>
        </div> <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer">
            <a href="{{ route('pegawais.index') }}" class="btn btn-danger">Kembali</a>
        </div>
        <!--end::Footer-->
    </div> <!--end::Quick Example-->
</div> <!--end::Col-->

@endsection
