<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Tanah - {{ ucfirst($lokasi) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        .table-bordered th, .table-bordered td { border: 1px solid black !important; vertical-align: middle; }
        thead { background-color: #e9ecef; }
        @media print {
            @page {
                size: landscape;
                margin: 0.5cm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h5 class="mb-0">KARTU INVENTARIS BARANG (KIB) A</h5>
            <h5 class="mb-0">TANAH</h5>
            <h6>SKPD: KECAMATAN {{ strtoupper($lokasi) }}</h6>
        </div>

        <table class="table table-bordered table-sm" style="font-size: 10px;">
            <thead class="text-center">
                <tr>
                    <th rowspan="3" class="align-middle">No.</th>
                    <th rowspan="3" class="align-middle">Nama Barang / Jenis Barang</th>
                    <th colspan="2">Nomor</th>
                    <th rowspan="3" class="align-middle">Luas (M²)</th>
                    <th rowspan="3" class="align-middle">Tahun Pengadaan</th>
                    <th rowspan="3" class="align-middle">Letak / Alamat</th>
                    <th colspan="3">Status Tanah</th>
                    <th rowspan="3" class="align-middle">Penggunaan</th>
                    <th rowspan="3" class="align-middle">Asal Usul</th>
                    <th rowspan="3" class="align-middle">Harga (Rp)</th>
                    <th rowspan="3" class="align-middle">Keterangan</th>
                </tr>
                <tr>
                    <th rowspan="2" class="align-middle">Kode Barang</th>
                    <th rowspan="2" class="align-middle">Register</th>
                    <th rowspan="2" class="align-middle">Hak</th>
                    <th colspan="2">Sertifikat</th>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <th>Nomor</th>
                </tr>
                 <tr>
                    @for ($i = 1; $i <= 14; $i++)
                        <th>({{ $i }})</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @forelse ($dataTanah as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td class="text-center">{{ $item->register }}</td>
                        <td class="text-right">{{ $item->luas }}</td>
                        <td class="text-center">{{ $item->tahun_pengadaan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->status_hak }}</td>
                        <td class="text-center">{{ $item->tanggal_sertifikat ? \Carbon\Carbon::parse($item->tanggal_sertifikat)->format('d-m-Y') : '' }}</td>
                        <td>{{ $item->nomor_sertifikat }}</td>
                        <td>{{ $item->penggunaan }}</td>
                        <td>{{ $item->asal_usul }}</td>
                        <td class="text-right">{{ number_format($item->harga, 2, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
