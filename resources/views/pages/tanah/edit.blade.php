@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Edit Data Tanah</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tawang.tanah.update', $tanah->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang / Jenis Barang</label>
                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $tanah->nama_barang) }}" required>
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode_barang" class="form-label">Nomor Kode Barang</label>
                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $tanah->kode_barang) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="register" class="form-label">Register</label>
                    <input type="text" class="form-control" id="register" name="register" value="{{ old('register', $tanah->register) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="luas" class="form-label">Luas (M²)</label>
                    <input type="number" class="form-control" id="luas" name="luas" value="{{ old('luas', $tanah->luas) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                    <input type="number" class="form-control" id="tahun_pengadaan" name="tahun_pengadaan" placeholder="Contoh: 2024" value="{{ old('tahun_pengadaan', $tanah->tahun_pengadaan) }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="alamat" class="form-label">Letak / Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $tanah->alamat) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="status_hak" class="form-label">Status Hak</label>
                    <input type="text" class="form-control" id="status_hak" name="status_hak" value="{{ old('status_hak', $tanah->status_hak) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tanggal_sertifikat" class="form-label">Tanggal Sertifikat</label>
                    {{-- Untuk input date, formatnya harus Y-m-d --}}
                    <input type="date" class="form-control" id="tanggal_sertifikat" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $tanah->tanggal_sertifikat ? $tanah->tanggal_sertifikat->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat</label>
                    <input type="text" class="form-control" id="nomor_sertifikat" name="nomor_sertifikat" value="{{ old('nomor_sertifikat', $tanah->nomor_sertifikat) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="penggunaan" class="form-label">Penggunaan</label>
                <input type="text" class="form-control" id="penggunaan" name="penggunaan" value="{{ old('penggunaan', $tanah->penggunaan) }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="asal_usul" class="form-label">Asal Usul</label>
                    <input type="text" class="form-control" id="asal_usul" name="asal_usul" value="{{ old('asal_usul', $tanah->asal_usul) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $tanah->harga) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $tanah->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ route('tawang.tanah.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection