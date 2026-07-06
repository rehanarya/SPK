<?php

use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Models\Periode;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;

/*
|--------------------------------------------------------------------------
| Form edit PENUH untuk rekord historis (revisi tahap 3–4)
|--------------------------------------------------------------------------
| Rekord tanpa komponen tidak lagi memakai fallback 5 kriteria: form edit
| menampilkan formulir lengkap dengan komponen di-prefill dari kriteria
| (Penjualan Usaha = C1; HPP = Biaya Usaha = 0; Kebutuhan Rmh. Tangga =
| C1 − C2) sehingga skor tidak bergeser bila angka tidak diubah.
*/

beforeEach(function () {
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);

    $this->petugas = Pengguna::create([
        'username' => 'petugas.historis',
        'password' => 'rahasia123',
        'nama'     => 'Petugas Historis',
        'peran'    => 'petugas',
    ]);

    $this->periode = Periode::create([
        'kode_periode'    => '2026-W28',
        'tanggal_mulai'   => '2026-07-06',
        'tanggal_selesai' => '2026-07-12',
        'status'          => 'aktif',
        'created_at'      => now(),
    ]);

    $this->nasabah = Nasabah::create([
        'no_anggota'   => 'A-0400',
        'nama_nasabah' => 'Sukirman',
        'alamat'       => 'Girimarto RT 04',
    ]);

    // Rekord historis: hanya kriteria, komponen NULL — C = [5jt, 1.5jt, 2, 8jt, 24]
    $this->pengajuan = Pengajuan::create([
        'id_nasabah'           => $this->nasabah->id_nasabah,
        'id_periode'           => $this->periode->id_periode,
        'C1_laba_usaha'        => 5000000,
        'C2_pendapatan_bersih' => 1500000,
        'C3_nilai_agunan'      => 2,
        'C4_besar_pembiayaan'  => 8000000,
        'C5_jangka_waktu'      => 24,
        'tanggal_pengajuan'    => '2026-07-06',
    ]);

    // Hitung WP via alur yang ada agar S awal = nilai riil (bukan tebakan)
    $this->actingAs($this->petugas)->post(route('perhitungan.wp.hitung'));
    $this->pengajuan->refresh()->load('hasilPerhitungan');
});

/** Payload yang MENIRU prefill historis persis — derivasi = C1/C2 tersimpan. */
function payloadPrefillHistoris(): array
{
    return [
        'mode_input'             => 'analisis',
        'id_nasabah'             => test()->nasabah->id_nasabah,
        'tanggal_pengajuan'      => '2026-07-06',
        'penjualan_usaha'        => 5000000,  // = C1 (laba usaha)
        'harga_pokok_jual'       => 0,
        'biaya_usaha'            => 0,
        'pendapatan_pasangan'    => 0,
        'pendapatan_lainnya'     => 0,
        'kebutuhan_rumah_tangga' => 3500000,  // = C1 − C2
        'biaya_pendidikan'       => 0,
        'biaya_lainnya'          => 0,
        'rasio_angsuran'         => 40,
        'C5_jangka_waktu'        => 24,
        'C4_besar_pembiayaan'    => 8000000,
        'simpanan'               => 10000,
        'jenis_akad'             => 'Murabahah',
        'C3_nilai_agunan'        => 2,
    ];
}

test('edit rekord historis menampilkan seluruh seksi formulir dengan prefill, bukan fallback 5 kriteria', function () {
    $this->actingAs($this->petugas)
        ->get(route('pengajuan.edit', $this->pengajuan))
        ->assertOk()
        // Seluruh seksi formulir lengkap hadir
        ->assertSee('Analisis Pembiayaan')
        ->assertSee('Usulan Pembiayaan')
        ->assertSee('Persetujuan')
        ->assertSee('Tanda Tangan')
        ->assertSee('Realisasi')
        // Keterangan prefill data historis
        ->assertSee('Data historis')
        ->assertSee('Rincian analisis pembiayaan belum tersedia')
        // Prefill: Penjualan Usaha = C1, Kebutuhan Rmh. Tangga = C1 − C2
        ->assertSee('name="penjualan_usaha"', false)
        ->assertSee('5000000')
        ->assertSee('3500000')
        // Fallback lama benar-benar hilang
        ->assertDontSee('isian langsung')
        ->assertDontSee('name="C1_laba_usaha"', false);
});

test('simpan prefill tanpa mengubah angka: C1/C2 dan skor S tidak berubah', function () {
    $skorAwal = (float) $this->pengajuan->hasilPerhitungan->vektor_S;

    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $this->pengajuan), payloadPrefillHistoris())
        ->assertRedirect(route('hasil.index'))
        ->assertSessionMissing('info'); // kriteria tak berubah → tanpa flash hitung ulang

    $this->pengajuan->refresh()->load('hasilPerhitungan');
    expect($this->pengajuan->C1_laba_usaha)->toBe(5000000.0);
    expect($this->pengajuan->C2_pendapatan_bersih)->toBe(1500000.0);
    expect((float) $this->pengajuan->hasilPerhitungan->vektor_S)->toBeCloseTo($skorAwal, 1e-6);

    // Komponen kini tersimpan — rekord tidak lagi historis
    expect($this->pengajuan->punyaRincianAnalisis())->toBeTrue();
});

test('simpan dengan perubahan komponen: skor terhitung ulang dengan flash ringkasan', function () {
    $skorAwal = (float) $this->pengajuan->hasilPerhitungan->vektor_S;

    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $this->pengajuan), array_merge(payloadPrefillHistoris(), [
            'penjualan_usaha' => 9000000, // laba naik 5jt → 9jt
        ]))
        ->assertRedirect(route('hasil.index'))
        ->assertSessionHas('info', fn ($v) => str_contains($v, 'dihitung ulang'));

    $this->pengajuan->refresh()->load('hasilPerhitungan');
    expect($this->pengajuan->C1_laba_usaha)->toBe(9000000.0);
    expect(abs((float) $this->pengajuan->hasilPerhitungan->vektor_S - $skorAwal))->toBeGreaterThan(1.0);
});
