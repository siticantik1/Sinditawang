<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// KIB Models
use App\Models\Tanah;
use App\Models\Peralatan;
use App\Models\Gedung;
use App\Models\Jalan;
use App\Models\Rusak;
// Ruangan Models
use App\Models\Room;
use App\Models\Rkl;
use App\Models\Rkc;
use App\Models\Rke;
use App\Models\Rkk;
use App\Models\Rkt;
// Inventaris Models
use App\Models\Inventaris;
use App\Models\Ikl;
use App\Models\Ikc;
use App\Models\Ike;
use App\Models\Ikk;
use App\Models\Ikt;

class ExportController extends Controller
{
    /**
     * Menangani permintaan ekspor data ke Excel menggunakan PhpSpreadsheet.
     *
     * @param string $lokasi
     * @param string $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export($lokasi, $menu)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $data = [];
        $headers = [];
        
        // Menentukan data dan header berdasarkan menu yang dipilih
        switch ($menu) {
            case 'tanah':
                $headers = ['Nama Barang', 'Kode Barang', 'Nomor Register', 'Luas (M2)', 'Tahun Pengadaan', 'Alamat', 'Status Hak', 'Nomor Sertifikat', 'Tanggal Sertifikat', 'Penggunaan', 'Asal Usul', 'Harga (Rp)', 'Keterangan'];
                $collection = Tanah::where('lokasi', $lokasi)->get();
                foreach ($collection as $item) {
                    $data[] = [$item->nama_barang, $item->kode_barang, $item->nomor_register, $item->luas, $item->tahun_pengadaan, $item->alamat, $item->status_hak, $item->nomor_sertifikat, $item->tanggal_sertifikat, $item->penggunaan, $item->asal_usul, $item->harga, $item->keterangan];
                }
                break;

            case 'peralatan':
                $headers = ['Nama Barang', 'Kode Barang', 'Nomor Register', 'Merk/Tipe', 'Ukuran/CC', 'Bahan', 'Tahun Pembelian', 'No. Pabrik', 'No. Rangka', 'No. Mesin', 'No. Polisi', 'No. BPKB', 'Asal Usul', 'Harga (Rp)', 'Keterangan'];
                $collection = Peralatan::where('lokasi', $lokasi)->get();
                foreach ($collection as $item) {
                    $data[] = [$item->nama_barang, $item->kode_barang, $item->nomor_register, $item->merk_tipe, $item->ukuran, $item->bahan, $item->tahun_pembelian, $item->nomor_pabrik, $item->nomor_rangka, $item->nomor_mesin, $item->nomor_polisi, $item->nomor_bpkb, $item->asal_usul, $item->harga, $item->keterangan];
                }
                break;
            
            case 'gedung':
                $headers = ['Jenis Barang/Nama Barang', 'Kode Barang', 'Nomor Register', 'Kondisi Bangunan', 'Bertingkat/Tidak', 'Beton/Tidak', 'Luas Lantai (M2)', 'Lokasi', 'Tgl/No Dokumen', 'Luas (M2)', 'Status Tanah', 'Nomor Kode Tanah', 'Asal-usul', 'Harga (Rp)', 'Keterangan'];
                $collection = Gedung::where('lokasi', $lokasi)->get();
                foreach ($collection as $item) {
                    $data[] = [$item->jenis_barang, $item->kode_barang, $item->nomor_register, $item->kondisi_bangunan, $item->bertingkat, $item->beton, $item->luas_lantai, $item->letak_lokasi, $item->dokumen_tanggal . ' / ' . $item->dokumen_nomor, $item->luas, $item->status_tanah, $item->kode_tanah, $item->asal_usul, $item->harga, $item->keterangan];
                }
                break;

            case 'jalan':
                 $headers = ['Jenis Barang/Nama Barang', 'Kode Barang', 'Nomor Register', 'Konstruksi', 'Panjang (KM)', 'Lebar (M)', 'Luas (M2)', 'Lokasi', 'Tgl/No Dokumen', 'Status Tanah', 'Kode Tanah', 'Asal-usul', 'Harga (Rp)', 'Kondisi', 'Keterangan'];
                 $collection = Jalan::where('lokasi', $lokasi)->get();
                 foreach ($collection as $item) {
                     $data[] = [$item->jenis_barang, $item->kode_barang, $item->nomor_register, $item->konstruksi, $item->panjang, $item->lebar, $item->luas, $item->letak_lokasi, $item->dokumen_tanggal . ' / ' . $item->dokumen_nomor, $item->status_tanah, $item->kode_tanah, $item->asal_usul, $item->harga, $item->kondisi, $item->keterangan];
                 }
                 break;

            case 'rusak':
                $headers = ['No. ID Pemda', 'Nama/Jenis Barang', 'Spesifikasi', 'No. Polisi', 'Tahun Perolehan', 'Harga Perolehan (Rp)', 'Kondisi', 'Tercatat di KIB', 'Keterangan'];
                $collection = Rusak::where('lokasi', $lokasi)->get();
                foreach ($collection as $item) {
                    $data[] = [$item->id_pemda, $item->nama_barang, $item->spesifikasi, $item->no_polisi, $item->tahun_perolehan, $item->harga_perolehan, $item->kondisi, $item->tercatat_di_kib, $item->keterangan];
                }
                break;
            
            case 'ruangan':
                $headers = ['Nama Ruangan', 'Kode Ruangan', 'Penanggung Jawab', 'Keterangan'];
                $modelClass = null;
                switch ($lokasi) {
                    case 'tawang': $modelClass = Room::class; break;
                    case 'lengkongsari': $modelClass = Rkl::class; break;
                    case 'cikalang': $modelClass = Rkc::class; break;
                    case 'empang': $modelClass = Rke::class; break;
                    case 'kahuripan': $modelClass = Rkk::class; break;
                    case 'tawangsari': $modelClass = Rkt::class; break;
                }
                if ($modelClass) {
                    $collection = $modelClass::where('lokasi', $lokasi)->get();
                    foreach ($collection as $item) {
                        $data[] = [$item->name, $item->kode_ruangan, $item->penanggung_jawab, $item->keterangan];
                    }
                }
                break;
            
            case 'inventaris':
                $headers = ['Nama Barang', 'Kode Barang', 'Merk/Tipe', 'Jumlah', 'Satuan', 'Tahun Perolehan', 'Harga (Rp)', 'Kondisi', 'Keterangan'];
                $modelClass = null;
                switch ($lokasi) {
                    case 'tawang': $modelClass = Inventaris::class; break;
                    case 'lengkongsari': $modelClass = Ikl::class; break;
                    case 'cikalang': $modelClass = Ikc::class; break;
                    case 'empang': $modelClass = Ike::class; break;
                    case 'kahuripan': $modelClass = Ikk::class; break;
                    case 'tawangsari': $modelClass = Ikt::class; break;
                }
                if ($modelClass) {
                    $collection = $modelClass::where('lokasi', $lokasi)->get();
                    foreach ($collection as $item) {
                        $data[] = [$item->nama_barang, $item->kode_barang, $item->merk, $item->jumlah, $item->satuan, $item->tahun_perolehan, $item->harga, $item->kondisi, $item->keterangan];
                    }
                }
                break;

            default:
                return redirect()->back()->with('error', 'Jenis data untuk ekspor tidak valid.');
        }

        // Menulis header ke baris pertama
        $sheet->fromArray($headers, NULL, 'A1');
        
        // Menulis data mulai dari baris kedua
        $sheet->fromArray($data, NULL, 'A2');

        // Menyiapkan file untuk di-download
        $filename = "data_{$menu}_{$lokasi}_" . date('Y-m-d') . ".xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

