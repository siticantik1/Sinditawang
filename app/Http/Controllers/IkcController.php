<?php

namespace App\Http\Controllers;

use App\Models\Ikc; // Model untuk Inventaris Kelurahan Cikalang
use App\Models\Rkc; // Model untuk Ruangan Kelurahan Cikalang
use Illuminate\Http\Request;
use PDF;

class IkcController extends Controller
{
    /**
     * Menampilkan daftar IKC (Inventaris Kelurahan Cikalang).
     */
    public function index(Request $request)
    {
        $lokasi = 'cikalang';
        $rkcs = Rkc::where('lokasi', $lokasi)->orderBy('name')->get();
        
        $query = Ikc::with('rkc')->whereHas('rkc', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkc_id') && $request->rkc_id != '') {
            $query->where('rkc_id', $request->rkc_id);
        }

        $ikcs = $query->latest()->get();
        $selectedRkc = Rkc::find($request->rkc_id);

        return view('pages.ikc.index', compact('ikcs', 'rkcs', 'selectedRkc', 'lokasi'));
    }

    /**
     * Menampilkan form untuk membuat IKC baru.
     */
    public function create()
    {
        $rkcs = Rkc::where('lokasi', 'cikalang')->orderBy('name')->get();
        $lokasi = 'cikalang'; 
        return view('pages.ikc.create', compact('rkcs', 'lokasi'));
    }

    /**
     * Menyimpan data IKC baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkc_id' => 'required|exists:rkcs,id',
            'kode_barang' => 'required|string|unique:ikcs,kode_barang',
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        Ikc::create($validatedData);

        return redirect()->route('cikalang.ikc.index', ['rkc_id' => $request->rkc_id])
                         ->with('success', 'Barang IKC baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data barang IKC.
     */
    public function edit(Ikc $ikc)
    {
        $rkcs = Rkc::where('lokasi', 'cikalang')->orderBy('name')->get();
        $lokasi = 'cikalang';
        return view('pages.ikc.edit', compact('ikc', 'rkcs', 'lokasi'));
    }

    /**
     * Memperbarui data barang IKC di database.
     */
    public function update(Request $request, Ikc $ikc)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkc_id' => 'required|exists:rkcs,id',
            'kode_barang' => 'required|string|unique:ikcs,kode_barang,' . $ikc->id,
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ikc->update($validatedData);

        return redirect()->route('cikalang.ikc.index', ['rkc_id' => $ikc->rkc_id])
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang IKC dari database.
     */
    public function destroy(Ikc $ikc)
    {
        $rkcId = $ikc->rkc_id;
        $ikc->delete();

        return redirect()->route('cikalang.ikc.index', ['rkc_id' => $rkcId])
                         ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Memindahkan barang ke ruangan RKC lain.
     */
    public function move(Request $request, Ikc $ikc)
    {
        $request->validate([
            'new_rkc_id' => 'required|exists:rkcs,id',
        ]);

        $ikc->rkc_id = $request->new_rkc_id;
        $ikc->save();

        return back()->with('success', 'Barang berhasil dipindahkan.');
    }

    /**
     * Membuat laporan PDF khusus untuk IKC Cikalang.
     */
    public function pdf(Request $request)
    {
        $lokasi = 'cikalang';
        $query = Ikc::with('rkc')->whereHas('rkc', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkc_id') && $request->rkc_id != '') {
            $query->where('rkc_id', $request->rkc_id);
        }

        $ikcs = $query->latest()->get();
        $selectedRkc = Rkc::find($request->rkc_id);
        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('pages.ikc.print', compact('ikcs', 'selectedRkc', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ikc-' . $lokasi . '-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
