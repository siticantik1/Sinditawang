@extends('layouts.app')

@section('title', 'Data Jalan, Irigasi & Jaringan - ' . ucfirst($lokasi))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Jalan, Irigasi & Jaringan - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('lokasi.jalan.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
            <a href="{{ route('lokasi.jalan.print', ['lokasi' => $lokasi]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Cetak Data</a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('lokasi.jalan.index', ['lokasi' => $lokasi]) }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama, lokasi, kode..." value="{{ $search ?? '' }}">
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
                            <th>Jenis / Nama Barang</th>
                            <th>Nomor Register</th>
                            <th>Konstruksi</th>
                            <th>Panjang (KM)</th>
                            <th>Lokasi</th>
                            <th>Harga (Rp)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataJalan as $jalan)
                        <tr>
                            <td>{{ $loop->iteration + $dataJalan->firstItem() - 1 }}</td>
                            <td>{{ $jalan->jenis_barang }} <br> <small class="text-muted">{{ $jalan->kode_barang }}</small></td>
                            <td>{{ $jalan->nomor_register }}</td>
                            <td>{{ $jalan->konstruksi }}</td>
                            <td>{{ $jalan->panjang }}</td>
                            <td>{{ $jalan->letak_lokasi }}</td>
                            <td>{{ number_format($jalan->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('lokasi.jalan.edit', ['lokasi' => $lokasi, 'jalan' => $jalan->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.jalan.destroy', ['lokasi' => $lokasi, 'jalan' => $jalan->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                {{ $dataJalan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
