<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peralatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'nomor_registrasi',
        'merk',
        'tipe',
        'ukuran',
        'bahan',
        'tahun_pembelian',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_polisi',
        'nomor_bpkb',
        'asal_usul',
        'harga',
        'keterangan',
        'lokasi', // Jangan lupa tambahkan 'lokasi'
    ];
}
