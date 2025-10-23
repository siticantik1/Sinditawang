@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Peralatan & Mesin (KIB B)</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.peralatan.store', ['lokasi' => $lokasi]) }}" method="POST">
            @csrf
            <div class="row">
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
                    <hr>
                    <h6>Spesifikasi Barang</h6>
                     <div class="form-group">
                        <label for="merek_tipe">Merek/Tipe</label>
                        <input type="text" class="form-control @error('merek_tipe') is-invalid @enderror" name="merek_tipe" value="{{ old('merek_tipe') }}">
                        @error('merek_tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="form-group">
                        <label for="ukuran">Ukuran</label>
                        <input type="text" class="form-control @error('ukuran') is-invalid @enderror" name="ukuran" value="{{ old('ukuran') }}">
                        @error('ukuran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="form-group">
                        <label for="spesifikasi_lainnya">Spesifikasi Lainnya</label>
                        <input type="text" class="form-control @error('spesifikasi_lainnya') is-invalid @enderror" name="spesifikasi_lainnya" value="{{ old('spesifikasi_lainnya') }}">
                        @error('spesifikasi_lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <hr>
                    <h6>Kendaraan (Isi jika barang adalah kendaraan)</h6>
                    <div class="form-group">
                        <label for="nomor_rangka">Nomor Rangka</label>
                        <input type="text" class="form-control @error('nomor_rangka') is-invalid @enderror" name="nomor_rangka" value="{{ old('nomor_rangka') }}">
                        @error('nomor_rangka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_mesin">Nomor Mesin</label>
                        <input type="text" class="form-control @error('nomor_mesin') is-invalid @enderror" name="nomor_mesin" value="{{ old('nomor_mesin') }}">
                        @error('nomor_mesin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_polisi">Nomor Polisi</label>
                        <input type="text" class="form-control @error('nomor_polisi') is-invalid @enderror" name="nomor_polisi" value="{{ old('nomor_polisi') }}">
                        @error('nomor_polisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nomor_bpkb">Nomor BPKB</label>
                        <input type="text" class="form-control @error('nomor_bpkb') is-invalid @enderror" name="nomor_bpkb" value="{{ old('nomor_bpkb') }}">
                        @error('nomor_bpkb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
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
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="4">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <hr>
            <a href="{{ route('lokasi.peralatan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection