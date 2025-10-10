@extends('layouts.app')

@section('title', 'Data Gedung & Bangunan - ' . ucfirst($lokasi))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Gedung & Bangunan - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('lokasi.gedung.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
            <a href="{{ route('lokasi.gedung.print', ['lokasi' => $lokasi]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Cetak Data</a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('lokasi.gedung.index', ['lokasi' => $lokasi]) }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama, kode, alamat..." value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Barang / Nama Barang</th>
                            <th>Nomor Register</th>
                            <th>Kondisi</th>
                            <th>Luas Lantai (M2)</th>
                            <th>Lokasi</th>
                            <th>Harga (Rp)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataGedung as $gedung)
                        <tr>
                            <td>{{ $loop->iteration + $dataGedung->firstItem() - 1 }}</td>
                            <td>{{ $gedung->jenis_barang }} <br> <small class="text-muted">{{ $gedung->kode_barang }}</small></td>
                            <td>{{ $gedung->nomor_register }}</td>
                            <td>{{ $gedung->kondisi }}</td>
                            <td>{{ $gedung->luas_lantai }}</td>
                            <td>{{ $gedung->alamat }}</td>
                            <td>{{ number_format($gedung->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('lokasi.gedung.edit', ['lokasi' => $lokasi, 'gedung' => $gedung->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.gedung.destroy', ['lokasi' => $lokasi, 'gedung' => $gedung->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-end">
                {{ $dataGedung->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
