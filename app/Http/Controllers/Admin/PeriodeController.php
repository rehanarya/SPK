<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PeriodeController extends Controller
{
    public function index(): View
    {
        $periode = Periode::orderByDesc('tanggal_mulai')->paginate(20);
        return view('admin.periode.index', compact('periode'));
    }

    public function create(): View
    {
        return view('admin.periode.create');
    }

    /**
     * Simpan periode baru. Tanggal mulai (Senin) dan tanggal selesai (Jumat)
     * dihitung otomatis di server dari "tanggal acuan" yang dipilih petugas
     * agar konsisten meskipun JS sisi klien dimatikan.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tanggal_acuan'   => ['required', 'date'],
            'kode_periode'    => ['nullable', 'string', 'max:20'],
            'tanggal_mulai'   => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date'],
        ], [
            'tanggal_acuan.required' => 'Tanggal acuan minggu harus diisi.',
            'tanggal_acuan.date'     => 'Tanggal acuan tidak valid.',
        ]);

        // Hitung Senin & Jumat di minggu yang sama dari tanggal acuan
        $acuan          = Carbon::parse($data['tanggal_acuan']);
        $tanggalMulai   = $acuan->copy()->startOfWeek(Carbon::MONDAY);     // Senin
        $tanggalSelesai = $tanggalMulai->copy()->addDays(4);                // Jumat

        // Generate kode periode otomatis: YYYY-Wnn (ISO week)
        $kodePeriode = ($data['kode_periode'] ?? null) ?: $tanggalMulai->format('o-\WW');

        // Cegah duplikasi
        if (Periode::where('kode_periode', $kodePeriode)->exists()) {
            return back()->withInput()->withErrors([
                'tanggal_acuan' => "Minggu \"$kodePeriode\" sudah pernah dibuat sebelumnya.",
            ]);
        }

        $periode = Periode::create([
            'kode_periode'    => $kodePeriode,
            'tanggal_mulai'   => $tanggalMulai->toDateString(),
            'tanggal_selesai' => $tanggalSelesai->toDateString(),
            'status'          => 'tutup',
            'created_at'      => now(),
        ]);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'buat_periode',
            'modul'       => 'periode',
            'detail'      => [
                'kode'   => $periode->kode_periode,
                'mulai'  => $periode->tanggal_mulai->toDateString(),
                'selesai'=> $periode->tanggal_selesai->toDateString(),
            ],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.periode.index')
            ->with('success', "Minggu pengajuan {$periode->kode_periode} berhasil dibuat ("
                . $tanggalMulai->format('d M') . '–' . $tanggalSelesai->format('d M Y') . ').');
    }

    /** Ubah status periode: aktifkan satu, tutup yang lain */
    public function toggleStatus(Request $request, Periode $periode): RedirectResponse
    {
        $statusLama = $periode->status;

        if ($periode->status === 'tutup') {
            // Tutup semua periode aktif sebelumnya
            Periode::where('status', 'aktif')->update(['status' => 'tutup']);
            $periode->update(['status' => 'aktif']);
            $pesanAksi = 'aktifkan_periode';
        } else {
            $periode->update(['status' => 'tutup']);
            $pesanAksi = 'tutup_periode';
        }

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => $pesanAksi,
            'modul'       => 'periode',
            'detail'      => ['kode' => $periode->kode_periode, 'status_lama' => $statusLama, 'status_baru' => $periode->status],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Status minggu pengajuan berhasil diubah.');
    }
}
