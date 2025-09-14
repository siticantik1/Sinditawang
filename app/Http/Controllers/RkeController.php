<?php

namespace App\Http\Controllers;

use App\Models\Rke; // Menggunakan model Rke
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF; // Tambahkan ini untuk fungsi PDF

class RkeController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan untuk Empang.
     */
    public function index()
    {
        $rkes = Rke::where('lokasi', 'empang')->orderBy('name')->get();
        return view('pages.empang.rke.index', compact('rkes'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('pages.empang.rke.create');
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan untuk data Rke
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:50|unique:rkes,kode_ruangan',
        ]);

        // Tambahkan lokasi 'empang' secara otomatis
        $validatedData['lokasi'] = 'empang';
        
        Rke::create($validatedData);

        return redirect()->route('empang.rke.index')
                         ->with('success', 'Data ruangan Empang berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Rke $rke)
    {
        return view('pages.empang.rke.edit', compact('rke'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Rke $rke)
    {
        // Validasi untuk pembaruan data Rke
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rkes', 'kode_ruangan')->ignore($rke->id),
            ],
        ]);
        
        $rke->update($validatedData);

        return redirect()->route('empang.rke.index')
                         ->with('success', 'Data ruangan Empang berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan dari database.
     */
    public function destroy(Rke $rke)
    {
        $rke->delete();

        return redirect()->route('empang.rke.index')
                         ->with('success', 'Data ruangan Empang berhasil dihapus.');
    }

    /**
     * Membuat laporan PDF untuk data ruangan Empang.
     */
    public function pdf()
    {
        $rkes = Rke::where('lokasi', 'empang')->orderBy('name')->get();
        $tanggalCetak = now()->translatedFormat('d F Y');
        $lokasi = 'empang';

        // Pastikan Anda memiliki view 'pages.empang.rke.print'
        $pdf = PDF::loadView('pages.empang.rke.print', compact('rkes', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ruangan-empang-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}
