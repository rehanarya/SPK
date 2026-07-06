<?php

namespace App\Support;

/**
 * Konversi angka ke terbilang bahasa Indonesia sederhana.
 * Dipakai halaman cetak formulir "Analisis Pembiayaan" untuk menulis
 * nominal "Besarnya Pembiayaan" dalam huruf (angka + terbilang).
 */
class Terbilang
{
    private const SATUAN = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima',
        'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas',
    ];

    /** Terbilang bilangan bulat non-negatif, mis. 8000000 → "delapan juta" */
    public static function angka(int|float $angka): string
    {
        $angka = (int) floor(abs($angka));

        $hasil = match (true) {
            $angka < 12          => self::SATUAN[$angka],
            $angka < 20          => self::angka($angka - 10) . ' belas',
            $angka < 100         => trim(self::angka(intdiv($angka, 10)) . ' puluh ' . self::angka($angka % 10)),
            $angka < 200         => trim('seratus ' . self::angka($angka - 100)),
            $angka < 1000        => trim(self::angka(intdiv($angka, 100)) . ' ratus ' . self::angka($angka % 100)),
            $angka < 2000        => trim('seribu ' . self::angka($angka - 1000)),
            $angka < 1000000     => trim(self::angka(intdiv($angka, 1000)) . ' ribu ' . self::angka($angka % 1000)),
            $angka < 1000000000  => trim(self::angka(intdiv($angka, 1000000)) . ' juta ' . self::angka($angka % 1000000)),
            default              => trim(self::angka(intdiv($angka, 1000000000)) . ' miliar ' . self::angka($angka % 1000000000)),
        };

        return trim(preg_replace('/\s+/', ' ', $hasil));
    }

    /** Format rupiah terbilang, mis. 8000000 → "Delapan juta rupiah" */
    public static function rupiah(int|float $nominal): string
    {
        $teks = $nominal == 0 ? 'nol' : self::angka($nominal);

        return ucfirst($teks) . ' rupiah';
    }
}
