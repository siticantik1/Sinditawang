@extends('layouts.app')

@section('title', 'Data Ruangan Kelurahan Empang')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Ruangan Kelurahan Empang</h1>
        <div>
            
            {{-- Tombol untuk menambah ruangan baru di Empang --}}
            <a href="{{ route('empang.rke.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Tabel untuk menampilkan data ruangan --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Kode Ruangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rkes as $rke)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rke->name }}</td>
                                    <td>{{ $rke->kode_ruangan }}</td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('empang.rke.edit', $rke->id) }}" class="d-inline-block mr-2 btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            
                                            {{-- Tombol Hapus yang memicu modal konfirmasi --}}
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmationDelete-{{ $rke->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr> 
                                {{-- Meng-include modal konfirmasi hapus untuk setiap item --}}
                                @include('pages.empang.rke.confirmation-delete', ['rke' => $rke])
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <p class="pt-3">Tidak Ada Data</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
