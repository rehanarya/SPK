<x-app-layout title="Ubah Pengguna" page-title="Ubah Pengguna">
    <div class="section-header">
        <h1 class="text-h1">Ubah Pengguna: {{ $pengguna->username }}</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('admin.pengguna.index') }}">Pengguna Sistem</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Ubah</span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.pengguna.update', $pengguna) }}" class="w-100 d-flex flex-column gap-3">
        @csrf @method('PUT')

        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Identitas Akun</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Username tidak dapat diubah. Untuk mengganti, hapus akun lama lalu buat baru.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="username" label="Username" :errors="$errors">
                            <input type="text" value="{{ $pengguna->username }}" class="form-control" disabled>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="nama" label="Nama Lengkap" required :errors="$errors">
                            <input type="text" id="nama" name="nama" maxlength="100"
                                   value="{{ old('nama', $pengguna->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="peran" label="Peran Pengguna" required :errors="$errors">
                            <select name="peran" class="form-select @error('peran') is-invalid @enderror" required>
                                <option value="petugas" {{ old('peran', $pengguna->peran) === 'petugas' ? 'selected' : '' }}>Petugas Pembiayaan</option>
                                <option value="admin"   {{ old('peran', $pengguna->peran) === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Ubah Kata Sandi</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Kosongkan kedua kolom jika tidak ingin mengubah kata sandi.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="password" label="Kata Sandi Baru" :errors="$errors"
                                      helper="Minimal 8 karakter jika diisi.">
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror">
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="password_confirmation" label="Konfirmasi Kata Sandi Baru" :errors="$errors">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control">
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
                <i class="bi bi-check2-circle"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</x-app-layout>
