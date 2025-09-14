@extends('layouts.app')

@section('title', 'Edit Data Ruangan Empang')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- Judul disesuaikan untuk Empang --}}
        <h1 class="h3 mb-0 text-gray-800">Edit Data Ruangan (Kel. Empang)</h1>
        
        {{-- Tombol kembali diarahkan ke halaman index RKE --}}
        <a href="{{ route('empang.rke.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    {{-- Form --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Ruangan</h6>
                </div>
                <div class="card-body">
                    {{-- Menampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form diarahkan ke route 'empang.rke.update' --}}
                    <form action="{{ route('empang.rke.update', $rke->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Ruangan</label>
                            {{-- Mengisi value dengan data lama dari variabel $rke --}}
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama ruangan..." value="{{ old('name', $rke->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kode_ruangan">Kode Ruangan</label>
                            {{-- Mengisi value dengan data lama dari variabel $rke --}}
                            <input type="text" class="form-control @error('kode_ruangan') is-invalid @enderror" id="kode_ruangan" name="kode_ruangan" placeholder="Masukkan kode ruangan..." value="{{ old('kode_ruangan', $rke->kode_ruangan) }}" required>
                            @error('kode_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Update Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
