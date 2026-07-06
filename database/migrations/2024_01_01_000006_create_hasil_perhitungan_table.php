<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_perhitungan', function (Blueprint $table) {
            $table->bigIncrements('id_hasil');
            $table->unsignedBigInteger('id_pengajuan')->unique();
            $table->decimal('vektor_S', 20, 8);
            $table->decimal('vektor_V', 20, 8);
            $table->unsignedSmallInteger('ranking')->nullable();
            $table->enum('status', ['diterima', 'ditolak']);
            $table->timestamp('created_at')->nullable();

            $table->foreign('id_pengajuan')
                  ->references('id_pengajuan')->on('pengajuan')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_perhitungan');
    }
};
