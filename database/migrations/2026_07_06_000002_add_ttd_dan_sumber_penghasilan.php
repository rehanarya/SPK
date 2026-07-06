<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Revisi pasca-sidang tahap 2: tanda tangan digital + penanda sumber penghasilan.
 *
 * - pengajuan.ttd_anggota / ttd_petugas : path file PNG di storage/app/public/ttd/
 *   (Anggota & Petugas menandatangani saat pengajuan/analisis).
 * - hasil_perhitungan.ttd_manager + nama_manager : Manager menandatangani saat
 *   penetapan keputusan — diletakkan di hasil_perhitungan karena relasinya 1:1
 *   dengan pengajuan dan memuat status keputusan; log_keputusan hanya riwayat.
 * - pengajuan.sumber_penghasilan : penanda UI 'usaha'|'gaji' untuk nasabah
 *   pegawai — BUKAN kriteria dan tidak menyentuh model WP.
 *
 * Seluruh kolom NULLABLE demi 20 rekord historis.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('sumber_penghasilan', 10)->nullable()->after('tanggal_realisasi');
            $table->string('ttd_anggota', 255)->nullable()->after('sumber_penghasilan');
            $table->string('ttd_petugas', 255)->nullable()->after('ttd_anggota');
        });

        Schema::table('hasil_perhitungan', function (Blueprint $table) {
            $table->string('ttd_manager', 255)->nullable()->after('status');
            $table->string('nama_manager', 100)->nullable()->after('ttd_manager');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn(['sumber_penghasilan', 'ttd_anggota', 'ttd_petugas']);
        });

        Schema::table('hasil_perhitungan', function (Blueprint $table) {
            $table->dropColumn(['ttd_manager', 'nama_manager']);
        });
    }
};
