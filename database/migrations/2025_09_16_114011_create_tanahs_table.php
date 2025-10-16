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
        Schema::create('tanahs', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi')->nullable(); // Dibuat nullable sesuai permintaan
            $table->string('nama_barang');
            $table->string('no_id_pemda')->nullable();
            $table->integer('luas');
            $table->year('tahun_pengadaan');
            $table->text('alamat');
            $table->string('status_hak'); // Dibuat wajib
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->string('penggunaan'); // Dibuat wajib
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
        Schema::dropIfExists('tanahs');
    }
};

