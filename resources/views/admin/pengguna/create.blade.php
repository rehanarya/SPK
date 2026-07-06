<x-app-layout title="Tambah Pengguna" page-title="Tambah Pengguna">
    <div class="section-header">
        <h1 class="text-h1">Tambah Pengguna</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('admin.pengguna.index') }}">Pengguna Sistem</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Tambah</span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.pengguna.store') }}" class="w-100 d-flex flex-column gap-3">
        @csrf

        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Identitas Akun Baru</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Tentukan username, nama, peran, dan kata sandi awal.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="username" label="Username" required :errors="$errors"
                                      helper="Hanya dipakai untuk login. Pilih nama unik tanpa spasi.">
                            <input type="text" id="username" name="username" maxlength="50"
                                   value="{{ old('username') }}"
                                   placeholder="contoh: petugas01"
                                   class="form-control @error('username') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="nama" label="Nama Lengkap" required :errors="$errors"
                                      helper="Nama yang akan ditampilkan di profil pengguna.">
                            <input type="text" id="nama" name="nama" maxlength="100"
                                   value="{{ old('nama') }}"
                                   placeholder="contoh: Siti Aminah"
                                   class="form-control @error('nama') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="peran" label="Peran Pengguna" required :errors="$errors"
                                      helper="Petugas hanya mengakses fitur pembiayaan; Administrator mengakses seluruh sistem.">
                            <select name="peran" class="form-select @error('peran') is-invalid @enderror" required>
                                <option value="">— Pilih peran —</option>
                                <option value="petugas" {{ old('peran') === 'petugas' ? 'selected' : '' }}>Petugas Pembiayaan</option>
                                <option value="admin" {{ old('peran') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Kata Sandi Awal</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Minimal 8 karakter. Sampaikan ke pengguna secara aman.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="password" label="Kata Sandi" required :errors="$errors"
                                      helper="Gunakan kombinasi huruf dan angka untuk keamanan.">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="password_confirmation" label="Konfirmasi Kata Sandi" required :errors="$errors"
                                      helper="Ketik ulang kata sandi yang sama persis.">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" required>
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center"
             style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;">
            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</x-app-layout>
