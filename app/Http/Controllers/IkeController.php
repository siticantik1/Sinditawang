<?php

namespace App\Http\Controllers;

use App\Models\Ike; // Model untuk Inventaris Kelurahan Empang
use App\Models\Rke; // Model untuk Ruangan Kelurahan Empang
use Illuminate\Http\Request;
use PDF;

class IkeController extends Controller
{
    /**
     * Menampilkan daftar IKE (Inventaris Kelurahan Empang).
     */
    public function index(Request $request)
    {
        $lokasi = 'empang';
        $rkes = Rke::where('lokasi', $lokasi)->orderBy('name')->get();
        
        $query = Ike::with('rke')->whereHas('rke', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rke_id') && $request->rke_id != '') {
            $query->where('rke_id', $request->rke_id);
        }

        $ikes = $query->latest()->get();
        $selectedRke = Rke::find($request->rke_id);

        return view('pages.empang.ike.index', compact('ikes', 'rkes', 'selectedRke', 'lokasi'));
    }

    /**
     * Menampilkan form untuk membuat IKE baru.
     */
    public function create()
    {
        $rkes = Rke::where('lokasi', 'empang')->orderBy('name')->get();
        $lokasi = 'empang'; 
        return view('pages.empang.ike.create', compact('rkes', 'lokasi'));
    }

    /**
     * Menyimpan data IKE baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rke_id' => 'required|exists:rkes,id',
            'kode_barang' => 'required|string|unique:ikes,kode_barang',
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        Ike::create($validatedData);

        return redirect()->route('empang.ike.index', ['rke_id' => $request->rke_id])
                         ->with('success', 'Barang IKE baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data barang IKE.
     */
    public function edit(Ike $ike)
    {
        $rkes = Rke::where('lokasi', 'empang')->orderBy('name')->get();
        $lokasi = 'empang';
        return view('pages.empang.ike.edit', compact('ike', 'rkes', 'lokasi'));
    }

    /**
     * Memperbarui data barang IKE di database.
     */
    public function update(Request $request, Ike $ike)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rke_id' => 'required|exists:rkes,id',
            'kode_barang' => 'required|string|unique:ikes,kode_barang,' . $ike->id,
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ike->update($validatedData);

        return redirect()->route('empang.ike.index', ['rke_id' => $ike->rke_id])
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang IKE dari database.
     */
    public function destroy(Ike $ike)
    {
        $rkeId = $ike->rke_id;
        $ike->delete();

        return redirect()->route('empang.ike.index', ['rke_id' => $rkeId])
                         ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Memindahkan barang ke ruangan RKE lain.
     */
    public function move(Request $request, Ike $ike)
    {
        $request->validate([
            'new_rke_id' => 'required|exists:rkes,id',
        ]);

        $ike->rke_id = $request->new_rke_id;
        $ike->save();

        return back()->with('success', 'Barang berhasil dipindahkan.');
    }

    /**
     * Membuat laporan PDF khusus untuk IKE Empang.
     */
    public function pdf(Request $request)
    {
        $lokasi = 'empang';
        $query = Ike::with('rke')->whereHas('rke', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rke_id') && $request->rke_id != '') {
            $query->where('rke_id', $request->rke_id);
        }

        $ikes = $query->latest()->get();
        $selectedRke = Rke::find($request->rke_id);
        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('pages.empang.ike.print', compact('ikes', 'selectedRke', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ike-' . $lokasi . '-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
