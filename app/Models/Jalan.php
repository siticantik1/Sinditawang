<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'jalans';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'lokasi',
        'jenis_barang',
        'kode_barang',
        'nomor_register',
        'konstruksi',
        'panjang',
        'lebar',
        'luas',
        'letak_lokasi',
        'dokumen_tanggal',
        'dokumen_nomor',
        'status_tanah',
        'kode_tanah',
        'asal_usul',
        'harga',
        'kondisi',
        'keterangan',
    ];

    /**
     * Tipe data casting untuk atribut model.
     */
    protected $casts = [
        'dokumen_tanggal' => 'date',
        'harga' => 'float',
        'panjang' => 'integer',
        'lebar' => 'integer',
        'luas' => 'integer',
    ];
}

