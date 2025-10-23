@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    {{-- Card Header - Aksi dan Pencarian --}}
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Jalan, Irigasi & Jaringan (KIB D) - {{ ucfirst($lokasi) }}</h6>
        
        <div class="d-flex">
            {{-- Form Pencarian --}}
            <form action="{{ route('lokasi.jalan.index', ['lokasi' => $lokasi]) }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data..." name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tombol Aksi dengan Dropdown --}}
            <div class="btn-group ml-3">
                <a href="{{ route('lokasi.jalan.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Data
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <h6 class="dropdown-header">Opsi Lain:</h6>
                    <a class="dropdown-item" href="{{ route('lokasi.jalan.print', ['lokasi' => $lokasi]) }}" target="_blank">
                        <i class="fas fa-print fa-fw mr-2 text-gray-400"></i>Cetak Data
                    </a>
                    <a class="dropdown-item" href="{{ route('lokasi.export.excel', ['lokasi' => $lokasi, 'menu' => 'jalan']) }}">
                        <i class="fas fa-file-excel fa-fw mr-2 text-gray-400"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Body - Tabel Data --}}
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light text-center">
                    {{-- REVISI: Header disesuaikan dengan KIB D di gambar --}}
                    <tr>
                        <th class="align-middle">No</th>
                        <th class="align-middle">Kode Barang</th>
                        <th class="align-middle">Nama Barang</th>
                        <th class="align-middle">NIBAR</th>
                        <th class="align-middle">Nomor Register</th>
                        <th class="align-middle">Spesifikasi Jalan/Jaringan</th>
                        <th class="align-middle">Nomor Ruas Jalan/Irigasi</th>
                        <th class="align-middle">Lokasi</th>
                        <th class="align-middle">Titik Koordinat</th>
                        <th class="align-middle">Status Kepemilikan Tanah</th>
                        <th class="align-middle">Jumlah</th>
                        <th class="align-middle">Satuan</th>
                        <th class="align-middle">Harga Satuan (Rp)</th>
                        <th class="align-middle">Nilai Perolehan (Rp)</th>
                        <th class="align-middle">Cara Perolehan</th>
                        <th class="align-middle">Tanggal Perolehan</th>
                        <th class="align-middle">Status Penggunaan</th>
                        <th class="align-middle">Keterangan</th>
                        <th class="align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataJalan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $dataJalan->firstItem() - 1 }}</td>
                        {{-- ASUMSI: Sesuaikan nama properti ini dengan Model Anda --}}
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
                        <td class="text-center">
                            <a href="{{ route('lokasi.jalan.edit', ['lokasi' => $lokasi, 'jalan' => $item->id]) }}" class="btn btn-sm btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('lokasi.jalan.destroy', ['lokasi' => $lokasi, 'jalan' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- REVISI: Colspan disesuaikan dengan jumlah kolom baru (19) --}}
                        <td colspan="19" class="text-center">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $dataJalan->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection