<?php

namespace App\Http\Controllers;

use App\Models\LaporanKegiatan;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Log; 
use App\Models\TitikReklame;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class LaporanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporankegiatans = LaporanKegiatan::paginate(10);
        $titikReklames = TitikReklame::all();
        $pegawais = Pegawai::all();// Tambahkan data titik reklame
        return view('laporankegiatans.index', compact('laporankegiatans', 'titikReklames', 'pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all();
        $pegawais = Pegawai::all();// Mengambil semua data titik reklame
        return view('laporankegiatans.create', compact('titikReklames', 'pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'koordinat_titik' => 'required|exists:titik_reklames,koordinat_titik',
            'jenis_kegiatan' => 'required|string|max:1000',
            'tanggal_kegiatan' => 'required|date',
            'id_pegawai' => 'required|exists:pegawais,id_pegawai',
            'laporan' => 'required|string|max:1000',
        ]);


        $tahun = date('Y');
        $bulanRomawi = strtoupper(date('m')); 

        $lastLaporan = LaporanKegiatan::whereYear('tanggal_kegiatan', $tahun)
                                    ->whereMonth('tanggal_kegiatan', date('m'))
                                    ->orderBy('no_laporan', 'desc')
                                    ->first();

        if ($lastLaporan) {
            $lastNumber = (int)substr($lastLaporan->no_laporan, -3); 
            $nomorUrut = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nomorUrut = '001'; 
        }

        $noLaporan = "LAP/{$tahun}/{$bulanRomawi}/{$nomorUrut}";
        $validated['no_laporan'] = $noLaporan;
        LaporanKegiatan::create($validated);

        return redirect()->route('laporankegiatans.index')->with('success', 'Laporan kegiatan berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show($no_laporan_url, LaporanKegiatan $laporanKegiatan)
    {
        // Convert the URL format to the database format
        $no_laporan = substr($no_laporan_url, 0, 3) . '/' . 
                      substr($no_laporan_url, 3, 4) . '/' . 
                      substr($no_laporan_url, 7, 2) . '/' . 
                      substr($no_laporan_url, 9, 3);
                      $titikReklames = TitikReklame::all();
                      $pegawais = Pegawai::all();

        $laporankegiatan = LaporanKegiatan::findOrFail($no_laporan);
        $laporankegiatan->load('titikReklame', 'pegawai');
        return view('laporankegiatans.show', compact('laporankegiatan', 'laporanKegiatan','titikReklames','pegawais'));
    }

    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $laporanKegiatans = LaporanKegiatan::with('pegawai', 'titikReklame');  
        
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate)->endOfDay(); 
            $laporanKegiatans->whereBetween('tanggal_kegiatan', [$startDate, $endDate]);
        }
    

        $pegawais = Pegawai::all();
        $titikReklames = TitikReklame::all();
        $laporankegiatan = $laporanKegiatans->get();

        $pdf = PDF::loadView('laporankegiatans.report', compact('laporankegiatan','pegawais','titikReklames'));
        return $pdf->download('laporan_kegiatan_report.pdf');
    }

}