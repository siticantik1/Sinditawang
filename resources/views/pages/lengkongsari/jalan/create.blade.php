@extends('layouts.app')

@section('title', 'Tambah Data Jalan, Irigasi & Jaringan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data Jalan, Irigasi & Jaringan - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lokasi.jalan.store', ['lokasi' => $lokasi]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_barang">Jenis Barang / Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jenis_barang') is-invalid @enderror" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang') }}" required>
                            @error('jenis_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <label for="konstruksi">Konstruksi</label>
                            <input type="text" class="form-control" id="konstruksi" name="konstruksi" value="{{ old('konstruksi') }}">
                        </div>
                        <div class="form-group">
                            <label for="panjang">Panjang (KM)</label>
                            <input type="number" step="0.1" class="form-control" id="panjang" name="panjang" value="{{ old('panjang') }}">
                        </div>
                        <div class="form-group">
                            <label for="lebar">Lebar (M)</label>
                            <input type="number" step="0.1" class="form-control" id="lebar" name="lebar" value="{{ old('lebar') }}">
                        </div>
                        <div class="form-group">
                            <label for="luas">Luas (M2)</label>
                            <input type="number" step="0.1" class="form-control" id="luas" name="luas" value="{{ old('luas') }}">
                        </div>
                        <div class="form-group">
                            <label for="letak_lokasi">Letak / Lokasi</label>
                            <textarea class="form-control" id="letak_lokasi" name="letak_lokasi" rows="3">{{ old('letak_lokasi') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="dokumen_tanggal">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="dokumen_tanggal" name="dokumen_tanggal" value="{{ old('dokumen_tanggal') }}">
                        </div>
                        <div class="form-group">
                            <label for="dokumen_nomor">Nomor Dokumen</label>
                            <input type="text" class="form-control" id="dokumen_nomor" name="dokumen_nomor" value="{{ old('dokumen_nomor') }}">
                        </div>
                        <div class="form-group">
                            <label for="status_tanah">Status Tanah</label>
                            <input type="text" class="form-control" id="status_tanah" name="status_tanah" value="{{ old('status_tanah') }}">
                        </div>
                        <div class="form-group">
                            <label for="kode_tanah">Nomor Kode Tanah</label>
                            <input type="text" class="form-control" id="kode_tanah" name="kode_tanah" value="{{ old('kode_tanah') }}">
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
                            <label for="kondisi">Kondisi (B/KB/RB)</label>
                            <select class="form-control" id="kondisi" name="kondisi">
                                <option value="B" {{ old('kondisi') == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi') == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi') == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lokasi.jalan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
