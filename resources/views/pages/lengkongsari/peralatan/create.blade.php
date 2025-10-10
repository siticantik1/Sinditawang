@extends('layouts.app')

@section('title', 'Tambah Data Peralatan & Mesin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Peralatan & Mesin - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lokasi.peralatan.store', ['lokasi' => $lokasi]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                            @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_register">Nomor Register</label>
                            <input type="text" class="form-control" id="nomor_register" name="nomor_register" value="{{ old('nomor_register') }}">
                        </div>
                        <div class="form-group">
                            <label for="merk_tipe">Merk / Tipe</label>
                            <input type="text" class="form-control" id="merk_tipe" name="merk_tipe" value="{{ old('merk_tipe') }}">
                        </div>
                        <div class="form-group">
                            <label for="ukuran">Ukuran / CC</label>
                            <input type="text" class="form-control" id="ukuran" name="ukuran" value="{{ old('ukuran') }}">
                        </div>
                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control" id="bahan" name="bahan" value="{{ old('bahan') }}">
                        </div>
                         <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian</label>
                            <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor_pabrik">Nomor Pabrik</label>
                            <input type="text" class="form-control" id="nomor_pabrik" name="nomor_pabrik" value="{{ old('nomor_pabrik') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_rangka">Nomor Rangka</label>
                            <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_mesin">Nomor Mesin</label>
                            <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_polisi">Nomor Polisi</label>
                            <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_bpkb">Nomor BPKB</label>
                            <input type="text" class="form-control" id="nomor_bpkb" name="nomor_bpkb" value="{{ old('nomor_bpkb') }}">
                        </div>
                        <div class="form-group">
                            <label for="asal_usul">Asal Usul</label>
                            <input type="text" class="form-control" id="asal_usul" name="asal_usul" value="{{ old('asal_usul') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lokasi.peralatan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
