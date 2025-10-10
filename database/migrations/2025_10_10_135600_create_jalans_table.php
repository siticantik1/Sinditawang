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
        Schema::create('jalans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_barang');
            $table->string('kode_barang')->nullable();
            $table->string('nomor_register')->nullable();
            $table->string('konstruksi')->nullable();
            $table->decimal('panjang', 10, 2)->nullable();
            $table->decimal('lebar', 10, 2)->nullable();
            $table->decimal('luas', 10, 2)->nullable();
            $table->text('letak_lokasi')->nullable();
            $table->date('dokumen_tanggal')->nullable();
            $table->string('dokumen_nomor')->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('kode_tanah')->nullable();
            $table->string('asal_usul')->nullable();
            $table->decimal('harga', 15, 2)->nullable();
            $table->string('kondisi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('lokasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalans');
    }
};
