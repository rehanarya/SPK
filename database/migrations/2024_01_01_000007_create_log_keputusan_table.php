<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_keputusan', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_hasil_perhitungan');
            $table->enum('keputusan_akhir', ['diterima', 'ditolak', 'diprioritaskan']);
            $table->text('catatan')->nullable();
            $table->timestamp('timestamp');

            $table->foreign('id_pengguna')
                  ->references('id_pengguna')->on('pengguna')
                  ->restrictOnDelete();

            $table->foreign('id_hasil_perhitungan')
                  ->references('id_hasil')->on('hasil_perhitungan')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_keputusan');
    }
};
