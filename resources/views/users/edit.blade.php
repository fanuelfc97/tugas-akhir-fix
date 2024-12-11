@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row my-5">
    <div class="card card-primary card-outline mb-4">
        <form method="POST" action="{{ route('users.update', $user->username) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="pegawai_id" class="form-label">Pegawai</label>
                    <select name="pegawai_id" class="form-select" id="pegawai_id" onchange="updatePegawaiDetails()" required>
                        <option value="">Pilih Pegawai</option>
                        @foreach ($pegawais as $pegawai)
                            <option value="{{ $pegawai->id_pegawai }}"
                                data-id="{{ $pegawai->id_pegawai }}"
                                data-jabatan="{{ $pegawai->jabatan }}"
                                {{ old('pegawai_id', $user->id_pegawai) == $pegawai->id_pegawai ? 'selected' : '' }}
                            >
                                {{ $pegawai->nama_pegawai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">ID Pegawai</label>
                    <input type="text" name="id_pegawai" class="form-control" id="id_pegawai" value="{{ $user->pegawai ? $user->pegawai->id_pegawai : 'Tidak ada data pegawai' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" id="jabatan" value="{{ $user->pegawai ? $user->pegawai->jabatan : 'tidak Ada Jabatan' }}" readonly>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePegawaiDetails() {
        const selectedPegawai = document.getElementById('pegawai_id').selectedOptions[0];
        document.getElementById('id_pegawai').value = selectedPegawai.getAttribute('data-id') || '';
        document.getElementById('jabatan').value = selectedPegawai.getAttribute('data-jabatan') || '';
    }

    // Trigger the function initially to populate the fields based on the current user data
    updatePegawaiDetails();
</script>
@endsection
