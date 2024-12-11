<?php

namespace App\Http\Controllers;

use App\Models\Imb;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class ImbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $imbs = Imb::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('imbs.index', compact('imbs', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('imbs.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string|exists:titik_reklames,koordinat_titik',
            'no_imb' => 'required|string|unique:imbs,no_imb',
            'periode_imb' => 'required|date',
            'dokumen_imb' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ], [
            'koordinat_titik.required' => 'Koordinat titik harus diisi.',
            'no_imb.required' => 'Isi no imb.',
            'periode_imb.required' => 'Isi awal periode.',
            'dokumen_imb.required' => 'Lampirkan dokumen.',
            // ... pesan validasi lainnya ...
        ]);

        try {
            // 2. Ambil data lokasi dan tahun periode
            $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
            $periodeImb = date('Y', strtotime($request->periode_imb));

            // 3. Generate nama file unik 
            $namaFile = 'IMB-' . $lokasi . '-' . $periodeImb . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenImbPath = $request->file('dokumen_imb')->storeAs('uploads/imb', $namaFile, 'public');

            // 5. Simpan data IMB ke database
            Imb::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_imb' => $request->no_imb,
                'periode_imb' => $request->periode_imb,
                'dokumen_imb' => $dokumenImbPath, 
            ]);

            return redirect()->route('imbs.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Imb $imb)
    {
        $titikReklames = TitikReklame::all();
        return view('imbs.show', compact('imb', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imb $imb)
    {
        $titikReklames = TitikReklame::all();
        return view('imbs.edit', compact('imb', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imb $imb)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string|exists:titik_reklames,koordinat_titik',
            'no_imb' => 'required|string|unique:imbs,no_imb',
            'periode_imb' => 'required|date',
            'dokumen_imb' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut IMB
            $imb->koordinat_titik = $request->koordinat_titik;
            $imb->no_imb = $request->no_imb;
            $imb->periode_imb = $request->periode_imb;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_imb')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeImb = date('Y', strtotime($request->periode_imb)); 

                // 5. Generate nama file unik 
                $namaFile = 'IMB-' . $lokasi . '-' . $periodeImb . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenImbPath = $request->file('dokumen_imb')->storeAs('uploads/imb', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($imb->dokumen_imb) {
                    Storage::disk('public')->delete($imb->dokumen_imb);
                }

                // 8. Update path file di model
                $imb->dokumen_imb = $dokumenImbPath;
            }

            // 9. Simpan perubahan data IMB
            $imb->save();

            return redirect()->route('imbs.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imb $imb)
    {
        try {
            // Check if dokumen_imb exists and delete it
            if ($imb->dokumen_imb) {
                Storage::disk('public')->delete($imb->dokumen_imb);
            }

            // Delete the record
            $imb->delete();

            return redirect()->route('imbs.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }
    public function generateReport(Request $request)
    {
        $imbs = Imb::with('titikReklame')
        ->orderBy('periode_imb', 'asc') // Urutkan berdasarkan periode_akhirimb secara ascending (naik)
        ->get(); // Ambil data IMB beserta relasinya dengan TitikReklame

        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('imbs.report', compact('imbs', 'titikReklames')); // Load view untuk report dan passing data imbs
        return $pdf->download('imb_report.pdf'); // Download PDF dengan nama imb_report.pdf
    }
}