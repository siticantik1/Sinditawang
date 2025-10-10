@extends('layouts.app')

@section('title', 'Daftar Barang Rusak - ' . ucfirst($lokasi))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Barang Rusak - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('lokasi.rusak.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
            <a href="{{ route('lokasi.rusak.print', ['lokasi' => $lokasi]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Cetak Data</a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('lokasi.rusak.index', ['lokasi' => $lokasi]) }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama, id pemda, spesifikasi..." value="{{ $search ?? '' }}">
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
                            <th>ID Pemda</th>
                            <th>Nama / Jenis Barang</th>
                            <th>Spesifikasi</th>
                            <th>Tahun</th>
                            <th>Harga (Rp)</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataRusak as $rusak)
                        <tr>
                            <td>{{ $loop->iteration + $dataRusak->firstItem() - 1 }}</td>
                            <td>{{ $rusak->id_pemda }}</td>
                            <td>{{ $rusak->nama_barang }}</td>
                            <td>{{ $rusak->spesifikasi }}</td>
                            <td>{{ $rusak->tahun_perolehan }}</td>
                            <td>{{ number_format($rusak->harga_perolehan, 0, ',', '.') }}</td>
                            <td>{{ $rusak->kondisi }}</td>
                            <td>
                                <a href="{{ route('lokasi.rusak.edit', ['lokasi' => $lokasi, 'rusak' => $rusak->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.rusak.destroy', ['lokasi' => $lokasi, 'rusak' => $rusak->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                {{ $dataRusak->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
