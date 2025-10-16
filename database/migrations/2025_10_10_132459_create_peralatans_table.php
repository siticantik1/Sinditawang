<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peralatans', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi');
            $table->string('nama_barang');
            $table->string('no_id_pemda')->nullable();
            $table->string('merk_tipe')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('bahan')->nullable();
            $table->year('tahun_pembelian');
            $table->string('nomor_pabrik')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('nomor_polisi')->nullable();
            $table->string('nomor_bpkb')->nullable();
            $table->string('asal_usul');
            $table->decimal('harga', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peralatans');
    }
};
