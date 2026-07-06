<x-app-layout title="Manajemen Pengguna" page-title="Manajemen Pengguna">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1">Manajemen Pengguna</h1>
            <div class="breadcrumb-meta">Kelola akun Administrator dan Petugas Pembiayaan</div>
        </div>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">Daftar Pengguna
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;">{{ $pengguna->total() }} akun</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Peran</th>
                        <th>Dibuat</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengguna as $p)
                        <tr>
                            <td class="font-numeric">{{ $p->username }}</td>
                            <td class="col-nama text-body-strong">{{ $p->nama }}</td>
                            <td>
                                <span class="status-badge {{ $p->peran === 'admin' ? 'status-priority' : 'status-accept' }}">
                                    {{ $p->peran === 'admin' ? 'Administrator' : 'Petugas' }}
                                </span>
                            </td>
                            <td class="text-meta">{{ $p->created_at?->format('d M Y') ?? '—' }}</td>
                            <td class="col-actions">
                                <a href="{{ route('admin.pengguna.edit', $p) }}" class="btn btn-ghost btn-icon" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if ($p->id_pengguna !== auth()->id())
                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $p) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger-ghost btn-icon"
                                                title="Hapus"
                                                data-confirm="Hapus pengguna {{ $p->username }}?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($pengguna->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan {{ $pengguna->firstItem() }}–{{ $pengguna->lastItem() }} dari {{ $pengguna->total() }}
                </div>
                {{ $pengguna->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
