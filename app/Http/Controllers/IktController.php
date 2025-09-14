<?php

namespace App\Http\Controllers;

use App\Models\Ikt; // Model untuk Inventaris Kelurahan Tawangsari
use App\Models\Rkt; // Model untuk Ruangan Kelurahan Tawangsari
use Illuminate\Http\Request;
use PDF;

class IktController extends Controller
{
    /**
     * Menampilkan daftar IKT (Inventaris Kelurahan Tawangsari).
     */
    public function index(Request $request)
    {
        $lokasi = 'tawangsari';
        $rkts = Rkt::where('lokasi', $lokasi)->orderBy('name')->get();
        
        $query = Ikt::with('rkt')->whereHas('rkt', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkt_id') && $request->rkt_id != '') {
            $query->where('rkt_id', $request->rkt_id);
        }

        $ikts = $query->latest()->get();
        $selectedRkt = Rkt::find($request->rkt_id);

        // Pastikan path view sesuai dengan struktur folder Anda
        return view('pages.tawangsari.ikt.index', compact('ikts', 'rkts', 'selectedRkt', 'lokasi'));
    }

    /**
     * Menampilkan form untuk membuat IKT baru.
     */
    public function create()
    {
        $rkts = Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get();
        $lokasi = 'tawangsari'; 
        return view('pages.tawangsari.ikt.create', compact('rkts', 'lokasi'));
    }

    /**
     * Menyimpan data IKT baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkt_id' => 'required|exists:rkts,id',
            'kode_barang' => 'required|string|unique:ikts,kode_barang',
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        Ikt::create($validatedData);

        return redirect()->route('tawangsari.ikt.index', ['rkt_id' => $request->rkt_id])
                         ->with('success', 'Barang IKT baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data barang IKT.
     */
    public function edit(Ikt $ikt)
    {
        $rkts = Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get();
        $lokasi = 'tawangsari';
        return view('pages.tawangsari.ikt.edit', compact('ikt', 'rkts', 'lokasi'));
    }

    /**
     * Memperbarui data barang IKT di database.
     */
    public function update(Request $request, Ikt $ikt)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'rkt_id' => 'required|exists:rkts,id',
            'kode_barang' => 'required|string|unique:ikts,kode_barang,' . $ikt->id,
            'tahun_pembelian' => 'required|numeric|digits:4',
            'jumlah' => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric',
            'kondisi' => 'required|in:B,KB,RB',
            'merk_model' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ikt->update($validatedData);

        return redirect()->route('tawangsari.ikt.index', ['rkt_id' => $ikt->rkt_id])
                         ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang IKT dari database.
     */
    public function destroy(Ikt $ikt)
    {
        $rktId = $ikt->rkt_id;
        $ikt->delete();

        return redirect()->route('tawangsari.ikt.index', ['rkt_id' => $rktId])
                         ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Memindahkan barang ke ruangan RKT lain.
     */
    public function move(Request $request, Ikt $ikt)
    {
        $request->validate([
            'new_rkt_id' => 'required|exists:rkts,id',
        ]);

        $ikt->rkt_id = $request->new_rkt_id;
        $ikt->save();

        return back()->with('success', 'Barang berhasil dipindahkan.');
    }

    /**
     * Membuat laporan PDF khusus untuk IKT Tawangsari.
     */
    public function pdf(Request $request)
    {
        $lokasi = 'tawangsari';
        $query = Ikt::with('rkt')->whereHas('rkt', function ($q) use ($lokasi) {
            $q->where('lokasi', $lokasi);
        });

        if ($request->has('rkt_id') && $request->rkt_id != '') {
            $query->where('rkt_id', $request->rkt_id);
        }

        $ikts = $query->latest()->get();
        $selectedRkt = Rkt::find($request->rkt_id);
        $tanggalCetak = now()->translatedFormat('d F Y');

        $pdf = PDF::loadView('pages.tawangsari.ikt.print', compact('ikts', 'selectedRkt', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ikt-' . $lokasi . '-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
