<?php

namespace App\Http\Controllers;

use App\Models\Tanah;
use Illuminate\Http\Request;

class TanahController extends Controller
{
    // Variabel untuk menyimpan nilainya, yaitu "Tawang"
    private $namaKecamatan = 'Tawang';

    public function index(Request $request)
    {
        $search = $request->query('search');

        // PERBAIKAN: Panggil kolom 'kecamatan' sesuai dengan yang ada di database
        $query = Tanah::where('kecamatan', $this->namaKecamatan);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%");
            });
        }
        
        $dataTanah = $query->latest()->paginate(10);
        
        // Pastikan path view Anda benar, sesuaikan jika perlu
        return view('tawang.tanah.index', compact('dataTanah'));
    }

    public function create()
    {
        return view('tawang.tanah.create');
    }

    public function store(Request $request)
    {
        $request->validate([ 'nama_barang' => 'required', /* ... validasi lainnya ... */ ]);
        
        $dataToStore = $request->all();
        // PERBAIKAN: Simpan ke kolom 'kecamatan'
        $dataToStore['kecamatan'] = $this->namaKecamatan;
        Tanah::create($dataToStore);

        // Panggil nama route yang benar: 'tawang.tanah.index'
        return redirect()->route('tawang.tanah.index')->with('success', 'Data tanah berhasil ditambahkan.');
    }

    public function edit(Tanah $tanah)
    {
        // PERBAIKAN: Cek ke kolom 'kecamatan'
        if ($tanah->kecamatan !== $this->namaKecamatan) {
            abort(404);
        }
        return view('tawang.tanah.edit', compact('tanah'));
    }

    public function update(Request $request, Tanah $tanah)
    {
        if ($tanah->kecamatan !== $this->namaKecamatan) {
            abort(404);
        }
        $tanah->update($request->all());

        // Panggil nama route yang benar: 'tawang.tanah.index'
        return redirect()->route('tawang.tanah.index')->with('success', 'Data tanah berhasil diperbarui.');
    }

    public function destroy(Tanah $tanah)
    {
        if ($tanah->kecamatan !== $this->namaKecamatan) {
            abort(404);
        }
        $tanah->delete();

        // Panggil nama route yang benar: 'tawang.tanah.index'
        return redirect()->route('tawang.tanah.index')->with('success', 'Data tanah berhasil dihapus.');
    }

    public function print()
    {
        // PERBAIKAN: Ambil data dari kolom 'kecamatan'
        $dataTanah = Tanah::where('kecamatan', $this->namaKecamatan)->latest()->get();
        return view('tawang.tanah.print', compact('dataTanah'));
    }
}