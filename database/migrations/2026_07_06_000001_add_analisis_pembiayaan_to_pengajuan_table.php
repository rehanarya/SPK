<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Revisi pasca-sidang: replikasi formulir manual "ANALISIS PEMBIAYAAN"
 * KSPPS Berkah Sakinah Almughni.
 *
 * Seluruh kolom NULLABLE agar 20 rekord historis (N01–N20) yang tidak
 * memiliki rincian komponen tetap valid. Kolom kriteria lama
 * (C1_laba_usaha … C5_jangka_waktu) TIDAK diubah — C1 dan C2 kini diisi
 * dari hasil hitung server-side atas komponen di bawah ini.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // Seksi 1 — Perhitungan Laba Usaha (dalam 1 bulan)
            $table->decimal('penjualan_usaha', 15, 2)->nullable()->after('tanggal_pengajuan');
            $table->decimal('harga_pokok_jual', 15, 2)->nullable()->after('penjualan_usaha');
            $table->decimal('biaya_usaha', 15, 2)->nullable()->after('harga_pokok_jual');

            // Seksi 2 — Perhitungan Kemampuan Bayar
            $table->decimal('pendapatan_pasangan', 15, 2)->nullable()->after('biaya_usaha');
            $table->decimal('pendapatan_lainnya', 15, 2)->nullable()->after('pendapatan_pasangan');

            // Seksi 3 — Biaya dan Pengeluaran di Luar Usaha
            $table->decimal('kebutuhan_rumah_tangga', 15, 2)->nullable()->after('pendapatan_lainnya');
            $table->decimal('biaya_pendidikan', 15, 2)->nullable()->after('kebutuhan_rumah_tangga');
            $table->decimal('biaya_lainnya', 15, 2)->nullable()->after('biaya_pendidikan');

            // Seksi 5–6 — Rasio Angsuran & Plafon (plafon disimpan untuk jejak audit)
            $table->decimal('rasio_angsuran', 5, 2)->nullable()->after('biaya_lainnya');
            $table->decimal('plafon_pembiayaan', 15, 2)->nullable()->after('rasio_angsuran');

            // Usulan Pembiayaan
            $table->decimal('angsuran_pokok', 15, 2)->nullable()->after('plafon_pembiayaan');
            $table->decimal('bagi_hasil', 15, 2)->nullable()->after('angsuran_pokok');
            $table->decimal('simpanan', 15, 2)->nullable()->after('bagi_hasil');
            $table->decimal('jumlah_angsuran', 15, 2)->nullable()->after('simpanan');

            // Persetujuan
            $table->string('jenis_akad', 30)->nullable()->after('jumlah_angsuran');
            $table->date('tanggal_realisasi')->nullable()->after('jenis_akad');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn([
                'penjualan_usaha', 'harga_pokok_jual', 'biaya_usaha',
                'pendapatan_pasangan', 'pendapatan_lainnya',
                'kebutuhan_rumah_tangga', 'biaya_pendidikan', 'biaya_lainnya',
                'rasio_angsuran', 'plafon_pembiayaan',
                'angsuran_pokok', 'bagi_hasil', 'simpanan', 'jumlah_angsuran',
                'jenis_akad', 'tanggal_realisasi',
            ]);
        });
    }
};
