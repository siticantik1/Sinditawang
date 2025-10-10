<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Inventaris Tanah - {{ ucfirst($lokasi) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .table th, .table td {
            font-size: 11px;
            padding: 0.4rem;
            vertical-align: middle;
        }
        .header-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        h4, h5, p {
            margin: 0;
            line-height: 1.5;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid mt-4">
        <div class="header-title">
            <h4>DAFTAR INVENTARIS TANAH</h4>
            <h5>LOKASI: {{ strtoupper($lokasi) }}</h5>
            <p>Per Tanggal: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        <table class="table table-bordered">
            <thead class="table-light text-center">
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Kode Barang / NUP</th>
                    <th>Luas (M²)</th>
                    <th>Tahun</th>
                    <th>Alamat</th>
                    <th>Hak & Sertifikat</th>
                    <th>Penggunaan</th>
                    <th>Asal Usul</th>
                    <th>Harga (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataTanah as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>
                            {{ $item->kode_barang }} <br>
                            <small class="text-muted">NUP: {{ $item->nup ?? '-' }}</small>
                        </td>
                        <td class="text-end">{{ $item->luas }}</td>
                        <td class="text-center">{{ $item->tahun_pengadaan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            {{ $item->hak }} <br>
                            <small class="text-muted">{{ $item->nomor_sertifikat ?? '-' }} ({{ $item->tanggal_sertifikat ? $item->tanggal_sertifikat->format('d/m/Y') : '-' }})</small>
                        </td>
                        <td>{{ $item->penggunaan }}</td>
                        <td>{{ $item->asal_usul }}</td>
                        <td class="text-end">{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">Belum ada data untuk dicetak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

