<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Import Auth
use App\Models\Tanah;
use App\Models\Peralatan;
use App\Models\Gedung;
use App\Models\Jalan;
use App\Models\Rusak;
use App\Models\Inventaris;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userLokasi = null;

        // Peta untuk mengubah nama pengguna menjadi slug lokasi
        $locationMap = [
            'Kecamatan Tawang' => 'tawang',
            'Kelurahan Lengkongsari' => 'lengkongsari',
            'Kelurahan Cikalang' => 'cikalang',
            'Kelurahan Empang' => 'empang',
            'Kelurahan Kahuripan' => 'kahuripan',
            'Kelurahan Tawangsari' => 'tawangsari',
        ];

        if (isset($locationMap[$user->name])) {
            $userLokasi = $locationMap[$user->name];
        }

        // --- Inisialisasi Query ---
        $tanahQuery = $userLokasi ? Tanah::where('lokasi', $userLokasi) : new Tanah;
        $peralatanQuery = $userLokasi ? Peralatan::where('lokasi', $userLokasi) : new Peralatan;
        $gedungQuery = $userLokasi ? Gedung::where('lokasi', $userLokasi) : new Gedung;
        $jalanQuery = $userLokasi ? Jalan::where('lokasi', $userLokasi) : new Jalan;
        $rusakQuery = $userLokasi ? Rusak::where('lokasi', $userLokasi) : new Rusak;
        $inventarisQuery = $userLokasi ? Inventaris::where('lokasi', $userLokasi) : new Inventaris;
        $roomQuery = $userLokasi ? Room::where('lokasi', $userLokasi) : new Room;

        // 1. Menghitung jumlah total setiap jenis aset (disaring berdasarkan lokasi jika bukan admin)
        $totalCounts = [
            'tanah' => $tanahQuery->count(),
            'peralatan' => $peralatanQuery->count(),
            'gedung' => $gedungQuery->count(),
            'jalan' => $jalanQuery->count(),
            'rusak' => $rusakQuery->count(),
            'inventaris' => $inventarisQuery->count(),
            'ruangan' => $roomQuery->count(),
        ];

        // 2. Menghitung total nilai aset (harga) dari semua KIB (disaring berdasarkan lokasi jika bukan admin)
        $totalValue = $tanahQuery->sum('harga') +
                      $peralatanQuery->sum('harga') +
                      $gedungQuery->sum('harga') +
                      $jalanQuery->sum('harga') +
                      $rusakQuery->sum('harga_perolehan');

        // 3. Data untuk Chart Garis: Jumlah Aset Tanah per Lokasi (hanya untuk admin)
        $assetByLocation = collect([]);
        if (!$userLokasi) { // Hanya admin yang melihat data semua lokasi
            $assetByLocation = Tanah::select('lokasi', DB::raw('count(*) as total'))
                                    ->groupBy('lokasi')
                                    ->pluck('total', 'lokasi');
        }

        // 4. Data untuk Chart Pie: Komposisi Nilai Aset berdasarkan KIB (disaring berdasarkan lokasi jika bukan admin)
        $assetValueComposition = collect([
            'Tanah (A)' => $tanahQuery->sum('harga'),
            'Peralatan (B)' => $peralatanQuery->sum('harga'),
            'Gedung (C)' => $gedungQuery->sum('harga'),
            'Jalan (D)' => $jalanQuery->sum('harga'),
        ]);

        return view('pages/dashboard', compact('totalCounts', 'totalValue', 'assetByLocation', 'assetValueComposition'));
    }
}

