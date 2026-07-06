<x-app-layout title="Uji Akurasi Sistem" page-title="Uji Akurasi Sistem">
    <div class="section-header">
        <h1 class="text-h1">Uji Akurasi Sistem (LOOCV)</h1>
        <div class="breadcrumb-meta">
            Mengukur seberapa akurat sistem merekomendasikan keputusan pembiayaan dibandingkan
            dengan keputusan riil para petugas
        </div>
    </div>

    @if (! $siap)
        <x-alert type="warning">
            <strong>Data belum cukup.</strong> Pengujian akurasi memerlukan minimal 20 keputusan riil.
            Saat ini tersedia {{ $jumlah }} data.
        </x-alert>
    @endif

    {{-- ── Ringkasan Metrik ──────────────────────────────────────────────────── --}}
    @if ($hasil)
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <x-kpi-card
                    label="Akurasi Sistem"
                    icon="bi-bullseye"
                    variant="accept"
                    :value="number_format($hasil['akurasi'] * 100, 2, ',', '.') . '%'"
                    meta="Persentase rekomendasi yang tepat" />
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <x-kpi-card
                    label="Presisi"
                    icon="bi-check2-circle"
                    variant="priority"
                    :value="number_format($hasil['presisi'] * 100, 2, ',', '.') . '%'"
                    meta="Saat sistem rekomendasi 'Layak', berapa benar" />
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <x-kpi-card
                    label="Recall (Sensitivitas)"
                    icon="bi-search"
                    variant="priority"
                    :value="number_format($hasil['recall'] * 100, 2, ',', '.') . '%'"
                    meta="Dari yang seharusnya Layak, berapa terdeteksi" />
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <x-kpi-card
                    label="Skor F1"
                    icon="bi-graph-up"
                    :value="number_format($hasil['f1'] * 100, 2, ',', '.') . '%'"
                    meta="Rata-rata harmonik presisi & recall" />
            </div>
        </div>

        {{-- ── Confusion Matrix ──────────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card w-100">
                    <div class="card-header">
                        <h3 class="text-h3">Tabel Akurasi (Confusion Matrix)</h3>
                    </div>
                    <div class="card-body" style="padding: 0; overflow-x: auto;">
                        <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th>Hasil Pengujian</th>
                                    <th class="text-end">Aktual: Layak</th>
                                    <th class="text-end">Aktual: Belum Layak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-body-strong">Sistem Bilang Layak</td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-accept-bg); color: var(--color-status-accept-fg);">
                                        {{ $hasil['tp'] }} <span class="text-meta">(benar)</span>
                                    </td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-reject-bg); color: var(--color-status-reject-fg);">
                                        {{ $hasil['fp'] }} <span class="text-meta">(salah)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-body-strong">Sistem Bilang Belum Layak</td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-reject-bg); color: var(--color-status-reject-fg);">
                                        {{ $hasil['fn'] }} <span class="text-meta">(salah)</span>
                                    </td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-accept-bg); color: var(--color-status-accept-fg);">
                                        {{ $hasil['tn'] }} <span class="text-meta">(benar)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card w-100">
                    <div class="card-header">
                        <h3 class="text-h3">Cara Membaca</h3>
                    </div>
                    <div class="card-body">
                        <ul style="margin: 0; padding-left: 18px; color: var(--color-text-body); line-height: 1.8;">
                            <li>
                                <strong>Akurasi {{ number_format($hasil['akurasi'] * 100, 2, ',', '.') }}%</strong>
                                — dari total {{ $jumlah }} pengujian, sistem menebak dengan tepat sebanyak
                                {{ $hasil['tp'] + $hasil['tn'] }} kasus.
                            </li>
                            <li>
                                <strong>Presisi {{ number_format($hasil['presisi'] * 100, 2, ',', '.') }}%</strong>
                                — saat sistem mengatakan "Layak Dibiayai", sebanyak persentase tersebut benar-benar layak.
                            </li>
                            <li>
                                <strong>Recall {{ number_format($hasil['recall'] * 100, 2, ',', '.') }}%</strong>
                                — dari semua nasabah yang seharusnya layak, sistem berhasil mendeteksi sebagian besar.
                            </li>
                            <li>
                                <strong>F1 Score {{ number_format($hasil['f1'] * 100, 2, ',', '.') }}%</strong>
                                — penyeimbang Presisi dan Recall, semakin tinggi semakin baik.
                            </li>
                        </ul>
                        <hr style="margin: 16px 0; border-color: var(--color-border);">
                        <p class="text-meta" style="margin: 0;">
                            Metode pengujian: Leave-One-Out Cross-Validation (LOOCV). Setiap data nasabah
                            dijadikan data uji satu per satu sementara 19 data sisanya dipakai untuk
                            mengkalibrasi ambang kelayakan. Hasilnya dirata-ratakan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Detail Per-Kasus ──────────────────────────────────────────────────── --}}
        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Rincian Pengujian Tiap Nasabah</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">
                        Daftar prediksi sistem vs keputusan riil untuk seluruh {{ $jumlah }} data uji
                    </p>
                </div>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                    <thead class="bg-slate-50">
                        <tr>
                            <th>Nama Nasabah</th>
                            <th class="text-end">Skor Kelayakan</th>
                            <th class="text-end">Ambang Kalibrasi</th>
                            <th>Rekomendasi Sistem</th>
                            <th>Keputusan Riil</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil['detail'] as $i => $d)
                            @php $row = $dataset[$i]; @endphp
                            <tr>
                                <td class="text-body-strong col-nama">{{ $row['nasabah'] }}</td>
                                <td class="text-end tabular-nums">{{ number_format($row['vektor_S'], 2, ',', '.') }}</td>
                                <td class="text-end tabular-nums">{{ number_format($d['theta'], 2, ',', '.') }}</td>
                                <td><x-status-badge :status="$d['prediksi']" /></td>
                                <td><x-status-badge :status="$d['aktual']" /></td>
                                <td>
                                    @if ($d['benar'])
                                        <span class="status-badge status-accept">
                                            <i class="bi bi-check-circle"></i> Tepat
                                        </span>
                                    @else
                                        <span class="status-badge status-reject">
                                            <i class="bi bi-x-circle"></i> Meleset
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>
