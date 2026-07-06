<x-app-layout title="Detail Penilaian" page-title="Detail Penilaian Nasabah">
    @php $p = $hasil->pengajuan; @endphp

    <div class="section-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="text-h1">Detail Penilaian — {{ $p?->nasabah?->nama_nasabah ?? '—' }}</h1>
                <div class="breadcrumb-meta">
                    <a href="{{ route('hasil.index') }}">Hasil Penilaian</a>
                    <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
                    <span>Detail #{{ $hasil->id_hasil }}</span>
                </div>
            </div>
            @if ($p)
                <div class="d-flex gap-2">
                    <a href="{{ route('pengajuan.edit', $p) }}" class="btn btn-secondary">
                        <i class="bi bi-pencil-square"></i> Ubah Pengajuan
                    </a>
                    <a href="{{ route('pengajuan.cetak', $p) }}" class="btn btn-primary-strong" target="_blank">
                        <i class="bi bi-printer"></i> Cetak Formulir
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Data Penilaian Nasabah</h3></div>
                <div class="card-body" style="padding: 0;">
                    <table class="table-finansial">
                        <thead>
                            <tr>
                                <th>Faktor Penilaian</th>
                                <th>Sifat</th>
                                <th class="col-right">Nilai Nasabah</th>
                                <th class="col-right">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $k)
                                @php
                                    $field = match ($k->kode_kriteria) {
                                        'C1' => 'C1_laba_usaha',
                                        'C2' => 'C2_pendapatan_bersih',
                                        'C3' => 'C3_nilai_agunan',
                                        'C4' => 'C4_besar_pembiayaan',
                                        'C5' => 'C5_jangka_waktu',
                                    };
                                    $nilai = $p?->{$field};
                                    $sifatLabel = $k->tipe === 'benefit' ? 'Semakin besar, semakin baik' : 'Semakin kecil, semakin baik';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="text-body-strong">{{ $k->nama_kriteria }}</div>
                                        <div class="text-meta">{{ $sifatLabel }}</div>
                                    </td>
                                    <td><x-criteria-badge :type="$k->tipe" /> {{ ucfirst($k->tipe) }}</td>
                                    <td class="col-nominal">{{ is_numeric($nilai) ? number_format($nilai, 0, ',', '.') : '—' }}</td>
                                    <td class="col-nominal">{{ number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.') }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── Rincian formulir Analisis Pembiayaan (revisi pasca-sidang) ── --}}
            <div class="card" style="margin-top: 16px;">
                <div class="card-header"><h3 class="text-h3">Rincian Analisis Pembiayaan</h3></div>
                <div class="card-body" @if ($p?->punyaRincianAnalisis()) style="padding: 0;" @endif>
                    @if ($p?->punyaRincianAnalisis())
                        @php $fmtRp = fn ($v) => $v !== null ? 'Rp ' . number_format((float) $v, fmod((float) $v, 1) != 0 ? 2 : 0, ',', '.') : '—'; @endphp
                        <table class="table-finansial">
                            <tbody>
                                <tr><td>Penjualan Usaha</td><td class="col-nominal">{{ $fmtRp($p->penjualan_usaha) }}</td></tr>
                                <tr><td>Harga Pokok Jual</td><td class="col-nominal">{{ $fmtRp($p->harga_pokok_jual) }}</td></tr>
                                <tr><td>Biaya Usaha</td><td class="col-nominal">{{ $fmtRp($p->biaya_usaha) }}</td></tr>
                                <tr><td class="text-body-strong">Laba Usaha (C1)</td><td class="col-nominal text-body-strong">{{ $fmtRp($p->C1_laba_usaha) }}</td></tr>
                                <tr><td>Pendapatan dari Istri/Suami</td><td class="col-nominal">{{ $fmtRp($p->pendapatan_pasangan) }}</td></tr>
                                <tr><td>Pendapatan Lainnya</td><td class="col-nominal">{{ $fmtRp($p->pendapatan_lainnya) }}</td></tr>
                                <tr><td>Kebutuhan Rumah Tangga</td><td class="col-nominal">{{ $fmtRp($p->kebutuhan_rumah_tangga) }}</td></tr>
                                <tr><td>Biaya Pendidikan</td><td class="col-nominal">{{ $fmtRp($p->biaya_pendidikan) }}</td></tr>
                                <tr><td>Biaya Lainnya</td><td class="col-nominal">{{ $fmtRp($p->biaya_lainnya) }}</td></tr>
                                <tr><td class="text-body-strong">Pendapatan Bersih (C2)</td><td class="col-nominal text-body-strong">{{ $fmtRp($p->C2_pendapatan_bersih) }}</td></tr>
                                <tr><td>Rasio Angsuran</td><td class="col-nominal">{{ $p->rasio_angsuran !== null ? rtrim(rtrim(number_format($p->rasio_angsuran, 2, ',', '.'), '0'), ',') . ' %' : '—' }}</td></tr>
                                <tr><td class="text-body-strong">Plafon Pembiayaan</td><td class="col-nominal text-body-strong">{{ $fmtRp($p->plafon_pembiayaan) }}</td></tr>
                                <tr><td>Angsuran Pokok</td><td class="col-nominal">{{ $fmtRp($p->angsuran_pokok) }}</td></tr>
                                <tr><td>Bagi Hasil</td><td class="col-nominal">{{ $fmtRp($p->bagi_hasil) }}</td></tr>
                                <tr><td>Simpanan</td><td class="col-nominal">{{ $fmtRp($p->simpanan) }}</td></tr>
                                <tr><td class="text-body-strong">Jumlah Angsuran</td><td class="col-nominal text-body-strong">{{ $fmtRp($p->jumlah_angsuran) }}</td></tr>
                                <tr><td>Jenis Akad</td><td class="col-nominal">{{ $p->jenis_akad ?? '—' }}</td></tr>
                                <tr><td>Agunan</td><td class="col-nominal">{{ $p->labelAgunan() }}</td></tr>
                                <tr><td>Tanggal Realisasi</td><td class="col-nominal">{{ $p->tanggal_realisasi?->format('d/m/Y') ?? '—' }}</td></tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-meta" style="margin: 0;">
                            <i class="bi bi-info-circle"></i>
                            Rincian analisis belum tersedia untuk data historis — hanya nilai kriteria C1–C5 yang tersimpan.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Ringkasan Skor</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 160px 1fr; gap: 12px 16px;">
                        <dt class="text-label">Skor Kelayakan</dt>
                        <dd class="font-numeric text-h2" style="margin: 0;">{{ number_format($hasil->vektor_S, 2, ',', '.') }}</dd>
                        <dt class="text-label">Nilai Prioritas</dt>
                        <dd class="font-numeric text-h2" style="margin: 0;">{{ number_format($hasil->vektor_V * 100, 2, ',', '.') }}%</dd>
                        <dt class="text-label">Urutan</dt>
                        <dd class="font-numeric" style="margin: 0;">{{ $hasil->ranking ?? '—' }}</dd>
                        <dt class="text-label">Status</dt>
                        <dd style="margin: 0;"><x-status-badge :status="$hasil->status" /></dd>
                        <dt class="text-label">Minggu Penilaian</dt>
                        <dd class="font-numeric" style="margin: 0;">{{ $p?->periode?->kode_periode ?? '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card" style="margin-top: 16px;">
                <div class="card-header"><h3 class="text-h3">Riwayat Keputusan</h3></div>
                <div class="card-body" style="padding: 0;">
                    @if ($hasil->logKeputusan->isEmpty())
                        <x-empty-state icon="bi-clipboard" title="Belum ada keputusan" body="Tetapkan keputusan akhir dari menu Penetapan Keputusan." />
                    @else
                        <table class="table-finansial">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Petugas</th>
                                    <th>Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hasil->logKeputusan->sortByDesc('timestamp') as $k)
                                    <tr>
                                        <td class="text-meta">{{ $k->timestamp?->format('d/m H:i') ?? '—' }}</td>
                                        <td>{{ $k->pengguna?->nama ?? '—' }}</td>
                                        <td><x-status-badge :status="$k->keputusan_akhir" /></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
