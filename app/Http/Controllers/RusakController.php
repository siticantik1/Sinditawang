<?php

namespace App\Http\Controllers;

use App\Models\Rusak; // Pastikan Anda membuat model Rusak
use Illuminate\Http\Request;

class RusakController extends Controller
{
    /**
     * Menampilkan daftar data barang rusak berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        $query = Rusak::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('no_id_pemda', 'LIKE', "%{$search}%")
                  ->orWhere('spesifikasi', 'LIKE', "%{$search}%")
                  ->orWhere('no_polisi', 'LIKE', "%{$search}%");
            });
        }
        
        $dataRusak = $query->latest()->paginate(10);
        
        return view("pages.{$lokasi}.rusak.index", compact('dataRusak', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.rusak.create", compact('lokasi'));
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'no_id_pemda' => 'nullable|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'no_polisi' => 'nullable|string|max:255',
            'tahun_perolehan' => 'nullable|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'harga_perolehan' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:255',
            'tercatat_di_kib' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        Rusak::create($dataToStore);

        return redirect()->route('lokasi.rusak.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Barang Rusak berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit($lokasi, Rusak $rusak)
    {
        if ($rusak->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.rusak.edit", compact('rusak', 'lokasi'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, $lokasi, Rusak $rusak)
    {
        if ($rusak->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'no_id_pemda' => 'nullable|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            'no_polisi' => 'nullable|string|max:255',
            'tahun_perolehan' => 'nullable|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'harga_perolehan' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:255',
            'tercatat_di_kib' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        $rusak->update($request->all());

        return redirect()->route('lokasi.rusak.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Barang Rusak berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy($lokasi, Rusak $rusak)
    {
        if ($rusak->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        
        $rusak->delete();

        return redirect()->route('lokasi.rusak.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Barang Rusak berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataRusak = Rusak::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.rusak.print", compact('dataRusak', 'lokasi'));
    }
}
