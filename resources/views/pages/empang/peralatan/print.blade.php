<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Peralatan & Mesin - {{ ucfirst($lokasi) }}</title>
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
            <h5 class="mb-0">KARTU INVENTARIS BARANG (KIB) B</h5>
            <h5 class="mb-0">PERALATAN DAN MESIN</h5>
            <h6>SKPD: KECAMATAN {{ strtoupper($lokasi) }}</h6>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th rowspan="2" class="align-middle">No</th>
                    <th rowspan="2" class="align-middle">Nama Barang / Jenis Barang</th>
                    <th colspan="2">Nomor</th>
                    <th rowspan="2" class="align-middle">Merk / Tipe</th>
                    <th rowspan="2" class="align-middle">Ukuran / CC</th>
                    <th rowspan="2" class="align-middle">Bahan</th>
                    <th rowspan="2" class="align-middle">Tahun Pembelian</th>
                    <th colspan="5">Nomor Identitas</th>
                    <th rowspan="2" class="align-middle">Asal Usul</th>
                    <th rowspan="2" class="align-middle">Harga (Rp)</th>
                    <th rowspan="2" class="align-middle">Keterangan</th>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <th>Register</th>
                    <th>Pabrik</th>
                    <th>Rangka</th>
                    <th>Mesin</th>
                    <th>Polisi</th>
                    <th>BPKB</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= 16; $i++)
                        <th>({{ $i }})</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @forelse ($dataPeralatan as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td class="text-center">{{ $item->nomor_register }}</td>
                    <td>{{ $item->merk_tipe }}</td>
                    <td>{{ $item->ukuran }}</td>
                    <td>{{ $item->bahan }}</td>
                    <td class="text-center">{{ $item->tahun_pembelian }}</td>
                    <td>{{ $item->nomor_pabrik }}</td>
                    <td>{{ $item->nomor_rangka }}</td>
                    <td>{{ $item->nomor_mesin }}</td>
                    <td>{{ $item->nomor_polisi }}</td>
                    <td>{{ $item->nomor_bpkb }}</td>
                    <td>{{ $item->asal_usul }}</td>
                    <td class="text-right">{{ number_format($item->harga, 2, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="16" class="text-center">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

