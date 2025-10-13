@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Inventaris di Ruangan: {{ $room->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.inventaris.update', ['lokasi' => $lokasi, 'room' => $room->id, 'inventari' => $inventari->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang / Jenis Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $inventari->nama_barang) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Merk / Model</label>
                        <input type="text" name="merk_model" class="form-control" value="{{ old('merk_model', $inventari->merk_model) }}">
                    </div>
                    <div class="form-group">
                        <label>Bahan</label>
                        <input type="text" name="bahan" class="form-control" value="{{ old('bahan', $inventari->bahan) }}">
                    </div>
                    <div class="form-group">
                        <label>Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" class="form-control" placeholder="YYYY" value="{{ old('tahun_pembelian', $inventari->tahun_pembelian) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang', $inventari->kode_barang) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $inventari->jumlah) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Beli / Perolehan (Rp)</label>
                        <input type="number" name="harga_perolehan" class="form-control" value="{{ old('harga_perolehan', $inventari->harga_perolehan) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Keadaan Barang</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="B" {{ old('kondisi', $inventari->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                            <option value="KB" {{ old('kondisi', $inventari->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                            <option value="RB" {{ old('kondisi', $inventari->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $inventari->keterangan) }}</textarea>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.inventaris.index', ['lokasi' => $lokasi, 'room' => $room->id]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

