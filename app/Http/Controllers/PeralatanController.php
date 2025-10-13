<?php

namespace App\Http\Controllers;

use App\Models\Peralatan; // Pastikan Anda sudah membuat model Peralatan
use Illuminate\Http\Request;
use App\Models\User; // Import User model
use App\Notifications\DataModificationNotification; // Import Notification class
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Notification; // Import Notification facade

class PeralatanController extends Controller
{
    /**
     * Menampilkan daftar data peralatan berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');

        $query = Peralatan::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_register', 'LIKE', "%{$search}%")
                  ->orWhere('merk_tipe', 'LIKE', "%{$search}%")
                  ->orWhere('bahan', 'LIKE', "%{$search}%");
            });
        }
        
        $dataPeralatan = $query->latest()->paginate(10);
        
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
            'nomor_register' => 'required|string|max:255',
            'merk_tipe' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembelian' => 'required|digits:4',
            'nomor_pabrik' => 'nullable|string|max:255',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'nomor_polisi' => 'nullable|string|max:255',
            'nomor_bpkb' => 'nullable|string|max:255',
            'asal_usul' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        $peralatan = Peralatan::create($dataToStore);

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'ditambahkan', 'Peralatan & Mesin', $peralatan->nama_barang));

        return redirect()->route('lokasi.peralatan.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data peralatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data peralatan.
     */
    public function edit($lokasi, Peralatan $peralatan)
    {
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
            'nomor_register' => 'required|string|max:255',
            'merk_tipe' => 'nullable|string|max:255',
            'ukuran' => 'nullable|string|max:255',
            'bahan' => 'nullable|string|max:255',
            'tahun_pembelian' => 'required|digits:4',
            'nomor_pabrik' => 'nullable|string|max:255',
            'nomor_rangka' => 'nullable|string|max:255',
            'nomor_mesin' => 'nullable|string|max:255',
            'nomor_polisi' => 'nullable|string|max:255',
            'nomor_bpkb' => 'nullable|string|max:255',
            'asal_usul' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);
        
        $peralatan->update($request->all());

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'diperbarui', 'Peralatan & Mesin', $peralatan->nama_barang));

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
        
        $itemName = $peralatan->nama_barang;
        $peralatan->delete();

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'dihapus', 'Peralatan & Mesin', $itemName));

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

