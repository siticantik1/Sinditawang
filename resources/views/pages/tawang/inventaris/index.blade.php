@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    {{-- Card Header --}}
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Kartu Inventaris Ruangan: {{ $room->name }} ({{ ucfirst($lokasi) }})</h6>
        <div class="d-flex">
            <form action="{{ route('lokasi.inventaris.index', ['lokasi' => $lokasi, 'room' => $room->id]) }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari barang..." name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search fa-sm"></i></button>
                    </div>
                </div>
            </form>
            
            <div class="btn-group ml-3">
                <a href="{{ route('lokasi.inventaris.create', ['lokasi' => $lokasi, 'room' => $room->id]) }}" class="btn btn-primary">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
                </a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                    <h6 class="dropdown-header">Opsi Lain:</h6>
                    <a class="dropdown-item" href="{{ route('lokasi.inventaris.print', ['lokasi' => $lokasi, 'room' => $room->id]) }}" target="_blank">
                        <i class="fas fa-print fa-fw mr-2 text-gray-400"></i>Cetak Data
                    </a>
                    <a class="dropdown-item" href="{{ route('lokasi.export.excel', ['lokasi' => $lokasi, 'menu' => 'inventaris', 'room_id' => $room->id]) }}">
                        <i class="fas fa-file-excel fa-fw mr-2 text-gray-400"></i>Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light text-center">
                    {{-- REVISI: Header disesuaikan dengan format di gambar --}}
                    <tr>
                        <th rowspan="2" class="align-middle">No</th>
                        <th rowspan="2" class="align-middle">NIBAR</th>
                        <th rowspan="2" class="align-middle">Nomor Register</th>
                        <th rowspan="2" class="align-middle">Kode Barang</th>
                        <th rowspan="2" class="align-middle">Nama Barang</th>
                        <th rowspan="2" class="align-middle">Spesifikasi Nama Barang</th>
                        <th colspan="2">Spesifikasi Barang</th>
                        <th rowspan="2" class="align-middle">Jumlah</th>
                        <th rowspan="2" class="align-middle">Satuan</th>
                        <th rowspan="2" class="align-middle">Ket.</th>
                        <th rowspan="2" class="align-middle">Aksi</th>
                    </tr>
                    <tr>
                        <th>Merek/Tipe</th>
                        <th>Tahun Perolehan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataInventaris as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $dataInventaris->firstItem() - 1 }}</td>
                        {{-- ASUMSI: Sesuaikan nama properti ini dengan Model Anda --}}
                        <td>{{ $item->nibar }}</td>
                        <td>{{ $item->nomor_register }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->spesifikasi_nama_barang }}</td>
                        <td>{{ $item->merek_tipe }}</td>
                        <td class="text-center">{{ $item->tahun_perolehan }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-info move-btn mr-1" data-toggle="modal" data-target="#moveModal" data-id="{{ $item->id }}" data-nama="{{ $item->nama_barang }}" title="Pindah Barang">
                                    <i class="fas fa-truck"></i>
                                </button>
                                <a href="{{ route('lokasi.inventaris.edit', ['lokasi' => $lokasi, 'room' => $room->id, 'inventari' => $item->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.inventaris.destroy', ['lokasi' => $lokasi, 'room' => $room->id, 'inventari' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="12" class="text-center">Belum ada data inventaris di ruangan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $dataInventaris->links() }}
    </div>
</div>

{{-- Modal untuk Pindah Barang (Tidak diubah) --}}
@include('inventaris.partials.modal-move') {{-- Asumsi modal dipisah ke partial --}}
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.move-btn').on('click', function() {
            var itemId = $(this).data('id');
            var itemName = $(this).data('nama');
            var url = "{{ url($lokasi . '/room/' . $room->id . '/inventaris') }}/" + itemId + "/move";
            
            $('#moveForm').attr('action', url);
            $('#namaBarangPindah').text(itemName);
        });
    });
</script>
@endpush