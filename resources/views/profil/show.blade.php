<x-app-layout title="Profil Saya" page-title="Profil Saya">
    <div class="section-header">
        <h1 class="text-h1">Profil Saya</h1>
        <div class="breadcrumb-meta">Atur nama tampilan dan kata sandi akun Anda</div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Informasi Akun</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 100px 1fr; gap: 8px 16px;">
                        <dt class="text-label">Username</dt>
                        <dd class="font-numeric" style="margin: 0;">{{ $pengguna->username }}</dd>
                        <dt class="text-label">Peran</dt>
                        <dd style="margin: 0;">
                            <span class="status-badge {{ $pengguna->peran === 'admin' ? 'status-priority' : 'status-accept' }}">
                                {{ $pengguna->peran === 'admin' ? 'Administrator' : 'Petugas Pembiayaan' }}
                            </span>
                        </dd>
                        <dt class="text-label">Bergabung</dt>
                        <dd style="margin: 0;">{{ $pengguna->created_at?->format('d M Y') ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Ubah Profil</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf @method('PUT')

                        <x-form-field name="nama" label="Nama Lengkap" required :errors="$errors">
                            <input type="text" id="nama" name="nama" maxlength="100"
                                   value="{{ old('nama', $pengguna->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror" required>
                        </x-form-field>

                        <div style="margin: 24px 0 16px 0; border-top: 1px solid var(--color-border); padding-top: 16px;">
                            <h4 class="text-h3">Ubah Kata Sandi</h4>
                            <p class="text-meta" style="margin: 4px 0 16px 0;">
                                Kosongkan jika tidak ingin mengubah kata sandi.
                            </p>
                        </div>

                        <x-form-field name="password_lama" label="Kata Sandi Saat Ini" :errors="$errors">
                            <input type="password" id="password_lama" name="password_lama" autocomplete="current-password"
                                   class="form-control @error('password_lama') is-invalid @enderror">
                        </x-form-field>

                        <x-form-field name="password_baru" label="Kata Sandi Baru" :errors="$errors"
                                      helper="Minimal 8 karakter.">
                            <input type="password" id="password_baru" name="password_baru" autocomplete="new-password"
                                   class="form-control @error('password_baru') is-invalid @enderror">
                        </x-form-field>

                        <x-form-field name="password_baru_confirmation" label="Konfirmasi Kata Sandi Baru" :errors="$errors">
                            <input type="password" id="password_baru_confirmation" name="password_baru_confirmation"
                                   autocomplete="new-password" class="form-control">
                        </x-form-field>

                        <div style="margin-top: 16px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
