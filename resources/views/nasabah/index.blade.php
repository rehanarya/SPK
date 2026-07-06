<x-app-layout title="Data Nasabah" page-title="Data Nasabah">

    <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
        <div>
            <h1 class="text-h1">Data Nasabah</h1>
            <div class="breadcrumb-meta">Master data anggota KSPPS yang dapat mengajukan pembiayaan</div>
        </div>
        <a href="{{ route('nasabah.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Nasabah
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body" style="padding: 16px 20px;">
            <form method="GET" action="{{ route('nasabah.index') }}" style="display: flex; gap: 12px;">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama atau no. anggota..."
                    class="form-control"
                    style="flex: 1;"
                >
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('nasabah.index') }}" class="btn btn-ghost">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">
                Daftar Nasabah
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;">{{ $nasabah->total() }} entri</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @if ($nasabah->isEmpty())
                <x-empty-state
                    icon="bi-people"
                    title="Belum ada data nasabah"
                    body="Tambahkan nasabah pertama untuk mulai memasukkan pengajuan pembiayaan."
                >
                    <x-slot:action>
                        <a href="{{ route('nasabah.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Nasabah Pertama
                        </a>
                    </x-slot:action>
                </x-empty-state>
            @else
                <table class="table-finansial">
                    <caption class="visually-hidden">Daftar seluruh nasabah terdaftar di sistem.</caption>
                    <thead>
                        <tr>
                            <th style="width: 140px;">No. Anggota</th>
                            <th>Nama Nasabah</th>
                            <th>Jenis Usaha</th>
                            <th>No. Telepon</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nasabah as $n)
                            <tr>
                                <td class="font-numeric">{{ $n->no_anggota }}</td>
                                <td class="col-nama text-body-strong">{{ $n->nama_nasabah }}</td>
                                <td>{{ $n->jenis_usaha ?? '—' }}</td>
                                <td>{{ $n->no_telp ?? '—' }}</td>
                                <td class="col-actions">
                                    <a href="{{ route('nasabah.show', $n) }}" class="btn btn-ghost btn-icon" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('nasabah.edit', $n) }}" class="btn btn-ghost btn-icon" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('nasabah.destroy', $n) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger-ghost btn-icon"
                                                title="Hapus"
                                                data-confirm="Hapus nasabah {{ $n->nama_nasabah }}?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @if ($nasabah->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan {{ $nasabah->firstItem() }}–{{ $nasabah->lastItem() }} dari {{ $nasabah->total() }}
                </div>
                {{ $nasabah->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
