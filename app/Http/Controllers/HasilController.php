<?php

namespace App\Http\Controllers;

use App\Models\HasilPerhitungan;
use App\Models\Konfigurasi;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HasilController extends Controller
{
    public function index(Request $request): View
    {
        $periodeList  = Periode::orderByDesc('tanggal_mulai')->get();
        $periodeId    = $request->input('id_periode', optional(Periode::where('status', 'aktif')->first())->id_periode);
        $periode      = $periodeId ? Periode::find($periodeId) : null;

        $hasil = HasilPerhitungan::with(['pengajuan.nasabah'])
            ->when($periode, fn ($q) => $q->whereHas('pengajuan', fn ($sq) => $sq->where('id_periode', $periode->id_periode)))
            ->orderBy('ranking')
            ->get();

        $topN     = (int) Konfigurasi::ambil('top_n_prioritas', 5);
        $theta    = (float) Konfigurasi::ambil('threshold_default', 250);
        $kriteria = \App\Models\Kriteria::orderBy('kode_kriteria')->get();

        return view('hasil.index', compact('hasil', 'periodeList', 'periode', 'topN', 'theta', 'kriteria'));
    }

    public function show(HasilPerhitungan $hasil): View
    {
        $hasil->load(['pengajuan.nasabah', 'pengajuan.periode', 'logKeputusan.pengguna']);
        $kriteria = \App\Models\Kriteria::orderBy('kode_kriteria')->get();
        return view('hasil.show', compact('hasil', 'kriteria'));
    }
}
