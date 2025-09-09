<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rkc extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini secara eksplisit.
     * @var string
     */
    protected $table = 'rkcs';

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
     * Mendefinisikan relasi one-to-many ke model Ikc.
     * Satu ruangan (Rkc) dapat memiliki banyak inventaris (Ikc).
     */
    public function ikcs()
    {
        return $this->hasMany(Ikc::class, 'rkc_id', 'id');
    }
}
