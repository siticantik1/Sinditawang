<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Peralatan & Mesin - {{ ucfirst($lokasi) }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .container { width: 95%; margin: 0 auto; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: left; font-size: 10px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h1>KARTU INVENTARIS BARANG (KIB) B - PERALATAN DAN MESIN</h1>
        <h3>Lokasi: {{ strtoupper($lokasi) }}</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang / Jenis Barang</th>
                    <th>Kode Barang / Register</th>
                    <th>Merk / Tipe</th>
                    <th>Ukuran / CC</th>
                    <th>Bahan</th>
                    <th>Thn Beli</th>
                    <th>No. Pabrik</th>
                    <th>No. Rangka</th>
                    <th>No. Mesin</th>
                    <th>No. Polisi</th>
                    <th>No. BPKB</th>
                    <th>Asal Usul</th>
                    <th>Harga (Rp)</th>
                    <th>Ket.</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataPeralatan as $peralatan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peralatan->nama_barang }}</td>
                    <td>{{ $peralatan->kode_barang }} / {{ $peralatan->nomor_register }}</td>
                    <td>{{ $peralatan->merk_tipe }}</td>
                    <td>{{ $peralatan->ukuran }}</td>
                    <td>{{ $peralatan->bahan }}</td>
                    <td>{{ $peralatan->tahun_pembelian }}</td>
                    <td>{{ $peralatan->nomor_pabrik }}</td>
                    <td>{{ $peralatan->nomor_rangka }}</td>
                    <td>{{ $peralatan->nomor_mesin }}</td>
                    <td>{{ $peralatan->nomor_polisi }}</td>
                    <td>{{ $peralatan->nomor_bpkb }}</td>
                    <td>{{ $peralatan->asal_usul }}</td>
                    <td>{{ number_format($peralatan->harga, 0, ',', '.') }}</td>
                    <td>{{ $peralatan->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="15" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
