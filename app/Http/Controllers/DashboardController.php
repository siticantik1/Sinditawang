<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tanah;
use App\Models\Peralatan;
use App\Models\Gedung;
use App\Models\Jalan;
use App\Models\Inventaris;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan data agregat.
     */
    public function index(Request $request)
    {
        $selectedLokasi = $request->input('lokasi');

        // --- 1. Ambil Semua Lokasi untuk Filter ---
        $lokasiQuery = Room::select('lokasi')->distinct()
            ->union(Tanah::select('lokasi')->distinct())
            ->union(Peralatan::select('lokasi')->distinct())
            ->union(Gedung::select('lokasi')->distinct())
            ->union(Jalan::select('lokasi')->distinct());
        
        $allLokasi = $lokasiQuery->pluck('lokasi')->filter(); // ->filter() untuk hapus null/empty

        // --- 2. Siapkan Query Dasar dengan Filter Lokasi ---
        $tanahQuery = Tanah::query();
        $peralatanQuery = Peralatan::query();
        $gedungQuery = Gedung::query();
        $jalanQuery = Jalan::query();
        $roomQuery = Room::query();
        
        // Inventaris difilter via relasi 'room'
        $inventarisQuery = Inventaris::query();

        if ($selectedLokasi) {
            $tanahQuery->where('lokasi', $selectedLokasi);
            $peralatanQuery->where('lokasi', $selectedLokasi);
            $gedungQuery->where('lokasi', $selectedLokasi);
            $jalanQuery->where('lokasi', $selectedLokasi);
            $roomQuery->where('lokasi', $selectedLokasi);
            
            // Filter inventaris berdasarkan 'lokasi' di tabel 'rooms'
            $inventarisQuery->whereHas('room', function ($q) use ($selectedLokasi) {
                $q->where('lokasi', $selectedLokasi);
            });
        }

        // --- 3. Hitung KPI (Key Performance Indicators) ---

        // KPI 1: Total Nilai Aset
        // Menggunakan asumsi nama kolom dari revisi sebelumnya
        $nilaiTanah = (clone $tanahQuery)->sum('nilai_perolehan');
        $nilaiPeralatan = (clone $peralatanQuery)->sum('nilai_perolehan');
        $nilaiGedung = (clone $gedungQuery)->sum('nilai_perolehan');
        $nilaiJalan = (clone $jalanQuery)->sum('nilai_perolehan');
        $nilaiInventaris = (clone $inventarisQuery)->sum(DB::raw('jumlah * harga_perolehan')); // Asumsi inventaris punya harga_perolehan (dari KIR lama)
        
        $kpiTotalNilai = $nilaiTanah + $nilaiPeralatan + $nilaiGedung + $nilaiJalan + $nilaiInventaris;

        // KPI 2: Total Aset Terdaftar (Berdasarkan jumlah item)
        $countTanah = (clone $tanahQuery)->count();
        $countPeralatan = (clone $peralatanQuery)->count();
        $countGedung = (clone $gedungQuery)->count();
        $countJalan = (clone $jalanQuery)->count();
        $countInventaris = (clone $inventarisQuery)->count(); // Menghitung item inventaris, bukan total 'jumlah'
        
        $kpiTotalAset = $countTanah + $countPeralatan + $countGedung + $countJalan + $countInventaris;

        // KPI 3: Total Ruangan
        $kpiTotalRuangan = (clone $roomQuery)->count();

        // KPI 4: Barang Rusak Berat
        // Asumsi 'kondisi' ada di model Inventaris (B, KB, RB)
        $kpiTotalRusak = (clone $inventarisQuery)->where('kondisi', 'RB')->count();


        // --- 4. Siapkan Data untuk Charts ---

        // Chart 1: Komposisi Aset (Pie)
        $chartKomposisiAset = [
            'labels' => ['KIB A (Tanah)', 'KIB B (Peralatan)', 'KIB C (Gedung)', 'KIB D (Jalan)', 'Inventaris'],
            'data' => [$countTanah, $countPeralatan, $countGedung, $countJalan, $countInventaris],
        ];

        // Chart 2: Nilai Aset per KIB (Bar)
        $chartNilaiAset = [
            'labels' => ['KIB A', 'KIB B', 'KIB C', 'KIB D', 'Inventaris'],
            'data' => [$nilaiTanah, $nilaiPeralatan, $nilaiGedung, $nilaiJalan, $nilaiInventaris],
        ];

        // Chart 3: Kondisi Inventaris Ruangan (Pie)
        $kondisiB = (clone $inventarisQuery)->where('kondisi', 'B')->count();
        $kondisiKB = (clone $inventarisQuery)->where('kondisi', 'KB')->count();
        $kondisiRB = (clone $inventarisQuery)->where('kondisi', 'RB')->count();

        $chartKondisi = [
            'labels' => ['Baik (B)', 'Kurang Baik (KB)', 'Rusak Berat (RB)'],
            'data' => [$kondisiB, $kondisiKB, $kondisiRB],
        ];
        
        // Chart 4: Perolehan Aset per Tahun (Line)
        $perolehanA = (clone $tanahQuery)->whereNotNull('tanggal_perolehan')->select(DB::raw('YEAR(tanggal_perolehan) as tahun'), DB::raw('count(*) as jumlah'))->groupBy('tahun')->pluck('jumlah', 'tahun');
        $perolehanB = (clone $peralatanQuery)->whereNotNull('tanggal_perolehan')->select(DB::raw('YEAR(tanggal_perolehan) as tahun'), DB::raw('count(*) as jumlah'))->groupBy('tahun')->pluck('jumlah', 'tahun');
        $perolehanC = (clone $gedungQuery)->whereNotNull('tanggal_perolehan')->select(DB::raw('YEAR(tanggal_perolehan) as tahun'), DB::raw('count(*) as jumlah'))->groupBy('tahun')->pluck('jumlah', 'tahun');
        $perolehanD = (clone $jalanQuery)->whereNotNull('tanggal_perolehan')->select(DB::raw('YEAR(tanggal_perolehan) as tahun'), DB::raw('count(*) as jumlah'))->groupBy('tahun')->pluck('jumlah', 'tahun');
        $perolehanInv = (clone $inventarisQuery)->whereNotNull('tahun_perolehan')->select('tahun_perolehan as tahun', DB::raw('count(*) as jumlah'))->groupBy('tahun')->pluck('jumlah', 'tahun');
        
        $allPerolehan = [];
        foreach ([$perolehanA, $perolehanB, $perolehanC, $perolehanD, $perolehanInv] as $collection) {
            foreach ($collection as $tahun => $jumlah) {
                if ($tahun) {
                    $allPerolehan[$tahun] = ($allPerolehan[$tahun] ?? 0) + $jumlah;
                }
            }
        }
        ksort($allPerolehan); // Urutkan berdasarkan tahun

        $chartPerolehan = [
            'labels' => array_keys($allPerolehan),
            'data' => array_values($allPerolehan),
        ];

        // --- 5. Siapkan Quick Lists ---

        // List 1: Aset Baru Ditambahkan (Ambil dari Inventaris sebagai contoh)
        $listAsetTerbaru = (clone $inventarisQuery)->with('room')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        // List 2: Daftar Ruangan Terpadat
        $listRuangan = (clone $roomQuery)->withCount('inventaris')
                        ->orderBy('inventaris_count', 'desc')
                        ->limit(5)
                        ->get();


        // --- 6. Kirim ke View ---
        return view('dashboard', compact(
            'kpiTotalNilai', 
            'kpiTotalAset', 
            'kpiTotalRuangan', 
            'kpiTotalRusak',
            'chartKomposisiAset',
            'chartNilaiAset',
            'chartKondisi',
            'chartPerolehan',
            'listAsetTerbaru',
            'listRuangan',
            'allLokasi',
            'selectedLokasi'
        ));
    }
}
