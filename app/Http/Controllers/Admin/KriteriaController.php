<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BobotHistory;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Services\WeightedProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Pengelolaan kriteria & bobot.
 * Setiap perubahan bobot WAJIB mencatat rekord baru di bobot_history (§3.4 RULES.md).
 */
class KriteriaController extends Controller
{
    public function __construct(private WeightedProductService $wp) {}

    public function index(): View
    {
        $kriteria = Kriteria::orderBy('kode_kriteria')->get();
        $history  = BobotHistory::with(['kriteria', 'periode'])
            ->orderByDesc('created_at')->limit(20)->get();

        return view('admin.kriteria.index', compact('kriteria', 'history'));
    }

    public function edit(Kriteria $kriteria): View
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update bobot mentah satu kriteria.
     * Normalisasi ulang seluruh 5 kriteria setelah perubahan.
     * Wajib catat ke bobot_history (§3.4).
     */
    public function update(Request $request, Kriteria $kriteria): RedirectResponse
    {
        $data = $request->validate([
            'bobot_mentah' => ['required', 'integer', 'min:1', 'max:9'],
            'satuan'       => ['nullable', 'string', 'max:30'],
        ]);

        DB::transaction(function () use ($data, $kriteria, $request) {
            $kriteria->update(['bobot_mentah' => $data['bobot_mentah'], 'satuan' => $data['satuan']]);

            // Normalisasi ulang semua kriteria
            $semuaKriteria = Kriteria::orderBy('kode_kriteria')->get();
            $kriteriaData  = $semuaKriteria->map(fn ($k) => [
                'bobot_mentah' => $k->bobot_mentah,
                'tipe'         => $k->tipe,
            ])->toArray();
            $bobotNorm = $this->wp->normalisasiBobot($kriteriaData);

            foreach ($semuaKriteria as $i => $k) {
                $k->update(['bobot_normalisasi' => $bobotNorm[$i]]);
            }

            // Catat ke bobot_history (periode aktif sebagai referensi, atau null)
            $periodeAktif = Periode::where('status', 'aktif')->first();
            if ($periodeAktif) {
                foreach ($semuaKriteria as $i => $k) {
                    BobotHistory::create([
                        'id_periode'        => $periodeAktif->id_periode,
                        'id_kriteria'       => $k->id_kriteria,
                        'bobot_mentah'      => $k->bobot_mentah,
                        'bobot_normalisasi' => $bobotNorm[$i],
                        'created_at'        => now(),
                    ]);
                }
            }

            AuditLog::create([
                'id_pengguna' => Auth::id(),
                'aksi'        => 'ubah_bobot_kriteria',
                'modul'       => 'kriteria',
                'detail'      => [
                    'kode'          => $kriteria->kode_kriteria,
                    'bobot_lama'    => $kriteria->getOriginal('bobot_mentah'),
                    'bobot_baru'    => $data['bobot_mentah'],
                ],
                'ip_address'  => $request->ip(),
                'created_at'  => now(),
            ]);
        });

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Bobot ' . $kriteria->kode_kriteria . ' berhasil diperbarui. Rekalibrasi θ direkomendasikan.');
    }
}
