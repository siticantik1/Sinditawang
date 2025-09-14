{{-- Meng-extend layout utama --}}
@extends('layouts.app')

{{-- Bagian untuk judul halaman --}}
@section('title', 'Data IKK Kelurahan Kahuripan')

{{-- Bagian untuk konten utama --}}
@section('content')
<div class="container-fluid">
    
    {{-- Filter berdasarkan ruangan --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('kahuripan.ikk.index') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="rkk_id_filter">Filter Berdasarkan Ruangan:</label>
                        <select name="rkk_id" id="rkk_id_filter" class="form-control">
                            <option value="">Tampilkan Semua</option>
                            @foreach ($rkks as $rkk)
                                {{-- Gunakan request()->get('rkk_id') untuk mempertahankan filter --}}
                                <option value="{{ $rkk->id }}" {{ request()->get('rkk_id') == $rkk->id ? 'selected' : '' }}>
                                    {{ $rkk->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Data IKK {{ $selectedRkk->name ?? '' }} - Kel. Kahuripan</h4>
                <div>
                    <a href="{{ route('kahuripan.ikk.print', request()->query()) }}" class="btn btn-danger btn-icon-split btn-sm">
                        <span class="icon text-white-50"><i class="fas fa-file-print"></i></span>
                        <span class="text">Export PDF</span>
                    </a>
                    <a href="{{ route('kahuripan.ikk.create') }}" class="btn btn-primary btn-icon-split btn-sm">
                        <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                        <span class="text">Tambah Barang</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="ikk-kahuripan-table">
                    <thead class="text-center" style="background-color: #f2f2f2;">
                        <tr>
                            <th rowspan="2" class="align-middle">No Urut</th>
                            <th rowspan="2" class="align-middle">Nama Barang</th>
                            <th rowspan="2" class="align-middle">Merk / Model</th>
                            <th rowspan="2" class="align-middle">Bahan</th>
                            <th rowspan="2" class="align-middle">Tahun Pembelian</th>
                            <th rowspan="2" class="align-middle">No. Kode Barang</th>
                            <th rowspan="2" class="align-middle">Jumlah</th>
                            <th rowspan="2" class="align-middle">Harga (Rp)</th>
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
                        @forelse ($ikks as $ikk)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ikk->nama_barang }}</td>
                                <td>{{ $ikk->merk_model ?? '-' }}</td>
                                <td>{{ $ikk->bahan ?? '-' }}</td>
                                <td class="text-center">{{ $ikk->tahun_pembelian }}</td>
                                <td>{{ $ikk->kode_barang }}</td>
                                <td class="text-center">{{ $ikk->jumlah }}</td>
                                <td class="text-right">{{ number_format($ikk->harga_perolehan, 0, ',', '.') }}</td>
                                
                                <td class="text-center">@if($ikk->kondisi == 'B') <i class="fas fa-check-circle text-success"></i> @endif</td>
                                <td class="text-center">@if($ikk->kondisi == 'KB') <i class="fas fa-exclamation-circle text-warning"></i> @endif</td>
                                <td class="text-center">@if($ikk->kondisi == 'RB') <i class="fas fa-times-circle text-danger"></i> @endif</td>
                                
                                <td>{{ $ikk->keterangan }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Aksi">
                                        <button type="button" class="btn btn-info btn-sm move-item-btn mr-1" 
                                                data-toggle="modal" 
                                                data-target="#moveItemModal" 
                                                data-id="{{ $ikk->id }}" 
                                                data-name="{{ $ikk->nama_barang }}"
                                                data-rkk="{{ $ikk->rkk->name ?? 'N/A' }}"
                                                title="Pindah Ruangan">
                                            <i class="fas fa-people-carry"></i>
                                        </button>

                                        <a href="{{ route('kahuripan.ikk.edit', $ikk->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit Barang">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="{{ route('kahuripan.ikk.destroy', $ikk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Barang">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center">
                                    Tidak ada data inventaris IKK ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pindah Ruangan -->
<div class="modal fade" id="moveItemModal" tabindex="-1" role="dialog" aria-labelledby="moveItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="moveItemModalLabel">Pindahkan Barang IKK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="moveItemForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Anda akan memindahkan barang: <strong id="itemName"></strong></p>
                    <p>Dari ruangan: <strong id="currentRkk"></strong></p>
                    <div class="form-group">
                        <label for="new_rkk_id">Pindahkan ke Ruangan:</label>
                        <select class="form-control" name="new_rkk_id" required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach ($rkks as $rkk)
                                <option value="{{ $rkk->id }}">{{ $rkk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
    // Script ini akan berjalan setiap kali modal #moveItemModal akan ditampilkan
    $('#moveItemModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang diklik

        // Ambil data dari atribut data-* di tombol
        var itemId = button.data('id');
        var itemName = button.data('name');
        var currentRkk = button.data('rkk');
        
        // Buat URL Template dengan route helper Laravel.
        let formAction = "{{ route('kahuripan.ikk.move', ['ikk' => ':id']) }}";
        // Ganti placeholder :id dengan ID barang yang sebenarnya
        formAction = formAction.replace(':id', itemId);
        
        var modal = $(this);

        // Update konten di dalam modal
        modal.find('#moveItemForm').attr('action', formAction);
        modal.find('#itemName').text(itemName);
        modal.find('#currentRkk').text(currentRkk);
    });
});
</script>
@endpush
