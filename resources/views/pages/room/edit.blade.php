@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Data Ruangan (Kec. Tawang)</h1>
        <a href="{{ route('tawang.room.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    {{-- Form ----}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Ruangan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tawang.room.update', $room) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Ruangan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama ruangan..." value="{{ old('name', $room->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            {{-- ====================================================== --}}
                            {{-- PERBAIKAN: Menggunakan 'kode_ruangan' agar konsisten --}}
                            {{-- dengan Controller dan Model. --}}
                            {{-- ====================================================== --}}
                            <label for="kode_ruangan">Kode Ruangan</label>
                            <input type="text" class="form-control @error('kode_ruangan') is-invalid @enderror" id="kode_ruangan" name="kode_ruangan" placeholder="Masukkan kode ruangan..." value="{{ old('kode_ruangan', $room->kode_ruangan) }}">
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
@endsection

