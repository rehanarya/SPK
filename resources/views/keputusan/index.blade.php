<x-app-layout title="Penetapan Keputusan" page-title="Penetapan Keputusan" :periode-aktif="$periodeAktif">

    <div class="section-header">
        <h1 class="text-h1">Penetapan Keputusan Akhir</h1>
        <div class="breadcrumb-meta">
            @if ($periodeAktif)
                Minggu berjalan: <strong>{{ $periodeAktif->kode_periode }}</strong> ·
            @endif
            Petugas menetapkan keputusan pembiayaan berdasarkan hasil penilaian
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-h2">Daftar Penilaian Menunggu Keputusan</h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    {{ $topN }} nasabah teratas masuk Kuota Prioritas Minggu Ini
                </p>
            </div>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if ($hasilList->isEmpty())
                <x-empty-state icon="bi-check2-square" title="Belum ada penilaian untuk diputuskan"
                               body="Jalankan perhitungan kelayakan minggu ini terlebih dahulu." />
            @else
                <table class="table-finansial">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Rank</th>
                            <th>Nasabah</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Rekomendasi Sistem</th>
                            <th>Keputusan Akhir</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasilList as $h)
                            @php
                                $isTop      = $h->ranking <= $topN && $h->status === 'diterima';
                                $saran      = $isTop ? 'diprioritaskan' : $h->status;
                                $keputusan  = $h->logKeputusan->sortByDesc('timestamp')->first();
                            @endphp
                            <tr>
                                <td><span class="rank-chip">{{ $h->ranking }}</span></td>
                                <td class="col-nama text-body-strong">{{ $h->pengajuan?->nasabah?->nama_nasabah ?? '—' }}</td>
                                <td class="col-nominal">{{ number_format($h->vektor_S, 4, ',', '.') }}</td>
                                <td class="col-nominal">{{ number_format($h->vektor_V * 100, 2, ',', '.') }}%</td>
                                <td><x-status-badge :status="$saran" /></td>
                                <td>
                                    @if ($keputusan)
                                        <x-status-badge :status="$keputusan->keputusan_akhir" />
                                    @else
                                        <span class="status-badge status-pending">Menunggu</span>
                                    @endif
                                </td>
                                <td class="col-actions">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#modal-keputusan-{{ $h->id_hasil }}">
                                        <i class="bi bi-check2"></i> Tetapkan
                                    </button>
                                    @if ($h->pengajuan)
                                        <a href="{{ route('pengajuan.edit', $h->pengajuan) }}" class="btn btn-secondary btn-sm"
                                           title="Edit pengajuan lengkap + realisasi & tanda tangan Manager (semua status)">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    @endif
                                    @if ($h->pengajuan)
                                        <a href="{{ route('pengajuan.cetak', $h->pengajuan) }}" class="btn btn-secondary btn-sm"
                                           target="_blank" title="Lihat / cetak formulir Analisis Pembiayaan">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Modal keputusan untuk setiap hasil --}}
    @foreach ($hasilList as $h)
        <div class="modal fade" id="modal-keputusan-{{ $h->id_hasil }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 480px;">
                <div class="modal-content" style="border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--elev-2);">
                    <form method="POST" action="{{ route('keputusan.store', $h) }}">
                        @csrf
                        <div class="modal-header" style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                            <h5 class="text-h3" style="margin: 0;">Tetapkan Keputusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 20px;">
                            <div class="text-body" style="margin-bottom: 16px;">
                                Nasabah: <strong>{{ $h->pengajuan?->nasabah?->nama_nasabah ?? '—' }}</strong>
                                <br>
                                Skor Kelayakan: <span class="font-numeric">{{ number_format($h->vektor_S, 2, ',', '.') }}</span> ·
                                Urutan: <span class="font-numeric">{{ $h->ranking }}</span>
                            </div>

                            <x-form-field name="keputusan_akhir" label="Keputusan Akhir" required :errors="$errors">
                                <select name="keputusan_akhir" class="form-select" required>
                                    <option value="">— Pilih keputusan —</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="diprioritaskan">Diprioritaskan</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </x-form-field>

                            <x-form-field name="catatan" label="Catatan (opsional)" :errors="$errors">
                                <textarea name="catatan" rows="3" class="form-control"></textarea>
                            </x-form-field>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid var(--color-border); padding: 12px 20px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
