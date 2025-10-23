<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Jalan, Irigasi & Jaringan - {{ ucfirst($lokasi) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-size: 8pt; }
        .table th, .table td { padding: 0.2rem; vertical-align: middle; border: 1px solid #000 !important; }
        .header-table td { border: none !important; padding: 0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .signature-block { margin-top: 40px; }
        .signature-block .signer { margin-top: 50px; }
        @page { size: A4 landscape; margin: 1cm; }
    </style>
</head>
<body onload="window.print()">

    <div class="container-fluid">
        <h6 class="text-center font-weight-bold">DAFTAR BMD PADA KUASA PENGGUNA BARANG</h6>
        <h6 class="text-center font-weight-bold">JALAN, IRIGASI DAN JARINGAN</h6>
        
        <table class="table header-table mt-4" style="width: 50%;">
             <tbody>
                <tr><td><b>Kuasa Pengguna Barang</b></td><td>: ............................................</td></tr>
                <tr><td><b>Kode Lokasi</b></td><td>: ............................................</td></tr>
                <tr><td><b>PROVINSI/KABUPATEN/KOTA</b></td><td>: ............................................</td></tr>
                <tr><td><b>TAHUN</b></td><td>: {{ date('Y') }}</td></tr>
            </tbody>
        </table>

        <table class="table table-bordered mt-3">
            <thead class="text-center">
                <tr>
                    <th class="align-middle">No</th>
                    <th class="align-middle">Kode Barang</th>
                    <th class="align-middle">Nama Barang</th>
                    <th class="align-middle">NIBAR</th>
                    <th class="align-middle">Nomor Register</th>
                    <th class="align-middle">Spesifikasi</th>
                    <th class="align-middle">Nomor Ruas</th>
                    <th class="align-middle">Lokasi</th>
                    <th class="align-middle">Titik Koordinat</th>
                    <th class="align-middle">Status Tanah</th>
                    <th class="align-middle">Jumlah</th>
                    <th class="align-middle">Satuan</th>
                    <th class="align-middle">Harga Satuan (Rp)</th>
                    <th class="align-middle">Nilai Perolehan (Rp)</th>
                    <th class="align-middle">Cara Perolehan</th>
                    <th class="align-middle">Tgl Perolehan</th>
                    <th class="align-middle">Status Penggunaan</th>
                    <th class="align-middle">Keterangan</th>
                </tr>
                 <tr>
                    @for ($i = 1; $i <= 18; $i++)
                        <th>({{ $i+5 }})</th> {{-- Nomor kolom dimulai dari (6) --}}
                    @endfor
                </tr>
            </thead>
            <tbody>
                @forelse ($dataJalan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->nibar }}</td>
                    <td>{{ $item->nomor_register }}</td>
                    <td>{{ $item->spesifikasi }}</td>
                    <td>{{ $item->nomor_ruas }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->titik_koordinat }}</td>
                    <td>{{ $item->status_tanah }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td class="text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->nilai_perolehan, 0, ',', '.') }}</td>
                    <td>{{ $item->cara_perolehan }}</td>
                    <td class="text-center">{{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d-m-Y') : '' }}</td>
                    <td>{{ $item->status_penggunaan }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @empty
                <tr><td colspan="18" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="row signature-block">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                <p>Kuasa Pengguna Barang</p>
                <div class="signer"><p class="font-weight-bold"><u>............................................</u></p><p>NIP. ............................................</p></div>
            </div>
        </div>
    </div>

</body>
</html>