@extends('layouts.app')

@section('title', 'Tanah - Kel.Lengkongsari')

@section('content')
<div class="card shadow mb-4">
    {{-- Card Header - Aksi dan Pencarian --}}
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Inventaris Tanah (KIB A) - {{ ucfirst($lokasi) }}</h6>
        
        <div class="d-flex">
            {{-- Form Pencarian --}}
            <form action="{{ route('lokasi.tanah.index', ['lokasi' => $lokasi]) }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari nama/alamat..." name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tombol Aksi dengan Dropdown (Bootstrap 4) --}}
            <div class="btn-group ml-3">
                <a href="{{ route('lokasi.tanah.create', ['lokasi' => $lokasi]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Data
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <h6 class="dropdown-header">Opsi Lain:</h6>
                    <a class="dropdown-item" href="{{ route('lokasi.tanah.print', ['lokasi' => $lokasi]) }}" target="_blank">
                        <i class="fas fa-print fa-fw mr-2 text-gray-400"></i>Cetak Data
                    </a>
                    <a class="dropdown-item" href="{{ route('lokasi.export.excel', ['lokasi' => $lokasi, 'menu' => 'tanah']) }}">
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
                    {{-- REVISI: Header tabel dibuat 3 baris agar sesuai KIB A --}}
                    <tr>
                        <th rowspan="3" class="align-middle">No.</th>
                        <th rowspan="3" class="align-middle">Nama Barang / Jenis Barang</th>
                        <th colspan="2">Nomor</th>
                        <th rowspan="3" class="align-middle">Luas (M²)</th>
                        <th rowspan="3" class="align-middle">Tahun Pengadaan</th>
                        <th rowspan="3" class="align-middle">Letak / Alamat</th>
                        <th colspan="3">Status Tanah</th>
                        <th rowspan="3" class="align-middle">Penggunaan</th>
                        <th rowspan="3" class="align-middle">Asal Usul</th>
                        <th rowspan="3" class="align-middle">Harga (Rp)</th>
                        <th rowspan="3" class="align-middle">Keterangan</th>
                        <th rowspan="3" class="align-middle">Aksi</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="align-middle">Kode Barang</th>
                        <th rowspan="2" class="align-middle">Register</th>
                        <th rowspan="2" class="align-middle">Hak</th>
                        <th colspan="2">Sertifikat</th>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataTanah as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + $dataTanah->firstItem() - 1 }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td class="text-center">{{ $item->register }}</td>
                            <td class="text-right">{{ $item->luas }}</td>
                            <td class="text-center">{{ $item->tahun_pengadaan }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->status_hak }}</td>
                            <td class="text-center">{{ $item->tanggal_sertifikat ? \Carbon\Carbon::parse($item->tanggal_sertifikat)->format('d-m-Y') : '' }}</td>
                            <td>{{ $item->nomor_sertifikat }}</td>
                            <td>{{ $item->penggunaan }}</td>
                            <td>{{ $item->asal_usul }}</td>
                            <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td class="text-center">
                                <a href="{{ route('lokasi.tanah.edit', ['lokasi' => $lokasi, 'tanah' => $item->id]) }}" class="btn btn-sm btn-warning mr-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('lokasi.tanah.destroy', ['lokasi' => $lokasi, 'tanah' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mr-1" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form> 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">
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

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-end">
            {{ $dataTanah->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>
@endsection

