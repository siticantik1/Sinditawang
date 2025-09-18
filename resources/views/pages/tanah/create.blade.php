@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Tambah Data Tanah</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('tanah.store') }}" method="POST">
            @csrf
            
            {{-- Letakkan semua field input form di sini --}}
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang / Jenis Barang</label>
                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- ... dan field lainnya --}}

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('tawang.tanah.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection