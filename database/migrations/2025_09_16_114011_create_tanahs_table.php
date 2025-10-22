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
        // Sebaiknya nama tabel lebih spesifik, misal: 'inventaris_tanah'
        Schema::create('tanahs', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi')->nullable();
            $table->string('kode_barang'); // (5) Kode Barang
            $table->string('nama_barang'); // (6) Nama Barang
            $table->string('nibar')->nullable(); // (7) NIBAR
            $table->string('nomor_register')->nullable(); // (8) Nomor Register
            $table->text('spesifikasi_barang')->nullable(); // (9) Spesifikasi Nama Barang
            $table->text('spesifikasi_lainnya')->nullable(); // (10) Spesifikasi Lainnya
            $table->unsignedInteger('jumlah'); // (11) Jumlah (misal: luas tanah)
            $table->string('satuan'); // (12) Satuan (misal: "M2")
            $table->text('Lok'); // (13) Lokasi / Alamat
            $table->string('titik_koordinat')->nullable(); // (14) Titik Koordinat

            // Grouping untuk Bukti Kepemilikan
            $table->string('bukti_nama')->nullable(); // (15) Nama
            $table->string('bukti_nomor')->nullable(); // (16) Nomor
            $table->date('bukti_tanggal')->nullable(); // (17) Tanggal

            $table->string('nama_kepemilikan_dokumen')->nullable(); // (18) Nama Kepemilikan dalam Dokumen
            $table->decimal('nilai_perolehan', 15, 2); // (19) Nilai Perolehan (Rp)
            $table->decimal('harga_satuan', 15, 2)->nullable(); // (20) Harga Satuan (Rp)
            $table->string('cara_perolehan'); // (21) Cara Perolehan
            $table->date('tanggal_perolehan'); // (22) Tanggal Perolehan
            $table->string('status_penggunaan'); // (23) Status Penggunaan
            $table->text('keterangan')->nullable(); // (24) Keterangan

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