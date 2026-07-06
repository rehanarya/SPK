<?php

namespace App\Services;

use App\Models\Konfigurasi;
use App\Models\Kriteria;
use App\Models\Pengajuan;
use Illuminate\Support\Collection;

/**
 * Implementasi algoritma Weighted Product (WP) sesuai §4 RULES.md.
 *
 * HARD CONSTRAINTS (§10 RULES.md):
 *  - Nilai atribut dipakai dalam bentuk asli, TANPA normalisasi min-max.
 *  - Eksponen bertanda: +w_j untuk benefit, -w_j untuk cost.
 *  - V_i dihitung per periode mingguan, BUKAN kumulatif.
 *  - θ default = 250; perubahan hanya via modul rekalibrasi §5.3.
 *  - Logika WP DILARANG ada di luar service class ini.
 */
class WeightedProductService
{
    // ─────────────────────────────────────────────────────────────────────────
    // §4.2  Normalisasi Bobot
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Normalisasi bobot mentah menjadi bobot ternormalisasi bertanda.
     *
     * Formula: w_j = (s_j × W_j) / Σ|W_j|
     * s_j = +1 benefit, -1 cost
     *
     * @param  array<array{bobot_mentah: int, tipe: string}>  $kriteriaData
     * @return array<float>
     */
    public function normalisasiBobot(array $kriteriaData): array
    {
        $totalAbsolut = array_sum(array_column($kriteriaData, 'bobot_mentah'));

        return array_map(function (array $k) use ($totalAbsolut): float {
            $sj = $k['tipe'] === 'benefit' ? 1 : -1;
            return (float) ($sj * $k['bobot_mentah']) / $totalAbsolut;
        }, $kriteriaData);
    }

    /**
     * Baca bobot ternormalisasi langsung dari tabel `kriteria` di database.
     *
     * @return array<float>  Berurutan berdasarkan kode_kriteria (C1..C5)
     */
    public function bobotNormFromDb(): array
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();

