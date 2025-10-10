<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Daftar Barang Rusak - {{ ucfirst($lokasi) }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .container { width: 95%; margin: 0 auto; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h1>DAFTAR BARANG RUSAK BERAT</h1>
        <h3>Lokasi: {{ strtoupper($lokasi) }}</h3>

        <table>
            <thead>
                <tr>
                    <th>No. Urut SKPD</th>
                    <th>No. ID Pemda</th>
                    <th>Nama / Jenis Barang</th>
                    <th>Spesifikasi</th>
                    <th>No. Polisi</th>
                    <th>Tahun Perolehan</th>
                    <th>Harga Perolehan (Rp)</th>
                    <th>Kondisi</th>
                    <th>Tercatat di KIB</th>
                    <th>Ket.</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataRusak as $rusak)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rusak->id_pemda }}</td>
                    <td>{{ $rusak->nama_barang }}</td>
                    <td>{{ $rusak->spesifikasi }}</td>
                    <td>{{ $rusak->no_polisi }}</td>
                    <td>{{ $rusak->tahun_perolehan }}</td>
                    <td>{{ number_format($rusak->harga_perolehan, 0, ',', '.') }}</td>
                    <td>{{ $rusak->kondisi }}</td>
                    <td>{{ $rusak->tercatat_di_kib }}</td>
                    <td>{{ $rusak->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
