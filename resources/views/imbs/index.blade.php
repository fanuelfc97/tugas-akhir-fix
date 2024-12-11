@extends('layouts.master')

@section('title', 'Data Imb')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Imb</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Imb
                    </li>
                </ol>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
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

                <!-- Button to create new insurance record -->

                @if (in_array(Auth::user()->jabatan, ['Manager Administrasi', 'Staff Administrasi']))
                    <a href="{{ route('imbs.create') }}" class="btn btn-primary mb-2">Tambah Imb</a>
                @endif    
                @if (Auth::user()->jabatan == 'Manager Administrasi')
                    <a href="{{ route('imbs.generateReport') }}" class="btn btn-secondary mb-2">Generate Report</a>
                @endif

                <!-- Table to display insurance records -->
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Titik Reklame</th>
                                        <th>Koordinat Titik</th>
                                        <th>No Imb</th>
                                        <th>Periode IMB</th>
                                        <th>Ukuran Reklame</th>
                                        <th>Dokumen Imb</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($imbs as $index => $imb)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <!-- Nama Titik Reklame -->
                                            <td>
                                                @php
                                                    $titikReklame = $titikReklames->firstWhere('koordinat_titik', $imb->koordinat_titik);
                                                @endphp
                                                {{ $titikReklame ? $titikReklame->nama_titik : 'Tidak ada data nama titik' }}
                                            </td>

                                            <td>{{ $imb->koordinat_titik }}</td>
                                            <td>{{ $imb->no_imb }}</td>

                                            <!-- Periode Awal -->
                                            <td>{{ \Carbon\Carbon::parse($imb->periode_imb)->format('d-m-Y') }}</td>

                                            <!-- Ukuran Reklame -->
                                            <td>
                                                @if ($titikReklame)
                                                    {{ $titikReklame->panjang }} m  x {{ $titikReklame->lebar }} m, {{ $titikReklame->muka }} muka
                                                @else
                                                    Tidak ada data ukuran
                                                @endif
                                            </td>

                                            <td>
                                                @if ($imb->dokumen_imb)
                                                    <a href="{{ Storage::url($imb->dokumen_imb) }}" target="_blank">Lihat Dokumen</a>
                                                @else
                                                    Tidak ada dokumen
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Detail button -->
                                                <a href="{{ route('imbs.show', $imb) }}" class="btn btn-info btn-sm">Detail</a>

                                                <!-- Edit button -->
                                                @if (in_array(Auth::user()->jabatan, ['Manager Administrasi', 'Staff Administrasi']))
                                                <a href="{{ route('imbs.edit', $imb) }}" class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete button with form -->
                                                <form action="{{ route('imbs.destroy', $imb) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            <!-- Pagination links -->
                            {{ $imbs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
