@extends('layouts.app')

@section('title', 'Edit Data Gedung & Bangunan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Data Gedung & Bangunan - {{ ucfirst($lokasi) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('lokasi.gedung.update', ['lokasi' => $lokasi, 'gedung' => $gedung->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_barang">Jenis Barang / Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jenis_barang') is-invalid @enderror" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang', $gedung->jenis_barang) }}" required>
                            @error('jenis_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $gedung->kode_barang) }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_register">Nomor Register</label>
                            <input type="text" class="form-control" id="nomor_register" name="nomor_register" value="{{ old('nomor_register', $gedung->nomor_register) }}">
                        </div>
                         <div class="form-group">
                            <label for="kondisi">Kondisi Bangunan (B/KB/RB)</label>
                            <select class="form-control" id="kondisi" name="kondisi">
                                <option value="B" {{ old('kondisi', $gedung->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi', $gedung->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi', $gedung->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="konstruksi_bertingkat">Konstruksi Bertingkat</label>
                            <select class="form-control" id="konstruksi_bertingkat" name="konstruksi_bertingkat">
                                <option value="Ya" {{ old('konstruksi_bertingkat', $gedung->konstruksi_bertingkat) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('konstruksi_bertingkat', $gedung->konstruksi_bertingkat) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="konstruksi_beton">Konstruksi Beton</label>
                             <select class="form-control" id="konstruksi_beton" name="konstruksi_beton">
                                <option value="Ya" {{ old('konstruksi_beton', $gedung->konstruksi_beton) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                <option value="Tidak" {{ old('konstruksi_beton', $gedung->konstruksi_beton) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="luas_lantai">Luas Lantai (M2)</label>
                            <input type="number" step="0.01" class="form-control" id="luas_lantai" name="luas_lantai" value="{{ old('luas_lantai', $gedung->luas_lantai) }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Letak / Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $gedung->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dokumen_tanggal">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="dokumen_tanggal" name="dokumen_tanggal" value="{{ old('dokumen_tanggal', $gedung->dokumen_tanggal) }}">
                        </div>
                        <div class="form-group">
                            <label for="dokumen_nomor">Nomor Dokumen</label>
                            <input type="text" class="form-control" id="dokumen_nomor" name="dokumen_nomor" value="{{ old('dokumen_nomor', $gedung->dokumen_nomor) }}">
                        </div>
                        <div class="form-group">
                            <label for="luas_tanah">Luas Tanah (M2)</label>
                            <input type="number" step="0.01" class="form-control" id="luas_tanah" name="luas_tanah" value="{{ old('luas_tanah', $gedung->luas_tanah) }}">
                        </div>
                        <div class="form-group">
                            <label for="status_tanah">Status Tanah</label>
                            <input type="text" class="form-control" id="status_tanah" name="status_tanah" value="{{ old('status_tanah', $gedung->status_tanah) }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_kode_tanah">Nomor Kode Tanah</label>
                            <input type="text" class="form-control" id="nomor_kode_tanah" name="nomor_kode_tanah" value="{{ old('nomor_kode_tanah', $gedung->nomor_kode_tanah) }}">
                        </div>
                        <div class="form-group">
                            <label for="asal_usul">Asal Usul</label>
                            <input type="text" class="form-control" id="asal_usul" name="asal_usul" value="{{ old('asal_usul', $gedung->asal_usul) }}">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $gedung->harga) }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $gedung->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('lokasi.gedung.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
