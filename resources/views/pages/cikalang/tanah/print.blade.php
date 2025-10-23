{{-- resources/views/tanah/print.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Inventaris Tanah - {{ ucfirst($lokasi) }}</title>
    {{-- Menggunakan Bootstrap dari CDN untuk styling dasar --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
        }
        .table th, .table td {
            padding: 0.25rem;
            vertical-align: middle;
            border: 1px solid #000 !important;
        }
        .header-table td {
            border: none !important;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .signature-block {
            margin-top: 50px;
        }
        .signature-block .signer {
            margin-top: 60px;
        }
        @media print {
            /* Sembunyikan elemen yang tidak perlu dicetak */
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container-fluid">
        <h5 class="text-center font-weight-bold">DAFTAR BMD PADA KUASA PENGGUNA BARANG</h5>
        <h5 class="text-center font-weight-bold">TANAH</h5>
        
        <table class="table header-table mt-4" style="width: 50%;">
             <tbody>
                <tr>
                    <td><b>Kuasa Pengguna Barang</b></td>
                    <td>: ............................................</td>
                </tr>
                <tr>
                    <td><b>Kode Lokasi</b></td>
                    <td>: ............................................</td>
                </tr>
                 <tr>
                    <td><b>PROVINSI/KABUPATEN/KOTA</b></td>
                    <td>: ............................................</td>
                </tr>
                <tr>
                    <td><b>TAHUN</b></td>
                    <td>: {{ date('Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Kode Barang</th>
                        <th rowspan="2">Nama Barang</th>
                        <th rowspan="2">NIBAR</th>
                        <th rowspan="2">Nomor Register</th>
                        <th rowspan="2">Spesifikasi Lainnya</th>
                        <th rowspan="2">Jumlah</th>
                        <th rowspan="2">Satuan</th>
                        <th rowspan="2">Lokasi</th>
                        <th rowspan="2">Titik Koordinat</th>
                        <th colspan="3">Bukti Kepemilikan</th>
                        <th rowspan="2">Harga Satuan (Rp)</th>
                        <th rowspan="2">Nilai Perolehan (Rp)</th>
                        <th rowspan="2">Cara Perolehan</th>
                        <th rowspan="2">Tgl Perolehan</th>
                        <th rowspan="2">Tgl Penggunaan</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Nama Kepemilikan</th>
                    </tr>
                     <tr>
                        @for ($i = 1; $i <= 20; $i++)
                            <th>({{ $i }})</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataTanah as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->nibar }}</td>
                            <td>{{ $item->nomor_register }}</td>
                            <td>{{ $item->spesifikasi_lainnya }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->titik_koordinat }}</td>
                            <td>{{ $item->bukti_nomor }}</td>
                            <td class="text-center">{{ $item->bukti_tanggal ? \Carbon\Carbon::parse($item->bukti_tanggal)->format('d-m-Y') : '' }}</td>
                            <td>{{ $item->bukti_nama_kepemilikan }}</td>
                            <td class="text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->nilai_perolehan, 0, ',', '.') }}</td>
                            <td>{{ $item->cara_perolehan }}</td>
                            <td class="text-center">{{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d-m-Y') : '' }}</td>
                            <td class="text-center">{{ $item->tanggal_penggunaan ? \Carbon\Carbon::parse($item->tanggal_penggunaan)->format('d-m-Y') : '' }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" class="text-center">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row signature-block">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>{{ date('d F Y') }}</p>
                <p>Kuasa Pengguna Barang</p>
                <div class="signer">
                    <p class="font-weight-bold"><u>............................................</u></p>
                    <p>NIP. ............................................</p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>