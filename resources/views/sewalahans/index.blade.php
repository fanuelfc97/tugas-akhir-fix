@extends('layouts.master')

@section('title', 'Data Sewa Lahan')

@section('content')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Sewa Lahan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Sewa Lahan
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
                    <a href="{{ route('sewalahans.create') }}" class="btn btn-primary mb-2">Tambah Sewa Lahan</a>
                    @endif
                    @if (Auth::user()->jabatan == 'Manager Administrasi')
                    <a href="#" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#filterModal">Generate Report</a>
                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel">Filter Laporan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('sewalahans.generateReport') }}" method="GET">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="periode_akhir" class="form-label">Periode Akhir:</label>
                                            <input type="date" name="periode_akhir" id="periode_akhir" class="form-control" value="{{ request('periode_akhir') }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                        <th>No Sewa Lahan</th>
                                        <th>Periode Awal</th>
                                        <th>Periode Akhir</th>
                                        <th>Ukuran Reklame</th>
                                        <th>Dokumen Sewa Lahan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sewalahans as $index => $sewalahan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <!-- Nama Titik Reklame -->
                                            <td>
                                                @php
                                                    $titikReklame = $titikReklames->firstWhere('koordinat_titik', $sewalahan->koordinat_titik);
                                                @endphp
                                                {{ $titikReklame ? $titikReklame->nama_titik : 'Tidak ada data nama titik' }}
                                            </td>

                                            <td>{{ $sewalahan->koordinat_titik }}</td>
                                            <td>{{ $sewalahan->no_kontrak }}</td>

                                            <!-- Periode Awal -->
                                            <td>{{ \Carbon\Carbon::parse($sewalahan->periode_awalsl)->format('d-m-Y') }}</td>

                                            <!-- Periode Akhir with color coding -->
                                            @php
                                                $periodeAkhir = \Carbon\Carbon::parse($sewalahan->periode_akhirsl);
                                                $today = \Carbon\Carbon::today();
                                                $dateDiff = $today->diffInDays($periodeAkhir, false);
                                                $colorClass = $dateDiff < 0 ? 'text-danger' :
                                                              ($dateDiff <= 30 ? 'text-warning' : 'text-success');
                                            @endphp
                                            <td class="{{ $colorClass }}">{{ $periodeAkhir->format('d-m-Y') }}</td>

                                            <!-- Ukuran Reklame -->
                                            <td>
                                                @if ($titikReklame)
                                                    {{ $titikReklame->panjang }} m  x {{ $titikReklame->lebar }} m, {{ $titikReklame->muka }} muka
                                                @else
                                                    Tidak ada data ukuran
                                                @endif
                                            </td>

                                            <td>
                                                @if ($sewalahan->dokumen_sl)
                                                    <a href="{{ Storage::url($sewalahan->dokumen_sl) }}" target="_blank">Lihat Dokumen</a>
                                                @else
                                                    Tidak ada dokumen
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Detail button -->
                                                <a href="{{ route('sewalahans.show', $sewalahan) }}" class="btn btn-info btn-sm">Detail</a>
                                                @if (in_array(Auth::user()->jabatan, ['Manager Administrasi', 'Staff Administrasi']))
                                                <!-- Edit button -->
                                                <a href="{{ route('sewalahans.edit', $sewalahan) }}" class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete button with form -->
                                                <form action="{{ route('sewalahans.destroy', $sewalahan) }}" method="POST" style="display:inline;">
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
                            {{ $sewalahans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
