<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rkk extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini secara eksplisit.
     * @var string
     */
    protected $table = 'rkks';

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
     * Mendefinisikan relasi one-to-many ke model Ikk.
     * Satu ruangan (Rkk) dapat memiliki banyak inventaris (Ikk).
     */
    public function ikks()
    {
        return $this->hasMany(Ikk::class, 'rkk_id', 'id');
    }
}
