<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tanah;
use App\Models\Peralatan;
use App\Models\Gedung;
use App\Models\Jalan;
use App\Models\Rusak;
use App\Models\Inventaris;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung jumlah total setiap jenis aset
        $totalCounts = [
            'tanah' => Tanah::count(),
            'peralatan' => Peralatan::count(),
            'gedung' => Gedung::count(),
            'jalan' => Jalan::count(),
            'rusak' => Rusak::count(),
            'inventaris' => Inventaris::count(),
        ];

        // 2. Menghitung total nilai aset (harga)
        $totalValue = Tanah::sum('harga') +
                      Peralatan::sum('harga') +
                      Gedung::sum('harga') +
                      Jalan::sum('harga') +
                      Rusak::sum('harga_perolehan');

        // 3. Data untuk Chart: Jumlah Aset per Lokasi
        $assetByLocation = Tanah::select('lokasi', DB::raw('count(*) as total'))
                                ->groupBy('lokasi')
                                ->pluck('total', 'lokasi');

        // 4. Mengambil data aktivitas terbaru (contoh: 5 data inventaris terakhir)
        $recentInventaris = Inventaris::with('room')->latest()->take(5)->get();

        return view('pages/dashboard', compact('totalCounts', 'totalValue', 'assetByLocation', 'recentInventaris'));
    }
}
