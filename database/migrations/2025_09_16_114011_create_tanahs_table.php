<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._create_tanahs_table.php

    public function up(): void
    {
    Schema::create('tanahs', function (Blueprint $table) {
        $table->id();
        $table->string('kecamatan'); // <-- TAMBAHKAN KOLOM INI
        $table->string('nama_barang');
        $table->string('kode_barang');
        $table->string('register');
        $table->integer('luas');
        $table->year('tahun_pengadaan');
        $table->text('alamat');
        $table->string('status_hak');
        $table->date('tanggal_sertifikat')->nullable();
        $table->string('nomor_sertifikat')->nullable();
        $table->string('penggunaan');
        $table->string('asal_usul');
        $table->decimal('harga', 15, 2);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('tanahs');
    }
};
