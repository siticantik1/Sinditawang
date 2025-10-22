@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Gedung & Bangunan (KIB C)</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.gedung.store', ['lokasi' => $lokasi]) }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" name="kode_barang" value="{{ old('kode_barang') }}">
                        @error('kode_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nibar">NIBAR</label>
                        <input type="text" class="form-control @error('nibar') is-invalid @enderror" name="nibar" value="{{ old('nibar') }}">
                        @error('nibar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_register">Nomor Register</label>
                        <input type="text" class="form-control @error('nomor_register') is-invalid @enderror" name="nomor_register" value="{{ old('nomor_register') }}">
                        @error('nomor_register') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi_nama_bangunan">Spesifikasi Nama Bangunan</label>
                        <input type="text" class="form-control @error('spesifikasi_nama_bangunan') is-invalid @enderror" name="spesifikasi_nama_bangunan" value="{{ old('spesifikasi_nama_bangunan') }}">
                        @error('spesifikasi_nama_bangunan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi_lainnya">Spesifikasi Lainnya</label>
                        <input type="text" class="form-control @error('spesifikasi_lainnya') is-invalid @enderror" name="spesifikasi_lainnya" value="{{ old('spesifikasi_lainnya') }}">
                        @error('spesifikasi_lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah', 1) }}">
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{ old('satuan') }}">
                        @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <textarea class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" rows="3">{{ old('lokasi') }}</textarea>
                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="titik_koordinat">Titik Koordinat</label>
                        <input type="text" class="form-control @error('titik_koordinat') is-invalid @enderror" name="titik_koordinat" value="{{ old('titik_koordinat') }}">
                        @error('titik_koordinat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_kepemilikan_tanah">Status Kepemilikan Tanah</label>
                        <input type="text" class="form-control @error('status_kepemilikan_tanah') is-invalid @enderror" name="status_kepemilikan_tanah" value="{{ old('status_kepemilikan_tanah') }}">
                        @error('status_kepemilikan_tanah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_satuan_tanah">Jumlah Satuan (Tanah)</label>
                        <input type="text" class="form-control @error('jumlah_satuan_tanah') is-invalid @enderror" name="jumlah_satuan_tanah" value="{{ old('jumlah_satuan_tanah') }}" placeholder="Contoh: 100 M2">
                        @error('jumlah_satuan_tanah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_satuan">Harga Satuan (Rp)</label>
                        <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" name="harga_satuan" value="{{ old('harga_satuan') }}">
                        @error('harga_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nilai_perolehan">Nilai Perolehan (Rp)</label>
                        <input type="number" class="form-control @error('nilai_perolehan') is-invalid @enderror" name="nilai_perolehan" value="{{ old('nilai_perolehan') }}">
                        @error('nilai_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="cara_perolehan">Cara Perolehan</label>
                        <input type="text" class="form-control @error('cara_perolehan') is-invalid @enderror" name="cara_perolehan" value="{{ old('cara_perolehan') }}">
                        @error('cara_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_perolehan">Tanggal Perolehan</label>
                        <input type="date" class="form-control @error('tanggal_perolehan') is-invalid @enderror" name="tanggal_perolehan" value="{{ old('tanggal_perolehan') }}">
                        @error('tanggal_perolehan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_penggunaan">Status Penggunaan</label>
                        <input type="text" class="form-control @error('status_penggunaan') is-invalid @enderror" name="status_penggunaan" value="{{ old('status_penggunaan') }}">
                        @error('status_penggunaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <hr>
            <a href="{{ route('lokasi.gedung.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection