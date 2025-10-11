<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
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
     * Menangani permintaan ekspor data ke Excel dengan styling.
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
        $title = 'Laporan Data';
        $headerRowStart = 3;
        
        switch ($menu) {
            case 'tanah':
                $title = 'Laporan Data Tanah (KIB A)';
                $collection = Tanah::where('lokasi', $lokasi)->get();
                foreach ($collection as $key => $item) {
                    $data[] = [ $key + 1, $item->nama_barang, $item->kode_barang, $item->register, $item->luas, $item->tahun_pengadaan, $item->alamat, $item->status_hak, $item->tanggal_sertifikat ? \Carbon\Carbon::parse($item->tanggal_sertifikat)->format('d-m-Y') : '', $item->nomor_sertifikat, $item->penggunaan, $item->asal_usul, $item->harga, $item->keterangan ];
                }
                $sheet->mergeCells('A1:N1')->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
                $sheet->mergeCells('A3:A5')->setCellValue('A3', 'No.');
                $sheet->mergeCells('B3:B5')->setCellValue('B3', 'Nama Barang / Jenis Barang');
                $sheet->mergeCells('C3:D3')->setCellValue('C3', 'Nomor');
                $sheet->mergeCells('E3:E5')->setCellValue('E3', 'Luas (M²)');
                $sheet->mergeCells('F3:F5')->setCellValue('F3', 'Tahun Pengadaan');
                $sheet->mergeCells('G3:G5')->setCellValue('G3', 'Letak / Alamat');
                $sheet->mergeCells('H3:J3')->setCellValue('H3', 'Status Tanah');
                $sheet->mergeCells('K3:K5')->setCellValue('K3', 'Penggunaan');
                $sheet->mergeCells('L3:L5')->setCellValue('L3', 'Asal Usul');
                $sheet->mergeCells('M3:M5')->setCellValue('M3', 'Harga (Rp)');
                $sheet->mergeCells('N3:N5')->setCellValue('N3', 'Keterangan');
                $sheet->mergeCells('C4:C5')->setCellValue('C4', 'Kode Barang');
                $sheet->mergeCells('D4:D5')->setCellValue('D4', 'Register');
                $sheet->mergeCells('H4:H5')->setCellValue('H4', 'Hak');
                $sheet->mergeCells('I4:J4')->setCellValue('I4', 'Sertifikat');
                $sheet->setCellValue('I5', 'Tanggal');
                $sheet->setCellValue('J5', 'Nomor');
                $sheet->fromArray($data, NULL, 'A6');
                break;

            case 'peralatan':
                $title = 'Laporan Data Peralatan & Mesin (KIB B)';
                $collection = Peralatan::where('lokasi', $lokasi)->get();
                foreach ($collection as $key => $item) {
                    $data[] = [$key + 1, $item->nama_barang, $item->kode_barang, $item->nomor_register, $item->merk_tipe, $item->ukuran, $item->bahan, $item->tahun_pembelian, $item->nomor_pabrik, $item->nomor_rangka, $item->nomor_mesin, $item->nomor_polisi, $item->nomor_bpkb, $item->asal_usul, $item->harga, $item->keterangan];
                }
                $sheet->mergeCells('A1:P1')->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
                $sheet->mergeCells('A3:A4')->setCellValue('A3', 'No');
                $sheet->mergeCells('B3:B4')->setCellValue('B3', 'Nama Barang / Jenis Barang');
                $sheet->mergeCells('C3:D3')->setCellValue('C3', 'Nomor');
                $sheet->mergeCells('E3:E4')->setCellValue('E3', 'Merk / Tipe');
                $sheet->mergeCells('F3:F4')->setCellValue('F3', 'Ukuran / CC');
                $sheet->mergeCells('G3:G4')->setCellValue('G3', 'Bahan');
                $sheet->mergeCells('H3:H4')->setCellValue('H3', 'Tahun Pembelian');
                $sheet->mergeCells('I3:M3')->setCellValue('I3', 'Nomor Identitas');
                $sheet->mergeCells('N3:N4')->setCellValue('N3', 'Asal Usul');
                $sheet->mergeCells('O3:O4')->setCellValue('O3', 'Harga (Rp)');
                $sheet->mergeCells('P3:P4')->setCellValue('P3', 'Keterangan');
                $sheet->setCellValue('C4', 'Kode Barang');
                $sheet->setCellValue('D4', 'Register');
                $sheet->setCellValue('I4', 'Pabrik');
                $sheet->setCellValue('J4', 'Rangka');
                $sheet->setCellValue('K4', 'Mesin');
                $sheet->setCellValue('L4', 'Polisi');
                $sheet->setCellValue('M4', 'BPKB');
                $sheet->fromArray($data, NULL, 'A5');
                break;
            
            case 'gedung':
                $title = 'Laporan Data Gedung & Bangunan (KIB C)';
                $collection = Gedung::where('lokasi', $lokasi)->get();
                foreach ($collection as $key => $item) {
                    $data[] = [ $key + 1, $item->jenis_barang, $item->kode_barang, $item->nomor_register, $item->kondisi_bangunan, $item->bertingkat, $item->beton, $item->luas_lantai, $item->letak_lokasi, $item->dokumen_tanggal ? \Carbon\Carbon::parse($item->dokumen_tanggal)->format('d-m-Y') : '', $item->dokumen_nomor, $item->luas, $item->status_tanah, $item->kode_tanah, $item->asal_usul, $item->harga, $item->keterangan ];
                }
                $sheet->mergeCells('A1:Q1')->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
                $sheet->mergeCells('A3:A4')->setCellValue('A3', 'No.');
                $sheet->mergeCells('B3:B4')->setCellValue('B3', 'Jenis Barang / Nama Barang');
                $sheet->mergeCells('C3:D3')->setCellValue('C3', 'Nomor');
                $sheet->mergeCells('E3:E4')->setCellValue('E3', 'Kondisi Bangunan (B, KB, RB)');
                $sheet->mergeCells('F3:G3')->setCellValue('F3', 'Konstruksi Bangunan');
                $sheet->mergeCells('H3:H4')->setCellValue('H3', 'Luas Lantai (M2)');
                $sheet->mergeCells('I3:I4')->setCellValue('I3', 'Letak / Lokasi Alamat');
                $sheet->mergeCells('J3:K3')->setCellValue('J3', 'Dokumen Gedung');
                $sheet->mergeCells('L3:L4')->setCellValue('L3', 'Luas (M2)');
                $sheet->mergeCells('M3:M4')->setCellValue('M3', 'Status Tanah');
                $sheet->mergeCells('N3:N4')->setCellValue('N3', 'Nomor Kode Tanah');
                $sheet->mergeCells('O3:O4')->setCellValue('O3', 'Asal-usul');
                $sheet->mergeCells('P3:P4')->setCellValue('P3', 'Harga (Rp)');
                $sheet->mergeCells('Q3:Q4')->setCellValue('Q3', 'Ket.');
                $sheet->setCellValue('C4', 'Kode Barang');
                $sheet->setCellValue('D4', 'Register');
                $sheet->setCellValue('F4', 'Bertingkat / Tidak');
                $sheet->setCellValue('G4', 'Beton / Tidak');
                $sheet->setCellValue('J4', 'Tanggal');
                $sheet->setCellValue('K4', 'Nomor');
                $sheet->fromArray($data, NULL, 'A5');
                break;

            case 'jalan':
                $title = 'Laporan Data Jalan, Irigasi & Jaringan (KIB D)';
                 $collection = Jalan::where('lokasi', $lokasi)->get();
                 foreach ($collection as $key => $item) {
                     $data[] = [ $key + 1, $item->jenis_barang, $item->kode_barang, $item->nomor_register, $item->konstruksi, $item->panjang, $item->lebar, $item->luas, $item->letak_lokasi, $item->dokumen_tanggal ? \Carbon\Carbon::parse($item->dokumen_tanggal)->format('d-m-Y') : '', $item->dokumen_nomor, $item->status_tanah, $item->kode_tanah, $item->asal_usul, $item->harga, $item->kondisi, $item->keterangan ];
                 }
                $sheet->mergeCells('A1:Q1')->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
                $sheet->mergeCells('A3:A4')->setCellValue('A3', 'No.');
                $sheet->mergeCells('B3:B4')->setCellValue('B3', 'Jenis Barang / Nama Barang');
                $sheet->mergeCells('C3:D3')->setCellValue('C3', 'Nomor');
                $sheet->mergeCells('E3:E4')->setCellValue('E3', 'Konstruksi');
                $sheet->mergeCells('F3:F4')->setCellValue('F3', 'Panjang (KM)');
                $sheet->mergeCells('G3:G4')->setCellValue('G3', 'Lebar (M)');
                $sheet->mergeCells('H3:H4')->setCellValue('H3', 'Luas (M2)');
                $sheet->mergeCells('I3:I4')->setCellValue('I3', 'Letak / Lokasi');
                $sheet->mergeCells('J3:K3')->setCellValue('J3', 'Dokumen');
                $sheet->mergeCells('L3:L4')->setCellValue('L3', 'Status Tanah');
                $sheet->mergeCells('M3:M4')->setCellValue('M3', 'Nomor Kode Tanah');
                $sheet->mergeCells('N3:N4')->setCellValue('N3', 'Asal-usul');
                $sheet->mergeCells('O3:O4')->setCellValue('O3', 'Harga (Rp)');
                $sheet->mergeCells('P3:P4')->setCellValue('P3', 'Kondisi');
                $sheet->mergeCells('Q3:Q4')->setCellValue('Q3', 'Keterangan');
                $sheet->setCellValue('C4', 'Kode Barang');
                $sheet->setCellValue('D4', 'Register');
                $sheet->setCellValue('J4', 'Tanggal');
                $sheet->setCellValue('K4', 'Nomor');
                $sheet->fromArray($data, NULL, 'A5');
                break;

            case 'rusak':
                $title = 'Laporan Data Barang Rusak Berat';
                $headers = ['No.', 'No. ID Pemda', 'Nama/Jenis Barang', 'Spesifikasi', 'No. Polisi', 'Tahun Perolehan', 'Harga Perolehan (Rp)', 'Kondisi', 'Tercatat di KIB', 'Keterangan'];
                $collection = Rusak::where('lokasi', $lokasi)->get();
                foreach ($collection as $key => $item) {
                    $data[] = [$key + 1, $item->id_pemda, $item->nama_barang, $item->spesifikasi, $item->no_polisi, $item->tahun_perolehan, $item->harga_perolehan, $item->kondisi, $item->tercatat_di_kib, $item->keterangan];
                }
                break;
            
            case 'ruangan':
                $title = 'Laporan Data Ruangan';
                $headers = ['No.', 'Nama Ruangan', 'Kode Ruangan', 'Penanggung Jawab', 'Keterangan'];
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
                    foreach ($collection as $key => $item) {
                        $data[] = [$key + 1, $item->name, $item->kode_ruangan, $item->penanggung_jawab, $item->keterangan];
                    }
                }
                break;
            
            case 'inventaris':
                $title = 'Laporan Data Inventaris Ruangan';
                $headers = ['No.', 'Nama Barang', 'Kode Barang', 'Merk/Tipe', 'Jumlah', 'Satuan', 'Tahun Perolehan', 'Harga (Rp)', 'Kondisi', 'Keterangan'];
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
                    // Diasumsikan model inventaris memiliki relasi ke ruangan, dan ruangan punya lokasi
                    // Ini adalah contoh query, mungkin perlu disesuaikan dengan struktur relasi Anda
                    $collection = $modelClass::get(); // Ini mungkin perlu query yang lebih kompleks
                    foreach ($collection as $key => $item) {
                        $data[] = [$key + 1, $item->nama_barang, $item->kode_barang, $item->merk, $item->jumlah, $item->satuan, $item->tahun_perolehan, $item->harga, $item->kondisi, $item->keterangan];
                    }
                }
                break;

            default:
                return redirect()->back()->with('error', 'Jenis data untuk ekspor tidak valid.');
        }

        // --- SECTION STYLING ---
        $isComplexHeader = in_array($menu, ['tanah', 'peralatan', 'gedung', 'jalan']);

        if (!$isComplexHeader) {
            if (empty($headers)) {
                 return redirect()->back()->with('error', 'Header untuk ekspor tidak ditemukan.');
            }
            $sheet->mergeCells('A1:' . chr(64 + count($headers)) . '1');
            $sheet->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
            $sheet->fromArray($headers, NULL, 'A' . $headerRowStart);
            $sheet->fromArray($data, NULL, 'A' . ($headerRowStart + 1));
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(20);

        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();
        
        $headerRange = 'A3:'.$highestColumn.'3'; // Default
        if ($menu === 'tanah') $headerRange = 'A3:'.$highestColumn.'5';
        if ($menu === 'peralatan') $headerRange = 'A3:'.$highestColumn.'4';
        if ($menu === 'gedung') $headerRange = 'A3:'.$highestColumn.'4';
        if ($menu === 'jalan') $headerRange = 'A3:'.$highestColumn.'4';

        $fullTableRange = 'A3:' . $highestColumn . $highestRow;
        
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ];
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);
        
        $tableStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
        ];
        $sheet->getStyle($fullTableRange)->applyFromArray($tableStyle);

        foreach (range('A', $highestColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = "data_{$menu}_{$lokasi}_" . date('Y-m-d') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

