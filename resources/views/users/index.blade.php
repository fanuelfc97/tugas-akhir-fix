@extends('layouts.master')

@section('title', 'Daftar User')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar User</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Display success message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display error messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Button to create new user -->
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah User</a>

                <!-- Table to display users -->
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Username</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @php
                                                    $pegawai = $pegawais->firstWhere('id_pegawai', $user->id_pegawai);
                                                @endphp
                                                {{ $pegawai ? $pegawai->nama_pegawai : 'Tidak ada data' }}
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>
                                                @php
                                                    $jabatan = $pegawais->firstWhere('jabatan', $user->jabatan);
                                                @endphp
                                                {{ $jabatan ? $jabatan->jabatan : 'Tidak ada data' }}
                                            </td>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete button with form -->
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data user.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination links -->
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
