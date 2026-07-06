<x-app-layout title="Audit Log" page-title="Audit Log">
    <div class="section-header">
        <h1 class="text-h1">Audit Log</h1>
        <div class="breadcrumb-meta">
            Catatan semua aktivitas penting pengguna pada sistem
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.audit.index') }}"
                  style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="modul" class="form-label">Modul</label>
                    <select id="modul" name="modul" class="form-select">
                        <option value="">Semua modul</option>
                        @foreach ($modulList as $m)
                            <option value="{{ $m }}" {{ request('modul') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                @if (request('modul') || request('tanggal'))
                    <a href="{{ route('admin.audit.index') }}" class="btn btn-ghost">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">Jejak Audit
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;">{{ $log->total() }} entri</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if ($log->isEmpty())
                <x-empty-state icon="bi-clock-history" title="Tidak ada audit log"
                               body="Belum ada aksi tercatat sesuai filter Anda." />
            @else
                <table class="table-finansial">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Modul</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($log as $l)
                            <tr>
                                <td class="text-meta font-numeric">{{ $l->created_at?->format('d/m/Y H:i:s') ?? '—' }}</td>
                                <td>{{ $l->pengguna?->nama ?? '—' }}</td>
                                <td><span class="status-badge status-priority">{{ $l->modul }}</span></td>
                                <td class="text-body-strong">{{ $l->aksi }}</td>
                                <td class="text-meta" style="max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                    title="{{ json_encode($l->detail) }}">
                                    {{ json_encode($l->detail) }}
                                </td>
                                <td class="font-numeric text-meta">{{ $l->ip_address ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @if ($log->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan {{ $log->firstItem() }}–{{ $log->lastItem() }} dari {{ $log->total() }}
                </div>
                {{ $log->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
