<?php

namespace App\Http\Controllers;

use App\Models\Peralatan; // Pastikan Anda sudah membuat model Peralatan
use Illuminate\Http\Request;

class PeralatanController extends Controller
{
    /**
     * Menampilkan daftar data peralatan berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        // Query dimulai dengan memfilter berdasarkan parameter {lokasi} dari URL.
        $query = Peralatan::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_registrasi', 'LIKE', "%{$search}%")
                  ->orWhere('merk', 'LIKE', "%{$search}%")
                  ->orWhere('tipe', 'LIKE', "%{$search}%")
                  ->orWhere('bahan', 'LIKE', "%{$search}%");
            });
        }
        
        $dataPeralatan = $query->latest()->paginate(10);
        
        // Path view dibuat dinamis menggunakan variabel $lokasi.
        // Pastikan Anda memiliki folder view untuk setiap lokasi 
        // (e.g., resources/views/pages/tawang/peralatan, etc.)
        return view("pages.{$lokasi}.peralatan.index", compact('dataPeralatan', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data peralatan baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.peralatan.create", compact('lokasi'));
    }

    /**
     * Menyimpan data peralatan yang baru dibuat ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_registrasi' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembelian' => 'nullable|numeric',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'nomor_polisi' => 'nullable|string|max:255',
            'nomor_bpkb' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        // Kolom 'lokasi' diisi secara otomatis dari parameter URL.
        $dataToStore['lokasi'] = $lokasi;
        
        Peralatan::create($dataToStore);

        // Redirect ke halaman index dari lokasi yang sesuai.
        return redirect()->route('lokasi.peralatan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data peralatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data peralatan.
     */
    public function edit($lokasi, Peralatan $peralatan)
    {
        // Pengaman: Pastikan data yang diedit sesuai dengan lokasinya.
        if ($peralatan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.peralatan.edit", compact('peralatan', 'lokasi'));
    }

    /**
     * Memperbarui data peralatan di database.
     */
    public function update(Request $request, $lokasi, Peralatan $peralatan)
    {
        if ($peralatan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:255',
            'nomor_registrasi' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'tipe' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembelian' => 'nullable|numeric',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'nomor_polisi' => 'nullable|string|max:255',
            'nomor_bpkb' => 'nullable|string|max:255',
            'asal_usul' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $peralatan->update($request->all());

        return redirect()->route('lokasi.peralatan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data peralatan berhasil diperbarui.');
    }

    /**
     * Menghapus data peralatan dari database.
     */
    public function destroy($lokasi, Peralatan $peralatan)
    {
        if ($peralatan->lokasi !== $lokasi) {
            abort(404, 'Data tidak ditemukan di lokasi ini.');
        }
        
        $peralatan->delete();

        return redirect()->route('lokasi.peralatan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data peralatan berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataPeralatan = Peralatan::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.peralatan.print", compact('dataPeralatan', 'lokasi'));
    }
}

