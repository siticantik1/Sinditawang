<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar data ruangan berdasarkan lokasi dan pencarian.
     */
    public function index(Request $request, $lokasi)
    {
        $search = $request->query('search');
        $query = Room::where('lokasi', $lokasi);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('kode_ruangan', 'LIKE', "%{$search}%");
            });
        }
        
        $dataRuangan = $query->latest()->paginate(10);
        
        return view("pages.{$lokasi}.room.index", compact('dataRuangan', 'lokasi', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data ruangan baru.
     */
    public function create($lokasi)
    {
        return view("pages.{$lokasi}.room.create", compact('lokasi'));
    }

    /**
     * Menyimpan data ruangan yang baru dibuat ke database.
     */
    public function store(Request $request, $lokasi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'nullable|string|max:255',
        ]);
        
        $dataToStore = $request->all();
        $dataToStore['lokasi'] = $lokasi;
        
        Room::create($dataToStore);

        return redirect()->route('lokasi.room.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data ruangan.
     */
    public function edit($lokasi, Room $room)
    {
        // Pengaman: Pastikan data yang diedit sesuai dengan lokasinya.
        if ($room->lokasi !== $lokasi) {
            abort(404, 'Data ruangan tidak ditemukan di lokasi ini.');
        }
        return view("pages.{$lokasi}.room.edit", compact('room', 'lokasi'));
    }

    /**
     * Memperbarui data ruangan di database.
     */
    public function update(Request $request, $lokasi, Room $room)
    {
        if ($room->lokasi !== $lokasi) {
            abort(404, 'Data ruangan tidak ditemukan di lokasi ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'kode_ruangan' => 'nullable|string|max:255',
        ]);
        
        $room->update($request->all());

        return redirect()->route('lokasi.room.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan dari database.
     */
    public function destroy($lokasi, Room $room)
    {
        if ($room->lokasi !== $lokasi) {
            abort(404, 'Data ruangan tidak ditemukan di lokasi ini.');
        }
        
        $room->delete();

        return redirect()->route('lokasi.room.index', ['lokasi' => $lokasi])
                         ->with('success', 'Data ruangan berhasil dihapus.');
    }

    /**
     * Menghasilkan halaman untuk dicetak (print).
     */
    public function print($lokasi)
    {
        $dataRuangan = Room::where('lokasi', $lokasi)->latest()->get();
        return view("pages.{$lokasi}.room.print", compact('dataRuangan', 'lokasi'));
    }
}

