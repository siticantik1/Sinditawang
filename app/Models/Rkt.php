<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rkt extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini secara eksplisit.
     * @var string
     */
    protected $table = 'rkts';

    /**
     * The attributes that are mass assignable.
     * Ini adalah daftar kolom yang boleh diisi melalui form.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kode_ruangan',
        'lokasi',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Ikt.
     * Satu ruangan (Rkt) dapat memiliki banyak inventaris (Ikt).
     */
    public function ikts()
    {
        return $this->hasMany(Ikt::class, 'rkt_id', 'id');
    }
}
