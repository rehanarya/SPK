<x-app-layout title="Hitung Kelayakan" page-title="Hitung Kelayakan Minggu Ini" :periode-aktif="$periodeAktif">

    <div class="section-header">
        <h1 class="text-h1">Hitung Kelayakan Pembiayaan</h1>
        <div class="breadcrumb-meta">
            Minggu berjalan: <strong>{{ $periodeAktif->kode_periode }}</strong>
            ({{ $periodeAktif->tanggal_mulai->format('d M') }}–{{ $periodeAktif->tanggal_selesai->format('d M Y') }})
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="text-h2">Data Pengajuan Minggu Ini</h2>
                        <p class="text-meta" style="margin: 4px 0 0 0;">
                            {{ $pengajuanList->count() }} pengajuan siap dihitung kelayakannya
                        </p>
                    </div>
                </div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    @if ($pengajuanList->isEmpty())
                        <x-empty-state icon="bi-inbox" title="Belum ada pengajuan minggu ini"
                                       body="Tambahkan pengajuan pembiayaan terlebih dahulu, lalu jalankan perhitungan.">
                            <x-slot:action>
                                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary-strong">
                                    <i class="bi bi-plus-lg"></i> Tambah Pengajuan
                                </a>
                            </x-slot:action>
                        </x-empty-state>
                    @else
                        <table class="table-finansial">
                            <thead>
                                <tr>
                                    <th>Nama Nasabah</th>
                                    <th class="col-right">Laba (Rp)</th>
                                    <th class="col-right">Pendapatan (Rp)</th>
                                    <th class="col-right">Agunan</th>
                                    <th class="col-right">Pembiayaan (Rp)</th>
                                    <th class="col-right">Tenor (bln)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanList as $p)
                                    <tr>
                                        <td class="col-nama text-body-strong">{{ $p->nasabah?->nama_nasabah ?? '—' }}</td>
                                        <td class="col-nominal">{{ number_format($p->C1_laba_usaha, 0, ',', '.') }}</td>
                                        <td class="col-nominal">{{ number_format($p->C2_pendapatan_bersih, 0, ',', '.') }}</td>
                                        <td class="col-nominal">{{ $p->C3_nilai_agunan }}</td>
                                        <td class="col-nominal">{{ number_format($p->C4_besar_pembiayaan, 0, ',', '.') }}</td>
                                        <td class="col-nominal">{{ $p->C5_jangka_waktu }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Bobot Faktor Penilaian</h3></div>
                <div class="card-body">
                    <table class="table-finansial" style="width: 100%; border: none;">
                        <thead>
                            <tr>
                                <th>Faktor</th>
                                <th class="col-right">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteriaList as $k)
                                <tr>
                                    <td>
                                        <x-criteria-badge :type="$k->tipe" />
                                        {{ $k->nama_kriteria }}
                                    </td>
                                    <td class="col-nominal">{{ number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.') }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="POST" action="{{ route('perhitungan.wp.hitung') }}" style="margin-top: 16px;">
                        @csrf
                        <button type="submit" class="btn btn-primary-strong" style="width: 100%;"
                                @if ($pengajuanList->isEmpty()) disabled @endif>
                            <i class="bi bi-calculator"></i> Hitung Kelayakan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($hasilList->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h2 class="text-h2">Hasil Perhitungan Terakhir</h2>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table-finansial">
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
                        @foreach ($hasilList as $h)
                            <tr>
                                <td><span class="rank-chip">{{ $h->ranking }}</span></td>
                                <td class="col-nama text-body-strong">{{ $h->pengajuan?->nasabah?->nama_nasabah ?? '—' }}</td>
                                <td class="col-nominal">{{ number_format($h->vektor_S, 2, ',', '.') }}</td>
                                <td class="col-nominal">{{ number_format($h->vektor_V * 100, 2, ',', '.') }}%</td>
                                <td><x-status-badge :status="$h->status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</x-app-layout>
