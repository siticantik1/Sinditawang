@extends('layouts.app')

@section('title', 'Tambah Data Barang Rusak')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Barang Rusak - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lokasi.rusak.store', ['lokasi' => $lokasi]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_pemda">No. ID Pemda</label>
                    <input type="text" class="form-control" id="id_pemda" name="id_pemda" value="{{ old('id_pemda') }}">
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama / Jenis Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                    @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi</label>
                    <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="{{ old('spesifikasi') }}">
                </div>
                <div class="form-group">
                    <label for="no_polisi">No. Polisi</label>
                    <input type="text" class="form-control" id="no_polisi" name="no_polisi" value="{{ old('no_polisi') }}">
                </div>
                <div class="form-group">
                    <label for="tahun_perolehan">Tahun Perolehan</label>
                    <input type="number" class="form-control" id="tahun_perolehan" name="tahun_perolehan" value="{{ old('tahun_perolehan') }}">
                </div>
                <div class="form-group">
                    <label for="harga_perolehan">Harga Perolehan (Rp)</label>
                    <input type="number" class="form-control" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan') }}">
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi</label>
                    <input type="text" class="form-control" id="kondisi" name="kondisi" value="{{ old('kondisi', 'RB') }}">
                </div>
                <div class="form-group">
                    <label for="tercatat_di_kib">Tercatat di KIB</label>
                    <input type="text" class="form-control" id="tercatat_di_kib" name="tercatat_di_kib" value="{{ old('tercatat_di_kib') }}">
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lokasi.rusak.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
