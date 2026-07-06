<?php

use App\Models\HasilPerhitungan;
use App\Models\LogKeputusan;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Models\Periode;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Edit dari Penetapan Keputusan (revisi tahap 3)
|--------------------------------------------------------------------------
| Tombol Edit kini aktif untuk SEMUA status dan membuka form pengajuan
| lengkap (route pengajuan.edit/update) yang memuat seksi Realisasi &
| Tanda Tangan Manager — route realisasi terpisah tahap 2 telah dihapus.
*/

beforeEach(function () {
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);

    $this->petugas = Pengguna::create([
        'username' => 'petugas.realisasi',
        'password' => 'rahasia123',
        'nama'     => 'Manager Uji',
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
        'no_anggota'   => 'A-0200',
        'nama_nasabah' => 'Siti Aminah',
        'alamat'       => 'Girimarto RT 02',
    ]);
});

/** Buat pengajuan (tanpa komponen — gaya historis) + hasil dengan status tertentu. */
function buatHasil(string $status): HasilPerhitungan
{
    $pengajuan = Pengajuan::create([
        'id_nasabah'           => test()->nasabah->id_nasabah,
        'id_periode'           => test()->periode->id_periode,
        'C1_laba_usaha'        => 5000000,
        'C2_pendapatan_bersih' => 1500000,
        'C3_nilai_agunan'      => 2,
        'C4_besar_pembiayaan'  => 8000000,
        'C5_jangka_waktu'      => 24,
        'tanggal_pengajuan'    => '2026-07-06',
    ]);

    return HasilPerhitungan::create([
        'id_pengajuan' => $pengajuan->id_pengajuan,
        'vektor_S'     => $status === 'diterima' ? 300.0 : 200.0,
        'vektor_V'     => 1.0,
        'ranking'      => 1,
        'status'       => $status,
        'created_at'   => now(),
    ]);
}

/** Payload update mode langsung (rekord tanpa komponen) + field realisasi. */
function payloadUpdateLangsung(array $override = []): array
{
    return array_merge([
        'mode_input'           => 'langsung',
        'id_nasabah'           => test()->nasabah->id_nasabah,
        'tanggal_pengajuan'    => '2026-07-06',
        'C1_laba_usaha'        => 5000000,
        'C2_pendapatan_bersih' => 1500000,
        'C3_nilai_agunan'      => 2,
        'C4_besar_pembiayaan'  => 8000000,
        'C5_jangka_waktu'      => 24,
    ], $override);
}

test('halaman edit dapat diakses untuk pengajuan berstatus ditolak dan menunggu', function () {
    // Status sistem ditolak, belum ada keputusan petugas (menunggu)
    $hasilDitolak = buatHasil('ditolak');
    $this->actingAs($this->petugas)
        ->get(route('pengajuan.edit', $hasilDitolak->pengajuan))
        ->assertOk()
        ->assertSee('Realisasi');

    // Sudah ditetapkan Ditolak oleh petugas — tetap bisa dibuka
    LogKeputusan::create([
        'id_pengguna'          => $this->petugas->id_pengguna,
        'id_hasil_perhitungan' => $hasilDitolak->id_hasil,
        'keputusan_akhir'      => 'ditolak',
        'timestamp'            => now(),
    ]);
    $this->actingAs($this->petugas)
        ->get(route('pengajuan.edit', $hasilDitolak->pengajuan))
        ->assertOk();
});

test('update menyimpan tanggal realisasi + nama & ttd manager (mode fallback historis)', function () {
    Storage::fake('public');
    $hasil = buatHasil('diterima');

    $dataUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $hasil->pengajuan), payloadUpdateLangsung([
            'tanggal_realisasi' => '2026-07-10',
            'nama_manager'      => 'Manager Uji',
            'ttd_manager'       => $dataUrl,
        ]))
        ->assertRedirect(route('hasil.index'))
        ->assertSessionHas('success');

    $hasil->refresh();
    expect($hasil->nama_manager)->toBe('Manager Uji');
    expect($hasil->ttd_manager)->toStartWith('ttd/');
    Storage::disk('public')->assertExists($hasil->ttd_manager);
    expect($hasil->pengajuan->fresh()->tanggal_realisasi->format('Y-m-d'))->toBe('2026-07-10');
});

test('validasi menolak tanggal realisasi sebelum tanggal pengajuan', function () {
    $hasil = buatHasil('diterima');

    $this->actingAs($this->petugas)
        ->put(route('pengajuan.update', $hasil->pengajuan), payloadUpdateLangsung([
            'tanggal_realisasi' => '2026-07-01', // sebelum tanggal pengajuan 06/07
            'nama_manager'      => 'Manager Uji',
        ]))->assertSessionHasErrors('tanggal_realisasi');
});

test('ttd manager tampil di cetakan hanya setelah keputusan ditetapkan petugas', function () {
    Storage::fake('public');
    $hasil = buatHasil('diterima');

    $dataUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    // Simpan ttd manager saat keputusan masih menunggu → cetakan TANPA gambar
    $this->actingAs($this->petugas)->put(route('pengajuan.update', $hasil->pengajuan), payloadUpdateLangsung([
        'tanggal_realisasi' => '2026-07-10',
        'nama_manager'      => 'Manager Uji',
        'ttd_manager'       => $dataUrl,
    ]));

    $pathTtd = $hasil->fresh()->ttd_manager;

    $this->actingAs($this->petugas)
        ->get(route('pengajuan.cetak', $hasil->pengajuan))
        ->assertOk()
        ->assertDontSee('storage/' . $pathTtd);

    // Setelah petugas menetapkan keputusan → gambar ttd manager tampil
    LogKeputusan::create([
        'id_pengguna'          => $this->petugas->id_pengguna,
        'id_hasil_perhitungan' => $hasil->id_hasil,
        'keputusan_akhir'      => 'diterima',
        'timestamp'            => now(),
    ]);

    $this->actingAs($this->petugas)
        ->get(route('pengajuan.cetak', $hasil->pengajuan))
        ->assertOk()
        ->assertSee('Manager Uji')
        ->assertSee('storage/' . $pathTtd);
});
