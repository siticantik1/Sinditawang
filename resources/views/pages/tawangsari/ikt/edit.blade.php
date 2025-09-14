@extends('layouts.app')

@section('title', 'Edit Barang Inventaris (Kel. Tawangsari)')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Barang Inventaris (Kel. Tawangsari)</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Menggunakan variabel $ikt yang dikirim dari IktController --}}
            <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Data Barang: {{ $ikt->nama_barang }}</h6>
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

            {{-- Form diarahkan ke route 'tawangsari.ikt.update' --}}
            <form action="{{ route('tawangsari.ikt.update', $ikt->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Metode PUT untuk update --}}

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang / Jenis Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $ikt->nama_barang) }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_barang">No. Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $ikt->kode_barang) }}" required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rkt_id">Lokasi Ruangan <span class="text-danger">*</span></label>
                            {{-- Menggunakan variabel $rkts untuk daftar ruangan Tawangsari --}}
                            <select class="form-control @error('rkt_id') is-invalid @enderror" id="rkt_id" name="rkt_id" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rkts as $rkt)
                                    <option value="{{ $rkt->id }}" {{ old('rkt_id', $ikt->rkt_id) == $rkt->id ? 'selected' : '' }}>{{ $rkt->name }}</option>
                                @endforeach
                            </select>
                            @error('rkt_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="merk_model">Merk / Model</label>
                            <input type="text" class="form-control @error('merk_model') is-invalid @enderror" id="merk_model" name="merk_model" value="{{ old('merk_model', $ikt->merk_model) }}">
                        </div>

                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control @error('bahan') is-invalid @enderror" id="bahan" name="bahan" value="{{ old('bahan', $ikt->bahan) }}">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_pembelian') is-invalid @enderror" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian', $ikt->tahun_pembelian) }}" placeholder="Contoh: 2023" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $ikt->jumlah) }}" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="harga_perolehan">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga_perolehan') is-invalid @enderror" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan', $ikt->harga_perolehan) }}" placeholder="Contoh: 1500000" required>
                        </div>

                        <div class="form-group">
                            <label for="kondisi">Keadaan Barang <span class="text-danger">*</span></label>
                            <select class="form-control @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="B" {{ old('kondisi', $ikt->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi', $ikt->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi', $ikt->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $ikt->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    {{-- Tombol Batal diarahkan ke 'tawangsari.ikt.index' dengan membawa ID ruangan --}}
                    <a href="{{ route('tawangsari.ikt.index', ['rkt_id' => $ikt->rkt_id]) }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
