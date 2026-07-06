<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Nasabah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NasabahController extends Controller
{
    public function index(Request $request): View
    {
        $nasabah = Nasabah::query()
            ->when($request->search, fn ($q, $s) => $q->where('nama_nasabah', 'like', "%$s%")
                ->orWhere('no_anggota', 'like', "%$s%"))
            ->orderBy('nama_nasabah')
            ->paginate(15)
            ->withQueryString();

        return view('nasabah.index', compact('nasabah'));
    }

    public function create(): View
    {
        $noAnggota = $this->generateNoAnggota();

        return view('nasabah.create', compact('noAnggota'));
    }

    /**
     * Bangun nomor anggota berikutnya secara otomatis dan berurutan.
     *
     * Format: HST-### (3 digit, zero-padded), mengikuti nomor urut tertinggi
     * yang sudah ada. Contoh: data terakhir HST-020 → hasil HST-021.
     *
     * Memakai nomor tertinggi + 1 (bukan sekadar jumlah data) agar tidak
     * terjadi tabrakan dengan aturan unique bila ada nasabah yang dihapus.
     */
    private function generateNoAnggota(): string
    {
        $prefix = 'HST-';

        $nomorTerakhir = Nasabah::where('no_anggota', 'like', $prefix.'%')
            ->pluck('no_anggota')
            ->map(fn (string $kode): int => (int) substr($kode, strlen($prefix)))
            ->max() ?? 0;

        return $prefix.str_pad($nomorTerakhir + 1, 3, '0', STR_PAD_LEFT);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'no_anggota'   => ['required', 'string', 'max:30', 'unique:nasabah,no_anggota'],
            'nama_nasabah' => ['required', 'string', 'max:100'],
            'alamat'       => ['nullable', 'string'],
            'no_telp'      => ['nullable', 'string', 'max:20'],
            'jenis_usaha'  => ['nullable', 'string', 'max:100'],
        ]);

        $nasabah = Nasabah::create($data);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'tambah_nasabah',
            'modul'       => 'nasabah',
            'detail'      => ['id_nasabah' => $nasabah->id_nasabah, 'nama' => $nasabah->nama_nasabah],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah): View
    {
        $nasabah->load(['pengajuan.hasilPerhitungan', 'pengajuan.periode']);
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah): View
    {
        return view('nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah): RedirectResponse
    {
        $data = $request->validate([
            'no_anggota'   => ['required', 'string', 'max:30', Rule::unique('nasabah', 'no_anggota')->ignore($nasabah->id_nasabah, 'id_nasabah')],
            'nama_nasabah' => ['required', 'string', 'max:100'],
            'alamat'       => ['nullable', 'string'],
            'no_telp'      => ['nullable', 'string', 'max:20'],
            'jenis_usaha'  => ['nullable', 'string', 'max:100'],
        ]);

        $nasabah->update($data);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'ubah_nasabah',
            'modul'       => 'nasabah',
            'detail'      => ['id_nasabah' => $nasabah->id_nasabah],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('nasabah.show', $nasabah)
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Request $request, Nasabah $nasabah): RedirectResponse
    {
        // Cegah hapus jika ada pengajuan terkait
        if ($nasabah->pengajuan()->exists()) {
            return back()->with('error', 'Nasabah tidak dapat dihapus karena memiliki data pengajuan.');
        }

        $nama = $nasabah->nama_nasabah;
        $nasabah->delete();

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'hapus_nasabah',
            'modul'       => 'nasabah',
            'detail'      => ['nama' => $nama],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil dihapus.');
    }
}
