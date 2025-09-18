@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Data Inventaris Tanah</h3>
            {{-- FORM PENCARIAN --}}
            <form action="{{ route('tawang.tanah.index') }}" method="GET" class="d-flex">
                <input class="form-control me-2" type="search" name="search" placeholder="Cari nama/alamat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('tawang.tanah.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Tambah Data Baru
            </a>
            <a href="{{ route('tawang.tanah.print') }}" target="_blank" class="btn btn-secondary">
                <i class="fas fa-print"></i> Cetak Data
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            {{-- Menambahkan class table-hover agar baris menyala saat disentuh mouse --}}
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Luas (M²)</th>
                        <th>Tahun</th>
                        <th>Alamat</th>
                        <th>Harga (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data dari controller --}}
                    @forelse ($dataTanah as $item)
                        <tr>
                            {{-- Menghitung nomor urut sesuai halaman pagination --}}
                            <td class="text-center">{{ $loop->iteration + $dataTanah->firstItem() - 1 }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td class="text-end">{{ $item->luas }}</td>
                            <td class="text-center">{{ $item->tahun_pengadaan }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('tawang.tanah.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tawang.tanah.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                @if (request('search'))
                                    Data tidak ditemukan untuk pencarian '{{ request('search') }}'.
                                @else
                                    Belum ada data.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MENAMPILKAN LINK HALAMAN (PAGINATION) --}}
        <div class="d-flex justify-content-end">
            {{ $dataTanah->links() }}
        </div>
    </div>
</div>
@endsection