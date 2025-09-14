<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikt extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'ikts'; // Nama tabel disesuaikan menjadi 'ikts'

    /**
     * The attributes that are mass assignable.
     * Ini WAJIB ada agar Ikt::create() berhasil.
     */
    protected $fillable = [
        'nama_barang',
        'rkt_id', // Foreign key ke tabel rkts
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
     * Relasi ke model Rkt.
     * Fungsi ini memberitahu Laravel bahwa setiap 'Ikt' pasti "milik" satu 'Rkt'.
     */
    public function rkt()
    {
        return $this->belongsTo(Rkt::class);
    }
}
