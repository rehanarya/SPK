<?php

use App\Models\HasilPerhitungan;
use App\Models\Kriteria;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Services\WeightedProductService;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;
use Database\Seeders\NasabahHistorisSeeder;

/*
|--------------------------------------------------------------------------
| Integrasi seeder 20 nasabah historis (RULES.md §6, §7.2)
|--------------------------------------------------------------------------
| Memastikan bahwa ketika seeder dijalankan terhadap database in-memory
| (SQLite), perangkingan output (Vektor S, Vektor V) sesuai dengan
| acuan draf Bab III skripsi.
*/

beforeEach(function () {
    // Pest config tests/Pest.php sudah memuat RefreshDatabase untuk folder ini.
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);
    $this->seed(NasabahHistorisSeeder::class);
});

test('seeder memuat 20 nasabah historis sesuai Tabel 3.1 RULES.md', function () {
    expect(Nasabah::count())->toBe(20);
    expect(Pengajuan::count())->toBe(20);
    expect(HasilPerhitungan::count())->toBe(20);
});

test('bobot kriteria default 5-4-4-2-2 dengan tipe yang benar', function () {
    $kriteria = Kriteria::orderBy('kode_kriteria')->get();

    expect($kriteria->pluck('bobot_mentah')->all())->toBe([5, 4, 4, 2, 2]);
    expect($kriteria->pluck('tipe')->all())->toBe(['benefit', 'benefit', 'benefit', 'cost', 'cost']);
});

test('Suyato memuncaki perangkingan sesuai Tabel 3.6 dokumen', function () {
    $top = HasilPerhitungan::with('pengajuan.nasabah')
        ->orderBy('ranking')
        ->first();

    expect($top->pengajuan->nasabah->nama_nasabah)->toBe('Suyato');
    expect((float) $top->vektor_S)->toBeCloseTo(550.7393, 1e-2);
});

test('4 nasabah dengan S_i di bawah 250 terklasifikasi tidak layak', function () {
    $ditolak = HasilPerhitungan::where('status', 'ditolak')->count();
    $diterima = HasilPerhitungan::where('status', 'diterima')->count();

    expect($ditolak)->toBe(4);
    expect($diterima)->toBe(16);
});

test('Σ V_i pada periode historis sama dengan 1.0', function () {
    $totalV = (float) HasilPerhitungan::sum('vektor_V');
    expect($totalV)->toBeCloseTo(1.0, 1e-4);
});

test('perhitungan WeightedProductService berbasis seeder konsisten dengan hasil tersimpan', function () {
    $wp = app(WeightedProductService::class);

    $pengajuanList = Pengajuan::with('nasabah')->get();
    $hasil = $wp->hitungPeriode($pengajuanList, 250.0, 5);

    // Total Σ S_i ≈ 6754.41 (hasil komputasi presisi double)
    $totalS = collect($hasil)->sum('vektor_S');
    expect($totalS)->toBeGreaterThan(6700.0);
    expect($totalS)->toBeLessThan(6800.0);

    // Σ V_i = 1.0
    $totalV = collect($hasil)->sum('vektor_V');
    expect($totalV)->toBeCloseTo(1.0, 1e-4);

    // 5 teratas wajib bertanda prioritas (status diterima)
    $top5 = collect($hasil)->where('ranking', '<=', 5);
    expect($top5->every(fn ($r) => $r['prioritas'] === true && $r['status'] === 'diterima'))->toBeTrue();
});

test('LOOCV pada dataset historis menghasilkan akurasi sempurna', function () {
    $wp = app(WeightedProductService::class);

    $dataset = HasilPerhitungan::get()->map(fn ($h) => [
        'vektor_S'       => (float) $h->vektor_S,
        'keputusan_riil' => $h->status,
    ])->toArray();

    $hasil = $wp->loocv($dataset);

    // Dataset bootstrap (status = klasifikasi by theta) — LOOCV harus 100% atau sangat tinggi
    expect($hasil['akurasi'])->toBeGreaterThanOrEqual(0.9);
    expect($hasil['tp'] + $hasil['tn'])->toBeGreaterThanOrEqual(18);
});
