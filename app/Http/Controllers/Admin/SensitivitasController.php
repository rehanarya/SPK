<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\LogKeputusan;
use App\Models\Pengajuan;
use App\Models\Periode;
use App\Services\WeightedProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Analisis sensitivitas tiga skenario bobot (§7.1.3 RULES.md).
 *
 * S0 = (5, 4, 4, 2, 2) — default
 * S1 = (6, 5, 4, 2, 2) — penekanan kapasitas
 * S2 = (3, 3, 3, 3, 3) — bobot setara
 */
class SensitivitasController extends Controller
{
    // Definisi skenario sesuai §7.1.3 — TIDAK boleh diubah di kode keras
    private const SKENARIO = [
        'S0' => ['label' => 'Bobot Asli',          'bobot' => [5, 4, 4, 2, 2]],
        'S1' => ['label' => 'Penekanan Kapasitas',  'bobot' => [6, 5, 4, 2, 2]],
        'S2' => ['label' => 'Bobot Setara',         'bobot' => [3, 3, 3, 3, 3]],
    ];

    public function __construct(private WeightedProductService $wp) {}

    public function index(Request $request): View
    {
        $periodeAktif  = Periode::where('status', 'aktif')->first();
        $pengajuanList = $periodeAktif
            ? Pengajuan::with('nasabah')->where('id_periode', $periodeAktif->id_periode)->get()
            : collect();

        // Dataset historis dipertahankan untuk distribusi (tidak dipakai rekalibrasi internal lagi)
        $datasetHistoris = $this->datasetHistoris();

        // Ambil ambang AKTIF dari database — sinkron dengan modul operasional
        $thetaAktif = (float) Konfigurasi::ambil('threshold_default', 250);

        $analisis = null;
        if ($pengajuanList->isNotEmpty()) {
            $analisis = $this->wp->analisisSensitivitas($pengajuanList, $datasetHistoris, $thetaAktif);
        }

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'lihat_sensitivitas',
            'modul'       => 'sensitivitas',
            'detail'      => [
                'id_periode'  => $periodeAktif?->id_periode,
                'theta_aktif' => $thetaAktif,
            ],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return view('admin.sensitivitas.index', compact(
            'periodeAktif', 'pengajuanList', 'analisis', 'thetaAktif'
        ));
    }

    /**
     * Sumber dataset historis untuk kalibrasi θ skenario S1/S2.
     * Prioritas: log_keputusan (sumber riil). Fallback bootstrap §6.2 RULES.md
     * memakai status klasifikasi yang sudah tersimpan di hasil_perhitungan.
     */
    private function datasetHistoris(): array
    {
        $dariLog = HasilPerhitungan::whereHas('logKeputusan', fn ($q) =>
            $q->whereIn('keputusan_akhir', ['diterima', 'ditolak'])
        )->with('logKeputusan')->get()->map(function ($h) {
            $keputusan = $h->logKeputusan->sortByDesc('timestamp')->first();
            return [
                'vektor_S'       => (float) $h->vektor_S,
                'keputusan_riil' => $keputusan?->keputusan_akhir ?? 'diterima',
            ];
        })->toArray();

        if (count($dariLog) >= 4) {
            return $dariLog;
        }

        // Bootstrap awal: pakai status klasifikasi dari hasil_perhitungan
        return HasilPerhitungan::get()->map(fn ($h) => [
            'vektor_S'       => (float) $h->vektor_S,
            'keputusan_riil' => $h->status,
        ])->toArray();
    }
}
