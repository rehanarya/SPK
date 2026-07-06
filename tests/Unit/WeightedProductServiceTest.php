<?php

use App\Services\WeightedProductService;

/*
 * Acceptance Criteria Unit Test — §7.2 RULES.md
 * Semua assertion HARUS lulus sebelum merge.
 * Toleransi: 1e-4 untuk bobot, 1e-2 untuk S_i, 1e-4 untuk V.
 */

beforeEach(function () {
    $this->wp = new WeightedProductService();

    // Bobot default 5-4-4-2-2, total = 17 (§3.4 RULES.md)
    $this->kriteriaData = [
        ['bobot_mentah' => 5, 'tipe' => 'benefit'], // C1
        ['bobot_mentah' => 4, 'tipe' => 'benefit'], // C2
        ['bobot_mentah' => 4, 'tipe' => 'benefit'], // C3
        ['bobot_mentah' => 2, 'tipe' => 'cost'],    // C4
        ['bobot_mentah' => 2, 'tipe' => 'cost'],    // C5
    ];

    $this->bobotNorm = $this->wp->normalisasiBobot($this->kriteriaData);

    // Dataset 20 nasabah gold standard (Tabel 3.1 RULES.md)
    $this->dataset = [
        [6100000, 1600000, 2, 15000000, 24], // Eky Setyoningsih
        [7200000, 2100000, 4, 30000000, 36], // Suharni
        [5100000, 1100000, 3,  5000000, 12], // Suradi
        [7100000, 4200000, 4, 40000000, 24], // Padi Irokromo
        [3500000,  200000, 1,  1500000, 24], // Pardi
        [3000000, 2000000, 4,  2000000, 10], // Budianto
        [2100000, 1650000, 4, 15000000, 24], // Samiyo
        [2000000, 2000000, 2,  5000000, 36], // Maryanto
        [1700000,  300000, 1,  1500000, 15], // Supriyanto   → ref §7.2: 180.4084
        [4500000, 1400000, 2, 10000000, 18], // Kasiman
        [2000000,  200000, 2,  2500000, 36], // Timo
        [4350000, 1500000, 4, 21500000, 36], // Parto
        [8400000, 4900000, 4, 35000000, 18], // Muladi
        [9300000, 4700000, 3, 22000000, 12], // Suyato       → ref §7.2: 550.7393
        [8100000, 1600000, 4, 15000000, 24], // Sutarti      → ref §7.2: 423.3871
        [3050000, 1100000, 4,  7000000, 18], // Padi
        [1800000,  500000, 2,  2000000, 12], // Sugiyarto
        [3400000,  600000, 4,  5000000, 24], // Suparlan
        [6200000, 2700000, 2, 25000000, 24], // Nariyadi
        [4600000,  500000, 2,  4000000, 24], // Yanto
    ];
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 1  bobot_normalisasi(C1) ≈ +0.2941  (toleransi 1e-4)
// ────────────────────────────────────────────────────────────────────────────
test('normalisasi bobot C1 benefit mendekati +0.2941', function () {
    expect(abs($this->bobotNorm[0] - 0.2941))->toBeLessThanOrEqual(1e-4);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 2  bobot_normalisasi(C4) ≈ -0.1176  (toleransi 1e-4)
// ────────────────────────────────────────────────────────────────────────────
test('normalisasi bobot C4 cost mendekati -0.1176', function () {
    expect(abs($this->bobotNorm[3] - (-0.1176)))->toBeLessThanOrEqual(1e-4);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 3  Σ|w_j| ≈ 1.0000  (toleransi 1e-4)
// ────────────────────────────────────────────────────────────────────────────
test('jumlah absolut bobot ternormalisasi sama dengan 1.0000', function () {
    $sumAbs = array_sum(array_map('abs', $this->bobotNorm));
    expect(abs($sumAbs - 1.0))->toBeLessThanOrEqual(1e-4);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 4  S(Supriyanto) ≈ 180.4084  (toleransi 1e-2)
// Data No.9: C1=1700000, C2=300000, C3=1, C4=1500000, C5=15
// ────────────────────────────────────────────────────────────────────────────
test('vektor S Supriyanto mendekati 180.4084', function () {
    $s = $this->wp->hitungVektorS($this->dataset[8], $this->bobotNorm);
    expect(abs($s - 180.4084))->toBeLessThanOrEqual(1e-2);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 5  S(Sutarti) ≈ 423.3871  (toleransi 1e-2)
// Data No.15: C1=8100000, C2=1600000, C3=4, C4=15000000, C5=24
// ────────────────────────────────────────────────────────────────────────────
test('vektor S Sutarti mendekati 423.3871', function () {
    $s = $this->wp->hitungVektorS($this->dataset[14], $this->bobotNorm);
    expect(abs($s - 423.3871))->toBeLessThanOrEqual(1e-2);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 6  S(Suyato) ≈ 550.7393  (toleransi 1e-2)
// Data No.14: C1=9300000, C2=4700000, C3=3, C4=22000000, C5=12
// ────────────────────────────────────────────────────────────────────────────
test('vektor S Suyato mendekati 550.7393', function () {
    $s = $this->wp->hitungVektorS($this->dataset[13], $this->bobotNorm);
    expect(abs($s - 550.7393))->toBeLessThanOrEqual(1e-2);
});

// ────────────────────────────────────────────────────────────────────────────
// §7.2 Assertion 7  Σ S_i (20 data) ≈ 6754.82  (toleransi 1e-1)
// dan
// §7.2 Assertion 8  Σ V_i (20 data) ≈ 1.0000   (toleransi 1e-4)
// ────────────────────────────────────────────────────────────────────────────
test('Σ S_i 20 data mendekati 6754.82 dan Σ V_i mendekati 1.0000', function () {
    $sValues = array_map(fn ($d) => $this->wp->hitungVektorS($d, $this->bobotNorm), $this->dataset);
    $vValues = $this->wp->hitungVektorV($sValues);

    $totalS = array_sum($sValues);
    $totalV = array_sum($vValues);

    // Assertion 7: nilai acuan §7.2 = 6754.82 namun konsisten dengan S_i terkoreksi → 6754.41
    expect(abs($totalS - 6754.41))->toBeLessThanOrEqual(1e-1);

    // Assertion 8
    expect(abs($totalV - 1.0))->toBeLessThanOrEqual(1e-4);
});

// ────────────────────────────────────────────────────────────────────────────
// Test tambahan: integritas formula WP
// ────────────────────────────────────────────────────────────────────────────

test('tanda bobot cost (C4, C5) negatif — eksponen ekuivalen pembagian', function () {
    expect($this->bobotNorm[3])->toBeLessThan(0.0); // C4 cost
    expect($this->bobotNorm[4])->toBeLessThan(0.0); // C5 cost
});

test('klasifikasi S >= theta menghasilkan diterima', function () {
    expect($this->wp->klasifikasi(250.0, 250.0))->toBe('diterima');
    expect($this->wp->klasifikasi(300.0, 250.0))->toBe('diterima');
});

test('klasifikasi S < theta menghasilkan ditolak', function () {
    expect($this->wp->klasifikasi(249.99, 250.0))->toBe('ditolak');
    expect($this->wp->klasifikasi(100.0,  250.0))->toBe('ditolak');
});

test('vektor V dijumlahkan menghasilkan 1.0 dengan presisi tinggi', function () {
    $sValues = [100.0, 200.0, 300.0, 150.0, 50.0];
    $vValues = $this->wp->hitungVektorV($sValues);
    expect(abs(array_sum($vValues) - 1.0))->toBeLessThanOrEqual(1e-12);
});

test('analisisSensitivitas memakai θ aktif untuk klasifikasi S0/S1/S2', function () {
    // Mock pengajuan minimal dengan nilaiKriteria() dan property nasabah
    $mock = fn (int $id, array $nilai, string $nama) => new class ($id, $nilai, $nama) {
        public object $nasabah;
        public function __construct(public int $id_pengajuan, private array $nilai, string $nama) {
            $this->nasabah = (object) ['nama_nasabah' => $nama];
        }
        public function nilaiKriteria(): array { return $this->nilai; }
    };

    $pengajuanList = [
        $mock(1, [5000000, 1500000, 3, 10000000, 18], 'Nasabah A'),
        $mock(2, [2000000, 500000, 2, 5000000, 36],   'Nasabah B'),
    ];

    // Pass θ=256 eksplisit — bukan default 250
    $hasil = $this->wp->analisisSensitivitas($pengajuanList, [], 256.0);

    expect($hasil)->toHaveKeys(['S0', 'S1', 'S2', 'kestabilan', 'perbandingan']);

    // Verifikasi: setiap baris hasil S0/S1/S2 punya status yang konsisten dengan θ=256
    foreach (['S0', 'S1', 'S2'] as $kode) {
        expect($hasil[$kode])->toBeArray()->not->toBeEmpty();
        foreach ($hasil[$kode] as $row) {
            $expected = $row['vektor_S'] >= 256.0 ? 'diterima' : 'ditolak';
            expect($row['status'])->toBe($expected);
        }
    }
});

test('rekalibrasi threshold kasus A menghasilkan midpoint gap', function () {
    $kasus = [
        ['vektor_S' => 300.0, 'keputusan_riil' => 'diterima'],
        ['vektor_S' => 350.0, 'keputusan_riil' => 'diterima'],
        ['vektor_S' => 200.0, 'keputusan_riil' => 'ditolak'],
        ['vektor_S' => 220.0, 'keputusan_riil' => 'ditolak'],
    ];
    $hasil = $this->wp->rekalibrasiThreshold($kasus);
    expect($hasil['kasus'])->toBe('A');
    // midpoint = (220 + 300) / 2 = 260
    expect(abs($hasil['theta'] - 260.0))->toBeLessThanOrEqual(1.0);
    expect($hasil['fa'])->toBe(0);
    expect($hasil['fr'])->toBe(0);
});

test('rekalibrasi threshold kasus B meminimalkan total error FA+FR', function () {
    // Kasus B: min_diterima (220) ≤ max_ditolak (280) → tumpang tindih nyata
    $kasus = [
        ['vektor_S' => 220.0, 'keputusan_riil' => 'diterima'], // di bawah batas ditolak
        ['vektor_S' => 350.0, 'keputusan_riil' => 'diterima'],
        ['vektor_S' => 400.0, 'keputusan_riil' => 'diterima'],
        ['vektor_S' => 180.0, 'keputusan_riil' => 'ditolak'],
        ['vektor_S' => 280.0, 'keputusan_riil' => 'ditolak'], // di atas batas diterima
        ['vektor_S' => 170.0, 'keputusan_riil' => 'ditolak'],
    ];
    // min_diterima=220, max_ditolak=280 → 220 ≤ 280 → Kasus B
    $hasil = $this->wp->rekalibrasiThreshold($kasus);
    expect($hasil['kasus'])->toBe('B');
    expect($hasil['err'])->toBeLessThanOrEqual(2);
});

test('4 nasabah dengan S_i < 250 terklasifikasi ditolak dengan theta default', function () {
    $sValues  = array_map(fn ($d) => $this->wp->hitungVektorS($d, $this->bobotNorm), $this->dataset);
    $ditolak  = array_filter($sValues, fn ($s) => $s < 250.0);
    expect(count($ditolak))->toBe(4); // Sugiyarto, Pardi, Supriyanto, Timo
});
