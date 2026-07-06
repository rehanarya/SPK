@php
    $user = auth()->user();
    $isAdmin = $user && $user->peran === 'admin';
    $isPetugas = $user && $user->peran === 'petugas';

    $activeRoute = request()->route()?->getName() ?? '';
    $is = fn (string|array $patterns) =>
        collect((array) $patterns)->contains(fn ($p) => str_starts_with($activeRoute, $p)) ? 'active' : '';
@endphp

<aside class="app-sidebar">
    <a href="{{ route('dashboard') }}" class="app-sidebar-brand" style="text-decoration: none;">
        {{-- Logo mini KSPPS; fallback ke monogram jika file gambar tidak ada --}}
        <img
            src="{{ asset('images/logo-kspps.png') }}"
            alt="Logo KSPPS"
            class="app-sidebar-brand-logo"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
        >
        <span class="app-sidebar-brand-mark" style="display: none;" aria-hidden="true">SK</span>

        <span class="app-sidebar-brand-text">SPK KSPPS</span>
    </a>

    <nav>
        <div class="app-sidebar-group">
            <div class="app-sidebar-group-label">Beranda</div>
            <a href="{{ route('dashboard') }}" class="app-sidebar-item {{ $is('dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Beranda</span>
            </a>
        </div>

        @if ($isPetugas || $isAdmin)
            <div class="app-sidebar-group">
                <div class="app-sidebar-group-label">Pembiayaan</div>
                <a href="{{ route('nasabah.index') }}" class="app-sidebar-item {{ $is('nasabah') }}">
                    <i class="bi bi-people"></i>
                    <span>Data Nasabah</span>
                </a>
                <a href="{{ route('pengajuan.index') }}" class="app-sidebar-item {{ $is('pengajuan') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Pengajuan</span>
                </a>
                <a href="{{ route('perhitungan.wp') }}" class="app-sidebar-item {{ $is('perhitungan') }}">
                    <i class="bi bi-calculator"></i>
                    <span>Hitung Kelayakan</span>
                </a>
                <a href="{{ route('hasil.index') }}" class="app-sidebar-item {{ $is('hasil') }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Hasil Penilaian</span>
                </a>
                <a href="{{ route('keputusan.index') }}" class="app-sidebar-item {{ $is('keputusan') }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Penetapan Keputusan</span>
                </a>
            </div>
        @endif

        @if ($isAdmin)
            <div class="app-sidebar-group">
                <div class="app-sidebar-group-label">Administrasi</div>
                <a href="{{ route('admin.pengguna.index') }}" class="app-sidebar-item {{ $is('admin.pengguna') }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Pengguna Sistem</span>
                </a>
                <a href="{{ route('admin.kriteria.index') }}" class="app-sidebar-item {{ $is('admin.kriteria') }}">
                    <i class="bi bi-sliders"></i>
                    <span>Faktor Penilaian</span>
                </a>
                <a href="{{ route('admin.periode.index') }}" class="app-sidebar-item {{ $is('admin.periode') }}">
                    <i class="bi bi-calendar-week"></i>
                    <span>Minggu Pengajuan</span>
                </a>
                <a href="{{ route('admin.threshold.index') }}" class="app-sidebar-item {{ $is('admin.threshold') }}">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Kalibrasi Ambang</span>
                </a>
                <a href="{{ route('admin.sensitivitas.index') }}" class="app-sidebar-item {{ $is('admin.sensitivitas') }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Uji Kestabilan</span>
                </a>
                <a href="{{ route('admin.loocv.index') }}" class="app-sidebar-item {{ $is('admin.loocv') }}">
                    <i class="bi bi-bullseye"></i>
                    <span>Uji Akurasi Sistem</span>
                </a>
                <a href="{{ route('admin.audit.index') }}" class="app-sidebar-item {{ $is('admin.audit') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Catatan Aktivitas</span>
                </a>
            </div>
        @endif
    </nav>
</aside>
