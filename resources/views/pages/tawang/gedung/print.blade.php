<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Gedung & Bangunan - {{ ucfirst($lokasi) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        .table-bordered th, .table-bordered td { border: 1px solid black !important; vertical-align: middle; font-size: 8px; padding: 2px 4px; }
        thead { background-color: #e9ecef; }
        @media print {
            @page { size: landscape; margin: 0.5cm; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h5 class="mb-0">KARTU INVENTARIS BARANG (KIB) C</h5>
            <h5 class="mb-0">GEDUNG DAN BANGUNAN</h5>
            <h6>SKPD: KECAMATAN {{ strtoupper($lokasi) }}</h6>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th rowspan="2" class="align-middle">No</th>
                    <th rowspan="2" class="align-middle">Jenis Barang / Nama Barang</th>
                    <th rowspan="2" class="align-middle">No Id Pemda</th>
                    <th rowspan="2" class="align-middle">Kondisi Bangunan (B, KB, RB)</th>
                    <th colspan="2">Konstruksi Bangunan</th>
                    <th rowspan="2" class="align-middle">Luas Lantai (M2)</th>
                    <th rowspan="2" class="align-middle">Letak / Lokasi Alamat</th>
                    <th colspan="2">Dokumen Gedung</th>
                    <th rowspan="2" class="align-middle">Luas (M2)</th>
                    <th rowspan="2" class="align-middle">Status Tanah</th>
                    <th rowspan="2" class="align-middle">Nomor Kode Tanah</th>
                    <th rowspan="2" class="align-middle">Asal-usul</th>
                    <th rowspan="2" class="align-middle">Harga (Rp)</th>
                    <th rowspan="2" class="align-middle">Ket.</th>
                </tr>
                <tr>
                    <th>Bertingkat / Tidak</th>
                    <th>Beton / Tidak</th>
                    <th>Tanggal</th>
                    <th>Nomor</th>
                </tr>
                 <tr>
                    @for ($i = 1; $i <= 17; $i++)
                        <th>({{ $i }})</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @forelse ($dataGedung as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->jenis_barang }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td class="text-center">{{ $item->nomor_register }}</td>
                    <td class="text-center">{{ $item->kondisi_bangunan }}</td>
                    <td class="text-center">{{ $item->bertingkat }}</td>
                    <td class="text-center">{{ $item->beton }}</td>
                    <td class="text-right">{{ $item->luas_lantai }}</td>
                    <td>{{ $item->letak_lokasi }}</td>
                    <td class="text-center">{{ $item->dokumen_tanggal ? \Carbon\Carbon::parse($item->dokumen_tanggal)->format('d-m-Y') : '' }}</td>
                    <td>{{ $item->dokumen_nomor }}</td>
                    <td class="text-right">{{ $item->luas }}</td>
                    <td>{{ $item->status_tanah }}</td>
                    <td>{{ $item->kode_tanah }}</td>
                    <td>{{ $item->asal_usul }}</td>
                    <td class="text-right">{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="17" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

