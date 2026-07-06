<?php

use App\Models\LogKeputusan;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Models\Periode;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;

/*
|--------------------------------------------------------------------------
| Hitung ulang WP saat edit pengajuan (revisi tahap 3)
|--------------------------------------------------------------------------
| Edit yang mengubah C1–C5 (lewat komponen) wajib menghitung ulang S/V/
| status rekomendasi memakai alur WP yang ada; keputusan final petugas
| tidak berubah otomatis. Angka referensi dataset RULES.md §7.2:
|   [1.7jt, 300rb, 1, 1.5jt, 15]  → S ≈ 180,41 (< θ=250, ditolak)
|   [8.1jt, 1.6jt, 4, 15jt, 24]   → S ≈ 423,39 (≥ θ=250, diterima)
*/

beforeEach(function () {
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);

    $this->petugas = Pengguna::create([
        'username' => 'petugas.edit',
        'password' => 'rahasia123',
        'nama'     => 'Petugas Edit',
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
        'no_anggota'   => 'A-0300',
        'nama_nasabah' => 'Warsito',
        'alamat'       => 'Girimarto RT 03',
    ]);
});

/** Komponen menghasilkan C = [1.7jt, 300rb, 1, 1.5jt, 15] → S ≈ 180,41 (ditolak). */
function payloadRendah(int $idNasabah): array
{
    return [
        'id_nasabah'             => $idNasabah,
        'tanggal_pengajuan'      => '2026-07-06',
        'mode_input'             => 'analisis',
        'penjualan_usaha'        => 2000000,
        'harga_pokok_jual'       => 300000,
        'biaya_usaha'            => 0,
        'pendapatan_pasangan'    => 0,
        'pendapatan_lainnya'     => 0,
        'kebutuhan_rumah_tangga' => 1400000,
        'biaya_pendidikan'       => 0,
        'biaya_lainnya'          => 0,
        'rasio_angsuran'         => 40,
        'C5_jangka_waktu'        => 15,
        'C4_besar_pembiayaan'    => 1500000,
        'simpanan'               => 10000,
        'jenis_akad'             => 'Murabahah',
        'C3_nilai_agunan'        => 1,
    ];
}

/** Komponen menghasilkan C = [8.1jt, 1.6jt, 4, 15jt, 24] → S ≈ 423,39 (diterima). */
function payloadTinggi(int $idNasabah): array
{
    return array_merge(payloadRendah($idNasabah), [
        'penjualan_usaha'        => 9000000,
        'harga_pokok_jual'       => 900000,
        'kebutuhan_rumah_tangga' => 6500000,
        'C5_jangka_waktu'        => 24,
        'C4_besar_pembiayaan'    => 15000000,
        'C3_nilai_agunan'        => 4,
    ]);
}

test('edit komponen menghitung ulang skor dan status melintasi θ dua arah', function () {
    // Simpan awal: ditolak (S ≈ 180,41 < 250)
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadRendah($this->nasabah->id_nasabah));

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->C1_laba_usaha)->toBe(1700000.0);
    expect((float) $pengajuan->hasilPerhitungan->vektor_S)->toBeCloseTo(180.4084, 1e-2);
    expect($pengajuan->hasilPerhitungan->status)->toBe('ditolak');

    // Arah 1: naik melewati θ → diterima, dengan flash ringkasan skor
    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $pengajuan), payloadTinggi($this->nasabah->id_nasabah))
        ->assertRedirect(route('hasil.index'))
        ->assertSessionHas('info', fn ($v) => str_contains($v, 'dihitung ulang'));

    $pengajuan->refresh()->load('hasilPerhitungan');
    expect($pengajuan->C1_laba_usaha)->toBe(8100000.0);            // hasil hitung server
    expect((float) $pengajuan->hasilPerhitungan->vektor_S)->toBeCloseTo(423.3871, 1e-2);
    expect($pengajuan->hasilPerhitungan->status)->toBe('diterima');

    // Arah 2: turun kembali di bawah θ → ditolak
    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $pengajuan), payloadRendah($this->nasabah->id_nasabah))
        ->assertSessionHas('info');

    $pengajuan->refresh()->load('hasilPerhitungan');
    expect((float) $pengajuan->hasilPerhitungan->vektor_S)->toBeCloseTo(180.4084, 1e-2);
    expect($pengajuan->hasilPerhitungan->status)->toBe('ditolak');
});

test('edit tanpa perubahan C1–C5 tidak mengubah skor dan tanpa flash ringkasan', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadTinggi($this->nasabah->id_nasabah));

    $pengajuan = Pengajuan::firstOrFail();
    $skorAwal  = (float) $pengajuan->hasilPerhitungan->vektor_S;

    // Kirim ulang payload identik (hanya tanggal realisasi ditambah)
    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $pengajuan), array_merge(
            payloadTinggi($this->nasabah->id_nasabah),
            ['tanggal_realisasi' => '2026-07-11'],
        ))
        ->assertRedirect(route('hasil.index'))
        ->assertSessionMissing('info');

    $pengajuan->refresh()->load('hasilPerhitungan');
    expect((float) $pengajuan->hasilPerhitungan->vektor_S)->toBeCloseTo($skorAwal, 1e-6);
    expect($pengajuan->hasilPerhitungan->status)->toBe('diterima');
});

test('keputusan final tidak berubah otomatis saat rekomendasi berubah — muncul peringatan', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadTinggi($this->nasabah->id_nasabah));

    $pengajuan = Pengajuan::firstOrFail();

    // Petugas menetapkan keputusan final: Diterima
    $this->actingAs($this->petugas)
        ->post(route('keputusan.store', $pengajuan->hasilPerhitungan), ['keputusan_akhir' => 'diterima']);

    // Edit menurunkan skor hingga rekomendasi berubah menjadi ditolak
    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $pengajuan), payloadRendah($this->nasabah->id_nasabah))
        ->assertSessionHas('warning', fn ($v) => str_contains($v, 'tidak diubah otomatis'));

    $pengajuan->refresh()->load('hasilPerhitungan.logKeputusan');
    expect($pengajuan->hasilPerhitungan->status)->toBe('ditolak'); // rekomendasi baru

    // Keputusan final petugas tetap 'diterima' — tidak diubah otomatis
    $final = $pengajuan->hasilPerhitungan->logKeputusan->sortByDesc('timestamp')->first();
    expect($final->keputusan_akhir)->toBe('diterima');
});
