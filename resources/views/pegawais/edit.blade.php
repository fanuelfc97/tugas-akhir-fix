@extends('layouts.master')

@section('title', 'Edit Data Pegawai')

@section('content')

<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Data Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pegawais.index') }}">Data Pegawai</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Data Pegawai
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div>

<!-- Form Section -->
<div class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <form method="POST" action="{{ route('pegawais.update', $pegawai->id_pegawai) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">

                        <!-- ID Pegawai -->
                        <div class="mb-3">
                            <label for="id_pegawai" class="form-label">ID Pegawai</label>
                            <input type="text" name="id_pegawai" id="id_pegawai"
                                   class="form-control" value="{{ old('id_pegawai', $pegawai->id_pegawai) }}" required>
                        </div>

                        <!-- Jabatan -->
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-select" required>
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach(['Manager EMS', 'Manager Administrasi', 'Manager Operasional', 'Staff Administrasi', 'Staff Operasional'] as $jabatan)
                                    <option value="{{ $jabatan }}" {{ $pegawai->jabatan == $jabatan ? 'selected' : '' }}>
                                        {{ $jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Pegawai -->
                        <div class="mb-3">
                            <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                            <input type="text" name="nama_pegawai" id="nama_pegawai"
                                   class="form-control" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" required>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                   class="form-control" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}" required>
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="number" name="no_hp" id="no_hp"
                                   class="form-control" value="{{ old('no_hp', $pegawai->no_hp) }}" required>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('pegawais.index') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
