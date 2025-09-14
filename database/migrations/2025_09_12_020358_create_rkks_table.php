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
        Schema::create('rkks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kode_ruangan')->unique();
            $table->string('lokasi')->default('kahuripan'); // Default diubah ke 'kahuripan'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rkks');
    }
};
