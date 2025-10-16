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
            $table->string('lokasi');
            $table->string('jenis_barang');
            $table->string('no_id_pemda')->nullable();
            $table->string('konstruksi');
            $table->integer('panjang')->nullable(); // KM
            $table->integer('lebar')->nullable(); // M
            $table->integer('luas')->nullable(); // M2
            $table->string('letak_lokasi');
            $table->date('dokumen_tanggal')->nullable();
            $table->string('dokumen_nomor')->nullable();
            $table->string('status_tanah');
            $table->string('kode_tanah')->nullable();
            $table->string('asal_usul');
            $table->decimal('harga', 15, 2);
            $table->enum('kondisi', ['B', 'KB', 'RB']); // Baik, Kurang Baik, Rusak Berat
            $table->text('keterangan')->nullable();
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

