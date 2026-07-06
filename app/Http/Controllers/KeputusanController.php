<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\LogKeputusan;
use App\Models\Periode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Penetapan keputusan akhir oleh Petugas Pembiayaan (§9 RULES.md).
 * Setiap penetapan WAJIB dicatat ke log_keputusan.
 */
class KeputusanController extends Controller
{
    public function index(Request $request): View
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();
        $topN         = (int) Konfigurasi::ambil('top_n_prioritas', 5);

        $hasilList = HasilPerhitungan::with(['pengajuan.nasabah', 'logKeputusan'])
            ->when($periodeAktif, fn ($q) => $q->whereHas('pengajuan',
                fn ($sq) => $sq->where('id_periode', $periodeAktif->id_periode)
            ))
            ->orderBy('ranking')
            ->get();

        return view('keputusan.index', compact('hasilList', 'periodeAktif', 'topN'));
    }

    /**
     * Simpan keputusan akhir petugas untuk satu hasil perhitungan.
     * Keputusan: diterima | ditolak | diprioritaskan
     */
    public function store(Request $request, HasilPerhitungan $hasil): RedirectResponse
    {
        $data = $request->validate([
            'keputusan_akhir' => ['required', 'in:diterima,ditolak,diprioritaskan'],
            'catatan'         => ['nullable', 'string', 'max:1000'],
        ]);

        LogKeputusan::create([
            'id_pengguna'          => Auth::id(),
            'id_hasil_perhitungan' => $hasil->id_hasil,
            'keputusan_akhir'      => $data['keputusan_akhir'],
            'catatan'              => $data['catatan'] ?? null,
            'timestamp'            => now(),
        ]);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'tetapkan_keputusan',
            'modul'       => 'keputusan',
            'detail'      => [
                'id_hasil'       => $hasil->id_hasil,
                'keputusan'      => $data['keputusan_akhir'],
                'vektor_S'       => $hasil->vektor_S,
            ],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('keputusan.index')
            ->with('success', 'Keputusan akhir berhasil ditetapkan.');
    }
}
