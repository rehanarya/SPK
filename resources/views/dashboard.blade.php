<x-app-layout title="Beranda" page-title="Beranda" :periode-aktif="$periodeAktif">

    {{-- Heading welcome --}}
    <div class="section-header">
        <h1 class="text-h1">Selamat datang, {{ $pengguna->nama }}</h1>
        <div class="breadcrumb-meta">
            <span class="status-badge {{ $pengguna->peran === 'admin' ? 'status-priority' : 'status-accept' }}" style="font-size: 11px;">
                {{ $pengguna->peran === 'admin' ? 'Administrator' : 'Petugas Pembiayaan' }}
            </span>
            <span style="margin-left: 8px;">
                @if ($periodeAktif)
                    Minggu berjalan: <strong>{{ $periodeAktif->kode_periode }}</strong>
                    ({{ $periodeAktif->tanggal_mulai?->format('d M') }}–{{ $periodeAktif->tanggal_selesai?->format('d M Y') }})
                @else
                    Belum ada minggu yang dibuka untuk pengajuan.
                @endif
            </span>
        </div>
    </div>

    {{-- KPI Grid 4 kolom --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <x-kpi-card
                label="Total Pengajuan"
                icon="bi-file-earmark-text"
                :value="$stats['total_pengajuan']"
                meta="Pengajuan minggu ini"
            />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-kpi-card
                label="Layak Dibiayai"
                icon="bi-check-circle"
                variant="accept"
                :value="$stats['diterima']"
                :meta="$stats['total_pengajuan'] > 0
                    ? round($stats['diterima'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—'"
            />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-kpi-card
                label="Belum Layak"
                icon="bi-x-circle"
                variant="reject"
                :value="$stats['ditolak']"
                :meta="$stats['total_pengajuan'] > 0
                    ? round($stats['ditolak'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—'"
            />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-kpi-card
                label="Prioritas Pencairan"
                icon="bi-bookmark-star"
                variant="priority"
                :value="min($stats['diterima'], $stats['top_n'])"
                :meta="$stats['top_n'] . ' nasabah teratas minggu ini'"
            />
        </div>
    </div>

    {{-- Tabel Top-5 --}}
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <h2 class="text-h2">Nasabah Prioritas Minggu Ini</h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    @if ($periodeAktif)
                        Lima nasabah teratas pada minggu <strong>{{ $periodeAktif->kode_periode }}</strong>
                    @else
                        Lima nasabah teratas pada minggu aktif
                    @endif
                    · Disusun berdasarkan tingkat prioritas tertinggi
                </p>
            </div>
            <a href="{{ route('hasil.index') }}" class="btn btn-ghost btn-sm">
                Lihat semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="card-body" style="padding: 0;">
            @if ($hasilTerkini && $hasilTerkini->isNotEmpty())
                <table class="table-finansial">
                    <caption class="visually-hidden">Daftar lima nasabah prioritas tertinggi minggu ini.</caption>
                    <thead>
                        <tr>
                            <th style="width: 80px;">Urutan</th>
                            <th>Nama Nasabah</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilTerkini as $row)
                            @php
                                $isTop = $row->ranking <= $stats['top_n'] && $row->status === 'diterima';
                                $badgeStatus = match (true) {
                                    $row->status === 'ditolak' => 'ditolak',
                                    $isTop                      => 'diprioritaskan',
                                    default                     => 'diterima_tidak_prio',
                                };
                            @endphp
                            <tr>
                                <td><span class="rank-chip">{{ $row->ranking }}</span></td>
                                <td class="col-nama text-body-strong">
                                    {{ $row->pengajuan?->nasabah?->nama_nasabah ?? '—' }}
                                </td>
                                <td class="col-nominal">{{ number_format($row->vektor_S, 2, ',', '.') }}</td>
                                <td class="col-nominal">{{ number_format($row->vektor_V * 100, 2, ',', '.') }}%</td>
                                <td><x-status-badge :status="$badgeStatus" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-empty-state
                    icon="bi-inbox"
                    title="Belum ada penilaian pada minggu ini"
                    body="Tambahkan pengajuan pembiayaan untuk melihat daftar nasabah prioritas."
                >
                    <x-slot:action>
                        @if (auth()->user()->peran === 'petugas' || auth()->user()->peran === 'admin')
                            <a href="{{ route('pengajuan.create') }}" class="btn btn-primary-strong">
                                <i class="bi bi-plus-lg"></i> Tambah Pengajuan Baru
                            </a>
                        @endif
                    </x-slot:action>
                </x-empty-state>
            @endif
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-h3">Aksi Cepat</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <a href="{{ route('pengajuan.create') }}" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-plus-circle me-2"></i> Pengajuan Baru
                                    </div>
                                    <div class="quick-action-meta">Catat pengajuan pembiayaan dari nasabah</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{ route('perhitungan.wp') }}" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-calculator me-2"></i> Hitung Kelayakan
                                    </div>
                                    <div class="quick-action-meta">Proses penilaian minggu ini</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{ route('hasil.index') }}" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-bar-chart me-2"></i> Hasil &amp; Urutan
                                    </div>
                                    <div class="quick-action-meta">Lihat skor dan ranking nasabah</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="{{ route('keputusan.index') }}" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-check2-square me-2"></i> Tetapkan Keputusan
                                    </div>
                                    <div class="quick-action-meta">Putuskan pengajuan diterima atau tidak</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-h3">Ringkasan Sistem</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div class="text-label">Ambang Kelayakan</div>
                            <div class="text-h2" style="margin-top: 4px;">{{ number_format($stats['theta'], 0, ',', '.') }}</div>
                            <div class="text-meta">Skor minimum agar pengajuan dapat diterima</div>
                        </div>
                        <hr style="margin: 4px 0; border-color: var(--color-border);">
                        <div>
                            <div class="text-label">Kuota Prioritas Minggu Ini</div>
                            <div class="text-h2" style="margin-top: 4px;">{{ $stats['top_n'] }}</div>
                            <div class="text-meta">Jumlah nasabah teratas yang diprioritaskan untuk pencairan</div>
                        </div>
                        <hr style="margin: 4px 0; border-color: var(--color-border);">
                        <div>
                            <div class="text-label">Total Nasabah</div>
                            <div class="text-h2" style="margin-top: 4px;">{{ $stats['total_nasabah'] }}</div>
                            <div class="text-meta">Anggota terdaftar di koperasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
