@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Peralatan & Mesin (KIB B) - {{ ucfirst($lokasi) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.peralatan.store', ['lokasi' => $lokasi]) }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang / Jenis Barang</label>
                        <input type="text" class="form-control" name="nama_barang" required>
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
                        <label for="merk_tipe">Merk / Tipe</label>
                        <input type="text" class="form-control" name="merk_tipe">
                    </div>
                    <div class="form-group">
                        <label for="ukuran">Ukuran / CC</label>
                        <input type="text" class="form-control" name="ukuran">
                    </div>
                     <div class="form-group">
                        <label for="bahan">Bahan</label>
                        <input type="text" class="form-control" name="bahan">
                    </div>
                    <div class="form-group">
                        <label for="tahun_pembelian">Tahun Pembelian</label>
                        <input type="number" class="form-control" name="tahun_pembelian" placeholder="YYYY" required>
                    </div>
                </div>
                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                     <div class="card card-body border-left-primary shadow-sm mb-3">
                        <h6 class="font-weight-bold">Nomor Identitas</h6>
                        <div class="form-group">
                            <label for="nomor_pabrik">Nomor Pabrik</label>
                            <input type="text" class="form-control" name="nomor_pabrik">
                        </div>
                        <div class="form-group">
                            <label for="nomor_rangka">Nomor Rangka</label>
                            <input type="text" class="form-control" name="nomor_rangka">
                        </div>
                        <div class="form-group">
                            <label for="nomor_mesin">Nomor Mesin</label>
                            <input type="text" class="form-control" name="nomor_mesin">
                        </div>
                        <div class="form-group">
                            <label for="nomor_polisi">Nomor Polisi</label>
                            <input type="text" class="form-control" name="nomor_polisi">
                        </div>
                        <div class="form-group mb-0">
                            <label for="nomor_bpkb">Nomor BPKB</label>
                            <input type="text" class="form-control" name="nomor_bpkb">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asal_usul">Asal Usul</label>
                        <input type="text" class="form-control" name="asal_usul" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.peralatan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

