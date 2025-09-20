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
        Schema::create('headers', function (Blueprint $table) {
            $table->id();
            $table->string('skpd');
            $table->string('warna_pertama')->nullable();
            $table->string('warna_kedua')->nullable();
            $table->string('warna_text_header')->nullable();
            $table->string('warna_text_utama')->nullable();
            $table->string('singkatan_skpd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headers');
    }
};
