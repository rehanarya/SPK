<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi', function (Blueprint $table) {
            $table->bigIncrements('id_konfigurasi');
            $table->string('kunci', 50)->unique();
            $table->string('nilai', 100);
            $table->string('deskripsi', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi');
    }
};
