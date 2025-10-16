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
            $table->string('lokasi');
            $table->string('jenis_barang');
            $table->string('no_id_pemda')->nullable();
            // REVISI: Mengubah string menjadi enum
            $table->enum('kondisi_bangunan', ['Baik', 'Kurang Baik', 'Rusak Berat']);
            $table->enum('bertingkat', ['Bertingkat', 'Tidak']);
            $table->enum('beton', ['Beton', 'Tidak']);
            $table->integer('luas_lantai');
            $table->string('letak_lokasi');
            $table->date('dokumen_tanggal')->nullable();
            $table->string('dokumen_nomor')->nullable();
            $table->integer('luas');
            $table->string('status_tanah');
            $table->string('kode_tanah')->nullable();
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
        Schema::dropIfExists('gedungs');
    }
};

