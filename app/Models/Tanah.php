<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tanahs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lokasi',
        'kode_barang',
        'nama_barang',
        'nibar',
        'nomor_register',
        'spesifikasi_barang',
        'spesifikasi_lainnya',
        'jumlah',
        'satuan',
        'Lok', // Nama kolom kedua untuk lokasi (dengan 'L' kapital)
        'titik_koordinat',
        'bukti_nama',
        'bukti_nomor',
        'bukti_tanggal',
        'nama_kepemilikan_dokumen',
        'nilai_perolehan',
        'harga_satuan',
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
        'bukti_tanggal' => 'date',
        'tanggal_perolehan' => 'date',
        'nilai_perolehan' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
    ];
}