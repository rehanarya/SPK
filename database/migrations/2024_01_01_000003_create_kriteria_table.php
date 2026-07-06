<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->bigIncrements('id_kriteria');
            $table->string('kode_kriteria', 5)->unique();
            $table->string('nama_kriteria', 100);
            $table->unsignedTinyInteger('bobot_mentah');
            $table->decimal('bobot_normalisasi', 10, 6);
            $table->enum('tipe', ['benefit', 'cost']);
            $table->string('satuan', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
