@extends('layouts.app')

@section('title', 'Edit Barang Inventaris (Kel. Cikalang)')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Barang Inventaris (Kel. Cikalang)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Menggunakan variabel $ikc yang dikirim dari IkcController --}}
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Barang: {{ $ikc->nama_barang }}</h6>
        </div>
        <div class="card-body">
            {{-- Form diarahkan ke route 'cikalang.ikc.update' --}}
            <form action="{{ route('cikalang.ikc.update', $ikc->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Metode PUT untuk update --}}

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang / Jenis Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $ikc->nama_barang) }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_barang">No. Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $ikc->kode_barang) }}" required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rkc_id">Lokasi Ruangan <span class="text-danger">*</span></label>
                            {{-- Menggunakan variabel $rkcs untuk daftar ruangan Cikalang --}}
                            <select class="form-control @error('rkc_id') is-invalid @enderror" id="rkc_id" name="rkc_id" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rkcs as $rkc)
                                    <option value="{{ $rkc->id }}" {{ old('rkc_id', $ikc->rkc_id) == $rkc->id ? 'selected' : '' }}>{{ $rkc->name }}</option>
                                @endforeach
                            </select>
                            @error('rkc_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="merk_model">Merk / Model</label>
                            <input type="text" class="form-control @error('merk_model') is-invalid @enderror" id="merk_model" name="merk_model" value="{{ old('merk_model', $ikc->merk_model) }}">
                        </div>

                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control @error('bahan') is-invalid @enderror" id="bahan" name="bahan" value="{{ old('bahan', $ikc->bahan) }}">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_pembelian') is-invalid @enderror" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian', $ikc->tahun_pembelian) }}" placeholder="Contoh: 2023" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $ikc->jumlah) }}" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_perolehan">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan', $ikc->harga_perolehan) }}" placeholder="Contoh: 1500000" required>
                        </div>

                        <div class="form-group">
                            <label for="kondisi">Keadaan Barang <span class="text-danger">*</span></label>
                            <select class="form-control @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="B" {{ old('kondisi', $ikc->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi', $ikc->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi', $ikc->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $ikc->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    {{-- Tombol Batal diarahkan ke 'cikalang.ikc.index' dengan membawa ID ruangan --}}
                    <a href="{{ route('cikalang.ikc.index', ['rkc_id' => $ikc->rkc_id]) }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
