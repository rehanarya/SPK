<x-app-layout title="Hasil Penilaian" page-title="Hasil Penilaian" :periode-aktif="$periode">

    <div class="section-header">
        <h1 class="text-h1">Hasil Penilaian Pembiayaan</h1>
        <div class="breadcrumb-meta">
            Skor kelayakan, nilai prioritas, dan status setiap nasabah ·
            Ambang Kelayakan <strong>{{ number_format($theta, 0, ',', '.') }}</strong> ·
            {{ $topN }} nasabah teratas masuk Kuota Prioritas
        </div>
    </div>

    {{-- Filter minggu --}}
    <div class="card mb-4">
        <div class="card-body" style="display: flex; align-items: end; gap: 16px; flex-wrap: wrap;">
            <form method="GET" action="{{ route('hasil.index') }}" style="flex: 1; min-width: 280px;">
                <label for="id_periode" class="form-label">Pilih Minggu</label>
                <div style="display: flex; gap: 12px;">
                    <select id="id_periode" name="id_periode" class="form-select" onchange="this.form.submit()">
                        @foreach ($periodeList as $p)
                            <option value="{{ $p->id_periode }}" {{ $periode && $p->id_periode === $periode->id_periode ? 'selected' : '' }}>
                                {{ $p->kode_periode }}
                                ({{ $p->tanggal_mulai->format('d M') }}–{{ $p->tanggal_selesai->format('d M Y') }})
                                @if ($p->status === 'aktif') · Sedang Berjalan @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('perhitungan.wp') }}" class="btn btn-secondary">
                    <i class="bi bi-calculator"></i> Hitung Ulang
                </a>
                <a href="{{ route('keputusan.index') }}" class="btn btn-primary-strong">
                    <i class="bi bi-check2-square"></i> Tetapkan Keputusan
                </a>
            </div>
        </div>
    </div>

    {{-- Tabel hasil --}}
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-h2">
                    @if ($periode)
                        Daftar Penilaian — Minggu {{ $periode->kode_periode }}
                    @else
                        Daftar Penilaian
                    @endif
                </h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    {{ $hasil->count() }} pengajuan ·
                    {{ $hasil->where('status', 'diterima')->count() }} layak ·
                    {{ $hasil->where('status', 'ditolak')->count() }} belum layak
                </p>
            </div>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if ($hasil->isEmpty())
                <x-empty-state
                    icon="bi-calculator"
                    title="Belum ada penilaian"
                    body="Tambahkan pengajuan, lalu jalankan perhitungan kelayakan untuk minggu ini."
                >
                    <x-slot:action>
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary-strong">
                            <i class="bi bi-plus-lg"></i> Tambah Pengajuan Baru
                        </a>
                    </x-slot:action>
                </x-empty-state>
            @else
                <table class="table-finansial">
                    <caption class="visually-hidden">Daftar hasil penilaian seluruh nasabah pada minggu terpilih.</caption>
                    <thead>
                        <tr>
                            <th style="width: 80px;">Urutan</th>
                            <th>Nama Nasabah</th>
                            <th class="col-right">Laba Usaha (Rp)</th>
                            <th class="col-right">Pendapatan (Rp)</th>
                            <th class="col-right">Agunan</th>
                            <th class="col-right">Pembiayaan (Rp)</th>
                            <th class="col-right">Tenor (bln)</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil as $row)
                            @php
                                $p = $row->pengajuan;
                                $isTop = $row->ranking <= $topN && $row->status === 'diterima';
                                $badge = match (true) {
                                    $row->status === 'ditolak' => 'ditolak',
                                    $isTop                     => 'diprioritaskan',
                                    default                    => 'diterima_tidak_prio',
                                };
                            @endphp
                            <tr>
                                <td><span class="rank-chip">{{ $row->ranking }}</span></td>
                                <td class="col-nama text-body-strong">{{ $p?->nasabah?->nama_nasabah ?? '—' }}</td>
                                <td class="col-nominal">{{ number_format($p?->C1_laba_usaha ?? 0, 0, ',', '.') }}</td>
                                <td class="col-nominal">{{ number_format($p?->C2_pendapatan_bersih ?? 0, 0, ',', '.') }}</td>
                                <td class="col-nominal">{{ $p?->C3_nilai_agunan ?? '—' }}</td>
                                <td class="col-nominal">{{ number_format($p?->C4_besar_pembiayaan ?? 0, 0, ',', '.') }}</td>
                                <td class="col-nominal">{{ $p?->C5_jangka_waktu ?? '—' }}</td>
                                <td class="col-nominal">{{ number_format($row->vektor_S, 2, ',', '.') }}</td>
                                <td class="col-nominal">{{ number_format($row->vektor_V * 100, 2, ',', '.') }}%</td>
                                <td><x-status-badge :status="$badge" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</x-app-layout>
