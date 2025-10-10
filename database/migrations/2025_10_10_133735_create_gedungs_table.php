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
        Schema::create('gedungs', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_barang');
            $table->string('kode_barang')->nullable();
            $table->string('nomor_register')->nullable();
            $table->string('kondisi')->nullable(); // B, KB, RB
            $table->string('bertingkat')->nullable(); // Bertingkat, Tidak
            $table->string('beton')->nullable(); // Beton, Tidak
            $table->decimal('luas_lantai', 10, 2)->nullable();
            $table->text('alamat')->nullable();
            $table->date('dokumen_tanggal')->nullable();
            $table->string('dokumen_nomor')->nullable();
            $table->decimal('luas_tanah', 10, 2)->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('kode_tanah')->nullable();
            $table->string('asal_usul')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('lokasi'); // Kolom untuk memfilter berdasarkan lokasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedungs');
    }
};
