<?php

namespace App\Http\Controllers;

use App\Models\Gedung; // Pastikan Anda membuat model Gedung
use Illuminate\Http\Request;

class GedungController extends Controller
{
    /**
     * Menampilkan daftar data gedung berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        // Query dimulai dengan memfilter berdasarkan parameter {lokasi} dari URL.
        $query = Gedung::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_register', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }
        
        $dataGedung = $query->latest()->paginate(10);
        
        // Path view dibuat dinamis menggunakan variabel $lokasi.
        return view("pages.{$lokasi}.gedung.index", compact('dataGedung', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data gedung baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.gedung.create", compact('lokasi'));
    }

    /**
     * Menyimpan data gedung yang baru dibuat ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'jenis_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_register' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'bertingkat' => 'nullable|string|max:255',
            'beton' => 'nullable|string|max:255',
            'luas_lantai' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:255',
            'luas_tanah' => 'nullable|numeric',
            'status_tanah' => 'nullable|string|max:255',
            'kode_tanah' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        Gedung::create($dataToStore);

        return redirect()->route('lokasi.gedung.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data gedung & bangunan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data gedung.
     */
    public function edit($lokasi, Gedung $gedung)
    {
        if ($gedung->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.gedung.edit", compact('gedung', 'lokasi'));
    }

    /**
     * Memperbarui data gedung di database.
     */
    public function update(Request $request, $lokasi, Gedung $gedung)
    {
        if ($gedung->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'jenis_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_register' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'bertingkat' => 'nullable|string|max:255',
            'beton' => 'nullable|string|max:255',
            'luas_lantai' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:255',
            'luas_tanah' => 'nullable|numeric',
            'status_tanah' => 'nullable|string|max:255',
            'kode_tanah' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $gedung->update($request->all());

        return redirect()->route('lokasi.gedung.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data gedung & bangunan berhasil diperbarui.');
    }

    /**
     * Menghapus data gedung dari database.
     */
    public function destroy($lokasi, Gedung $gedung)
    {
        if ($gedung->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        
        $gedung->delete();

        return redirect()->route('lokasi.gedung.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data gedung & bangunan berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataGedung = Gedung::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.gedung.print", compact('dataGedung', 'lokasi'));
    }
}
