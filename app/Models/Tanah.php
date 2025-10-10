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
     *
     * Menggunakan `$fillable` adalah praktik yang lebih aman daripada `$guarded`
     * karena secara eksplisit hanya mengizinkan kolom-kolom yang terdaftar
     * untuk diisi melalui metode `create()` atau `update()`.
     * Pastikan semua kolom form Anda terdaftar di sini.
     */
    protected $fillable = [
        'lokasi', // Kolom baru untuk menangani data dinamis per lokasi
        'nama_barang',
        'kode_barang',
        'nup',
        'luas',
        'tahun_pengadaan',
        'alamat',
        'hak',
        'tanggal_sertifikat',
        'nomor_sertifikat',
        'penggunaan',
        'asal_usul',
        'harga',
        'keterangan',
    ];

    /**
     * Tipe data casting untuk atribut model.
     * Ini memastikan data yang diambil dari database memiliki tipe yang benar.
     */
    protected $casts = [
        'luas' => 'integer',
        'tahun_pengadaan' => 'integer',
        'harga' => 'float',
        'tanggal_sertifikat' => 'date',
    ];
}
