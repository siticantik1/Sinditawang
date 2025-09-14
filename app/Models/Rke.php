<?php

namespace App\Models; // Pastikan namespace-nya App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// NAMA KELAS HARUS 'Rke' (dengan R besar)
class Rke extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini secara eksplisit.
     * @var string
     */
    protected $table = 'rkes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kode_ruangan',
        'lokasi',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Ike.
     */
    public function ikes()
    {
        return $this->hasMany(Ike::class, 'rke_id', 'id');
    }
}

