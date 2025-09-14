<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ikk extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'ikks'; // Nama tabel disesuaikan menjadi 'ikks'

    /**
     * The attributes that are mass assignable.
     * Ini WAJIB ada agar Ikk::create() berhasil.
     */
    protected $fillable = [
        'nama_barang',
        'rkk_id', // Foreign key ke tabel rkks
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
     * Relasi ke model Rkk.
     * Fungsi ini memberitahu Laravel bahwa setiap 'Ikk' pasti "milik" satu 'Rkk'.
     */
    public function rkk()
    {
        return $this->belongsTo(Rkk::class);
    }
}
