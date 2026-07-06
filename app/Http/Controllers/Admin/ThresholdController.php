<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\LogKeputusan;
use App\Services\WeightedProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Modul rekalibrasi ambang batas θ (§5.3 RULES.md).
 *
 * Prasyarat: minimal 20 kasus dengan keputusan riil tersedia.
 * Visualisasi distribusi S_i ditampilkan sebelum konfirmasi.
 */
class ThresholdController extends Controller
{
    public function __construct(private WeightedProductService $wp) {}

    public function index(): View
    {
        $theta     = (float) Konfigurasi::ambil('threshold_default', 250);
        $jumlahLog = LogKeputusan::whereIn('keputusan_akhir', ['diterima', 'ditolak', 'diprioritaskan'])
            ->distinct('id_hasil_perhitungan')
            ->count();
        $siap      = $jumlahLog >= 20;

        return view('admin.threshold.index', compact('theta', 'jumlahLog', 'siap'));
    }

    /**
     * Pratinjau rekalibrasi: hitung θ_baru tanpa menyimpan.
     */
    public function preview(Request $request): View
    {
        $dataset = $this->ambilDataset();

        if (count($dataset) < 20) {
            return view('admin.threshold.index', [
                'theta'     => Konfigurasi::ambil('threshold_default', 250),
                'jumlahLog' => count($dataset),
                'siap'      => false,
                'error'     => 'Data keputusan riil belum mencapai 20 kasus.',
            ]);
        }

        $hasil      = $this->wp->rekalibrasiThreshold($dataset);
        $thetaLama  = (float) Konfigurasi::ambil('threshold_default', 250);
        $distribusi = $this->distribusiSiPerPopulasi($dataset);

        return view('admin.threshold.preview', compact('hasil', 'thetaLama', 'distribusi', 'dataset'));
    }

    /**
     * Konfirmasi: simpan θ_baru sebagai parameter aktif + catat audit.
     */
    public function apply(Request $request): RedirectResponse
    {
        $request->validate(['theta_baru' => ['required', 'numeric', 'min:1']]);

        $thetaLama = Konfigurasi::ambil('threshold_default', 250);
        $thetaBaru = (float) $request->theta_baru;

        Konfigurasi::set('threshold_default', $thetaBaru, 'Ambang batas θ — terakhir dikalibrasi ' . now()->toDateString());

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'rekalibrasi_threshold',
            'modul'       => 'threshold',
            'detail'      => ['theta_lama' => $thetaLama, 'theta_baru' => $thetaBaru],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.threshold.index')
            ->with('success', "Ambang batas θ berhasil diperbarui dari {$thetaLama} menjadi {$thetaBaru}.");
    }

    /**
     * Penyetelan manual ambang batas oleh Administrator (di luar kalibrasi otomatis).
     * Misalnya untuk mengembalikan θ ke nilai default 250 atau penetapan kebijakan.
     */
    public function updateAmbangManual(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'theta_manual' => ['required', 'integer', 'min:1', 'max:99999'],
        ], [
            'theta_manual.required' => 'Nilai ambang batas wajib diisi.',
            'theta_manual.integer'  => 'Ambang batas harus berupa bilangan bulat.',
            'theta_manual.min'      => 'Ambang batas minimal bernilai 1.',
            'theta_manual.max'      => 'Ambang batas maksimal 99999.',
        ]);

        $thetaLama = (float) Konfigurasi::ambil('threshold_default', 250);
        $thetaBaru = (int) $data['theta_manual'];

        Konfigurasi::set(
            'threshold_default',
            $thetaBaru,
            'Ambang batas θ — diatur manual oleh Administrator pada ' . now()->format('d M Y H:i')
        );

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'set_ambang_manual',
            'modul'       => 'threshold',
            'detail'      => [
                'theta_lama' => $thetaLama,
                'theta_baru' => $thetaBaru,
                'metode'     => 'manual',
                'catatan'    => "Administrator mengubah ambang batas kelayakan secara manual menjadi {$thetaBaru}",
            ],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.threshold.index')
            ->with('success', "Ambang kelayakan berhasil diatur secara manual ke {$thetaBaru} (sebelumnya {$thetaLama}).");
    }

    private function ambilDataset(): array
    {
        return LogKeputusan::with('hasilPerhitungan')
            ->whereIn('keputusan_akhir', ['diterima', 'ditolak', 'diprioritaskan'])
            ->get()
            ->map(fn ($log) => [
                'vektor_S'       => $log->hasilPerhitungan?->vektor_S ?? 0,
                // Status 'diprioritaskan' termasuk himpunan 'diterima' untuk algoritma kalibrasi
                'keputusan_riil' => $log->keputusan_akhir === 'diprioritaskan' ? 'diterima' : $log->keputusan_akhir,
            ])
            ->values()
            ->toArray();
    }

    private function distribusiSiPerPopulasi(array $dataset): array
    {
        $diterima = array_values(array_filter($dataset, fn ($k) => $k['keputusan_riil'] === 'diterima'));
        $ditolak  = array_values(array_filter($dataset, fn ($k) => $k['keputusan_riil'] === 'ditolak'));

        return [
            'diterima' => array_column($diterima, 'vektor_S'),
            'ditolak'  => array_column($ditolak,  'vektor_S'),
        ];
    }
}
