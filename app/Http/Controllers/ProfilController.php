<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function show(): View
    {
        return view('profil.show', ['pengguna' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $pengguna = Auth::user();

        $data = $request->validate([
            'nama'             => ['required', 'string', 'max:100'],
            'password_lama'    => ['nullable', 'string'],
            'password_baru'    => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($data['password_baru'] ?? false) {
            if (!Hash::check($data['password_lama'] ?? '', $pengguna->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
            }
            $pengguna->password = $data['password_baru'];
        }

        $pengguna->nama = $data['nama'];
        $pengguna->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
