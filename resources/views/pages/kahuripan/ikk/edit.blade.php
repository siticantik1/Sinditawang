@extends('layouts.app')

@section('title', 'Edit Barang Inventaris (Kel. Kahuripan)')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Barang Inventaris (Kel. Kahuripan)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Menggunakan variabel $ikk yang dikirim dari IkkController --}}
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Barang: {{ $ikk->nama_barang }}</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form diarahkan ke route 'kahuripan.ikk.update' --}}
            <form action="{{ route('kahuripan.ikk.update', $ikk->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Metode PUT untuk update --}}

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang / Jenis Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $ikk->nama_barang) }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_barang">No. Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $ikk->kode_barang) }}" required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rkk_id">Lokasi Ruangan <span class="text-danger">*</span></label>
                            {{-- Menggunakan variabel $rkks untuk daftar ruangan Kahuripan --}}
                            <select class="form-control @error('rkk_id') is-invalid @enderror" id="rkk_id" name="rkk_id" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rkks as $rkk)
                                    <option value="{{ $rkk->id }}" {{ old('rkk_id', $ikk->rkk_id) == $rkk->id ? 'selected' : '' }}>{{ $rkk->name }}</option>
                                @endforeach
                            </select>
                            @error('rkk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="merk_model">Merk / Model</label>
                            <input type="text" class="form-control @error('merk_model') is-invalid @enderror" id="merk_model" name="merk_model" value="{{ old('merk_model', $ikk->merk_model) }}">
                        </div>

                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control @error('bahan') is-invalid @enderror" id="bahan" name="bahan" value="{{ old('bahan', $ikk->bahan) }}">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_pembelian') is-invalid @enderror" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian', $ikk->tahun_pembelian) }}" placeholder="Contoh: 2023" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $ikk->jumlah) }}" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_perolehan">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan', $ikk->harga_perolehan) }}" placeholder="Contoh: 1500000" required>
                        </div>

                        <div class="form-group">
                            <label for="kondisi">Keadaan Barang <span class="text-danger">*</span></label>
                            <select class="form-control @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="B" {{ old('kondisi', $ikk->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi', $ikk->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi', $ikk->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $ikk->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    {{-- Tombol Batal diarahkan ke 'kahuripan.ikk.index' dengan membawa ID ruangan --}}
                    <a href="{{ route('kahuripan.ikk.index', ['rkk_id' => $ikk->rkk_id]) }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
