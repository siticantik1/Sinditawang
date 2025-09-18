<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * Laravel sebenarnya otomatis mendeteksi nama tabel 'tanahs' (bentuk jamak dari 'Tanah'),
     * tapi menuliskannya secara eksplisit adalah praktik yang baik.
     */
    protected $table = 'tanahs';

    /**
     * Mass Assignment Protection.
     * 'guarded' adalah kebalikan dari 'fillable'.
     * Dengan mengisi ['id'], kita memberitahu Laravel bahwa SEMUA kolom BOLEH diisi
     * secara massal (mass assignment) KECUALI kolom 'id'.
     * Ini cara yang praktis dan aman untuk model ini.
     */
    protected $guarded = ['id'];

    /**
     * Opsional: Tipe data casting.
     * Ini untuk memastikan kolom tertentu selalu dibaca sebagai tipe data yang benar.
     * Contoh: 'harga' akan selalu menjadi angka desimal (float),
     * dan 'tanggal_sertifikat' akan selalu menjadi objek tanggal (Carbon).
     */
    protected $casts = [
        'luas' => 'integer',
        'tahun_pengadaan' => 'integer',
        'harga' => 'float',
        'tanggal_sertifikat' => 'date',
    ];
}