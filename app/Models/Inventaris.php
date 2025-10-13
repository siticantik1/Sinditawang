<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventaris';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lokasi',
        'room_id',
        'nama_barang',
        'merk_model',
        'bahan',
        'tahun_pembelian',
        'kode_barang',
        'jumlah',
        'harga_perolehan',
        'kondisi',
        'keterangan',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Room.
     * Setiap barang inventaris milik satu ruangan.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

