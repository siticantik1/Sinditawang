@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Gedung & Bangunan (KIB C) - {{ ucfirst($lokasi) }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lokasi.gedung.update', ['lokasi' => $lokasi, 'gedung' => $gedung->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang / Nama Barang</label>
                        <input type="text" class="form-control" name="jenis_barang" value="{{ old('jenis_barang', $gedung->jenis_barang) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_id_pemda">No Id Pemda</label>
                        <input type="text" class="form-control" name="no_id_pemda" value="{{ old('no_id_pemda', $gedung->no_id_pemda) }}" required>
                    </div>
                    
                    

                    <div class="card card-body border-left-warning mb-3">
                        <h6 class="font-weight-bold">Konstruksi Bangunan</h6>
                         <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <label for="bertingkat">Bertingkat / Tidak</label>
                                <select name="bertingkat" class="form-control" required>
                                    <option value="Bertingkat" {{ old('bertingkat', $gedung->bertingkat) == 'Bertingkat' ? 'selected' : '' }}>Bertingkat</option>
                                    <option value="Tidak" {{ old('bertingkat', $gedung->bertingkat) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <label for="beton">Beton / Tidak</label>
                                <select name="beton" class="form-control" required>
                                    <option value="Beton" {{ old('beton', $gedung->beton) == 'Beton' ? 'selected' : '' }}>Beton</option>
                                    <option value="Tidak" {{ old('beton', $gedung->beton) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="luas_lantai">Luas Lantai (M2)</label>
                        <input type="number" class="form-control" name="luas_lantai" value="{{ old('luas_lantai', $gedung->luas_lantai) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="letak_lokasi">Letak / Lokasi Alamat</label>
                        <textarea name="letak_lokasi" class="form-control" rows="3" required>{{ old('letak_lokasi', $gedung->letak_lokasi) }}</textarea>
                    </div>

                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <div class="card card-body border-left-info mb-3">
                        <h6 class="font-weight-bold">Dokumen Gedung</h6>
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="dokumen_tanggal" value="{{ old('dokumen_tanggal', $gedung->dokumen_tanggal) }}">
                            </div>
                            <div class="form-group col-md-6 mb-0">
                                <label for="dokumen_nomor">Nomor</label>
                                <input type="text" class="form-control" name="dokumen_nomor" value="{{ old('dokumen_nomor', $gedung->dokumen_nomor) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="luas">Luas Tanah (M2)</label>
                        <input type="number" class="form-control" name="luas" value="{{ old('luas', $gedung->luas) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status_tanah">Status Tanah</label>
                        <input type="text" class="form-control" name="status_tanah" value="{{ old('status_tanah', $gedung->status_tanah) }}" required>
                    </div>

                     <div class="form-group">
                        <label for="kode_tanah">Nomor Kode Tanah</label>
                        <input type="text" class="form-control" name="kode_tanah" value="{{ old('kode_tanah', $gedung->kode_tanah) }}">
                    </div>

                    <div class="form-group">
                        <label for="asal_usul">Asal-usul</label>
                        <input type="text" class="form-control" name="asal_usul" value="{{ old('asal_usul', $gedung->asal_usul) }}" required>
                    </div>

                     <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" value="{{ old('harga', $gedung->harga) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kondisi_bangunan">Kondisi Bangunan</label>
                        <select name="kondisi_bangunan" class="form-control" required>
                            <option value="Baik" {{ old('kondisi_bangunan', $gedung->kondisi_bangunan) == 'Baik' ? 'selected' : '' }}>Baik (B)</option>
                            <option value="Kurang Baik" {{ old('kondisi_bangunan', $gedung->kondisi_bangunan) == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                            <option value="Rusak Berat" {{ old('kondisi_bangunan', $gedung->kondisi_bangunan) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="2">{{ old('keterangan', $gedung->keterangan) }}</textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('lokasi.gedung.index', ['lokasi' => $lokasi]) }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

