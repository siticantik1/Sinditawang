<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use Illuminate\Http\Request;

class TanahController extends Controller
{
    /**
     * Menampilkan daftar data tanah berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        // Query dimulai dengan memfilter berdasarkan parameter {lokasi} dari URL.
        $query = Tanah::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%");
            });
        }
        
        $dataTanah = $query->latest()->paginate(10);
        
        // Path view dibuat dinamis menggunakan variabel $lokasi.
        // Pastikan Anda memiliki folder view untuk setiap lokasi (e.g., resources/views/pages/tawang/tanah, etc.)
        return view("pages.{$lokasi}.tanah.index", compact('dataTanah', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data tanah baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.tanah.create", compact('lokasi'));
    }

    /**
     * Menyimpan data tanah yang baru dibuat ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // Tambahkan validasi lain sesuai kebutuhan...
        ]);
        
        $dataToStore = $request->all();
        // Kolom 'lokasi' diisi secara otomatis dari parameter URL.
        $dataToStore['lokasi'] = $lokasi;
        
        Tanah::create($dataToStore);

        // Redirect ke halaman index dari lokasi yang sesuai.
        return redirect()->route('lokasi.tanah.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data tanah berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data tanah.
     */
    public function edit($lokasi, Tanah $tanah)
    {
        // Pengaman: Pastikan data yang diedit sesuai dengan lokasinya.
        if ($tanah->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.tanah.edit", compact('tanah', 'lokasi'));
    }

    /**
     * Memperbarui data tanah di database.
     */
    public function update(Request $request, $lokasi, Tanah $tanah)
    {
        if ($tanah->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            // ...
        ]);
        
        $tanah->update($request->all());

        return redirect()->route('lokasi.tanah.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data tanah berhasil diperbarui.');
    }

    /**
     * Menghapus data tanah dari database.
     */
    public function destroy($lokasi, Tanah $tanah)
    {
        if ($tanah->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        
        $tanah->delete();

        return redirect()->route('lokasi.tanah.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data tanah berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataTanah = Tanah::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.tanah.print", compact('dataTanah', 'lokasi'));
    }
}
