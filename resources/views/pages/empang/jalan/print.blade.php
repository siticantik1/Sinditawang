<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Jalan, Irigasi & Jaringan - {{ ucfirst($lokasi) }}</title>
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
        <h1>KARTU INVENTARIS BARANG (KIB) D - JALAN, IRIGASI DAN JARINGAN</h1>
        <h3>Lokasi: {{ strtoupper($lokasi) }}</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Barang / Nama Barang</th>
                    <th>Nomor Kode / Register</th>
                    <th>Konstruksi</th>
                    <th>Panjang (KM)</th>
                    <th>Lebar (M)</th>
                    <th>Luas (M2)</th>
                    <th>Lokasi</th>
                    <th>Tgl/No Dokumen</th>
                    <th>Status Tanah</th>
                    <th>Kode Tanah</th>
                    <th>Asal-usul</th>
                    <th>Harga (Rp)</th>
                    <th>Kondisi (B/KB/RB)</th>
                    <th>Ket.</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataJalan as $jalan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jalan->jenis_barang }}</td>
                    <td>{{ $jalan->kode_barang }} / {{ $jalan->nomor_register }}</td>
                    <td>{{ $jalan->konstruksi }}</td>
                    <td>{{ $jalan->panjang }}</td>
                    <td>{{ $jalan->lebar }}</td>
                    <td>{{ $jalan->luas }}</td>
                    <td>{{ $jalan->letak_lokasi }}</td>
                    <td>{{ $jalan->dokumen_tanggal }} / {{ $jalan->dokumen_nomor }}</td>
                    <td>{{ $jalan->status_tanah }}</td>
                    <td>{{ $jalan->kode_tanah }}</td>
                    <td>{{ $jalan->asal_usul }}</td>
                    <td>{{ number_format($jalan->harga, 0, ',', '.') }}</td>
                    <td>{{ $jalan->kondisi }}</td>
                    <td>{{ $jalan->keterangan }}</td>
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
