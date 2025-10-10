<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Gedung & Bangunan - {{ ucfirst($lokasi) }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .container {
            width: 95%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h1>KARTU INVENTARIS BARANG (KIB) C - GEDUNG DAN BANGUNAN</h1>
        <h3>Lokasi: {{ strtoupper($lokasi) }}</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Barang / Nama Barang</th>
                    <th>Nomor Kode / Register</th>
                    <th>Kondisi (B/KB/RB)</th>
                    <th>Konstruksi Bertingkat / Beton</th>
                    <th>Luas Lantai (M2)</th>
                    <th>Alamat</th>
                    <th>Tgl/No Dokumen</th>
                    <th>Luas Tanah (M2)</th>
                    <th>Status Tanah</th>
                    <th>Kode Tanah</th>
                    <th>Asal-usul</th>
                    <th>Harga (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataGedung as $gedung)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gedung->jenis_barang }}</td>
                    <td>{{ $gedung->kode_barang }} / {{ $gedung->nomor_register }}</td>
                    <td>{{ $gedung->kondisi }}</td>
                    <td>{{ $gedung->konstruksi_bertingkat }} / {{ $gedung->konstruksi_beton }}</td>
                    <td>{{ $gedung->luas_lantai }}</td>
                    <td>{{ $gedung->alamat }}</td>
                    <td>{{ $gedung->dokumen_tanggal }} / {{ $gedung->dokumen_nomor }}</td>
                    <td>{{ $gedung->luas_tanah }}</td>
                    <td>{{ $gedung->status_tanah }}</td>
                    <td>{{ $gedung->nomor_kode_tanah }}</td>
                    <td>{{ $gedung->asal_usul }}</td>
                    <td>{{ number_format($gedung->harga, 0, ',', '.') }}</td>
                    <td>{{ $gedung->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="14" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
