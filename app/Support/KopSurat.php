<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Teks kop surat formulir cetak "Analisis Pembiayaan".
 *
 * Bagian bulan-romawi/tahun pada nomor BH serta baris "Tanggal ..." dibuat
 * DINAMIS mengikuti tanggal saat halaman dicetak/dibuka (permintaan revisi
 * tahap 4). Nomor pokok badan hukum "BH. 798 / BH / PAD / XIV . 30" adalah
 * nomor tetap dan tidak pernah berubah.
 *
 * CARA REVERT ke kop statis formulir asli (III / 2016, Tanggal 10 Maret 2016):
 * cukup ubah konstanta DINAMIS di bawah menjadi false — tidak perlu
 * menyentuh view.
 */
class KopSurat
{
    /** Set false untuk kembali ke kop statis "III / 2016 — 10 Maret 2016" */
    private const DINAMIS = true;

    private const NOMOR_POKOK = 'BH. 798 / BH / PAD / XIV . 30';

    private const ROMAWI = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
        7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
    ];

    /** Baris nomor BH, mis. "BH. 798 / BH / PAD / XIV . 30 / VII / 2026" */
    public static function nomorBh(): string
    {
        if (! self::DINAMIS) {
            return self::NOMOR_POKOK . ' / III / 2016';
        }

        $kini = Carbon::now();

        return self::NOMOR_POKOK . ' / ' . self::ROMAWI[$kini->month] . ' / ' . $kini->year;
    }

    /** Baris tanggal, mis. "Tanggal 06 Juli 2026" */
    public static function tanggal(): string
    {
        if (! self::DINAMIS) {
            return 'Tanggal 10 Maret 2016';
        }

        return 'Tanggal ' . Carbon::now()->locale('id')->translatedFormat('d F Y');
    }
}
