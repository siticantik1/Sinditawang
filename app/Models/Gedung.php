<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'gedungs';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lokasi',
        'no_id_pemda',
        'nomor_register',
        'kondisi_bangunan',
        'bertingkat',
        'beton',
        'luas_lantai',
        'letak_lokasi',
        'dokumen_tanggal',
        'dokumen_nomor',
        'luas',
        'status_tanah',
        'kode_tanah',
        'asal_usul',
        'harga',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dokumen_tanggal' => 'date',
        'harga' => 'decimal:2',
    ];
}

