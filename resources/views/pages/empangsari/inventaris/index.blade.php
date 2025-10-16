@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    {{-- Card Header --}}
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Kartu Inventaris Ruangan: {{ $room->name }} ({{ ucfirst($lokasi) }})</h6>
        <div class="d-flex">
            <form action="{{ route('lokasi.inventaris.index', ['lokasi' => $lokasi, 'room' => $room->id]) }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari barang..." name="search" value="{{ $search ?? '' }}">
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
                    <tr>
                        <th rowspan="2" class="align-middle">No Urut</th>
                        <th rowspan="2" class="align-middle">Nama Barang/ Jenis Barang</th>
                        <th rowspan="2" class="align-middle">Merk/ Model</th>
                        <th rowspan="2" class="align-middle">Bahan</th>
                        <th rowspan="2" class="align-middle">Tahun Pembelian</th>
                        <th rowspan="2" class="align-middle">No. Kode Barang</th>
                        <th rowspan="2" class="align-middle">Jumlah Barang</th>
                        <th rowspan="2" class="align-middle">Harga Beli/ Perolehan (Rp)</th>
                        <th colspan="3">Keadaan Barang</th>
                        <th rowspan="2" class="align-middle">Keterangan</th>
                        <th rowspan="2" class="align-middle">Aksi</th>
                    </tr>
                    <tr>
                        <th>Baik (B)</th>
                        <th>Kurang Baik (KB)</th>
                        <th>Rusak Berat (RB)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataInventaris as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + $dataInventaris->firstItem() - 1 }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->merk_model }}</td>
                        <td>{{ $item->bahan }}</td>
                        <td class="text-center">{{ $item->tahun_pembelian }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                        <td class="text-right">{{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                        <td class="text-center">{!! $item->kondisi == 'B' ? '&check;' : '' !!}</td>
                        <td class="text-center">{!! $item->kondisi == 'KB' ? '&check;' : '' !!}</td>
                        <td class="text-center">{!! $item->kondisi == 'RB' ? '&check;' : '' !!}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td class="text-center">
                            {{-- REVISI: Tombol aksi dibungkus dengan .btn-group --}}
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-info move-btn mr-1 " data-toggle="modal" data-target="#moveModal" data-id="{{ $item->id }}" data-nama="{{ $item->nama_barang }}" title="Pindah Barang">
                                    <i class="fas fa-truck"></i>
                                </button>
                                <a href="{{ route('lokasi.inventaris.edit', ['lokasi' => $lokasi, 'room' => $room->id, 'inventari' => $item->id]) }}" class="btn btn-warning btn-sm mr-1" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('lokasi.inventaris.destroy', ['lokasi' => $lokasi, 'room' => $room->id, 'inventari' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mr-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="13" class="text-center">Belum ada data inventaris di ruangan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $dataInventaris->links() }}
    </div>
</div>

{{-- Modal untuk Pindah Barang --}}
<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveModalLabel">Pindahkan Barang</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="moveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Anda akan memindahkan barang: <strong id="namaBarangPindah"></strong></p>
                    <div class="form-group">
                        <label for="new_room_id">Pindahkan ke Ruangan:</label>
                        <select name="new_room_id" id="new_room_id" class="form-control" required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach ($allRooms as $targetRoom)
                                @if ($targetRoom->id !== $room->id)
                                    <option value="{{ $targetRoom->id }}">{{ $targetRoom->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pindahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

