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
        Schema::create('jumlah_kunjungan_wisatas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('januari')->default(0)->nullable();
            $table->bigInteger('februari')->default(0)->nullable();
            $table->bigInteger('maret')->default(0)->nullable();
            $table->bigInteger('april')->default(0)->nullable();
            $table->bigInteger('mei')->default(0)->nullable();
            $table->bigInteger('juni')->default(0)->nullable();
            $table->bigInteger('juli')->default(0)->nullable();
            $table->bigInteger('agustus')->default(0)->nullable();
            $table->bigInteger('september')->default(0)->nullable();
            $table->bigInteger('oktober')->default(0)->nullable();
            $table->bigInteger('november')->default(0)->nullable();
            $table->bigInteger('desember')->default(0)->nullable();

            $table->year('tahun');
            $table->foreignId('destinasi_wisata_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_kunjungan_wisatas');
    }
};
