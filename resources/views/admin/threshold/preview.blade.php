<x-app-layout title="Hasil Kalibrasi" page-title="Hasil Kalibrasi Ambang">
    <div class="section-header">
        <h1 class="text-h1">Hasil Kalibrasi Ambang Kelayakan</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('admin.threshold.index') }}">Kalibrasi Ambang</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Pratinjau</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <x-kpi-card label="Ambang Saat Ini"
                        :value="number_format($thetaLama, 0, ',', '.')"
                        meta="Nilai yang masih dipakai" />
        </div>
        <div class="col-12 col-md-4">
            <x-kpi-card label="Ambang Disarankan" variant="accept"
                        :value="number_format($hasil['theta'], 0, ',', '.')"
                        meta="Hasil hitung dari data nyata" />
        </div>
        <div class="col-12 col-md-4">
            <x-kpi-card label="Selisih"
                        :value="($hasil['theta'] > $thetaLama ? '+' : '') . number_format($hasil['theta'] - $thetaLama, 0, ',', '.')"
                        :meta="$hasil['kasus'] === 'B' ? 'Ada ' . $hasil['err'] . ' data yang masih tumpang tindih' : 'Data terpisah dengan baik'" />
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h2 class="text-h2">Sebaran Skor Kelayakan per Kelompok</h2></div>
        <div class="card-body">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Kelompok</th>
                        <th class="col-right">Jumlah Nasabah</th>
                        <th class="col-right">Skor Terendah</th>
                        <th class="col-right">Skor Tertinggi</th>
                        <th class="col-right">Skor Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['diterima' => 'Pernah Diterima', 'ditolak' => 'Pernah Ditolak'] as $key => $label)
                        @php $list = $distribusi[$key]; @endphp
                        <tr>
                            <td>
                                <x-status-badge :status="$key" />
                                <span style="margin-left: 6px;">{{ $label }}</span>
                            </td>
                            <td class="col-nominal">{{ count($list) }}</td>
                            <td class="col-nominal">{{ count($list) > 0 ? number_format(min($list), 2, ',', '.') : '—' }}</td>
                            <td class="col-nominal">{{ count($list) > 0 ? number_format(max($list), 2, ',', '.') : '—' }}</td>
                            <td class="col-nominal">{{ count($list) > 0 ? number_format(array_sum($list)/count($list), 2, ',', '.') : '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="text-h3">Konfirmasi Penerapan</h3></div>
        <div class="card-body">
            <p class="text-body" style="margin-bottom: 16px;">
                Jika Anda menyetujui, ambang baru sebesar <strong>{{ number_format($hasil['theta'], 0, ',', '.') }}</strong>
                akan diberlakukan untuk seluruh penilaian berikutnya. Perubahan ini tercatat di
                jejak audit sistem.
            </p>
            <form method="POST" action="{{ route('admin.threshold.apply') }}">
                @csrf
                <input type="hidden" name="theta_baru" value="{{ $hasil['theta'] }}">
                <div style="display: flex; justify-content: space-between; gap: 12px;">
                    <a href="{{ route('admin.threshold.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-strong">
                        <i class="bi bi-check2"></i> Terapkan Ambang Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
