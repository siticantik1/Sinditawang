@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Jalan, Irigasi & Jaringan (KIB D) - {{ ucfirst($lokasi) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.jalan.store', ['lokasi' => $lokasi]) }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang / Nama Barang</label>
                        <input type="text" class="form-control" name="jenis_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" class="form-control" name="kode_barang">
                    </div>
                    <div class="form-group">
                        <label for="nomor_register">Nomor Register</label>
                        <input type="text" class="form-control" name="nomor_register" required>
                    </div>
                    <div class="form-group">
                        <label for="konstruksi">Konstruksi</label>
                        <input type="text" class="form-control" name="konstruksi" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="panjang">Panjang (KM)</label>
                            <input type="number" class="form-control" name="panjang" step="any">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lebar">Lebar (M)</label>
                            <input type="number" class="form-control" name="lebar" step="any">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="luas">Luas (M2)</label>
                            <input type="number" class="form-control" name="luas" step="any">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="letak_lokasi">Letak/Lokasi</label>
                        <textarea class="form-control" name="letak_lokasi" rows="3" required></textarea>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="card card-body border-left-info mb-3">
                        <h6 class="font-weight-bold">Dokumen</h6>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="dokumen_tanggal">
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_nomor">Nomor</label>
                                <input type="text" class="form-control" name="dokumen_nomor">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_tanah">Status Tanah</label>
                        <input type="text" class="form-control" name="status_tanah" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_tanah">Nomor Kode Tanah</label>
                        <input type="text" class="form-control" name="kode_tanah">
                    </div>
                    <div class="form-group">
                        <label for="asal_usul">Asal-Usul</label>
                        <input type="text" class="form-control" name="asal_usul" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="B">Baik (B)</option>
                            <option value="KB">Kurang Baik (KB)</option>
                            <option value="RB">Rusak Berat (RB)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.jalan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

