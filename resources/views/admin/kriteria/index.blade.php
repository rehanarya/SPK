<x-app-layout title="Faktor Penilaian" page-title="Faktor Penilaian & Bobot">
    <div class="section-header">
        <h1 class="text-h1">Faktor Penilaian &amp; Bobot</h1>
        <div class="breadcrumb-meta">
            Pengaturan lima faktor yang menentukan kelayakan pembiayaan · Bobot dihitung otomatis
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><h2 class="text-h2">Daftar Faktor Penilaian</h2></div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="">Faktor Penilaian</th>
                                <th class="">Sifat</th>
                                <th class="">Satuan</th>
                                <th class="text-end">Bobot Awal</th>
                                <th class="text-end">Pengaruh</th>
                                <th class="col-actions">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $k)
                                <tr>
                                    <td class="">
                                        <div class="text-body-strong">{{ $k->nama_kriteria }}</div>
                                        <div class="text-meta">Kode {{ $k->kode_kriteria }}</div>
                                    </td>
                                    <td class="">
                                        <x-criteria-badge :type="$k->tipe" />
                                        {{ $k->tipe === 'benefit' ? 'Semakin besar, semakin baik' : 'Semakin kecil, semakin baik' }}
                                    </td>
                                    <td class="text-meta">{{ $k->satuan ?? '—' }}</td>
                                    <td class="text-end tabular-nums font-medium">{{ $k->bobot_mentah }}</td>
                                    <td class="text-end tabular-nums font-medium">{{ number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.') }}%</td>
                                    <td class="col-actions">
                                        <a href="{{ route('admin.kriteria.edit', $k) }}" class="btn btn-ghost btn-icon" title="Ubah bobot">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: var(--color-bg-subtle);">
                                <td colspan="3" class="text-label text-end">Total</td>
                                <td class="text-end tabular-nums text-body-strong">{{ $kriteria->sum('bobot_mentah') }}</td>
                                <td class="text-end tabular-nums text-body-strong">
                                    {{ number_format($kriteria->sum(fn ($k) => abs($k->bobot_normalisasi)) * 100, 1, ',', '.') }}%
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Hal yang Perlu Diingat</h3></div>
                <div class="card-body">
                    <ul style="margin: 0; padding-left: 18px; color: var(--color-text-body); font-size: 13px; line-height: 1.7;">
                        <li>Faktor bertanda <strong>B</strong>: nilai besar = nasabah lebih layak.</li>
                        <li>Faktor bertanda <strong>C</strong>: nilai besar = nasabah kurang layak.</li>
                        <li>Setiap perubahan bobot otomatis tercatat di riwayat.</li>
                        <li>Setelah bobot diubah, sebaiknya lakukan kalibrasi ambang kelayakan.</li>
                    </ul>
                    <div style="margin-top: 16px;">
                        <a href="{{ route('admin.threshold.index') }}" class="btn btn-secondary" style="width: 100%;">
                            <i class="bi bi-arrow-repeat"></i> Kalibrasi Ambang Kelayakan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header"><h3 class="text-h3">Riwayat Perubahan Bobot (20 Terakhir)</h3></div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if ($history->isEmpty())
                <x-empty-state icon="bi-clock-history" title="Belum ada riwayat perubahan"
                               body="Setiap perubahan bobot oleh Administrator akan tercatat di sini." />
            @else
                <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="">Waktu</th>
                            <th class="">Faktor</th>
                            <th class="">Minggu</th>
                            <th class="text-end">Bobot</th>
                            <th class="text-end">Pengaruh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $h)
                            <tr>
                                <td class="text-meta tabular-nums">{{ $h->created_at?->format('d M Y H:i') ?? '—' }}</td>
                                <td class="">{{ $h->kriteria?->nama_kriteria ?? '—' }}</td>
                                <td class="tabular-nums">{{ $h->periode?->kode_periode ?? '—' }}</td>
                                <td class="text-end tabular-nums font-medium">{{ $h->bobot_mentah }}</td>
                                <td class="text-end tabular-nums font-medium">{{ number_format(abs($h->bobot_normalisasi) * 100, 1, ',', '.') }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
