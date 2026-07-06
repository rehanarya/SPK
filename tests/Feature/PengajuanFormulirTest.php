<?php

use App\Models\HasilPerhitungan;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Models\Periode;
use Database\Seeders\KonfigurasiSeeder;
use Database\Seeders\KriteriaSeeder;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Formulir "Analisis Pembiayaan" (revisi pasca-sidang)
|--------------------------------------------------------------------------
| Menguji alur HTTP pengajuan: C1/C2 dihitung server-side dari komponen
| formulir manual, validasi pendapatan bersih, peringatan plafon,
| kompatibilitas rekord historis, dan halaman cetak.
*/

beforeEach(function () {
    $this->seed(KonfigurasiSeeder::class);
    $this->seed(KriteriaSeeder::class);

    $this->petugas = Pengguna::create([
        'username' => 'petugas.uji',
        'password' => 'rahasia123',
        'nama'     => 'Petugas Uji',
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
        'no_anggota'   => 'A-0100',
        'nama_nasabah' => 'Budi Santoso',
        'alamat'       => 'Girimarto RT 01 RW 01',
        'jenis_usaha'  => 'Kelontong',
    ]);
});

/** Payload formulir lengkap memakai angka contoh formulir asli koperasi. */
function payloadAnalisis(int $idNasabah, array $override = []): array
{
    return array_merge([
        'id_nasabah'             => $idNasabah,
        'tanggal_pengajuan'      => '2026-07-06',
        'mode_input'             => 'analisis',
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
        'jenis_akad'             => 'Murabahah',
        'tanggal_realisasi'      => '2026-07-10',
        'C3_nilai_agunan'        => 2,
    ], $override);
}

test('store menyimpan C1/C2 hasil hitung server, bukan nilai kiriman klien yang dimanipulasi', function () {
    $respon = $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        // Manipulasi klien: kirim C1/C2 palsu — server WAJIB mengabaikannya
        ['C1_laba_usaha' => 999999999, 'C2_pendapatan_bersih' => 888888888]
    ));

    $respon->assertRedirect(route('hasil.index'))->assertSessionHas('success');

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->C1_laba_usaha)->toBe(3900000.0);         // bukan 999999999
    expect($pengajuan->C2_pendapatan_bersih)->toBe(900000.0);   // bukan 888888888
    expect($pengajuan->plafon_pembiayaan)->toBe(8640000.0);
    expect($pengajuan->angsuran_pokok)->toBeCloseTo(333333.33, 1e-2);
    expect($pengajuan->jumlah_angsuran)->toBeCloseTo(503333.33, 1e-2);
    expect($pengajuan->jenis_akad)->toBe('Murabahah');

    // Kalkulasi WP otomatis terpicu
    expect(HasilPerhitungan::where('id_pengajuan', $pengajuan->id_pengajuan)->exists())->toBeTrue();
});

test('validasi menolak pengajuan dengan pendapatan bersih ≤ 0', function () {
    $respon = $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['kebutuhan_rumah_tangga' => 10000000] // pengeluaran 14.5jt > pendapatan 7.4jt
    ));

    $respon->assertSessionHasErrors('biaya_lainnya');
    expect(Pengajuan::count())->toBe(0);
});

test('validasi menolak pengajuan dengan laba usaha ≤ 0', function () {
    $respon = $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['biaya_usaha' => 8900000] // 33.4jt − 24.5jt − 8.9jt = 0
    ));

    $respon->assertSessionHasErrors('biaya_usaha');
    expect(Pengajuan::count())->toBe(0);
});

test('pengajuan melebihi plafon tetap tersimpan dengan peringatan (keputusan di petugas)', function () {
    $respon = $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['C4_besar_pembiayaan' => 20000000] // plafon hitung hanya 8.64jt
    ));

    $respon->assertRedirect(route('hasil.index'))
        ->assertSessionHas('success')
        ->assertSessionHas('warning');

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->C4_besar_pembiayaan)->toBe(20000000.0);
    expect($pengajuan->plafon_pembiayaan)->toBe(8640000.0);
});

