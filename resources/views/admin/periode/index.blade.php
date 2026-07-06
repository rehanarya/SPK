<x-app-layout title="Periode Mingguan" page-title="Periode Mingguan">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1">Periode Mingguan</h1>
            <div class="breadcrumb-meta">Atur jadwal minggu pengajuan pembiayaan dan status aktif/tutup</div>
        </div>
        <a href="{{ route('admin.periode.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Periode
        </a>
    </div>

    <div class="card">
        <div class="card-header"><h2 class="text-h2">Daftar Periode</h2></div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Kode Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periode as $p)
                        <tr>
                            <td class="text-body-strong font-numeric">{{ $p->kode_periode }}</td>
                            <td class="font-numeric">{{ $p->tanggal_mulai->format('d M Y') }}</td>
                            <td class="font-numeric">{{ $p->tanggal_selesai->format('d M Y') }}</td>
                            <td><x-status-badge :status="$p->status" /></td>
                            <td class="text-meta">{{ $p->created_at?->format('d M Y') ?? '—' }}</td>
                            <td class="col-actions">
                                @if ($p->status === 'aktif')
                                    {{-- Tombol Tutup memicu Bootstrap modal kustom --}}
                                    <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmTutupPeriodeModal-{{ $p->id_periode }}">
                                        Tutup
                                    </button>
                                @else
                                    {{-- Aktivasi adalah aksi reversibel, submit langsung tanpa konfirmasi --}}
                                    <form method="POST" action="{{ route('admin.periode.toggle', $p) }}" style="display: inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-secondary btn-sm">Aktifkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($periode->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan {{ $periode->firstItem() }}–{{ $periode->lastItem() }} dari {{ $periode->total() }}
                </div>
                {{ $periode->links() }}
            </div>
        @endif
    </div>

    {{-- ── Modal Konfirmasi Penutupan Periode ────────────────────────────────── --}}
    @foreach ($periode->where('status', 'aktif') as $p)
        <div class="modal fade"
             id="confirmTutupPeriodeModal-{{ $p->id_periode }}"
             tabindex="-1"
             aria-labelledby="confirmTutupTitle-{{ $p->id_periode }}"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
                <div class="modal-content"
                     style="border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--elev-2);">

                    <div class="modal-header"
                         style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                        <h3 class="text-h3" style="margin: 0;" id="confirmTutupTitle-{{ $p->id_periode }}">
                            Konfirmasi Penutupan Periode Mingguan
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body" style="padding: 20px;">
                        <p style="margin: 0 0 12px 0; color: var(--color-text-body);">
                            Apakah Anda yakin ingin menutup periode mingguan
                            <strong class="font-numeric">{{ $p->kode_periode }}</strong>
                            ({{ $p->tanggal_mulai->format('d M') }}–{{ $p->tanggal_selesai->format('d M Y') }})?
                        </p>
                        <p style="margin: 0; color: var(--color-text-muted); font-size: 13px;">
                            Tindakan ini akan mengunci seluruh pengajuan nasabah pada minggu berjalan
                            dan tidak dapat dibatalkan.
                        </p>
                    </div>

                    <div class="modal-footer"
                         style="border-top: 1px solid var(--color-border); padding: 12px 20px; display: flex; justify-content: space-between; gap: 12px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form method="POST"
                              action="{{ route('admin.periode.toggle', $p) }}"
                              style="margin: 0; display: inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-lock"></i> Ya, Tutup Periode
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
