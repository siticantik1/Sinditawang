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
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari data..." name="search" value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tombol Aksi dengan Dropdown (Bootstrap 4) --}}
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
                    {{-- REVISI: Header disesuaikan agar sama persis dengan KIB D --}}
                    <tr>
                        <th rowspan="2" class="align-middle">No</th>
                        <th rowspan="2" class="align-middle">Jenis Barang / Nama Barang</th>
                        <th colspan="2">Nomor</th>
                        <th rowspan="2" class="align-middle">Konstruksi</th>
                        <th rowspan="2" class="align-middle">Panjang (KM)</th>
                        <th rowspan="2" class="align-middle">Lebar (M)</th>
                        <th rowspan="2" class="align-middle">Luas (M2)</th>
                        <th rowspan="2" class="align-middle">Letak/Lokasi</th>
                        <th colspan="2">Dokumen</th>
                        <th rowspan="2" class="align-middle">Status Tanah</th>
                        <th rowspan="2" class="align-middle">Nomor Kode Tanah</th>
                        <th rowspan="2" class="align-middle">Asal-Usul</th>
                        <th rowspan="2" class="align-middle">Harga</th>
                        <th rowspan="2" class="align-middle">Kondisi (B,KB,RB)</th>
                        <th rowspan="2" class="align-middle">Ket.</th>
                        <th rowspan="2" class="align-middle">Aksi</th>
                    </tr>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Register</th>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataJalan as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $dataJalan->firstItem() - 1 }}</td>
                        <td>{{ $item->jenis_barang }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td class="text-center">{{ $item->nomor_register }}</td>
                        <td>{{ $item->konstruksi }}</td>
                        <td class="text-right">{{ $item->panjang }}</td>
                        <td class="text-right">{{ $item->lebar }}</td>
                        <td class="text-right">{{ $item->luas }}</td>
                        <td>{{ $item->letak_lokasi }}</td>
                        <td class="text-center">{{ $item->dokumen_tanggal ? \Carbon\Carbon::parse($item->dokumen_tanggal)->format('d-m-Y') : '' }}</td>
                        <td>{{ $item->dokumen_nomor }}</td>
                        <td>{{ $item->status_tanah }}</td>
                        <td>{{ $item->kode_tanah }}</td>
                        <td>{{ $item->asal_usul }}</td>
                        <td class="text-right">{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->kondisi }}</td>
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
                        <td colspan="18" class="text-center">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end">
            {{ $dataJalan->appends(['search' => $search ?? ''])->links() }}
        </div>
    </div>
</div>
@endsection

