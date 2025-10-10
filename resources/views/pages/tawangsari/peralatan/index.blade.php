@extends('layouts.app')

@section('title', 'Data Peralatan & Mesin - ' . ucfirst($lokasi))

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Peralatan & Mesin - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('lokasi.peralatan.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Data</a>
            <a href="{{ route('lokasi.peralatan.print', ['lokasi' => $lokasi]) }}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Cetak Data</a>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('lokasi.peralatan.index', ['lokasi' => $lokasi]) }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama, merk, kode..." value="{{ $search ?? '' }}">
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
                            <th>Nama / Jenis Barang</th>
                            <th>Nomor Register</th>
                            <th>Merk / Tipe</th>
                            <th>Tahun</th>
                            <th>Harga (Rp)</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataPeralatan as $peralatan)
                        <tr>
                            <td>{{ $loop->iteration + $dataPeralatan->firstItem() - 1 }}</td>
                            <td>{{ $peralatan->nama_barang }} <br> <small class="text-muted">{{ $peralatan->kode_barang }}</small></td>
                            <td>{{ $peralatan->nomor_register }}</td>
                            <td>{{ $peralatan->merk_tipe }}</td>
                            <td>{{ $peralatan->tahun_pembelian }}</td>
                            <td>{{ number_format($peralatan->harga, 0, ',', '.') }}</td>
                            <td>{{ $peralatan->keterangan }}</td>
                            <td>
                                <a href="{{ route('lokasi.peralatan.edit', ['lokasi' => $lokasi, 'peralatan' => $peralatan->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.peralatan.destroy', ['lokasi' => $lokasi, 'peralatan' => $peralatan->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                {{ $dataPeralatan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
