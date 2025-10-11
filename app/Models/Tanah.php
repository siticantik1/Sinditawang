<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'tanahs';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Pastikan semua kolom dari form Anda terdaftar di sini.
     */
    protected $fillable = [
        'lokasi',
        'nama_barang',
        'kode_barang',
        'register', // Disesuaikan dengan migrasi
        'luas',
        'tahun_pengadaan',
        'alamat',
        'status_hak', // Disesuaikan dengan migrasi
        'tanggal_sertifikat',
        'nomor_sertifikat',
        'penggunaan',
        'asal_usul',
        'harga',
        'keterangan',
    ];

    /**
     * Tipe data casting untuk atribut model.
     */
    protected $casts = [
        'luas' => 'integer',
        'tahun_pengadaan' => 'integer',
        'harga' => 'float',
        'tanggal_sertifikat' => 'date',
    ];
}

