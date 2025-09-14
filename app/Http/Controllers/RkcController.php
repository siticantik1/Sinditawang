<?php

namespace App\Http\Controllers;

use App\Models\Rkc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF; // Tambahkan ini untuk fungsi PDF

class RkcController extends Controller
{
    /**
     * Menampilkan daftar semua ruangan untuk Cikalang.
     */
    public function index()
    {
        $rkcs = Rkc::where('lokasi', 'cikalang')->orderBy('name')->get();
        return view('pages.cikalang.rkc.index', compact('rkcs'));
    }

    /**
     * Menampilkan form untuk membuat ruangan baru.
     */
    public function create()
    {
        return view('pages.cikalang.rkc.create');
    }

    /**
     * Menyimpan ruangan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan untuk data Rkc
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'required|string|max:50|unique:rkcs,kode_ruangan',
        ]);

        // Tambahkan lokasi 'cikalang' secara otomatis
        $validatedData['lokasi'] = 'cikalang';
        
        Rkc::create($validatedData);

        return redirect()->route('cikalang.rkc.index')
                         ->with('success', 'Data ruangan Cikalang berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit ruangan.
     */
    public function edit(Rkc $rkc)
    {
        return view('pages.cikalang.rkc.edit', compact('rkc'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, Rkc $rkc)
    {
        // Validasi untuk pembaruan data Rkc
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rkcs', 'kode_ruangan')->ignore($rkc->id),
            ],
        ]);
        
        $rkc->update($validatedData);

        return redirect()->route('cikalang.rkc.index')
                         ->with('success', 'Data ruangan Cikalang berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan dari database.
     */
    public function destroy(Rkc $rkc)
    {
        $rkc->delete();

        return redirect()->route('cikalang.rkc.index')
                         ->with('success', 'Data ruangan Cikalang berhasil dihapus.');
    }

    /**
     * Membuat laporan PDF untuk data ruangan Cikalang.
     */
    public function pdf()
    {
        $rkcs = Rkc::where('lokasi', 'cikalang')->orderBy('name')->get();
        $tanggalCetak = now()->translatedFormat('d F Y');
        $lokasi = 'cikalang';

        // Pastikan Anda memiliki view 'pages.rkc.print'
        $pdf = PDF::loadView('pages.cikalang.rkc.print', compact('rkcs', 'tanggalCetak', 'lokasi'));
        
        $fileName = 'laporan-ruangan-cikalang-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}

