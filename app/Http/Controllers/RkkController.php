<?php

namespace App\Http\Controllers;

use App\Models\Rkk; // Menggunakan model Rkk
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF; // Tambahkan ini untuk fungsi PDF

class RkkController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan untuk Kahuripan.
     */
    public function index()
    {
        $rkks = Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get();
        return view('pages.kahuripan.rkk.index', compact('rkks'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('pages.kahuripan.rkk.create');
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan untuk data Rkk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:50|unique:rkks,kode_ruangan',
        ]);

        // Tambahkan lokasi 'kahuripan' secara otomatis
        $validatedData['lokasi'] = 'kahuripan';
        
        Rkk::create($validatedData);

        return redirect()->route('kahuripan.rkk.index')
                         ->with('success', 'Data ruangan Kahuripan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Rkk $rkk)
    {
        return view('pages.kahuripan.rkk.edit', compact('rkk'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Rkk $rkk)
    {
        // Validasi untuk pembaruan data Rkk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rkks', 'kode_ruangan')->ignore($rkk->id),
            ],
        ]);
        
        $rkk->update($validatedData);

        return redirect()->route('kahuripan.rkk.index')
                         ->with('success', 'Data ruangan Kahuripan berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan dari database.
     */
    public function destroy(Rkk $rkk)
    {
        $rkk->delete();

        return redirect()->route('kahuripan.rkk.index')
                         ->with('success', 'Data ruangan Kahuripan berhasil dihapus.');
    }

    /**
     * Membuat laporan PDF untuk data ruangan Kahuripan.
     */
    public function pdf()
    {
        $rkks = Rkk::where('lokasi', 'kahuripan')->orderBy('name')->get();
        $tanggalCetak = now()->translatedFormat('d F Y');
        $lokasi = 'kahuripan';

        // Pastikan Anda memiliki view 'pages.kahuripan.rkk.print'
        $pdf = PDF::loadView('pages.kahuripan.rkk.print', compact('rkks', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ruangan-kahuripan-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
