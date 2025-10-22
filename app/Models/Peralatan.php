<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'peralatans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lokasi',
        'kode_barang',
        'nama_barang',
        'nibr',
        'nomor_register',
        'spesifikasi_barang',
        'merk_tipe',
        'Lok', // Nama kolom kedua untuk lokasi (dengan 'L' kapital)
        'spesifikasi_lainnya',
        'nomor_polisi',
        'nomor_rangka',
        'nomor_bpkb',
        'jumlah',
        'satuan',
        'harga_satuan',
        'nilai_perolehan',
        'cara_perolehan',
        'tanggal_perolehan',
        'status_penggunaan',
        'keterangan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_perolehan' => 'date',
        'harga_satuan' => 'decimal:2',
        'nilai_perolehan' => 'decimal:2',
    ];
}