<?php

namespace App\Http\Controllers;

use App\Models\Ikk; // Model untuk Inventaris Kelurahan Kahuripan
use App\Models\Rkk; // Model untuk Ruangan Kelurahan Kahuripan
use Illuminate\Http\Request;
use PDF;

class IkkController extends Controller
{
    /**
     * Menampilkan daftar IKK (Inventaris Kelurahan Kahuripan).
     */
    public function index(Request $request)
    {
        $lokasi = 'kahuripan';
        $rkks = Rkk::where('lokasi', $lokasi)->orderBy('name')->get();
        
        $query = Ikk::with('rkk')->whereHas('rkk', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkk_id') && $request->rkk_id != '') {
            $query->where('rkk_id', $request->rkk_id);
        }

        $ikks = $query->latest()->get();
        $selectedRkk = Rkk::find($request->rkk_id);

        // Pastikan path view sesuai dengan struktur folder Anda
        return view('pages.kahuripan.ikk.index', compact('ikks', 'rkks', 'selectedRkk', 'lokasi'));
    }

    /**
     * Menampilkan form untuk membuat IKK baru.
     */
    public function create()
    {
        $rkks = Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get();
        $lokasi = 'kahuripan'; 
        return view('pages.kahuripan.ikk.create', compact('rkks', 'lokasi'));
    }

    /**
     * Menyimpan data IKK baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkk_id' => 'required|exists:rkks,id',
            'kode_barang' => 'required|string|unique:ikks,kode_barang',
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        Ikk::create($validatedData);

        return redirect()->route('kahuripan.ikk.index', ['rkk_id' => $request->rkk_id])
                         ->with('success', 'Barang IKK baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data barang IKK.
     */
    public function edit(Ikk $ikk)
    {
        $rkks = Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get();
        $lokasi = 'kahuripan';
        return view('pages.kahuripan.ikk.edit', compact('ikk', 'rkks', 'lokasi'));
    }

    /**
     * Memperbarui data barang IKK di database.
     */
    public function update(Request $request, Ikk $ikk)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkk_id' => 'required|exists:rkks,id',
            'kode_barang' => 'required|string|unique:ikks,kode_barang,' . $ikk->id,
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ikk->update($validatedData);

        return redirect()->route('kahuripan.ikk.index', ['rkk_id' => $ikk->rkk_id])
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang IKK dari database.
     */
    public function destroy(Ikk $ikk)
    {
        $rkkId = $ikk->rkk_id;
        $ikk->delete();

        return redirect()->route('kahuripan.ikk.index', ['rkk_id' => $rkkId])
                         ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Memindahkan barang ke ruangan RKK lain.
     */
    public function move(Request $request, Ikk $ikk)
    {
        $request->validate([
            'new_rkk_id' => 'required|exists:rkks,id',
        ]);

        $ikk->rkk_id = $request->new_rkk_id;
        $ikk->save();

        return back()->with('success', 'Barang berhasil dipindahkan.');
    }

    /**
     * Membuat laporan PDF khusus untuk IKK Kahuripan.
     */
    public function pdf(Request $request)
    {
        $lokasi = 'kahuripan';
        $query = Ikk::with('rkk')->whereHas('rkk', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkk_id') && $request->rkk_id != '') {
            $query->where('rkk_id', $request->rkk_id);
        }

        $ikks = $query->latest()->get();
        $selectedRkk = Rkk::find($request->rkk_id);
        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('pages.kahuripan.ikk.print', compact('ikks', 'selectedRkk', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ikk-' . $lokasi . '-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
