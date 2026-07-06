<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenggunaController extends Controller
{
    public function index(): View
    {
        $pengguna = Pengguna::orderBy('nama')->paginate(15);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create(): View
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:pengguna,username'],
            'nama'     => ['required', 'string', 'max:100'],
            'peran'    => ['required', 'in:admin,petugas'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $pengguna = Pengguna::create($data);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'tambah_pengguna',
            'modul'       => 'pengguna',
            'detail'      => ['username' => $pengguna->username, 'peran' => $pengguna->peran],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(Pengguna $pengguna): View
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $data = $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'peran'    => ['required', 'in:admin,petugas'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$data['password']) {
            unset($data['password']);
        }

        $pengguna->update($data);

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'ubah_pengguna',
            'modul'       => 'pengguna',
            'detail'      => ['id_pengguna' => $pengguna->id_pengguna],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengguna $pengguna): RedirectResponse
    {
        if ($pengguna->id_pengguna === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        $pengguna->delete();

        AuditLog::create([
            'id_pengguna' => Auth::id(),
            'aksi'        => 'hapus_pengguna',
            'modul'       => 'pengguna',
            'detail'      => ['username' => $pengguna->username],
            'ip_address'  => $request->ip(),
            'created_at'  => now(),
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
