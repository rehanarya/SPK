<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanRequest;
use App\Models\AuditLog;
use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\Pengajuan;
use App\Models\Periode;
use App\Services\AnalisisPembiayaanService;
use App\Services\WeightedProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Mengelola input pengajuan baru dan memicu kalkulasi WP otomatis.
 *
 * Alur (revisi pasca-sidang — formulir "Analisis Pembiayaan"):
 *   1. Petugas mengisi formulir manual lengkap (Seksi 1–6, Usulan, Persetujuan)
 *   2. Server menghitung laba usaha, pendapatan bersih, plafon, dan angsuran
 *      via AnalisisPembiayaanService — C1 & C2 diisi dari hasil hitung ini
 *   3. Pada submit: simpan ke tabel pengajuan
 *   4. Hitung WP seluruh periode aktif (ulang semua agar V_i konsisten §4.4)
 *   5. Simpan hasil ke hasil_perhitungan + catat ke audit_log
 */
class PenilaianController extends Controller
{
    public function __construct(
        private WeightedProductService $wp,
        private AnalisisPembiayaanService $analisis,
        private \App\Services\TandaTanganService $tandaTangan,
    ) {}

    // ── Tampilan form input pengajuan baru ───────────────────────────────────

    public function create(): View|RedirectResponse
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('pengajuan.index')
                ->with('warning', 'Tidak ada periode aktif. Hubungi Administrator.');
        }

        $nasabahList = \App\Models\Nasabah::orderBy('nama_nasabah')->get();
        $kriteriaList = \App\Models\Kriteria::orderBy('kode_kriteria')->get();

        return view('penilaian.create', compact('periodeAktif', 'nasabahList', 'kriteriaList'));
    }

    // ── Simpan pengajuan + trigger kalkulasi WP ──────────────────────────────

    public function store(PengajuanRequest $request): RedirectResponse
    {
        $periodeAktif = Periode::where('status', 'aktif')->firstOrFail();

        // Cegah duplikasi nasabah dalam satu periode
        $duplikat = Pengajuan::where('id_nasabah', $request->validated('id_nasabah'))
            ->where('id_periode', $periodeAktif->id_periode)
            ->exists();

        if ($duplikat) {
            return back()->withInput()
                ->withErrors(['id_nasabah' => 'Nasabah ini sudah mengajukan pada periode aktif.']);
        }

        [$data, $peringatanPlafon] = $this->susunDataPengajuan($request);

        DB::transaction(function () use ($data, $periodeAktif) {
            // 1. Simpan pengajuan (C1 & C2 hasil hitung server-side)
            $pengajuan = Pengajuan::create(array_merge($data, [
                'id_periode' => $periodeAktif->id_periode,
            ]));

            // 2. Hitung ulang WP seluruh pengajuan periode ini agar V_i konsisten
            $this->hitungUlangPeriode($periodeAktif->id_periode);

            // 3. Catat audit
            AuditLog::create([
                'id_pengguna' => Auth::id(),
                'aksi'        => 'input_pengajuan',
                'modul'       => 'penilaian',
                'detail'      => ['id_pengajuan' => $pengajuan->id_pengajuan, 'id_nasabah' => $data['id_nasabah']],
                'ip_address'  => request()->ip(),
                'created_at'  => now(),
            ]);
        });

        $redirect = redirect()->route('hasil.index')
            ->with('success', 'Pengajuan berhasil disimpan dan kalkulasi WP telah diperbarui.');

        if ($peringatanPlafon !== null) {
            $redirect->with('warning', $peringatanPlafon);
        }

        return $redirect;
    }

    // ── Form edit pengajuan ───────────────────────────────────────────────────

    public function edit(Pengajuan $pengajuan): View
    {
        $pengajuan->load(['nasabah', 'periode', 'hasilPerhitungan']);

        /*
         * Rekord historis (komponen NULL) tetap memakai formulir LENGKAP:
         * komponen di-prefill dari kriteria tersimpan dengan pemetaan yang
         * mereproduksi C1 & C2 persis, sehingga menyimpan tanpa mengubah
         * angka tidak menggeser skor:
         *   Penjualan Usaha = Laba Usaha (C1); HPP = Biaya Usaha = 0
         *   Kebutuhan Rmh. Tangga = C1 − C2 → Pendapatan Bersih = C2
         * (prefill hanya di memori — tersimpan ke DB saat form disimpan)
         */
        $isHistoris = ! $pengajuan->punyaRincianAnalisis();
        if ($isHistoris) {
            $pengajuan->fill([
                'penjualan_usaha'        => $pengajuan->C1_laba_usaha,
                'harga_pokok_jual'       => 0,
                'biaya_usaha'            => 0,
                'pendapatan_pasangan'    => 0,
                'pendapatan_lainnya'     => 0,
                'kebutuhan_rumah_tangga' => max(0, $pengajuan->C1_laba_usaha - $pengajuan->C2_pendapatan_bersih),
                'biaya_pendidikan'       => 0,
                'biaya_lainnya'          => 0,
                'rasio_angsuran'         => AnalisisPembiayaanService::RASIO_DEFAULT,
                'simpanan'               => AnalisisPembiayaanService::SIMPANAN_DEFAULT,
            ]);
        }

        $nasabahList  = \App\Models\Nasabah::orderBy('nama_nasabah')->get();
        $kriteriaList = \App\Models\Kriteria::orderBy('kode_kriteria')->get();

        return view('penilaian.edit', compact('pengajuan', 'nasabahList', 'kriteriaList', 'isHistoris'));
    }

    // ── Perbarui pengajuan + hitung ulang WP periodenya ──────────────────────

    public function update(PengajuanRequest $request, Pengajuan $pengajuan): RedirectResponse
    {
        // Cegah duplikasi nasabah dalam periode yang sama (kecuali dirinya sendiri)
        $duplikat = Pengajuan::where('id_nasabah', $request->validated('id_nasabah'))
            ->where('id_periode', $pengajuan->id_periode)
            ->where('id_pengajuan', '!=', $pengajuan->id_pengajuan)
            ->exists();

        if ($duplikat) {
            return back()->withInput()
                ->withErrors(['id_nasabah' => 'Nasabah ini sudah memiliki pengajuan lain pada periode yang sama.']);
        }

        [$data, $peringatanPlafon] = $this->susunDataPengajuan($request);

        // Potret kondisi sebelum edit — untuk ringkasan skor lama → baru
        $kriteriaLama = $pengajuan->nilaiKriteria();
        $hasilLama    = $pengajuan->hasilPerhitungan()->first();
        $skorLama     = $hasilLama?->vektor_S;
        $statusLama   = $hasilLama?->status;

        DB::transaction(function () use ($request, $data, $pengajuan) {
            $pengajuan->fill($data)->save();

            // Nilai kriteria (mungkin) berubah → hitung ulang S, V, status
            // rekomendasi seluruh periode via alur WP yang sudah ada (§4.4)
            $this->hitungUlangPeriode($pengajuan->id_periode);

            // Realisasi & tanda tangan Manager (seksi bawah form edit)
            $this->simpanRealisasiManager($request, $pengajuan);
        });

        $pengajuan->refresh();
        $hasilBaru       = $pengajuan->hasilPerhitungan()->first();
        $kriteriaBerubah = $pengajuan->nilaiKriteria() != $kriteriaLama;

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'ubah_pengajuan',
            'modul'       => 'penilaian',
            'detail'      => [
                'id_pengajuan'     => $pengajuan->id_pengajuan,
                'id_nasabah'       => $data['id_nasabah'],
                'kriteria_berubah' => $kriteriaBerubah,
                'skor_lama'        => $skorLama,
                'skor_baru'        => $hasilBaru?->vektor_S,
                'status_lama'      => $statusLama,
                'status_baru'      => $hasilBaru?->status,
            ],
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);

        $redirect = redirect()->route('hasil.index')
            ->with('success', 'Pengajuan berhasil diperbarui dan kalkulasi WP telah diperbarui.');

        $peringatan = array_filter([$peringatanPlafon]);

        // Ringkasan hitung ulang bila nilai kriteria C1–C5 berubah
        if ($kriteriaBerubah && $hasilLama && $hasilBaru) {
            $redirect->with('info', sprintf(
                'Nilai kriteria berubah — skor dihitung ulang: S %s → %s; status rekomendasi %s → %s.',
                number_format((float) $skorLama, 2, ',', '.'),
                number_format((float) $hasilBaru->vektor_S, 2, ',', '.'),
                strtoupper((string) $statusLama),
                strtoupper((string) $hasilBaru->status),
            ));

            // Keputusan final petugas TIDAK diubah otomatis — beri peringatan
            // bila status rekomendasi bergeser setelah keputusan ditetapkan
            $adaKeputusanFinal = $hasilBaru->logKeputusan()->exists();
            if ($adaKeputusanFinal && $hasilBaru->status !== $statusLama) {
                $peringatan[] = 'Status rekomendasi sistem berubah, namun keputusan final petugas tidak diubah otomatis — '
                    . 'silakan tinjau ulang keputusan di menu Penetapan Keputusan.';
            }
        }

        if ($peringatan !== []) {
            $redirect->with('warning', implode(' ', $peringatan));
        }

        return $redirect;
    }

    /**
     * Simpan tanggal realisasi sudah ikut lewat fill(); bagian ini khusus
     * nama + tanda tangan Manager yang tinggal di hasil_perhitungan.
     */
    private function simpanRealisasiManager(PengajuanRequest $request, Pengajuan $pengajuan): void
    {
        $hasil = $pengajuan->hasilPerhitungan()->first();

        if (! $hasil) {
            return;
        }

        $update = [];

        if ($nama = $request->validated('nama_manager')) {
            $update['nama_manager'] = $nama;
        }

        // Tanda tangan baru menggantikan yang lama; kosong = pertahankan lama
        if ($path = $this->tandaTangan->simpan($request->validated('ttd_manager'), 'ttd_manager')) {
            $update['ttd_manager'] = $path;
        }

        if ($update !== []) {
            $hasil->update($update);
        }
    }

    // ── Halaman cetak formulir Analisis Pembiayaan ───────────────────────────

    public function cetak(Pengajuan $pengajuan): View
    {
        $pengajuan->load(['nasabah', 'periode', 'hasilPerhitungan.logKeputusan']);

        return view('penilaian.cetak', [
            'pengajuan' => $pengajuan,
            'petugas'   => Auth::user(),
        ]);
    }

    /**
     * Susun atribut pengajuan dari request tervalidasi.
     *
     * Mode 'analisis': seluruh nilai turunan (C1, C2, plafon, angsuran) dihitung
     * server-side via AnalisisPembiayaanService — nilai kiriman klien untuk field
     * hasil hitung diabaikan. Mode 'langsung' (fallback historis): kriteria
     * dipakai apa adanya seperti perilaku lama.
     *
     * @return array{0: array<string, mixed>, 1: ?string}  [data, pesan peringatan plafon]
     */
    private function susunDataPengajuan(PengajuanRequest $request): array
    {
        $data = $request->validated();
        // mode_input bukan kolom; nama/ttd manager tinggal di hasil_perhitungan
        // dan ditangani terpisah oleh simpanRealisasiManager()
        unset($data['mode_input'], $data['nama_manager'], $data['ttd_manager']);

        if (! $request->modeAnalisis()) {
            return [$data, null];
        }

        // Tanda tangan digital: konversi dataURL → file PNG; bila kosong,
        // jangan menimpa tanda tangan yang sudah tersimpan (saat update)
        foreach (['ttd_anggota', 'ttd_petugas'] as $ttd) {
            $path = $this->tandaTangan->simpan($data[$ttd] ?? null, $ttd);
            if ($path !== null) {
                $data[$ttd] = $path;
            } else {
                unset($data[$ttd]);
            }
        }

        $hasil = $this->analisis->hitung($data);

        $data['C1_laba_usaha']        = $hasil['laba_usaha'];
        $data['C2_pendapatan_bersih'] = $hasil['pendapatan_bersih'];
        $data['plafon_pembiayaan']    = $hasil['plafon_pembiayaan'];
        $data['angsuran_pokok']       = $hasil['angsuran_pokok'];
        $data['bagi_hasil']           = $hasil['bagi_hasil'];   // 2% × C4, abaikan kiriman klien
        $data['jumlah_angsuran']      = $hasil['jumlah_angsuran'];

        // Melebihi plafon TIDAK memblokir — keputusan tetap di tangan petugas
        $peringatan = null;
        if ((float) $data['C4_besar_pembiayaan'] > $hasil['plafon_pembiayaan']) {
            $peringatan = sprintf(
                'Perhatian: Besarnya Pembiayaan (Rp %s) melebihi plafon hasil hitung (Rp %s). Pengajuan tetap tersimpan — keputusan akhir di tangan petugas.',
                number_format((float) $data['C4_besar_pembiayaan'], 0, ',', '.'),
                number_format($hasil['plafon_pembiayaan'], 0, ',', '.')
            );
        }

        return [$data, $peringatan];
    }

    // ── Eksekusi hitung WP untuk periode aktif (endpoint manual) ────────────

    public function hitungWP(Request $request): RedirectResponse
    {
        $periodeAktif = Periode::where('status', 'aktif')->firstOrFail();

        DB::transaction(function () use ($periodeAktif) {
            $this->hitungUlangPeriode($periodeAktif->id_periode);

            AuditLog::create([
                'id_pengguna' => Auth::id(),
                'aksi'        => 'eksekusi_wp',
                'modul'       => 'perhitungan',
                'detail'      => ['id_periode' => $periodeAktif->id_periode, 'kode' => $periodeAktif->kode_periode],
                'ip_address'  => request()->ip(),
                'created_at'  => now(),
            ]);
        });

        return redirect()->route('hasil.index')
            ->with('success', 'Kalkulasi WP periode ' . $periodeAktif->kode_periode . ' selesai.');
    }

    // ── Tampilan halaman hitung WP ────────────────────────────────────────────

    public function indexWP(): View|RedirectResponse
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('dashboard')
                ->with('warning', 'Tidak ada periode aktif.');
        }

        $pengajuanList = Pengajuan::with('nasabah')
            ->where('id_periode', $periodeAktif->id_periode)
            ->get();

        $hasilList = HasilPerhitungan::with(['pengajuan.nasabah'])
            ->whereHas('pengajuan', fn ($q) => $q->where('id_periode', $periodeAktif->id_periode))
            ->orderBy('ranking')
            ->get();

        $kriteriaList = \App\Models\Kriteria::orderBy('kode_kriteria')->get();

        return view('penilaian.wp', compact('periodeAktif', 'pengajuanList', 'hasilList', 'kriteriaList'));
    }

    // ── Helper: hitung ulang semua WP untuk satu periode ────────────────────

    private function hitungUlangPeriode(int $idPeriode): void
    {
        $theta = (float) Konfigurasi::ambil('threshold_default', 250);
        $topN  = (int) Konfigurasi::ambil('top_n_prioritas', 5);

        $pengajuanList = Pengajuan::where('id_periode', $idPeriode)->get();

        if ($pengajuanList->isEmpty()) {
            return;
        }

        $hasilList = $this->wp->hitungPeriode($pengajuanList, $theta, $topN);

        foreach ($hasilList as $hasil) {
            HasilPerhitungan::updateOrCreate(
                ['id_pengajuan' => $hasil['id_pengajuan']],
                [
                    'vektor_S'   => $hasil['vektor_S'],
                    'vektor_V'   => $hasil['vektor_V'],
                    'ranking'    => $hasil['ranking'],
                    'status'     => $hasil['status'],
                    'created_at' => now(),
                ]
            );
        }
    }
}
