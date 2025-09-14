{{-- Meng-extend layout utama --}}
@extends('layouts.app')

{{-- Bagian untuk judul halaman --}}
@section('title', 'Data IKE Kelurahan Empang')

{{-- Bagian untuk konten utama --}}
@section('content')
<div class="container-fluid">
    
    {{-- Filter berdasarkan ruangan --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('empang.ike.index') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="rke_id_filter">Filter Berdasarkan Ruangan:</label>
                        <select name="rke_id" id="rke_id_filter" class="form-control">
                            <option value="">Tampilkan Semua</option>
                            @foreach ($rkes as $rke)
                                {{-- Gunakan request()->get('rke_id') untuk mempertahankan filter --}}
                                <option value="{{ $rke->id }}" {{ request()->get('rke_id') == $rke->id ? 'selected' : '' }}>
                                    {{ $rke->name }}
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
                <h4 class="m-0 font-weight-bold text-primary">Data IKE {{ $selectedRke->name ?? '' }} - Kel. Empang</h4>
                <div>
                    {{-- Pastikan semua route helper sudah benar --}}
                    <a href="{{ route('empang.ike.print', request()->query()) }}" class="btn btn-danger btn-icon-split btn-sm">
                        <span class="icon text-white-50"><i class="fas fa-file-print"></i></span>
                        <span class="text">Export PDF</span>
                    </a>
                    <a href="{{ route('empang.ike.create') }}" class="btn btn-primary btn-icon-split btn-sm">
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
                <table class="table table-bordered" width="100%" cellspacing="0" id="ike-empang-table">
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
                        @forelse ($ikes as $ike)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ike->nama_barang }}</td>
                                <td>{{ $ike->merk_model ?? '-' }}</td>
                                <td>{{ $ike->bahan ?? '-' }}</td>
                                <td class="text-center">{{ $ike->tahun_pembelian }}</td>
                                <td>{{ $ike->kode_barang }}</td>
                                <td class="text-center">{{ $ike->jumlah }}</td>
                                <td class="text-right">{{ number_format($ike->harga_perolehan, 0, ',', '.') }}</td>
                                
                                <td class="text-center">@if($ike->kondisi == 'B') <i class="fas fa-check-circle text-success"></i> @endif</td>
                                <td class="text-center">@if($ike->kondisi == 'KB') <i class="fas fa-exclamation-circle text-warning"></i> @endif</td>
                                <td class="text-center">@if($ike->kondisi == 'RB') <i class="fas fa-times-circle text-danger"></i> @endif</td>
                                
                                <td>{{ $ike->keterangan }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Aksi">
                                        <button type="button" class="btn btn-info btn-sm move-item-btn mr-1" 
                                                data-toggle="modal" 
                                                data-target="#moveItemModal" 
                                                data-id="{{ $ike->id }}" 
                                                data-name="{{ $ike->nama_barang }}"
                                                data-rke="{{ $ike->rke->name ?? 'N/A' }}"
                                                title="Pindah Ruangan">
                                            <i class="fas fa-people-carry"></i>
                                        </button>

                                        <a href="{{ route('empang.ike.edit', $ike->id) }}" class="btn btn-warning btn-sm mr-1" title="Edit Barang">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="{{ route('empang.ike.destroy', $ike->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');" style="display:inline;">
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
                                    Tidak ada data inventaris IKE ditemukan.
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
                <h5 class="modal-title" id="moveItemModalLabel">Pindahkan Barang IKE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="moveItemForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Anda akan memindahkan barang: <strong id="itemName"></strong></p>
                    <p>Dari ruangan: <strong id="currentRke"></strong></p>
                    <div class="form-group">
                        <label for="new_rke_id">Pindahkan ke Ruangan:</label>
                        <select class="form-control" name="new_rke_id" required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach ($rkes as $rke)
                                <option value="{{ $rke->id }}">{{ $rke->name }}</option>
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
        var currentRke = button.data('rke');
        
        // Buat URL Template dengan route helper Laravel.
        let formAction = "{{ route('empang.ike.move', ['ike' => ':id']) }}";
        // Ganti placeholder :id dengan ID barang yang sebenarnya
        formAction = formAction.replace(':id', itemId);
        
        var modal = $(this);

        // Update konten di dalam modal
        modal.find('#moveItemForm').attr('action', formAction);
        modal.find('#itemName').text(itemName);
        modal.find('#currentRke').text(currentRke);
    });
});
</script>
@endpush
