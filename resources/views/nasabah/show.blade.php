<x-app-layout title="Detail Nasabah" page-title="Detail Nasabah">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1">{{ $nasabah->nama_nasabah }}</h1>
            <div class="breadcrumb-meta">
                <a href="{{ route('nasabah.index') }}">Data Nasabah</a>
                <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
                <span>{{ $nasabah->no_anggota }}</span>
            </div>
        </div>
        <a href="{{ route('nasabah.edit', $nasabah) }}" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Ubah Data
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Identitas</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 120px 1fr; gap: 8px 16px;">
                        <dt class="text-label">No. Anggota</dt><dd class="font-numeric" style="margin: 0;">{{ $nasabah->no_anggota }}</dd>
                        <dt class="text-label">Nama</dt><dd style="margin: 0;">{{ $nasabah->nama_nasabah }}</dd>
                        <dt class="text-label">Jenis Usaha</dt><dd style="margin: 0;">{{ $nasabah->jenis_usaha ?? '—' }}</dd>
                        <dt class="text-label">Telepon</dt><dd style="margin: 0;">{{ $nasabah->no_telp ?? '—' }}</dd>
                        <dt class="text-label">Alamat</dt><dd style="margin: 0;">{{ $nasabah->alamat ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Riwayat Pengajuan</h3></div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    @if ($nasabah->pengajuan->isEmpty())
                        <x-empty-state icon="bi-file-earmark-text" title="Belum ada pengajuan"
                                       body="Nasabah ini belum pernah mengajukan pembiayaan."/>
                    @else
                        <table class="table-finansial">
                            <thead>
                                <tr>
                                    <th>Minggu</th>
                                    <th class="col-right">Laba Usaha</th>
                                    <th class="col-right">Pembiayaan</th>
                                    <th class="col-right">Skor Kelayakan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nasabah->pengajuan as $p)
                                    <tr>
                                        <td class="font-numeric">{{ $p->periode?->kode_periode ?? '—' }}</td>
                                        <td class="col-nominal">{{ number_format($p->C1_laba_usaha, 0, ',', '.') }}</td>
                                        <td class="col-nominal">{{ number_format($p->C4_besar_pembiayaan, 0, ',', '.') }}</td>
                                        <td class="col-nominal">
                                            {{ $p->hasilPerhitungan ? number_format($p->hasilPerhitungan->vektor_S, 2, ',', '.') : '—' }}
                                        </td>
                                        <td>
                                            @if ($p->hasilPerhitungan)
                                                <x-status-badge :status="$p->hasilPerhitungan->status" />
                                            @else
                                                <span class="status-badge status-pending">Belum dihitung</span>
                                            @endif
                                        </td>
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
