<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bobot_history', function (Blueprint $table) {
            $table->bigIncrements('id_bobot');
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_kriteria');
            $table->unsignedTinyInteger('bobot_mentah');
            $table->decimal('bobot_normalisasi', 10, 6);
            $table->timestamp('created_at')->nullable();

            $table->foreign('id_periode')
                  ->references('id_periode')->on('periode')
                  ->restrictOnDelete();

            $table->foreign('id_kriteria')
                  ->references('id_kriteria')->on('kriteria')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_history');
    }
};
