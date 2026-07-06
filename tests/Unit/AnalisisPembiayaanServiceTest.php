<?php

use App\Services\AnalisisPembiayaanService;
use App\Support\Terbilang;

/*
 * Verifikasi rumus derivasi formulir manual "ANALISIS PEMBIAYAAN"
 * memakai persis angka contoh dari formulir asli koperasi:
 *
 *   Penjualan 33.400.000 − HPP 24.500.000 − Biaya Usaha 5.000.000 = Laba 3.900.000
 *   Jumlah Pendapatan 3.900.000 + 3.500.000 + 0                   = 7.400.000
 *   Jumlah Pengeluaran 2.500.000 + 1.500.000 + 2.500.000          = 6.500.000
 *   Pendapatan Bersih 7.400.000 − 6.500.000                       = 900.000
 *   Plafon 900.000 × 40% × 24                                     = 8.640.000
 *   Angsuran Pokok 8.000.000 ÷ 24                                 = 333.333,33
 *   Jumlah Angsuran 333.333,33 + 160.000 + 10.000                 = 503.333,33
 */

beforeEach(function () {
    $this->analisis = new AnalisisPembiayaanService();

    // Angka contoh formulir asli
    $this->komponen = [
        'penjualan_usaha'        => 33400000,
        'harga_pokok_jual'       => 24500000,
        'biaya_usaha'            => 5000000,
        'pendapatan_pasangan'    => 3500000,
        'pendapatan_lainnya'     => 0,
        'kebutuhan_rumah_tangga' => 2500000,
        'biaya_pendidikan'       => 1500000,
        'biaya_lainnya'          => 2500000,
        'rasio_angsuran'         => 40,
        'C5_jangka_waktu'        => 24,
        'C4_besar_pembiayaan'    => 8000000,
        'bagi_hasil'             => 160000,
        'simpanan'               => 10000,
    ];
});

test('seluruh subtotal formulir asli terhitung persis (laba 3.9jt, bersih 900rb, plafon 8.64jt)', function () {
    $hasil = $this->analisis->hitung($this->komponen);

    expect($hasil['laba_usaha'])->toBe(3900000.0);
    expect($hasil['jumlah_pendapatan'])->toBe(7400000.0);
    expect($hasil['jumlah_pengeluaran'])->toBe(6500000.0);
    expect($hasil['pendapatan_bersih'])->toBe(900000.0);
    expect($hasil['plafon_pembiayaan'])->toBe(8640000.0);
});

test('angsuran pokok 333.333,33 dan jumlah angsuran 503.333,33 sesuai formulir asli', function () {
    $hasil = $this->analisis->hitung($this->komponen);

    expect($hasil['angsuran_pokok'])->toBeCloseTo(333333.33, 1e-2);
    expect($hasil['jumlah_angsuran'])->toBeCloseTo(503333.33, 1e-2);
});

test('bagi hasil otomatis 2% × pembiayaan — kiriman klien diabaikan (8jt → 160rb)', function () {
    // Klien mengirim bagi_hasil palsu; service wajib menghitung sendiri
    $hasil = $this->analisis->hitung(array_merge($this->komponen, ['bagi_hasil' => 999999]));

    expect($hasil['bagi_hasil'])->toBe(160000.0); // 2% × 8.000.000
    expect($hasil['jumlah_angsuran'])->toBeCloseTo(503333.33, 1e-2);
});

test('kasus formulir kedua: pembiayaan 15jt/24 bulan → bagi hasil 300rb, jumlah angsuran 935rb', function () {
    $hasil = $this->analisis->hitung(array_merge($this->komponen, ['C4_besar_pembiayaan' => 15000000]));

    expect($hasil['angsuran_pokok'])->toBe(625000.0);   // 15.000.000 ÷ 24
    expect($hasil['bagi_hasil'])->toBe(300000.0);       // 2% × 15.000.000
    expect($hasil['jumlah_angsuran'])->toBe(935000.0);  // 625.000 + 300.000 + 10.000
});

test('nasabah pegawai: HPP dan biaya usaha kosong diperlakukan 0 — laba usaha = gaji', function () {
    $hasil = $this->analisis->hitung([
        'penjualan_usaha'        => 4000000, // gaji bulanan
        'harga_pokok_jual'       => null,
        'biaya_usaha'            => null,
        'pendapatan_pasangan'    => 0,
        'pendapatan_lainnya'     => 0,
        'kebutuhan_rumah_tangga' => 1000000,
        'biaya_pendidikan'       => 500000,
        'biaya_lainnya'          => 0,
        'rasio_angsuran'         => 40,
        'C5_jangka_waktu'        => 24,
        'C4_besar_pembiayaan'    => 8000000,
        'simpanan'               => 10000,
    ]);

    expect($hasil['laba_usaha'])->toBe(4000000.0);        // = gaji
    expect($hasil['pendapatan_bersih'])->toBe(2500000.0); // 4jt − 1.5jt
    expect($hasil['plafon_pembiayaan'])->toBe(24000000.0); // 2.5jt × 40% × 24
});

test('laba usaha dan pendapatan bersih bisa negatif untuk dideteksi validasi', function () {
    $hasil = $this->analisis->hitung(array_merge($this->komponen, [
        'kebutuhan_rumah_tangga' => 9000000, // pengeluaran 13jt > pendapatan 7.4jt
    ]));

    expect($hasil['pendapatan_bersih'])->toBeLessThan(0.0);
});

test('jangka waktu nol tidak menyebabkan pembagian ilegal', function () {
    $hasil = $this->analisis->hitung(array_merge($this->komponen, ['C5_jangka_waktu' => 0]));

    expect($hasil['angsuran_pokok'])->toBe(0.0);
    expect($hasil['plafon_pembiayaan'])->toBe(0.0);
});

test('helper terbilang menulis nominal pembiayaan dalam huruf', function () {
    expect(Terbilang::rupiah(8000000))->toBe('Delapan juta rupiah');
    expect(Terbilang::rupiah(8640000))->toBe('Delapan juta enam ratus empat puluh ribu rupiah');
    expect(Terbilang::rupiah(1111))->toBe('Seribu seratus sebelas rupiah');
    expect(Terbilang::rupiah(0))->toBe('Nol rupiah');
});
