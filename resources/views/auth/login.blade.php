<x-auth-layout title="Masuk Sistem">
    @if ($errors->has('username') && ! $errors->has('password'))
        <div style="width: 100%; max-width: 400px; margin-bottom: 16px;">
            <x-alert type="danger">{{ $errors->first('username') }}</x-alert>
        </div>
    @endif

    <div class="auth-card">
        <div class="auth-brand">
            {{-- Logo asli KSPPS; jika file tidak ada, otomatis sembunyikan diri dan tampilkan monogram --}}
            <img
                src="{{ asset('images/logo-kspps.png') }}"
                alt="Logo KSPPS Berkah Sakinah Almughni"
                class="auth-brand-img"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
            >
            <span class="auth-brand-mark" style="display: none;" aria-hidden="true">SK</span>

            <h1 class="text-h1" style="margin: 0;">SPK Pembiayaan KSPPS</h1>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Berkah Sakinah Almughni Girimarto
            </p>
        </div>

        <div class="auth-divider"></div>

        <form method="POST" action="{{ route('login.post') }}" novalidate>
            @csrf

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="username" class="form-label">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username Anda"
                    class="form-control @error('username') is-invalid @enderror"
                    autocomplete="username"
                    autofocus
                    required
                >
                @error('username')
                    <div class="form-error">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group-password">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan kata sandi Anda"
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="toggle-pwd" data-target="#password" aria-label="Tampilkan kata sandi">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="form-error">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="d-flex align-items-center" style="gap: 8px; font-size: 14px; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1" class="form-check-input m-0" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 44px;">
                MASUK
            </button>
        </form>
    </div>
</x-auth-layout>
