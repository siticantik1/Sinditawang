<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use Illuminate\Http\Request;
use App\Models\User; // Import User model
use App\Notifications\DataModificationNotification; // Import Notification class
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Notification; // Import Notification facade

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
        $request->validate([
            'kode_barang'       => 'required|string|max:255',
            'nama_barang'       => 'required|string|max:255',
            'nibar'             => 'nullable|string|max:255',
            'nomor_register'    => 'nullable|string|max:255',
            'spesifikasi_barang' => 'nullable|string',
            'spesifikasi_lainnya' => 'nullable|string',
            'jumlah'            => 'required|numeric', // Merepresentasikan luas, dll.
            'satuan'            => 'required|string|max:255',
            'Lok'            => 'required|string', // Alamat lengkap
            'titik_koordinat'   => 'nullable|string|max:255',
            'bukti_nama'        => 'nullable|string|max:255',
            'bukti_nomor'       => 'nullable|string|max:255',
            'bukti_tanggal'     => 'nullable|date',
            'nama_kepemilikan_dokumen' => 'nullable|string|max:255',
            'nilai_perolehan'   => 'required|numeric|min:0',
            'harga_satuan'      => 'nullable|numeric|min:0',
            'cara_perolehan'    => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'status_penggunaan' => 'required|string|max:255',
            'keterangan'        => 'nullable|string',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        $tanah = Tanah::create($dataToStore);

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'ditambahkan', 'Tanah', $tanah->nama_barang));

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

        $request->validate([
            'kode_barang'       => 'required|string|max:255',
            'nama_barang'       => 'required|string|max:255',
            'nibar'             => 'nullable|string|max:255',
            'nomor_register'    => 'nullable|string|max:255',
            'spesifikasi_barang' => 'nullable|string',
            'spesifikasi_lainnya' => 'nullable|string',
            'jumlah'            => 'required|numeric', // Merepresentasikan luas, dll.
            'satuan'            => 'required|string|max:255',
            'Lok'            => 'required|string', // Alamat lengkap
            'titik_koordinat'   => 'nullable|string|max:255',
            'bukti_nama'        => 'nullable|string|max:255',
            'bukti_nomor'       => 'nullable|string|max:255',
            'bukti_tanggal'     => 'nullable|date',
            'nama_kepemilikan_dokumen' => 'nullable|string|max:255',
            'nilai_perolehan'   => 'required|numeric|min:0',
            'harga_satuan'      => 'nullable|numeric|min:0',
            'cara_perolehan'    => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'status_penggunaan' => 'required|string|max:255',
            'keterangan'        => 'nullable|string',
        ]);
        
        $tanah->update($request->all());

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'diperbarui', 'Tanah', $tanah->nama_barang));

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
        
        $itemName = $tanah->nama_barang;
        $tanah->delete();

        // Kirim notifikasi ke Admin (1) dan Kecamatan (2)
        $recipients = User::whereIn('role_id', [1, 2])->get();
        Notification::send($recipients, new DataModificationNotification(Auth::user(), 'dihapus', 'Tanah', $itemName));

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

