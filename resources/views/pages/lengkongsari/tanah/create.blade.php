@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Inventaris Tanah (KIB A) - {{ ucfirst($lokasi) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.tanah.store', ['lokasi' => $lokasi]) }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang / Jenis Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="no_id_pemda">No Id Pemda</label>
                        <input type="text" class="form-control" id="no_id_pemda" name="no_id_pemda">
                    </div>
                    
                    <div class="form-group">
                        <label for="luas">Luas (M²)</label>
                        <input type="number" class="form-control" id="luas" name="luas" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="number" class="form-control" id="tahun_pengadaan" name="tahun_pengadaan" placeholder="YYYY" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Letak / Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="card card-body border-left-primary shadow-sm mb-3">
                        <h6 class="font-weight-bold">Status Tanah</h6>
                        <div class="form-group">
                            <label for="status_hak">Hak</label>
                            <input type="text" class="form-control" id="status_hak" name="status_hak">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sertifikat">Tanggal Sertifikat</label>
                            <input type="date" class="form-control" id="tanggal_sertifikat" name="tanggal_sertifikat">
                        </div>
                        <div class="form-group">
                            <label for="nomor_sertifikat">Nomor Sertifikat</label>
                            <input type="text" class="form-control" id="nomor_sertifikat" name="nomor_sertifikat">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="penggunaan">Penggunaan</label>
                        <input type="text" class="form-control" id="penggunaan" name="penggunaan">
                    </div>
                    <div class="form-group">
                        <label for="asal_usul">Asal Usul</label>
                        <input type="text" class="form-control" id="asal_usul" name="asal_usul" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.tanah.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
