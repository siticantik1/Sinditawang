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
        $title = 'Laporan Data'; // Judul default
        $headerRow = 3; // Baris awal untuk header
        
        // Menentukan data dan header berdasarkan menu yang dipilih
        switch ($menu) {
            case 'tanah':
                $title = 'Laporan Data Tanah (KIB A)';
                
                // REVISI: Menggunakan data array biasa karena header dibuat manual
                $collection = Tanah::where('lokasi', $lokasi)->get();
                foreach ($collection as $key => $item) {
                    $data[] = [
                        $key + 1,
                        $item->nama_barang,
                        $item->kode_barang,
                        $item->register,
                        $item->luas,
                        $item->tahun_pengadaan,
                        $item->alamat,
                        $item->status_hak,
                        $item->tanggal_sertifikat ? \Carbon\Carbon::parse($item->tanggal_sertifikat)->format('d-m-Y') : '',
                        $item->nomor_sertifikat,
                        $item->penggunaan,
                        $item->asal_usul,
                        $item->harga,
                        $item->keterangan
                    ];
                }

                // --- SECTION PEMBUATAN HEADER MANUAL UNTUK TANAH ---
                $headerRow = 3;
                $sheet->mergeCells('A1:N1');
                $sheet->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));

                // Baris 1 Header Utama
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
                
                // Baris 2 Sub-Header
                $sheet->mergeCells('C4:C5')->setCellValue('C4', 'Kode Barang');
                $sheet->mergeCells('D4:D5')->setCellValue('D4', 'Register');
                $sheet->mergeCells('H4:H5')->setCellValue('H4', 'Hak');
                $sheet->mergeCells('I4:J4')->setCellValue('I4', 'Sertifikat');

                // Baris 3 Sub-Sub-Header
                $sheet->setCellValue('I5', 'Tanggal');
                $sheet->setCellValue('J5', 'Nomor');
                // --- END SECTION ---

                // Menulis data mulai dari baris setelah header kompleks
                $sheet->fromArray($data, NULL, 'A6');
                break;

            // ... (case lain tetap sama)
            case 'peralatan':
                // ... kode peralatan
                break;
            
            case 'gedung':
                // ... kode gedung
                break;

            case 'jalan':
                // ... kode jalan
                 break;

            case 'rusak':
                // ... kode rusak
                break;
            
            case 'ruangan':
                // ... kode ruangan
                break;
            
            case 'inventaris':
                // ... kode inventaris
                break;

            default:
                return redirect()->back()->with('error', 'Jenis data untuk ekspor tidak valid.');
        }

        // --- SECTION STYLING ---
        if ($menu !== 'tanah') {
            // Logika styling standar untuk menu lain
            $sheet->mergeCells('A1:' . chr(64 + count($headers)) . '1');
            $sheet->setCellValue('A1', strtoupper($title . ' - LOKASI: ' . $lokasi));
            $sheet->fromArray($headers, NULL, 'A' . $headerRow);
            $sheet->fromArray($data, NULL, 'A' . ($headerRow + 1));
        }

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(20);

        // Mendapatkan dimensi tabel
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Menentukan range header berdasarkan menu
        $headerRange = ($menu === 'tanah') ? 'A3:' . $highestColumn . '5' : 'A' . $headerRow . ':' . $highestColumn . $headerRow;
        $fullTableRange = ($menu === 'tanah') ? 'A3:' . $highestColumn . $highestRow : 'A' . $headerRow . ':' . $highestColumn . $highestRow;

        // Styling untuk Header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ];
        $sheet->getStyle($headerRange)->applyFromArray($headerStyle);
        
        // Styling untuk seluruh tabel (border)
        $tableStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]]
        ];
        $sheet->getStyle($fullTableRange)->applyFromArray($tableStyle);

        // Auto-size semua kolom
        foreach (range('A', $highestColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // --- END SECTION STYLING ---

        $filename = "data_{$menu}_{$lokasi}_" . date('Y-m-d') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

