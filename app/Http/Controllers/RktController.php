<?php

namespace App\Http\Controllers;

use App\Models\Rkt; // Menggunakan model Rkt
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF; // Tambahkan ini untuk fungsi PDF

class RktController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan untuk Tawangsari.
     */
    public function index()
    {
        $rkts = Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get();
        return view('pages.tawangsari.rkt.index', compact('rkts'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('pages.tawangsari.rkt.create');
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan untuk data Rkt
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:50|unique:rkts,kode_ruangan',
        ]);

        // Tambahkan lokasi 'tawangsari' secara otomatis
        $validatedData['lokasi'] = 'tawangsari';
        
        Rkt::create($validatedData);

        return redirect()->route('tawangsari.rkt.index')
                         ->with('success', 'Data ruangan Tawangsari berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Rkt $rkt)
    {
        return view('pages.tawangsari.rkt.edit', compact('rkt'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Rkt $rkt)
    {
        // Validasi untuk pembaruan data Rkt
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rkts', 'kode_ruangan')->ignore($rkt->id),
            ],
        ]);
        
        $rkt->update($validatedData);

        return redirect()->route('tawangsari.rkt.index')
                         ->with('success', 'Data ruangan Tawangsari berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan dari database.
     */
    public function destroy(Rkt $rkt)
    {
        $rkt->delete();

        return redirect()->route('tawangsari.rkt.index')
                         ->with('success', 'Data ruangan Tawangsari berhasil dihapus.');
    }

    /**
     * Membuat laporan PDF untuk data ruangan Tawangsari.
     */
    public function pdf()
    {
        $rkts = Rkt::where('lokasi', 'tawangsari')->orderBy('name')->get();
        $tanggalCetak = now()->translatedFormat('d F Y');
        $lokasi = 'tawangsari';

        // Pastikan Anda memiliki view 'pages.tawangsari.rkt.print'
        $pdf = PDF::loadView('pages.tawangsari.rkt.print', compact('rkts', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ruangan-tawangsari-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
