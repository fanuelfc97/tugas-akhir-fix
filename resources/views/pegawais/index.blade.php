@extends('layouts.master')

@section('title', 'Data Pegawai')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <a href="{{ route('pegawais.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>

        <div class="card card-primary card-outline mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pegawai</th>
                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Tanggal Lahir</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pegawais as $index => $pegawai)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pegawai->id_pegawai }}</td>
                                    <td>{{ $pegawai->nama_pegawai }}</td>
                                    <td>{{ $pegawai->jabatan }}</td>
                                    <td>{{ $pegawai->tanggal_lahir }}</td>
                                    <td>{{ $pegawai->no_hp }}</td>
                                    <td>
                                        <a href="{{ route('pegawais.show', $pegawai) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('pegawais.edit', $pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('pegawais.destroy', $pegawai) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $pegawais->links() }}
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection
