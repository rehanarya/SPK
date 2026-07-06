<?php

namespace App\Services;

/**
 * Perhitungan bertahap formulir manual "ANALISIS PEMBIAYAAN"
 * KSPPS Berkah Sakinah Almughni (revisi pasca-sidang).
 *
 * Seluruh nilai turunan (laba usaha, pendapatan bersih, plafon, angsuran)
 * WAJIB dihitung server-side lewat service ini — hitungan JavaScript pada
 * form hanya untuk tampilan langsung. C1 dan C2 pengajuan diisi dari hasil
 * service ini, BUKAN dari nilai kiriman klien.
 *
 * CATATAN: service ini TIDAK menyentuh model keputusan Weighted Product.
 * Logika WP tetap eksklusif di WeightedProductService (§10 RULES.md).
 */
class AnalisisPembiayaanService
{
    /** Rasio angsuran bawaan formulir manual (persen) */
    public const RASIO_DEFAULT = 40.0;

    /** Simpanan wajib bawaan formulir manual (Rp) */
    public const SIMPANAN_DEFAULT = 10000.0;

    /**
     * Bagi hasil per bulan = persen ini × Besarnya Pembiayaan.
     * Verifikasi formulir asli: 15.000.000 → 300.000; 8.000.000 → 160.000.
     */
    public const BAGI_HASIL_PERSEN = 2.0;

    /**
     * Hitung seluruh baris "HITUNG OTOMATIS" formulir manual.
     *
     * Kunci masukan (semua numerik, mengikuti nama kolom tabel pengajuan):
     *   penjualan_usaha, harga_pokok_jual, biaya_usaha,
     *   pendapatan_pasangan, pendapatan_lainnya,
     *   kebutuhan_rumah_tangga, biaya_pendidikan, biaya_lainnya,
     *   rasio_angsuran (persen), C5_jangka_waktu (bulan),
     *   C4_besar_pembiayaan, simpanan
     *
     * Nilai kosong/null diperlakukan 0 — mendukung nasabah pegawai yang
     * mengisi gaji bulanan di penjualan_usaha dan membiarkan HPP + biaya
     * usaha kosong. Bagi hasil TIDAK diambil dari klien: selalu dihitung
     * BAGI_HASIL_PERSEN × Besarnya Pembiayaan.
     *
     * @return array{
     *     laba_usaha: float,
     *     jumlah_pendapatan: float,
     *     jumlah_pengeluaran: float,
     *     pendapatan_bersih: float,
     *     plafon_pembiayaan: float,
     *     angsuran_pokok: float,
     *     bagi_hasil: float,
     *     jumlah_angsuran: float
     * }
     */
    public function hitung(array $komponen): array
    {
        $ambil = fn (string $kunci): float => (float) ($komponen[$kunci] ?? 0);

        // Seksi 1 — Laba Usaha = Penjualan − Harga Pokok Jual − Biaya Usaha
        $labaUsaha = $ambil('penjualan_usaha') - $ambil('harga_pokok_jual') - $ambil('biaya_usaha');

        // Seksi 2 — Jumlah Pendapatan = Laba Usaha + Pendapatan Istri/Suami + Pendapatan Lainnya
        $jumlahPendapatan = $labaUsaha + $ambil('pendapatan_pasangan') + $ambil('pendapatan_lainnya');

        // Seksi 3 — Jumlah Pengeluaran = Kebutuhan Rmh. Tangga + Biaya Pendidikan + Biaya Lainnya
        $jumlahPengeluaran = $ambil('kebutuhan_rumah_tangga') + $ambil('biaya_pendidikan') + $ambil('biaya_lainnya');

        // Seksi 4 — Pendapatan Bersih = Jumlah Pendapatan − Jumlah Pengeluaran
        $pendapatanBersih = $jumlahPendapatan - $jumlahPengeluaran;

        // Seksi 5–6 — Plafon = Pendapatan Bersih × Rasio Angsuran × Jangka Waktu
        $rasio  = $ambil('rasio_angsuran') ?: self::RASIO_DEFAULT;
        $jangka = (int) $ambil('C5_jangka_waktu');
        $plafon = $pendapatanBersih * ($rasio / 100) * $jangka;

        // Usulan — Angsuran Pokok = Besarnya Pembiayaan ÷ Jangka Waktu
        $angsuranPokok = $jangka > 0
            ? round($ambil('C4_besar_pembiayaan') / $jangka, 2)
            : 0.0;

        // Usulan — Bagi Hasil otomatis = 2% × Besarnya Pembiayaan (per bulan)
        $bagiHasil = round($ambil('C4_besar_pembiayaan') * (self::BAGI_HASIL_PERSEN / 100), 2);

        // Usulan — Jumlah Angsuran = Angsuran Pokok + Bagi Hasil + Simpanan
        $jumlahAngsuran = $angsuranPokok + $bagiHasil + $ambil('simpanan');

        return [
            'laba_usaha'         => round($labaUsaha, 2),
            'jumlah_pendapatan'  => round($jumlahPendapatan, 2),
            'jumlah_pengeluaran' => round($jumlahPengeluaran, 2),
            'pendapatan_bersih'  => round($pendapatanBersih, 2),
            'plafon_pembiayaan'  => round($plafon, 2),
            'angsuran_pokok'     => $angsuranPokok,
            'bagi_hasil'         => $bagiHasil,
            'jumlah_angsuran'    => round($jumlahAngsuran, 2),
        ];
    }
}
