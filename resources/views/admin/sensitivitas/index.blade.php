<x-app-layout title="Uji Kestabilan Bobot" page-title="Uji Kestabilan Bobot" :periode-aktif="$periodeAktif">
    <div class="section-header">
        <h1 class="text-h1">Uji Kestabilan Hasil Penilaian</h1>
        <div class="breadcrumb-meta">
            Memeriksa apakah daftar lima nasabah teratas tetap konsisten ketika bobot faktor diubah
            ke skenario yang berbeda ·
            Ambang kelayakan yang dipakai:
            <strong class="font-numeric">{{ number_format($thetaAktif ?? 250, 0, ',', '.') }}</strong>
        </div>
    </div>

    @if (!$periodeAktif)
        <x-alert type="warning">Belum ada minggu yang sedang berjalan. Aktifkan minggu pengajuan terlebih dahulu.</x-alert>
    @elseif ($pengajuanList->isEmpty())
        <x-alert type="warning">Minggu berjalan belum memiliki pengajuan untuk diuji.</x-alert>
    @elseif (!$analisis)
        <x-alert type="warning">Data riwayat keputusan belum mencukupi untuk uji kestabilan ini.</x-alert>
    @else
        {{-- ── Ringkasan Skenario ─────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4">
            @php
                $skenarioLabel = [
                    'S0' => ['judul' => 'Bobot Awal Sistem',          'sub' => 'Bobot (5, 4, 4, 2, 2)'],
                    'S1' => ['judul' => 'Penekanan Kapasitas Usaha',   'sub' => 'Bobot (6, 5, 4, 2, 2)'],
                    'S2' => ['judul' => 'Semua Faktor Setara',         'sub' => 'Bobot (3, 3, 3, 3, 3)'],
                ];
            @endphp
            @foreach ($skenarioLabel as $kode => $label)
                <div class="col-12 col-lg-4">
                    <div class="card w-100">
                        <div class="card-header">
                            <div>
                                <h3 class="text-h3">Skenario {{ substr($kode, -1) }} — {{ $label['judul'] }}</h3>
                                <p class="text-meta" style="margin: 4px 0 0 0;">{{ $label['sub'] }}</p>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 0;">
                            <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th style="width: 60px;">Urutan</th>
                                        <th>Nama Nasabah</th>
                                        <th class="text-end">Nilai Prioritas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (array_slice($analisis[$kode], 0, 5) as $r)
                                        <tr>
                                            <td><span class="rank-chip">{{ $r['ranking'] }}</span></td>
                                            <td class="col-nama">{{ $r['nama_nasabah'] ?? '—' }}</td>
                                            <td class="text-end tabular-nums font-medium">{{ number_format($r['vektor_V'] * 100, 2, ',', '.') }}%</td>
                                            <td><x-status-badge :status="$r['status']" /></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Tabel Perbandingan + Indikator ─────────────────────────────────── --}}
        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="card w-100">
                    <div class="card-header">
                        <h2 class="text-h2">Perbandingan Lima Besar pada Tiga Skenario</h2>
                    </div>
                    <div class="card-body" style="padding: 0; overflow-x: auto;">
                        <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th style="width: 80px;">Urutan</th>
                                    <th>Bobot Awal</th>
                                    <th>Penekanan Kapasitas</th>
                                    <th>Bobot Setara</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analisis['perbandingan'] as $row)
                                    <tr>
                                        <td><span class="rank-chip">{{ $row['rank'] }}</span></td>
                                        <td>{{ $row['S0'] }}</td>
                                        <td>{{ $row['S1'] }}</td>
                                        <td>{{ $row['S2'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <x-kpi-card
                    label="Tingkat Kestabilan"
                    icon="bi-diagram-3"
                    variant="priority"
                    :value="$analisis['kestabilan'] . ' / 5'"
                    meta="Jumlah nasabah yang tetap masuk lima besar meski bobot diubah"
                />
                <div class="card w-100" style="margin-top: 16px;">
                    <div class="card-header"><h3 class="text-h3">Bagaimana Membaca Hasil</h3></div>
                    <div class="card-body">
                        <ul style="margin: 0; padding-left: 18px; color: var(--color-text-body); font-size: 13px; line-height: 1.7;">
                            <li>
                                Semakin tinggi tingkat kestabilan, semakin yakin kita bahwa daftar
                                prioritas tidak terlalu sensitif terhadap pilihan bobot.
                            </li>
                            <li>
                                Jika daftar berubah drastis antar-skenario, perlu kajian ulang
                                penetapan bobot di tabel Faktor Penilaian.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
