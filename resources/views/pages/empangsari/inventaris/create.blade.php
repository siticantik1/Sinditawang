@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Inventaris untuk Ruangan: {{ $room->name }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.inventaris.store', ['lokasi' => $lokasi, 'room' => $room->id]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang / Jenis Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Merk / Model</label>
                        <input type="text" name="merk_model" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Bahan</label>
                        <input type="text" name="bahan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" class="form-control" placeholder="YYYY" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input type="number" name="jumlah" class="form-control" value="1" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Beli / Perolehan (Rp)</label>
                        <input type="number" name="harga_perolehan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keadaan Barang</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="B">Baik (B)</option>
                            <option value="KB">Kurang Baik (KB)</option>
                            <option value="RB">Rusak Berat (RB)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.inventaris.index', ['lokasi' => $lokasi, 'room' => $room->id]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

