@props([
    'title' => '',
    'periodeAktif' => null,
])

@php
    $user = auth()->user();
    $initials = $user ? collect(explode(' ', $user->nama))->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->implode('') : 'NN';
@endphp

<header class="app-topbar">
    <button class="app-topbar-burger" type="button" data-sidebar-toggle aria-label="Buka navigasi">
        <i class="bi bi-list"></i>
    </button>

    <h2 class="app-topbar-title">{{ $title }}</h2>

    <div style="flex: 1;"></div>

    @if ($periodeAktif)
        <div class="app-topbar-periode" title="Periode aktif sistem">
            <span class="dot {{ $periodeAktif->status === 'aktif' ? 'aktif' : '' }}"></span>
            <i class="bi bi-calendar3"></i>
            <span>
                {{ $periodeAktif->kode_periode }}
                <span class="text-muted-strong">
                    ({{ $periodeAktif->tanggal_mulai?->format('d M') }}–{{ $periodeAktif->tanggal_selesai?->format('d M Y') }})
                </span>
            </span>
        </div>
    @else
        <div class="app-topbar-periode" style="color: var(--color-text-muted);">
            <span class="dot"></span>
            <i class="bi bi-calendar3"></i>
            <span>Tidak ada periode aktif</span>
        </div>
    @endif

    <div class="dropdown">
        <button class="app-topbar-avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu pengguna">
            {{ strtoupper($initials) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
            <li class="dropdown-item-text" style="padding: 12px 16px;">
                <div class="text-body-strong">{{ $user->nama }}</div>
                <div class="text-meta">
                    <span class="status-badge {{ $user->peran === 'admin' ? 'status-priority' : 'status-accept' }}" style="font-size: 11px;">
                        {{ $user->peran === 'admin' ? 'Administrator' : 'Petugas Pembiayaan' }}
                    </span>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('profil.show') }}">
                    <i class="bi bi-person me-2"></i> Profil Saya
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
