<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Inventaris Ruangan - {{ $room->name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        .table-bordered th, .table-bordered td { border: 1px solid black !important; vertical-align: middle; font-size: 10px; padding: 4px; }
        thead { background-color: #e9ecef; }
        @media print {
            @page { size: landscape; margin: 1cm; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h5 class="mb-0">KARTU INVENTARIS RUANGAN</h5>
            <h6>SKPD: KECAMATAN {{ strtoupper($lokasi) }}</h6>
            <h6>RUANGAN: {{ strtoupper($room->name) }}</h6>
        </div>

        <table class="table table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th rowspan="2" class="align-middle">No Urut</th>
                    <th rowspan="2" class="align-middle">Nama Barang/ Jenis Barang</th>
                    <th rowspan="2" class="align-middle">Merk/ Model</th>
                    <th rowspan="2" class="align-middle">Bahan</th>
                    <th rowspan="2" class="align-middle">Tahun Pembelian</th>
                    <th rowspan="2" class="align-middle">No. Kode Barang</th>
                    <th rowspan="2" class="align-middle">Jumlah Barang</th>
                    <th rowspan="2" class="align-middle">Harga Beli/ Perolehan (Rp)</th>
                    <th colspan="3">Keadaan Barang</th>
                    <th rowspan="2" class="align-middle">Keterangan</th>
                </tr>
                <tr>
                    <th>Baik (B)</th>
                    <th>Kurang Baik (KB)</th>
                    <th>Rusak Berat (RB)</th>
                </tr> 
            </thead>
            <tbody>
                @forelse ($dataInventaris as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->merk_model }}</td>
                    <td>{{ $item->bahan }}</td>
                    <td class="text-center">{{ $item->tahun_pembelian }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-right">{{ number_format($item->harga_perolehan, 2, ',', '.') }}</td>
                    <td class="text-center">{{ $item->kondisi == 'B' ? 'V' : '' }}</td>
                    <td class="text-center">{{ $item->kondisi == 'KB' ? 'V' : '' }}</td>
                    <td class="text-center">{{ $item->kondisi == 'RB' ? 'V' : '' }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @empty
                <tr><td colspan="12" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

