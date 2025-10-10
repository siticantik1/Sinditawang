@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Data Tanah - {{ ucfirst($lokasi) }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.tanah.update', ['lokasi' => $lokasi, 'tanah' => $tanah->id]) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $tanah->nama_barang) }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $tanah->kode_barang) }}">
                        @error('kode_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nup" class="form-label">NUP (Nomor Urut Pendaftaran)</label>
                        <input type="text" class="form-control @error('nup') is-invalid @enderror" id="nup" name="nup" value="{{ old('nup', $tanah->nup) }}">
                        @error('nup')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="luas" class="form-label">Luas (M²)</label>
                        <input type="number" class="form-control @error('luas') is-invalid @enderror" id="luas" name="luas" value="{{ old('luas', $tanah->luas) }}">
                        @error('luas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tahun_pengadaan" class="form-label">Tahun Pengadaan</label>
                        <input type="number" class="form-control @error('tahun_pengadaan') is-invalid @enderror" id="tahun_pengadaan" name="tahun_pengadaan" placeholder="Contoh: 2023" value="{{ old('tahun_pengadaan', $tanah->tahun_pengadaan) }}">
                        @error('tahun_pengadaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $tanah->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="hak" class="form-label">Hak</label>
                        <input type="text" class="form-control @error('hak') is-invalid @enderror" id="hak" name="hak" value="{{ old('hak', $tanah->hak) }}">
                        @error('hak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_sertifikat" class="form-label">Tanggal Sertifikat</label>
                        <input type="date" class="form-control @error('tanggal_sertifikat') is-invalid @enderror" id="tanggal_sertifikat" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $tanah->tanggal_sertifikat ? $tanah->tanggal_sertifikat->format('Y-m-d') : '') }}">
                        @error('tanggal_sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat</label>
                        <input type="text" class="form-control @error('nomor_sertifikat') is-invalid @enderror" id="nomor_sertifikat" name="nomor_sertifikat" value="{{ old('nomor_sertifikat', $tanah->nomor_sertifikat) }}">
                        @error('nomor_sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="penggunaan" class="form-label">Penggunaan</label>
                        <input type="text" class="form-control @error('penggunaan') is-invalid @enderror" id="penggunaan" name="penggunaan" value="{{ old('penggunaan', $tanah->penggunaan) }}">
                        @error('penggunaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="asal_usul" class="form-label">Asal Usul</label>
                        <input type="text" class="form-control @error('asal_usul') is-invalid @enderror" id="asal_usul" name="asal_usul" value="{{ old('asal_usul', $tanah->asal_usul) }}">
                        @error('asal_usul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Contoh: 150000000" value="{{ old('harga', $tanah->harga) }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $tanah->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.tanah.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

