<?php

use App\Models\HasilPerhitungan;
use App\Models\LogKeputusan;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Services\AnalisisPembiayaanService;
use Database\Seeders\HistoricalAnalisisSeeder;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;
use Database\Seeders\NasabahHistorisSeeder;

/*
|--------------------------------------------------------------------------
| Seeder data lengkap 20 nasabah historis (revisi tahap 4)
|--------------------------------------------------------------------------
| Komponen formulir asli mengisi 20 rekord yang ada TANPA menyentuh C1–C5
| maupun skor S/V/status; derivasi komponen wajib mereproduksi C1/C2 persis.
*/

beforeEach(function () {
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);
    $this->seed(NasabahHistorisSeeder::class);

    // Potret skor sebelum pengisian komponen — wajib tak berubah sesudahnya
    $this->skorSebelum = HasilPerhitungan::orderBy('id_pengajuan')
        ->pluck('vektor_S', 'id_pengajuan')->map(fn ($s) => (float) $s)->all();

    $this->seed(HistoricalAnalisisSeeder::class);
});

test('20 rekord memiliki komponen terisi lengkap tanpa rekord baru', function () {
    expect(Pengajuan::count())->toBe(20);
    expect(Pengajuan::whereNotNull('penjualan_usaha')->count())->toBe(20);
    expect(Pengajuan::whereNotNull('rasio_angsuran')->count())->toBe(20);
    expect(Pengajuan::where('jenis_akad', 'Murabahah')->count())->toBe(20);
    expect(Pengajuan::where('sumber_penghasilan', 'usaha')->count())->toBe(20);
});

test('derivasi komponen mereproduksi C1 dan C2 tersimpan untuk SEMUA rekord', function () {
    $analisis = app(AnalisisPembiayaanService::class);

    Pengajuan::with('nasabah')->get()->each(function (Pengajuan $p) use ($analisis) {
        $hasil = $analisis->hitung($p->only([
            'penjualan_usaha', 'harga_pokok_jual', 'biaya_usaha',
            'pendapatan_pasangan', 'pendapatan_lainnya',
            'kebutuhan_rumah_tangga', 'biaya_pendidikan', 'biaya_lainnya',
            'rasio_angsuran', 'C5_jangka_waktu', 'C4_besar_pembiayaan', 'simpanan',
        ]));

        expect($hasil['laba_usaha'])->toBeCloseTo($p->C1_laba_usaha, 0.01);
        expect($hasil['pendapatan_bersih'])->toBeCloseTo($p->C2_pendapatan_bersih, 0.01);
    });
});

test('skor S dan status TIDAK berubah: 16 diterima / 4 ditolak + spot-check', function () {
    // Seluruh skor identik dengan sebelum seeder komponen dijalankan
    HasilPerhitungan::orderBy('id_pengajuan')->get()->each(function ($h) {
        expect((float) $h->vektor_S)->toBeCloseTo($this->skorSebelum[$h->id_pengajuan], 1e-6);
    });

    expect(HasilPerhitungan::where('status', 'diterima')->count())->toBe(16);
    expect(HasilPerhitungan::where('status', 'ditolak')->count())->toBe(4);

    $skor = fn (string $nama) => HasilPerhitungan::whereHas('pengajuan.nasabah',
        fn ($q) => $q->where('nama_nasabah', $nama))->firstOrFail();

    expect((float) $skor('Suyato')->vektor_S)->toBeCloseTo(550.7393, 1e-2);
    expect((float) $skor('Sugiyarto')->vektor_S)->toBeCloseTo(241.7078, 1e-2);
    expect($skor('Sugiyarto')->status)->toBe('ditolak');
    expect((float) $skor('Yanto')->vektor_S)->toBeCloseTo(270.59, 0.05);
    expect($skor('Yanto')->status)->toBe('diterima');
});

test('keputusan final terisi: 16 disetujui + 4 ditolak, realisasi hanya untuk yang disetujui', function () {
    expect(LogKeputusan::count())->toBe(20);
    expect(LogKeputusan::where('keputusan_akhir', 'diterima')->count())->toBe(16);
    expect(LogKeputusan::where('keputusan_akhir', 'ditolak')->count())->toBe(4);

    expect(Pengajuan::whereNotNull('tanggal_realisasi')->count())->toBe(16);

    // Nama manager arsip terisi; ttd digital tetap NULL (arsip fisik)
    expect(HasilPerhitungan::where('nama_manager', 'MARYADI')->count())->toBe(20);
    expect(HasilPerhitungan::whereNull('ttd_manager')->count())->toBe(20);
    expect(Pengajuan::whereNull('ttd_anggota')->count())->toBe(20);
});

test('bagi hasil memakai nilai formulir asli — deviasi Parto 400.000 dipertahankan', function () {
    $parto = Pengajuan::whereHas('nasabah', fn ($q) => $q->where('nama_nasabah', 'Parto'))->firstOrFail();
    expect($parto->bagi_hasil)->toBe(400000.0);          // formulir asli, bukan 2% (430.000)

    $eky = Pengajuan::whereHas('nasabah', fn ($q) => $q->where('nama_nasabah', 'Eky Setyoningsih'))->firstOrFail();
    expect($eky->bagi_hasil)->toBe(300000.0);            // 2% × 15jt — sesuai rumus
    expect($eky->plafon_pembiayaan)->toBe(15360000.0);   // 1.6jt × 40% × 24
});

test('seeder idempoten: dijalankan dua kali tanpa duplikasi atau perubahan', function () {
    $this->seed(HistoricalAnalisisSeeder::class); // eksekusi kedua

    expect(Pengajuan::count())->toBe(20);
    expect(LogKeputusan::count())->toBe(20);
    expect(Pengguna::where('username', 'maryadi')->count())->toBe(1);

    HasilPerhitungan::orderBy('id_pengajuan')->get()->each(function ($h) {
        expect((float) $h->vektor_S)->toBeCloseTo($this->skorSebelum[$h->id_pengajuan], 1e-6);
    });
});

test('halaman cetak Suyato memuat angka formulir asli, terbilang, dan label agunan', function () {
    $petugas = Pengguna::create([
        'username' => 'petugas.cetak',
        'password' => 'rahasia123',
        'nama'     => 'Petugas Cetak',
        'peran'    => 'petugas',
    ]);

    $suyato = Pengajuan::whereHas('nasabah', fn ($q) => $q->where('nama_nasabah', 'Suyato'))->firstOrFail();

    $this->actingAs($petugas)->get(route('pengajuan.cetak', $suyato))
        ->assertOk()
        ->assertSee('9.300.000')                       // Laba Usaha (C1)
        ->assertSee('4.700.000')                       // Pendapatan Bersih (C2)
        ->assertSee('22.000.000')                      // Besarnya Pembiayaan (C4)
        ->assertSee('Dua puluh dua juta rupiah')       // terbilang
        ->assertSee('BPKB Mobil');                     // label agunan C3 = 3
});
