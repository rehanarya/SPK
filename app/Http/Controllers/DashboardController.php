<?php

namespace App\Http\Controllers;

use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\Nasabah;
use App\Models\Pengajuan;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Statistik dasbor diisolasi ketat ke periode aktif.
     * Bila tidak ada periode aktif (atau periode aktif masih kosong),
     * KPI menampilkan 0 — tidak boleh ambil data minggu sebelumnya.
     */
    public function index(): View
    {
        $pengguna     = Auth::user();
        $periodeAktif = Periode::where('status', 'aktif')->first();

        $stats = [
            'total_nasabah'   => Nasabah::count(),
            'total_pengajuan' => 0,
            'diterima'        => 0,
            'ditolak'         => 0,
            'theta'           => (float) Konfigurasi::ambil('threshold_default', 250),
            'top_n'           => (int) Konfigurasi::ambil('top_n_prioritas', 5),
        ];

        $hasilTerkini = null;

        if ($periodeAktif) {
            // Pengajuan periode aktif saja
            $stats['total_pengajuan'] = Pengajuan::where('id_periode', $periodeAktif->id_periode)->count();

            // Hasil penilaian khusus periode aktif (via relasi pengajuan)
            $stats['diterima'] = HasilPerhitungan::where('status', 'diterima')
                ->whereHas('pengajuan', fn ($q) => $q->where('id_periode', $periodeAktif->id_periode))
                ->count();

            $stats['ditolak'] = HasilPerhitungan::where('status', 'ditolak')
                ->whereHas('pengajuan', fn ($q) => $q->where('id_periode', $periodeAktif->id_periode))
                ->count();

            $hasilTerkini = HasilPerhitungan::with(['pengajuan.nasabah'])
                ->whereHas('pengajuan', fn ($q) => $q->where('id_periode', $periodeAktif->id_periode))
                ->orderBy('ranking')
                ->limit(5)
                ->get();
        }

        return view('dashboard', compact('pengguna', 'periodeAktif', 'stats', 'hasilTerkini'));
    }
}
