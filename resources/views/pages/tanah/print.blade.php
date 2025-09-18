<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data Inventaris Tanah - Kecamatan Tawang</title>
    {{-- Memuat Bootstrap agar tampilan tabel tetap rapi --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS ini hanya akan aktif saat mode cetak/print preview */
        @media print {
            body {
                -webkit-print-color-adjust: exact; /* Memaksa browser mencetak warna background */
                margin: 0;
            }
            .no-print {
                display: none; /* Menyembunyikan elemen dengan class 'no-print' (contoh: tombol) */
            }
            .table {
                font-size: 10pt; /* Ukuran font lebih kecil agar muat di kertas */
                border-color: #000 !important; /* Warna border tabel menjadi hitam pekat saat dicetak */
            }
            .table th, .table td {
                padding: 4px 6px;
            }
            h4, h5, h6 {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="text-center mb-4">
            <h4>KARTU INVENTARIS BARANG (KIB) A</h4>
            <h5>TANAH</h5>
            {{-- Mengambil tahun saat ini secara dinamis --}}
            <h6>SKPD: SEKRETARIAT KECAMATAN TAWANG <br> TAHUN ANGGARAN {{ date('Y') }}</h6>
        </div>

        {{-- Tombol ini tidak akan ikut tercetak karena memiliki class 'no-print' --}}
        <div class="mb-3 text-center no-print">
            <button class="btn btn-primary" onclick="window.print()">
                Cetak Halaman
            </button>
            <a href="{{ route('tawang.tanah.index') }}" class="btn btn-secondary">Kembali</a>
        </div>


        <table class="table table-bordered">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th rowspan="2">No. Urut</th>
                    <th rowspan="2">Nama Barang / Jenis Barang</th>
                    <th colspan="2">Nomor</th>
                    <th rowspan="2">Luas (M²)</th>
                    <th rowspan="2">Tahun Pengadaan</th>
                    <th rowspan="2">Letak / Alamat</th>
                    <th colspan="3">Status Tanah</th>
                    <th rowspan="2">Penggunaan</th>
                    <th rowspan="2">Asal Usul</th>
                    <th rowspan="2">Harga (Rp)</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <th>Register</th>
                    <th>Hak</th>
                    <th>Tgl. Sertifikat</th>
                    <th>No. Sertifikat</th>
                </tr>
                 {{-- Kolom penomoran sesuai dokumen asli --}}
                <tr class="table-secondary">
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
                        <td class="text-end">{{ $item->luas }}</td>
                        <td class="text-center">{{ $item->tahun_pengadaan }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->status_hak }}</td>
                        <td class="text-center">{{ $item->tanggal_sertifikat ? \Carbon\Carbon::parse($item->tanggal_sertifikat)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $item->nomor_sertifikat }}</td>
                        <td>{{ $item->penggunaan }}</td>
                        <td>{{ $item->asal_usul }}</td>
                        <td class="text-end">{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">Belum ada data untuk dicetak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>