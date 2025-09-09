<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikc extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'ikcs'; // Sesuaikan jika nama tabelnya berbeda

    /**
     * The attributes that are mass assignable.
     * Ini WAJIB ada agar Ikc::create() berhasil.
     */
    protected $fillable = [
        'nama_barang',
        'rkc_id', // Foreign key ke tabel rkcs
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
     * Relasi ke model Rkc.
     * Fungsi ini memberitahu Laravel bahwa setiap 'Ikc' pasti "milik" satu 'Rkc'.
     */
    public function rkc()
    {
        return $this->belongsTo(Rkc::class);
    }
}