test('rekord historis tanpa komponen tetap bisa dibuka di edit dan detail', function () {
    // Rekord lama: hanya kriteria C1–C5, seluruh komponen analisis NULL
    $pengajuan = Pengajuan::create([
        'id_nasabah'           => $this->nasabah->id_nasabah,
        'id_periode'           => $this->periode->id_periode,
        'C1_laba_usaha'        => 6100000,
        'C2_pendapatan_bersih' => 1600000,
        'C3_nilai_agunan'      => 2,
        'C4_besar_pembiayaan'  => 15000000,
        'C5_jangka_waktu'      => 24,
        'tanggal_pengajuan'    => '2026-07-06',
    ]);

    $hasil = HasilPerhitungan::create([
        'id_pengajuan' => $pengajuan->id_pengajuan,
        'vektor_S'     => 300.0,
        'vektor_V'     => 1.0,
        'ranking'      => 1,
        'status'       => 'diterima',
        'created_at'   => now(),
    ]);

    // Halaman edit: fallback isian langsung + keterangan data historis
    $this->actingAs($this->petugas)->get(route('pengajuan.edit', $pengajuan))
        ->assertOk()
        ->assertSee('Data historis')
        ->assertSee('Rincian analisis pembiayaan belum tersedia');

    // Halaman detail: keterangan rincian belum tersedia
    $this->actingAs($this->petugas)->get(route('hasil.show', $hasil))
        ->assertOk()
        ->assertSee('Rincian analisis belum tersedia untuk data historis');
});

test('update rekord historis mode langsung tetap bekerja seperti semula', function () {
    $pengajuan = Pengajuan::create([
        'id_nasabah'           => $this->nasabah->id_nasabah,
        'id_periode'           => $this->periode->id_periode,
        'C1_laba_usaha'        => 6100000,
        'C2_pendapatan_bersih' => 1600000,
        'C3_nilai_agunan'      => 2,
        'C4_besar_pembiayaan'  => 15000000,
        'C5_jangka_waktu'      => 24,
        'tanggal_pengajuan'    => '2026-07-06',
    ]);

    $this->actingAs($this->petugas)->put(route('pengajuan.update', $pengajuan), [
        'mode_input'           => 'langsung',
        'id_nasabah'           => $this->nasabah->id_nasabah,
        'tanggal_pengajuan'    => '2026-07-07',
        'C1_laba_usaha'        => 6500000,
        'C2_pendapatan_bersih' => 1700000,
        'C3_nilai_agunan'      => 3,
        'C4_besar_pembiayaan'  => 12000000,
        'C5_jangka_waktu'      => 18,
    ])->assertRedirect(route('hasil.index'))->assertSessionHas('success');

    $pengajuan->refresh();
    expect($pengajuan->C1_laba_usaha)->toBe(6500000.0);
    expect($pengajuan->C3_nilai_agunan)->toBe(3);
});

test('halaman cetak merender formulir lengkap dengan terbilang dan tiga blok tanda tangan', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));

    $pengajuan = Pengajuan::firstOrFail();

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        ->assertSee('KSPPS BERKAH SAKINAH ALMUGHNI')
        ->assertSee('ANALISIS PEMBIAYAAN')
        ->assertSee('USULAN PEMBIAYAAN')
        ->assertSee('Budi Santoso')                 // nama nasabah
        ->assertSee('Delapan juta rupiah')          // terbilang Besarnya Pembiayaan
        ->assertSee('Anggota')                      // tiga blok tanda tangan
        ->assertSee('Petugas')
        ->assertSee('Manager')
        ->assertSee('Petugas Uji')                  // nama petugas login
        ->assertSee('BPKB Sepeda Motor');           // label agunan tekstual (C3 = 2)
});

// ── Tahap 2: tenor maks. 48, bagi hasil otomatis, pegawai, tanda tangan ────

test('validasi tenor: menolak 49 bulan dan menerima 48 bulan', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah, ['C5_jangka_waktu' => 49]))
        ->assertSessionHasErrors('C5_jangka_waktu');
    expect(Pengajuan::count())->toBe(0);

    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah, ['C5_jangka_waktu' => 48]))
        ->assertRedirect(route('hasil.index'))->assertSessionHas('success');
    expect(Pengajuan::count())->toBe(1);
});

test('bagi hasil otomatis via HTTP: 8jt/24 → 160rb; kiriman klien yang dimanipulasi diabaikan', function () {
    $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['bagi_hasil' => 999999] // manipulasi klien — wajib diabaikan
    ))->assertRedirect(route('hasil.index'));

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->bagi_hasil)->toBe(160000.0);                       // 2% × 8.000.000
    expect($pengajuan->jumlah_angsuran)->toBeCloseTo(503333.33, 1e-2);
});

test('bagi hasil otomatis kasus kedua: 15jt/24 → 300rb dan jumlah angsuran 935rb', function () {
    $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['C4_besar_pembiayaan' => 15000000]
    ))->assertRedirect(route('hasil.index'));

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->bagi_hasil)->toBe(300000.0);
    expect($pengajuan->angsuran_pokok)->toBe(625000.0);
    expect($pengajuan->jumlah_angsuran)->toBe(935000.0);
});

test('nasabah pegawai: gaji di penjualan_usaha, HPP & biaya usaha kosong → C1 = gaji', function () {
    $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        [
            'sumber_penghasilan'     => 'gaji',
            'penjualan_usaha'        => 4000000, // gaji bulanan
            'harga_pokok_jual'       => '',      // dikosongkan
            'biaya_usaha'            => '',      // dikosongkan
            'pendapatan_pasangan'    => 0,
            'pendapatan_lainnya'     => 0,
            'kebutuhan_rumah_tangga' => 1000000,
            'biaya_pendidikan'       => 500000,
            'biaya_lainnya'          => 0,
        ]
    ))->assertRedirect(route('hasil.index'))->assertSessionHas('success');

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->C1_laba_usaha)->toBe(4000000.0);        // laba = gaji
    expect($pengajuan->C2_pendapatan_bersih)->toBe(2500000.0); // 4jt − 1.5jt
    expect($pengajuan->plafon_pembiayaan)->toBe(24000000.0);   // 2.5jt × 40% × 24
    expect($pengajuan->sumber_penghasilan)->toBe('gaji');
});

// ── Tahap 3: coretan DISETUJUI/TIDAK DISETUJUI mengikuti keputusan final ───

test('cetak sebelum keputusan ditetapkan: kedua frasa tampil tanpa coretan', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));

    $pengajuan = Pengajuan::firstOrFail();
    // Sistem sudah punya rekomendasi (hasil perhitungan ada), tapi petugas
    // belum menetapkan keputusan → tidak boleh ada coretan sama sekali
    expect($pengajuan->hasilPerhitungan)->not->toBeNull();

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        ->assertSee('DISETUJUI / TIDAK DISETUJUI')
        ->assertDontSee('<span class="tercoret">DISETUJUI</span>', false)
        ->assertDontSee('<span class="tercoret">TIDAK DISETUJUI</span>', false);
});

test('cetak setelah ditetapkan Disetujui: hanya "TIDAK DISETUJUI" tercoret', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));
    $pengajuan = Pengajuan::firstOrFail();

    $this->actingAs($this->petugas)
        ->post(route('keputusan.store', $pengajuan->hasilPerhitungan), ['keputusan_akhir' => 'diterima']);

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        ->assertSee('<span class="tercoret">TIDAK DISETUJUI</span>', false)
        ->assertDontSee('<span class="tercoret">DISETUJUI</span>', false);
});

test('cetak setelah ditetapkan Ditolak: hanya "DISETUJUI" tercoret', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));
    $pengajuan = Pengajuan::firstOrFail();

    $this->actingAs($this->petugas)
        ->post(route('keputusan.store', $pengajuan->hasilPerhitungan), ['keputusan_akhir' => 'ditolak']);

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        ->assertSee('<span class="tercoret">DISETUJUI</span>', false)
        ->assertDontSee('<span class="tercoret">TIDAK DISETUJUI</span>', false);
});

test('kop cetak memuat bulan romawi dan tahun berjalan (tanggal cetak dinamis)', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));
    $pengajuan = Pengajuan::firstOrFail();

    $romawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        // Nomor pokok BH tetap + bulan romawi & tahun mengikuti tanggal cetak
        ->assertSee('BH. 798 / BH / PAD / XIV . 30 / ' . $romawi[now()->month] . ' / ' . now()->year)
        ->assertSee(\App\Support\KopSurat::tanggal());
});

test('view cetak memuat aturan @page ukuran A4 potret untuk cetak 1 halaman', function () {
    $this->actingAs($this->petugas)
        ->post(route('pengajuan.store'), payloadAnalisis($this->nasabah->id_nasabah));
    $pengajuan = Pengajuan::firstOrFail();

    $this->actingAs($this->petugas)->get(route('pengajuan.cetak', $pengajuan))
        ->assertOk()
        ->assertSee('@page', false)
        ->assertSee('size: A4 portrait', false)
        ->assertSee('page-break-inside: avoid', false);
});

test('tanda tangan anggota & petugas tersimpan sebagai file PNG di storage', function () {
    Storage::fake('public');

    // PNG 1×1 valid sebagai dataURL dari x-signature-pad
    $dataUrl = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    $this->actingAs($this->petugas)->post(route('pengajuan.store'), payloadAnalisis(
        $this->nasabah->id_nasabah,
        ['ttd_anggota' => $dataUrl, 'ttd_petugas' => $dataUrl]
    ))->assertRedirect(route('hasil.index'));

    $pengajuan = Pengajuan::firstOrFail();
    expect($pengajuan->ttd_anggota)->toStartWith('ttd/');
    expect($pengajuan->ttd_petugas)->toStartWith('ttd/');
    Storage::disk('public')->assertExists($pengajuan->ttd_anggota);
    Storage::disk('public')->assertExists($pengajuan->ttd_petugas);
});
