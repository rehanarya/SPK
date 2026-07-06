<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->bigIncrements('id_pengajuan');
            $table->unsignedBigInteger('id_nasabah');
            $table->unsignedBigInteger('id_periode');
            $table->decimal('C1_laba_usaha', 15, 2);
            $table->decimal('C2_pendapatan_bersih', 15, 2);
            $table->unsignedTinyInteger('C3_nilai_agunan');
            $table->decimal('C4_besar_pembiayaan', 15, 2);
            $table->unsignedSmallInteger('C5_jangka_waktu');
            $table->date('tanggal_pengajuan');

            $table->foreign('id_nasabah')
                  ->references('id_nasabah')->on('nasabah')
                  ->restrictOnDelete();

            $table->foreign('id_periode')
                  ->references('id_periode')->on('periode')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
