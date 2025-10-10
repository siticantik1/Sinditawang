<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis_barang',
        'kode_barang',
        'nomor_register',
        'kondisi',
        'bertingkat',
        'beton',
        'luas_lantai',
        'alamat',
        'dokumen_tanggal',
        'dokumen_nomor',
        'luas_tanah',
        'status_tanah',
        'kode_tanah',
        'asal_usul',
        'harga',
        'keterangan',
        'lokasi',
    ];
}
