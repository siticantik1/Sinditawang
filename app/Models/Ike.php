<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ike extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'ikes'; // Nama tabel disesuaikan menjadi 'ikes'

    /**
     * The attributes that are mass assignable.
     * Ini WAJIB ada agar Ike::create() berhasil.
     */
    protected $fillable = [
        'nama_barang',
        'rke_id', // Foreign key ke tabel rkes
        'kode_barang',
        'merk_model',
        'bahan',
        'tahun_pembelian',
        'jumlah',
        'harga_perolehan',
        'kondisi',
        'keterangan',
    ];

    /**
     * Relasi ke model Rke.
     * Fungsi ini memberitahu Laravel bahwa setiap 'Ike' pasti "milik" satu 'Rke'.
     */
    public function rke()
    {
        return $this->belongsTo(Rke::class);
    }
}
