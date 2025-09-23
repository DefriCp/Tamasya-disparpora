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
        Schema::create('destinasi_wisatas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug');
            $table->json('jenis')->change();
            $table->foreignId('kecamatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('desa_id')->constrained()->cascadeOnDelete();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('potensi_unggulan');
            $table->string('produk_unggulan');
            $table->string('daya_tarik_wisata');
            $table->string('amenitas');
            $table->string('status_pemilik');
            $table->string('luas');
            $table->string('aktivitas');
            $table->string('kondisi_akses');
            $table->string('jarak_tempuh');
            $table->string('nama_pengelola');
            $table->string('nomor_hp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi_wisatas');
    }
};