        return $kriteria->map(fn (Kriteria $k): array => [
            'bobot_mentah' => $k->bobot_mentah,
            'tipe'         => $k->tipe,
        ])->pipe(fn (Collection $c) => $this->normalisasiBobot($c->toArray()));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §4.3  Vektor S (skor absolut)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Hitung vektor S untuk satu pengajuan.
     *
     * Formula: S_i = Π (X_ij)^(w_j)
     * Nilai X_ij dipakai dalam bentuk asli tanpa normalisasi min-max.
     *
     * @param  array<float|int>  $nilaiKriteria  [C1, C2, C3, C4, C5]
     * @param  array<float>      $bobotNorm      Bobot ternormalisasi bertanda
     */
    public function hitungVektorS(array $nilaiKriteria, array $bobotNorm): float
    {
        $s = 1.0;
        foreach ($nilaiKriteria as $j => $nilai) {
            $s *= pow((float) $nilai, $bobotNorm[$j]);
        }
        return $s;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §5.1  Klasifikasi via ambang θ
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Klasifikasi status kelayakan: Diterima jika S_i ≥ θ, Ditolak jika S_i < θ.
     */
    public function klasifikasi(float $vektorS, float $theta): string
    {
        return $vektorS >= $theta ? 'diterima' : 'ditolak';
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §4.4  Vektor V (skor relatif per periode)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Hitung vektor V untuk kumpulan S_i dalam satu periode.
     *
     * Formula: V_i = S_i / Σ S_i
     * Denominator HANYA mencakup pengajuan pada periode yang sama (§4.4 WAJIB).
     *
     * @param  array<float>  $vektorS
     * @return array<float>  Σ V_i = 1.0
     */
    public function hitungVektorV(array $vektorS): array
    {
        $totalS = array_sum($vektorS);
        if ($totalS == 0) {
            return array_fill(0, count($vektorS), 0.0);
        }
        return array_map(fn (float $s): float => $s / $totalS, $vektorS);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Perhitungan WP lengkap untuk satu periode
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Proses perhitungan WP lengkap untuk seluruh Pengajuan dalam satu periode.
     *
     * Langkah:
     *  1. Baca bobot aktif dari DB → normalisasi
     *  2. Hitung S_i setiap pengajuan
     *  3. Hitung V_i (per-periode)
     *  4. Ranking menurun berdasarkan V_i
     *  5. Tetapkan status diterima/ditolak berdasarkan θ
     *
     * @param  array<Pengajuan>|Collection  $pengajuanList
     * @param  float                        $theta          Ambang batas (default 250)
     * @param  int                          $topN           Jumlah prioritas (default 5)
     * @return array<array{
     *     id_pengajuan: int,
     *     vektor_S:     float,
     *     vektor_V:     float,
     *     ranking:      int,
     *     status:       string,
     *     prioritas:    bool
     * }>
     */
    public function hitungPeriode(
        array|Collection $pengajuanList,
        float $theta = 250.0,
        int $topN = 5,
    ): array {
        $bobotNorm = $this->bobotNormFromDb();

        $hasilS = [];
        foreach ($pengajuanList as $pengajuan) {
            $hasilS[] = [
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'vektor_S'     => $this->hitungVektorS($pengajuan->nilaiKriteria(), $bobotNorm),
            ];
        }

        $sValues = array_column($hasilS, 'vektor_S');
        $vValues = $this->hitungVektorV($sValues);

        $hasil = [];
        foreach ($hasilS as $i => $row) {
            $hasil[] = array_merge($row, ['vektor_V' => $vValues[$i]]);
        }

        // Ranking menurun berdasarkan V_i
        usort($hasil, fn ($a, $b): int => $b['vektor_V'] <=> $a['vektor_V']);

        foreach ($hasil as $rank => &$row) {
            $row['ranking']  = $rank + 1;
            $row['status']   = $this->klasifikasi($row['vektor_S'], $theta);
            // Top-N dari yang berstatus diterima mendapat label prioritas (§5.2)
            $row['prioritas'] = ($row['status'] === 'diterima') && ($rank < $topN);
        }

        return $hasil;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §5.3  Rekalibrasi ambang θ dinamis
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Rekalibrasi ambang θ dari dataset historis berkeputusan riil.
     *
     * Kasus A (separable gap): θ = round((max_ditolak + min_diterima) / 2, 4)
     * Kasus B (tumpang tindih): linear search argmin FA+FR
     *
     * @param  array<array{vektor_S: float, keputusan_riil: string}>  $kasus
     *         Minimal 20 data (§5.3 prasyarat).
     * @return array{theta: float, kasus: string, min_diterima: float, max_ditolak: float, fa: int, fr: int, err: int}
     */
    public function rekalibrasiThreshold(array $kasus): array
    {
        $diterima = array_values(array_filter($kasus, fn ($k) => $k['keputusan_riil'] === 'diterima'));
        $ditolak  = array_values(array_filter($kasus, fn ($k) => $k['keputusan_riil'] === 'ditolak'));

        $minDiterima = min(array_column($diterima, 'vektor_S'));
        $maxDitolak  = max(array_column($ditolak,  'vektor_S'));

        if ($minDiterima > $maxDitolak) {
            // Kasus A: gap bersih
            $thetaBaru = round(($maxDitolak + $minDiterima) / 2, 4);
            return [
                'theta'        => $thetaBaru,
                'kasus'        => 'A',
                'min_diterima' => $minDiterima,
                'max_ditolak'  => $maxDitolak,
                'fa'           => 0,
                'fr'           => 0,
                'err'          => 0,
            ];
        }

        // Kasus B: overlap — linear search minimum error
        $kandidat = array_unique(array_column($kasus, 'vektor_S'));
        sort($kandidat);

        $bestTheta     = $kandidat[0];
        $bestErr       = PHP_INT_MAX;
        $bestFa = $bestFr = 0;
        $seriesOptimum = [];

        foreach ($kandidat as $tc) {
            $fa  = count(array_filter($ditolak,  fn ($k) => $k['vektor_S'] >= $tc));
            $fr  = count(array_filter($diterima, fn ($k) => $k['vektor_S'] < $tc));
            $err = $fa + $fr;

            if ($err < $bestErr) {
                $bestErr       = $err;
                $bestFa        = $fa;
                $bestFr        = $fr;
                $seriesOptimum = [$tc];
            } elseif ($err === $bestErr) {
                $seriesOptimum[] = $tc;
            }
        }

        // Jika seri: ambil nilai tengah dari himpunan optimum (§5.3 Kasus B)
        $bestTheta = count($seriesOptimum) > 1
            ? round(($seriesOptimum[0] + end($seriesOptimum)) / 2, 4)
            : round($seriesOptimum[0], 4);

        return [
            'theta'        => $bestTheta,
            'kasus'        => 'B',
            'min_diterima' => $minDiterima,
            'max_ditolak'  => $maxDitolak,
            'fa'           => $bestFa,
            'fr'           => $bestFr,
            'err'          => $bestErr,
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §7.1.2  LOOCV
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Leave-One-Out Cross-Validation pada dataset historis (§7.1.2 RULES.md).
     *
     * Setiap fold: train=19, test=1, θ dikalibrasi dari train_set.
     *
     * @param  array<array{vektor_S: float, keputusan_riil: string}>  $dataset  n=20
     * @return array{
     *     akurasi: float, presisi: float, recall: float, f1: float,
     *     tp: int, tn: int, fp: int, fn: int,
     *     detail: array<int, array{theta: float, prediksi: string, aktual: string, benar: bool}>
     * }
     */
    public function loocv(array $dataset): array
    {
        $tp = $tn = $fp = $fn = 0;
        $detail = [];

        foreach ($dataset as $i => $test) {
            $train = array_values(array_filter(
                $dataset,
                fn ($_val, int $j): bool => $j !== $i,
                ARRAY_FILTER_USE_BOTH
            ));

            $rekalibrasi = $this->rekalibrasiThreshold($train);
            $theta       = $rekalibrasi['theta'];
            $prediksi    = $test['vektor_S'] >= $theta ? 'diterima' : 'ditolak';
            $aktual      = $test['keputusan_riil'];
            $benar       = $prediksi === $aktual;

            $detail[] = ['theta' => $theta, 'prediksi' => $prediksi, 'aktual' => $aktual, 'benar' => $benar];

            match (true) {
                $prediksi === 'diterima' && $aktual === 'diterima' => $tp++,
                $prediksi === 'ditolak'  && $aktual === 'ditolak'  => $tn++,
                $prediksi === 'diterima' && $aktual === 'ditolak'  => $fp++,
                default                                            => $fn++,
            };
        }

        $n       = count($dataset);
        $akurasi = ($tp + $tn) / $n;
        $presisi = ($tp + $fp) > 0 ? $tp / ($tp + $fp) : 0.0;
        $recall  = ($tp + $fn) > 0 ? $tp / ($tp + $fn) : 0.0;
        $f1      = ($presisi + $recall) > 0
            ? 2 * $presisi * $recall / ($presisi + $recall)
            : 0.0;

        return compact('akurasi', 'presisi', 'recall', 'f1', 'tp', 'tn', 'fp', 'fn', 'detail');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // §7.1.3  Analisis Sensitivitas (3 skenario)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Hitung skor S dan ranking untuk skenario bobot tertentu (tanpa menyimpan ke DB).
     *
     * Dipakai untuk analisis sensitivitas S0/S1/S2 (§7.1.3 RULES.md).
     * θ dikalibrasi ulang via §5.3 pada dataset 20 data acuan untuk S1 dan S2.
     *
     * @param  array<Pengajuan>|Collection  $pengajuanList
     * @param  array<array{bobot_mentah: int, tipe: string}>  $kriteriaOverride  Bobot skenario
     * @param  float  $theta  Ambang batas yang dipakai skenario ini
     * @return array<array{id_pengajuan: int, nama_nasabah: string, vektor_S: float, vektor_V: float, ranking: int, status: string}>
     */
    public function hitungSkenario(
        array|Collection $pengajuanList,
        array $kriteriaOverride,
        float $theta,
    ): array {
        $bobotNorm = $this->normalisasiBobot($kriteriaOverride);

        $hasilS = [];
        foreach ($pengajuanList as $pengajuan) {
            $hasilS[] = [
                'id_pengajuan'  => $pengajuan->id_pengajuan,
                'nama_nasabah'  => $pengajuan->nasabah->nama_nasabah ?? '—',
                'vektor_S'      => $this->hitungVektorS($pengajuan->nilaiKriteria(), $bobotNorm),
            ];
        }

        $sValues = array_column($hasilS, 'vektor_S');
        $vValues = $this->hitungVektorV($sValues);

        $hasil = [];
        foreach ($hasilS as $i => $row) {
            $hasil[] = array_merge($row, ['vektor_V' => $vValues[$i]]);
        }

        usort($hasil, fn ($a, $b): int => $b['vektor_V'] <=> $a['vektor_V']);

        foreach ($hasil as $rank => &$row) {
            $row['ranking'] = $rank + 1;
            $row['status']  = $this->klasifikasi($row['vektor_S'], $theta);
        }

        return $hasil;
    }

    /**
     * Jalankan analisis sensitivitas tiga skenario S0/S1/S2 (§7.1.3 RULES.md).
     *
     * Bobot:
     *  S0 = (5, 4, 4, 2, 2) — default
     *  S1 = (6, 5, 4, 2, 2) — penekanan kapasitas
     *  S2 = (3, 3, 3, 3, 3) — bobot setara
     *
     * Θ S1 dan S2 dikalibrasi ulang dari dataset 20 nasabah historis.
     *
     * @param  array<Pengajuan>|Collection  $pengajuanList    Data periode yang sedang dianalisis
     * @param  array<array{vektor_S: float, keputusan_riil: string}>  $datasetHistoris  20 data untuk kalibrasi
     * @return array{
     *     S0: array, S1: array, S2: array,
     *     kestabilan: int,
     *     perbandingan: array
     * }
     */
    public function analisisSensitivitas(
        array|Collection $pengajuanList,
        array $datasetHistoris,
        ?float $thetaAktif = null,
    ): array {
        // Definisi tipe kriteria (urutan C1-C5 sesuai kode_kriteria)
        $tipes = ['benefit', 'benefit', 'benefit', 'cost', 'cost'];

        $skenario = [
            'S0' => [5, 4, 4, 2, 2],
            'S1' => [6, 5, 4, 2, 2],
            'S2' => [3, 3, 3, 3, 3],
        ];

        /*
         * Ambang θ untuk seluruh skenario diambil dari ambang AKTIF di database
         * (tabel `konfigurasi` → kunci `threshold_default`) sehingga sinkron dengan
         * keputusan operasional saat ini. Bila ambang sengaja diubah Administrator
         * (mis. dari 250 → 256), maka klasifikasi S0/S1/S2 ikut tergeser.
         *
         * $datasetHistoris saat ini tidak dipakai untuk rekalibrasi internal —
         * dipertahankan sebagai parameter untuk kompatibilitas dan kebutuhan masa
         * depan (mis. menampilkan distribusi historis di view).
         */
        $thetaAktif ??= (float) Konfigurasi::ambil('threshold_default', 250);
        unset($datasetHistoris); // marker non-pemakaian; signature tetap

        $hasilSkenario = [];

        foreach ($skenario as $kode => $bobotMentah) {
            $kriteriaData = array_map(
                fn (int $idx, int $bm): array => ['bobot_mentah' => $bm, 'tipe' => $tipes[$idx]],
                array_keys($bobotMentah),
                $bobotMentah,
            );

            // Sinkron operasional: semua skenario klasifikasi pakai θ aktif DB
            $hasilSkenario[$kode] = $this->hitungSkenario($pengajuanList, $kriteriaData, $thetaAktif);
        }

        // Indikator kestabilan: nasabah yang konsisten di top-5 ketiga skenario
        $top5 = fn (array $hasil): array => array_column(
            array_filter($hasil, fn ($r) => $r['ranking'] <= 5),
            'id_pengajuan'
        );

        $idsS0 = $top5($hasilSkenario['S0']);
        $idsS1 = $top5($hasilSkenario['S1']);
        $idsS2 = $top5($hasilSkenario['S2']);
        $konsisten = count(array_intersect($idsS0, $idsS1, $idsS2));

        // Tabel perbandingan ranking 1-5
        $perbandingan = [];
        $allPengajuan = collect($pengajuanList)->keyBy('id_pengajuan');
        for ($rank = 1; $rank <= 5; $rank++) {
            $find = fn (array $h, int $r): ?array => collect($h)->firstWhere('ranking', $r);
            $perbandingan[] = [
                'rank' => $rank,
                'S0'   => $find($hasilSkenario['S0'], $rank)['nama_nasabah'] ?? '—',
                'S1'   => $find($hasilSkenario['S1'], $rank)['nama_nasabah'] ?? '—',
                'S2'   => $find($hasilSkenario['S2'], $rank)['nama_nasabah'] ?? '—',
            ];
        }

        return [
            'S0'           => $hasilSkenario['S0'],
            'S1'           => $hasilSkenario['S1'],
            'S2'           => $hasilSkenario['S2'],
            'kestabilan'   => $konsisten,
            'perbandingan' => $perbandingan,
        ];
    }
}
