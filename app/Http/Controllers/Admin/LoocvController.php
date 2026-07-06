<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\HasilPerhitungan;
use App\Models\LogKeputusan;
use App\Services\WeightedProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Modul Uji Akurasi Sistem dengan Leave-One-Out Cross-Validation.
 * Membandingkan rekomendasi sistem (S_i ≥ θ) terhadap keputusan riil petugas.
 */
class LoocvController extends Controller
{
    public function __construct(private WeightedProductService $wp) {}

    public function index(Request $request): View
    {
        $dataset = $this->ambilDataset();
        $jumlah  = count($dataset);
        $siap    = $jumlah >= 20;

        $hasil = null;
        if ($siap) {
            $hasil = $this->wp->loocv($dataset);

            AuditLog::create([
                'id_pengguna' => Auth::id(),
                'aksi'        => 'eksekusi_loocv',
                'modul'       => 'loocv',
                'detail'      => [
                    'n'        => $jumlah,
                    'akurasi'  => round($hasil['akurasi'], 4),
                    'presisi'  => round($hasil['presisi'], 4),
                    'recall'   => round($hasil['recall'], 4),
                    'f1'       => round($hasil['f1'], 4),
                ],
                'ip_address'  => $request->ip(),
                'created_at'  => now(),
            ]);
        }

        return view('admin.loocv.index', compact('dataset', 'jumlah', 'siap', 'hasil'));
    }

    /**
     * Ambil dataset historis: hasil perhitungan yang sudah punya keputusan riil
     * (lewat log_keputusan). Untuk bootstrap awal, kita pakai bootstrap status
     * dari hasil_perhitungan itu sendiri (sesuai §6.2 RULES.md).
     *
     * @return array<int, array{vektor_S: float, keputusan_riil: string, nasabah: string}>
     */
    private function ambilDataset(): array
    {
        // 1. Coba ambil dari log_keputusan dulu (sumber utama keputusan riil)
        $dariLog = LogKeputusan::with('hasilPerhitungan.pengajuan.nasabah')
            ->whereIn('keputusan_akhir', ['diterima', 'ditolak'])
            ->get()
            ->map(function ($log) {
                $h = $log->hasilPerhitungan;
                return $h ? [
                    'vektor_S'       => (float) $h->vektor_S,
                    'keputusan_riil' => $log->keputusan_akhir,
                    'nasabah'        => $h->pengajuan?->nasabah?->nama_nasabah ?? '—',
                ] : null;
            })
            ->filter()
            ->values()
            ->toArray();

        if (count($dariLog) >= 20) {
            return $dariLog;
        }

        // 2. Bootstrap awal §6.2 RULES.md: pakai status bootstrap dari hasil_perhitungan
        return HasilPerhitungan::with('pengajuan.nasabah')
            ->get()
            ->map(fn ($h) => [
                'vektor_S'       => (float) $h->vektor_S,
                'keputusan_riil' => $h->status,
                'nasabah'        => $h->pengajuan?->nasabah?->nama_nasabah ?? '—',
            ])
            ->values()
            ->toArray();
    }
}
