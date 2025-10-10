<?php

namespace App\Http\Controllers;

use App\Models\Jalan; // Pastikan Anda membuat model Jalan
use Illuminate\Http\Request;

class JalanController extends Controller
{
    /**
     * Menampilkan daftar data jalan/irigasi/jaringan berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        $query = Jalan::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_register', 'LIKE', "%{$search}%")
                  ->orWhere('letak_lokasi', 'LIKE', "%{$search}%");
            });
        }
        
        $dataJalan = $query->latest()->paginate(10);
        
        return view("pages.{$lokasi}.jalan.index", compact('dataJalan', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.jalan.create", compact('lokasi'));
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'jenis_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_register' => 'nullable|string|max:255',
            'konstruksi' => 'nullable|string|max:255',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'luas' => 'nullable|numeric',
            'letak_lokasi' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:255',
            'status_tanah' => 'nullable|string|max:255',
            'kode_tanah' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        Jalan::create($dataToStore);

        return redirect()->route('lokasi.jalan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Jalan, Irigasi & Jaringan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit($lokasi, Jalan $jalan)
    {
        if ($jalan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.jalan.edit", compact('jalan', 'lokasi'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, $lokasi, Jalan $jalan)
    {
        if ($jalan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'jenis_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_register' => 'nullable|string|max:255',
            'konstruksi' => 'nullable|string|max:255',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'luas' => 'nullable|numeric',
            'letak_lokasi' => 'nullable|string',
            'dokumen_tanggal' => 'nullable|date',
            'dokumen_nomor' => 'nullable|string|max:255',
            'status_tanah' => 'nullable|string|max:255',
            'kode_tanah' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'kondisi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        
        $jalan->update($request->all());

        return redirect()->route('lokasi.jalan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Jalan, Irigasi & Jaringan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy($lokasi, Jalan $jalan)
    {
        if ($jalan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        
        $jalan->delete();

        return redirect()->route('lokasi.jalan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data Jalan, Irigasi & Jaringan berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataJalan = Jalan::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.jalan.print", compact('dataJalan', 'lokasi'));
    }
}
