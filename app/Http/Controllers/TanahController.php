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
        $query = Tanah::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%");
            });
        }
        
        $dataTanah = $query->latest()->paginate(10);
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
        // REVISI: Validasi disesuaikan dengan semua kolom di form
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255',
            'register' => 'required|string|max:255',
            'luas' => 'required|integer',
            'tahun_pengadaan' => 'required|digits:4',
            'alamat' => 'required|string',
            'status_hak' => 'required|string|max:255',
            'tanggal_sertifikat' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'asal_usul' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        Tanah::create($dataToStore);

        return redirect()->route('lokasi.tanah.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data tanah berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data tanah.
     */
    public function edit($lokasi, Tanah $tanah)
    {
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

        // REVISI: Validasi disesuaikan dengan semua kolom di form
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:255',
            'register' => 'required|string|max:255',
            'luas' => 'required|integer',
            'tahun_pengadaan' => 'required|digits:4',
            'alamat' => 'required|string',
            'status_hak' => 'required|string|max:255',
            'tanggal_sertifikat' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'penggunaan' => 'required|string|max:255',
            'asal_usul' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
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

