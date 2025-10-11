@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Jalan, Irigasi & Jaringan (KIB D) - {{ ucfirst($lokasi) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.jalan.update', ['lokasi' => $lokasi, 'jalan' => $jalan->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang / Nama Barang</label>
                        <input type="text" class="form-control" name="jenis_barang" value="{{ old('jenis_barang', $jalan->jenis_barang) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" class="form-control" name="kode_barang" value="{{ old('kode_barang', $jalan->kode_barang) }}">
                    </div>
                    <div class="form-group">
                        <label for="nomor_register">Nomor Register</label>
                        <input type="text" class="form-control" name="nomor_register" value="{{ old('nomor_register', $jalan->nomor_register) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="konstruksi">Konstruksi</label>
                        <input type="text" class="form-control" name="konstruksi" value="{{ old('konstruksi', $jalan->konstruksi) }}" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="panjang">Panjang (KM)</label>
                            <input type="number" class="form-control" name="panjang" value="{{ old('panjang', $jalan->panjang) }}" step="any">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lebar">Lebar (M)</label>
                            <input type="number" class="form-control" name="lebar" value="{{ old('lebar', $jalan->lebar) }}" step="any">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="luas">Luas (M2)</label>
                            <input type="number" class="form-control" name="luas" value="{{ old('luas', $jalan->luas) }}" step="any">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="letak_lokasi">Letak/Lokasi</label>
                        <textarea class="form-control" name="letak_lokasi" rows="3" required>{{ old('letak_lokasi', $jalan->letak_lokasi) }}</textarea>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="card card-body border-left-info mb-3">
                        <h6 class="font-weight-bold">Dokumen</h6>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="dokumen_tanggal" value="{{ old('dokumen_tanggal', $jalan->dokumen_tanggal) }}">
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_nomor">Nomor</label>
                                <input type="text" class="form-control" name="dokumen_nomor" value="{{ old('dokumen_nomor', $jalan->dokumen_nomor) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_tanah">Status Tanah</label>
                        <input type="text" class="form-control" name="status_tanah" value="{{ old('status_tanah', $jalan->status_tanah) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_tanah">Nomor Kode Tanah</label>
                        <input type="text" class="form-control" name="kode_tanah" value="{{ old('kode_tanah', $jalan->kode_tanah) }}">
                    </div>
                    <div class="form-group">
                        <label for="asal_usul">Asal-Usul</label>
                        <input type="text" class="form-control" name="asal_usul" value="{{ old('asal_usul', $jalan->asal_usul) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" value="{{ old('harga', $jalan->harga) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="B" {{ old('kondisi', $jalan->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                            <option value="KB" {{ old('kondisi', $jalan->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                            <option value="RB" {{ old('kondisi', $jalan->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2">{{ old('keterangan', $jalan->keterangan) }}</textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.jalan.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

