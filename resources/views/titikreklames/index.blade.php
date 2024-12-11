@extends('layouts.master')

@section('title', 'Data Titik Reklame')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Titik Reklame</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Titik Reklame</li>
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
        @if (in_array(Auth::user()->jabatan, ['Manager Administrasi', 'Staff Administrasi']))
        <a href="{{ route('titikreklames.create') }}" class="btn btn-primary mb-3">Tambah Titik Reklame</a>
        @endif
        @if (Auth::user()->jabatan == 'Manager Administrasi')
        <a href="#" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#generateReportModal">Generate Report</a>
        <div class="modal fade" id="generateReportModal" tabindex="-1" role="dialog" aria-labelledby="generateReportModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
           <div class="modal-content">
            <div class="modal-header">
           <h5 class="modal-title" id="generateReportModalLabel">Pilih Status Titik</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <a href="{{ route('titikreklames.generateReport', ['status' => 'available']) }}" class="btn btn-primary btn-block mb-2">Available</a>
              <a href="{{ route('titikreklames.generateReport', ['status' => 'sold']) }}" class="btn btn-secondary btn-block">Sold Out</a>
            </div>
          </div>
         </div>
        </div>
        @endif

        <div class="card card-primary card-outline mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Koordinat Titik</th>
                                <th>Alamat Titik Reklame</th>
                                <th>Status</th>
                                <th>Jenis Penerangan</th>
                                <th>Ukuran Reklame (m²)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($titikReklames as $index => $titikReklame)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $titikReklame->koordinat_titik }}</td>
                                    <td>{{ $titikReklame->nama_titik }}</td>
                                    <td>{{ ucfirst($titikReklame->status_titik) }}</td>
                                    <td>{{ $titikReklame->jenis_penerangan }}</td>
                                    <td>{{ $titikReklame->panjang }}M x {{ $titikReklame->lebar}}M x {{ $titikReklame->muka}} Muka</td>
                                    <td>
                                        <a href="{{ route('titikreklames.show', $titikReklame) }}" class="btn btn-info btn-sm">Detail</a>
                                        @if (in_array(Auth::user()->jabatan, ['Manager Administrasi', 'Staff Administrasi']))
                                        <a href="{{ route('titikreklames.edit', $titikReklame) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('titikreklames.destroy', $titikReklame) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $titikReklames->links() }}
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection
