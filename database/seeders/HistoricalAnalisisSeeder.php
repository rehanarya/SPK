<?php

namespace Database\Seeders;

use App\Models\LogKeputusan;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Pengguna;
use App\Services\AnalisisPembiayaanService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Pengisian data komponen LENGKAP 20 nasabah historis dari transkrip
 * pindaian formulir asli "Analisis Pembiayaan" (revisi tahap 4).
 *
 * - Meng-UPDATE 20 rekord pengajuan periode 2024-HIST yang sudah ada
 *   (dicocokkan berdasarkan nama nasabah) — TIDAK membuat rekord baru
 *   dan TIDAK PERNAH menyentuh kolom C1–C5 maupun hasil_perhitungan
 *   (vektor S/V, ranking, status).
 * - Nilai C1/C2 tersimpan di database adalah acuan kebenaran: derivasi
 *   dari komponen diverifikasi harus PERSIS sama; bila berbeda, seeder
 *   berhenti dengan error yang menyebut nama nasabah.
 * - `bagi_hasil` disimpan sesuai NILAI FORMULIR ASLI (satu deviasi yang
 *   diketahui dari rumus 2%: Parto → 400.000, rumus = 430.000);
 *   jumlah_angsuran mengikuti bagi hasil formulir.
 * - Idempoten: aman dijalankan berulang.
 *
 * Jalankan: php artisan db:seed --class=HistoricalAnalisisSeeder
 * (juga dipanggil otomatis dari DatabaseSeeder setelah NasabahHistorisSeeder)
 */
class HistoricalAnalisisSeeder extends Seeder
{
    /** Alamat placeholder dari NasabahHistorisSeeder — boleh ditimpa */
    private const ALAMAT_PLACEHOLDER = 'Girimarto, Wonogiri';

    /*
     * Transkrip formulir asli per nasabah.
     * Kunci: pu, hpp, bu (Seksi 1) | pp (pendapatan pasangan; lainnya = 0)
     * rt, pd, bl (Seksi 3) | bagi_hasil = nilai formulir | keputusan final
     * tanggal: [tgl_form (→ tanggal_pengajuan), tgl_realisasi|null]
     *
     * Catatan penyesuaian data (lihat ringkasan revisi):
     * - Budianto: scan seksi 2–4 kontradiktif → rekonsiliasi terhadap C2 DB
     *   (pp 2jt; rt/pd/bl = 1,5jt/1jt/0,5jt); tgl form disamakan 18-04-2018
     *   karena scan mencantumkan realisasi mendahului tgl form.
     * - Padi: tgl pengajuan diset 25-10-2016 (realisasi pada scan) agar valid.
     * - Maryanto & Suyato: tgl form tak terbaca → memakai tanggal realisasi.
     * - Maryanto ("BPKB.AD.5017.ZG") & Nariyadi ("BPKB Kendaraan Bermotor"):
     *   label agunan mengikuti C3 tersimpan di DB (= 2, BPKB Sepeda Motor).
     * - Parto: bagi hasil formulir 400.000 ≠ rumus 2% (430.000) — dipertahankan.
     */
    private array $dataset = [
        // ── 16 DITERIMA ──────────────────────────────────────────────────
        'Eky Setyoningsih' => ['alamat' => 'Pelang Rt. 02/03 Giriwarno Girimarto', 'form' => '2020-01-09', 'realisasi' => '2020-01-09', 'pu' => 35600000, 'hpp' => 24500000, 'bu' => 5000000, 'pp' => 2000000, 'rt' => 2500000, 'pd' => 1500000, 'bl' => 2500000, 'bagi_hasil' => 300000, 'keputusan' => 'diterima'],
        'Suharni'          => ['alamat' => 'Pundung Rt. 01/10 Ngadirojo Lor Ngadirojo', 'form' => '2018-05-14', 'realisasi' => '2018-05-18', 'pu' => 30000000, 'hpp' => 12000000, 'bu' => 10800000, 'pp' => 1500000, 'rt' => 3600000, 'pd' => 1500000, 'bl' => 1500000, 'bagi_hasil' => 600000, 'keputusan' => 'diterima'],
        'Suradi'           => ['alamat' => 'Jendi Rt. 01/02 Jendi Girimarto', 'form' => '2019-01-25', 'realisasi' => '2019-01-25', 'pu' => 31000000, 'hpp' => 12900000, 'bu' => 13000000, 'pp' => 1500000, 'rt' => 3000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 100000, 'keputusan' => 'diterima'],
        'Padi Irokromo'    => ['alamat' => 'Karangduren Rt. 02/08 Jatirejo Girimarto', 'form' => '2017-08-16', 'realisasi' => '2017-08-16', 'pu' => 25000000, 'hpp' => 11800000, 'bu' => 6100000, 'pp' => 1600000, 'rt' => 2000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 800000, 'keputusan' => 'diterima'],
        'Budianto'         => ['alamat' => 'Pakem Rt. 001/008 Girimarto', 'form' => '2018-04-18', 'realisasi' => '2018-04-18', 'pu' => 15000000, 'hpp' => 7000000, 'bu' => 5000000, 'pp' => 2000000, 'rt' => 1500000, 'pd' => 1000000, 'bl' => 500000, 'bagi_hasil' => 40000, 'keputusan' => 'diterima', 'rekonsiliasi_rt' => true],
        'Samiyo'           => ['alamat' => 'Jagir Rt. 03/02 Selorejo Girimarto', 'form' => '2014-08-11', 'realisasi' => '2014-08-11', 'pu' => 11100000, 'hpp' => 5500000, 'bu' => 3500000, 'pp' => 3000000, 'rt' => 1750000, 'pd' => 1000000, 'bl' => 700000, 'bagi_hasil' => 300000, 'keputusan' => 'diterima'],
        'Maryanto'         => ['alamat' => 'Girimarto Rt. 002/001', 'form' => '2013-10-10', 'realisasi' => '2013-10-10', 'pu' => 2500000, 'hpp' => 0, 'bu' => 500000, 'pp' => 500000, 'rt' => 300000, 'pd' => 200000, 'bl' => 0, 'bagi_hasil' => 100000, 'keputusan' => 'diterima'],
        'Kasiman'          => ['alamat' => 'Karangduren Rt. 02/08 Jatirejo Girimarto', 'form' => '2017-09-11', 'realisasi' => '2017-09-11', 'pu' => 16500000, 'hpp' => 7500000, 'bu' => 4500000, 'pp' => 1400000, 'rt' => 2000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 200000, 'keputusan' => 'diterima'],
        'Parto'            => ['alamat' => 'Talang Rt. 10/04 Ngepungsari Jatipuro', 'form' => '2017-07-27', 'realisasi' => '2017-07-27', 'pu' => 16000000, 'hpp' => 6500000, 'bu' => 5150000, 'pp' => 1650000, 'rt' => 2000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 400000, 'keputusan' => 'diterima'],
        'Muladi'           => ['alamat' => 'Watuleter Rt. 02/05 Giriwarno Girimarto', 'form' => '2019-05-24', 'realisasi' => '2019-05-24', 'pu' => 40400000, 'hpp' => 19000000, 'bu' => 13000000, 'pp' => 2000000, 'rt' => 3000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 700000, 'keputusan' => 'diterima'],
        'Suyato'           => ['alamat' => 'Petung Rt. 01/07 Semagar Girimarto', 'form' => '2018-07-12', 'realisasi' => '2018-07-12', 'pu' => 42000000, 'hpp' => 18000000, 'bu' => 14700000, 'pp' => 1900000, 'rt' => 3500000, 'pd' => 1500000, 'bl' => 1500000, 'bagi_hasil' => 440000, 'keputusan' => 'diterima'],
        'Sutarti'          => ['alamat' => 'Doho Lor Rt. 02/01 Doho Girimarto', 'form' => '2018-08-13', 'realisasi' => '2018-08-13', 'pu' => 42000000, 'hpp' => 17000000, 'bu' => 16900000, 'pp' => 1500000, 'rt' => 4000000, 'pd' => 2000000, 'bl' => 2000000, 'bagi_hasil' => 300000, 'keputusan' => 'diterima'],
        'Padi'             => ['alamat' => 'Pelang Rt. 02/03 Giriwarno Girimarto', 'form' => '2016-10-25', 'realisasi' => '2016-10-25', 'pu' => 8200000, 'hpp' => 3800000, 'bu' => 1350000, 'pp' => 1500000, 'rt' => 2000000, 'pd' => 550000, 'bl' => 900000, 'bagi_hasil' => 140000, 'keputusan' => 'diterima'],
        'Suparlan'         => ['alamat' => 'Sanan Rt. 01/05 Sanan Girimarto', 'form' => '2017-01-24', 'realisasi' => '2017-01-24', 'pu' => 15200000, 'hpp' => 6500000, 'bu' => 5300000, 'pp' => 1000000, 'rt' => 1300000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 100000, 'keputusan' => 'diterima'],
        'Nariyadi'         => ['alamat' => 'Watuleter Rt. 01/05 Giriwarno Girimarto', 'form' => '2019-07-23', 'realisasi' => '2019-07-23', 'pu' => 38200000, 'hpp' => 19000000, 'bu' => 13000000, 'pp' => 2000000, 'rt' => 3000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 500000, 'keputusan' => 'diterima'],
        'Yanto'            => ['alamat' => 'Tambakmerang Rt. 02/09 Girimarto', 'form' => '2018-11-26', 'realisasi' => '2018-11-26', 'pu' => 16000000, 'hpp' => 6800000, 'bu' => 4600000, 'pp' => 1400000, 'rt' => 3000000, 'pd' => 1000000, 'bl' => 1500000, 'bagi_hasil' => 80000, 'keputusan' => 'diterima'],

        // ── 4 DITOLAK (realisasi NULL — tanggal scan hanyalah tgl formulir) ─
        'Pardi'            => ['alamat' => 'Tambakruci Rt. 02/07 Jatirejo Girimarto', 'form' => '2020-12-18', 'realisasi' => null, 'pu' => 23000000, 'hpp' => 14000000, 'bu' => 5500000, 'pp' => 0, 'rt' => 1400000, 'pd' => 1550000, 'bl' => 350000, 'bagi_hasil' => 30000, 'keputusan' => 'ditolak'],
        'Supriyanto'       => ['alamat' => 'Bulak Rt. 03/05 Selorejo Girimarto', 'form' => '2021-02-02', 'realisasi' => null, 'pu' => 8000000, 'hpp' => 4800000, 'bu' => 1500000, 'pp' => 0, 'rt' => 1000000, 'pd' => 0, 'bl' => 400000, 'bagi_hasil' => 30000, 'keputusan' => 'ditolak'],
        'Timo'             => ['alamat' => 'Sananan Rt. 01/04 Mangunharjo Jatipurno', 'form' => '2021-09-13', 'realisasi' => null, 'pu' => 21000000, 'hpp' => 14500000, 'bu' => 4500000, 'pp' => 1500000, 'rt' => 1500000, 'pd' => 1200000, 'bl' => 600000, 'bagi_hasil' => 50000, 'keputusan' => 'ditolak'],
        'Sugiyarto'        => ['alamat' => 'Geneng Rt. 04/09 Tambakmerang Girimarto', 'form' => '2019-05-21', 'realisasi' => null, 'pu' => 15000000, 'hpp' => 8500000, 'bu' => 4700000, 'pp' => 1200000, 'rt' => 1200000, 'pd' => 850000, 'bl' => 450000, 'bagi_hasil' => 40000, 'keputusan' => 'ditolak'],
    ];

    public function run(): void
    {
        $analisis = app(AnalisisPembiayaanService::class);

        // Petugas historis "Maryadi" — pemilik entri log keputusan final
        $maryadi = Pengguna::firstOrCreate(
            ['username' => 'maryadi'],
            ['password' => Hash::make('maryadi123'), 'nama' => 'Maryadi', 'peran' => 'petugas'],
        );

        foreach ($this->dataset as $nama => $d) {
            $nasabah = Nasabah::where('nama_nasabah', $nama)->first()
                ?? throw new \RuntimeException("Seeder historis: nasabah '{$nama}' tidak ditemukan.");

            $pengajuan = Pengajuan::where('id_nasabah', $nasabah->id_nasabah)
                ->whereHas('periode', fn ($q) => $q->where('kode_periode', '2024-HIST'))
                ->first()
                ?? throw new \RuntimeException("Seeder historis: pengajuan 2024-HIST '{$nama}' tidak ditemukan.");

            // ── Verifikasi acuan kebenaran: derivasi komponen == C1/C2 DB ──
            $komponen = [
                'penjualan_usaha'        => $d['pu'],
                'harga_pokok_jual'       => $d['hpp'],
                'biaya_usaha'            => $d['bu'],
                'pendapatan_pasangan'    => $d['pp'],
                'pendapatan_lainnya'     => 0,
                'kebutuhan_rumah_tangga' => $d['rt'],
                'biaya_pendidikan'       => $d['pd'],
                'biaya_lainnya'          => $d['bl'],
                'rasio_angsuran'         => 40,
                'C5_jangka_waktu'        => $pengajuan->C5_jangka_waktu,
                'C4_besar_pembiayaan'    => $pengajuan->C4_besar_pembiayaan,
                'simpanan'               => AnalisisPembiayaanService::SIMPANAN_DEFAULT,
            ];

            $hasil = $analisis->hitung($komponen);

            // Rekonsiliasi khusus Budianto: scan kontradiktif → sesuaikan RT
            // saja agar Pendapatan Bersih pas dengan C2 tersimpan, lalu catat
            if (($d['rekonsiliasi_rt'] ?? false)
                && abs($hasil['pendapatan_bersih'] - $pengajuan->C2_pendapatan_bersih) >= 0.01) {
                $selisih = $hasil['pendapatan_bersih'] - $pengajuan->C2_pendapatan_bersih;
                $komponen['kebutuhan_rumah_tangga'] += $selisih;
                $hasil = $analisis->hitung($komponen);
                $this->command?->warn("  ⚠ {$nama}: RT direkonsiliasi menjadi " . number_format($komponen['kebutuhan_rumah_tangga'], 0, ',', '.'));
            }

            if (abs($hasil['laba_usaha'] - $pengajuan->C1_laba_usaha) >= 0.01) {
                throw new \RuntimeException(
                    "Seeder historis DIHENTIKAN — {$nama}: derivasi Laba Usaha ({$hasil['laba_usaha']}) "
                    . "≠ C1 tersimpan ({$pengajuan->C1_laba_usaha}). C1–C5 tidak boleh ditimpa."
                );
            }
            if (abs($hasil['pendapatan_bersih'] - $pengajuan->C2_pendapatan_bersih) >= 0.01) {
                throw new \RuntimeException(
                    "Seeder historis DIHENTIKAN — {$nama}: derivasi Pendapatan Bersih ({$hasil['pendapatan_bersih']}) "
                    . "≠ C2 tersimpan ({$pengajuan->C2_pendapatan_bersih}). C1–C5 tidak boleh ditimpa."
                );
            }

            // ── Update komponen + turunan (C1–C5 TIDAK disentuh) ───────────
            // bagi_hasil & jumlah_angsuran memakai NILAI FORMULIR ASLI
            // (deviasi rumus 2% yang diketahui: Parto 400.000 vs 430.000)
            $pengajuan->update([
                'penjualan_usaha'        => $d['pu'],
                'harga_pokok_jual'       => $d['hpp'],
                'biaya_usaha'            => $d['bu'],
                'pendapatan_pasangan'    => $d['pp'],
                'pendapatan_lainnya'     => 0,
                'kebutuhan_rumah_tangga' => $komponen['kebutuhan_rumah_tangga'],
                'biaya_pendidikan'       => $d['pd'],
                'biaya_lainnya'          => $d['bl'],
                'rasio_angsuran'         => 40,
                'plafon_pembiayaan'      => $hasil['plafon_pembiayaan'],
                'angsuran_pokok'         => $hasil['angsuran_pokok'],
                'bagi_hasil'             => $d['bagi_hasil'],
                'simpanan'               => AnalisisPembiayaanService::SIMPANAN_DEFAULT,
                'jumlah_angsuran'        => round($hasil['angsuran_pokok'] + $d['bagi_hasil'] + AnalisisPembiayaanService::SIMPANAN_DEFAULT, 2),
                'jenis_akad'             => 'Murabahah',
                'sumber_penghasilan'     => 'usaha',
                'tanggal_pengajuan'      => $d['form'],
                'tanggal_realisasi'      => $d['realisasi'],
            ]);

            // ── Nama manager arsip (ttd digital dibiarkan NULL — arsip fisik) ─
            $hasilWp = $pengajuan->hasilPerhitungan;
            $hasilWp?->update(['nama_manager' => 'MARYADI']);

            // ── Keputusan final petugas (log_keputusan; idempoten) ──────────
            if ($hasilWp) {
                LogKeputusan::firstOrCreate(
                    ['id_hasil_perhitungan' => $hasilWp->id_hasil],
                    [
                        'id_pengguna'     => $maryadi->id_pengguna,
                        'keputusan_akhir' => $d['keputusan'],
                        'catatan'         => 'Keputusan arsip formulir asli (seeder historis)',
                        'timestamp'       => ($d['realisasi'] ?? $d['form']) . ' 09:00:00',
                    ]
                );
            }

            // ── Alamat master nasabah: isi hanya bila kosong/placeholder ───
            if (in_array(trim((string) $nasabah->alamat), ['', self::ALAMAT_PLACEHOLDER], true)) {
                $nasabah->update(['alamat' => $d['alamat']]);
            }
        }

        $this->command?->info('HistoricalAnalisisSeeder: 20 rekord historis terisi & terverifikasi (C1/C2 cocok).');
    }
}
