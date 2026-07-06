<x-app-layout title="Ubah Nasabah" page-title="Ubah Nasabah">
    <div class="section-header">
        <h1 class="text-h1">Ubah Data Nasabah</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('nasabah.index') }}">Data Nasabah</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>{{ $nasabah->nama_nasabah }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('nasabah.update', $nasabah) }}" class="w-100 d-flex flex-column gap-3">
        @csrf @method('PUT')

        {{-- ── Identitas Nasabah ────────────────────────────────────────────────── --}}
        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Identitas Nasabah</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Perbarui data pokok keanggotaan koperasi.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="no_anggota" label="Nomor Anggota" required :errors="$errors">
                            <input type="text" id="no_anggota" name="no_anggota" maxlength="30"
                                   value="{{ old('no_anggota', $nasabah->no_anggota) }}"
                                   class="form-control @error('no_anggota') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="nama_nasabah" label="Nama Lengkap Nasabah" required :errors="$errors">
                            <input type="text" id="nama_nasabah" name="nama_nasabah" maxlength="100"
                                   value="{{ old('nama_nasabah', $nasabah->nama_nasabah) }}"
                                   class="form-control @error('nama_nasabah') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12">
                        <x-form-field name="alamat" label="Alamat Tempat Tinggal" :errors="$errors">
                            <textarea id="alamat" name="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $nasabah->alamat) }}</textarea>
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Kontak & Usaha ───────────────────────────────────────────────────── --}}
        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Kontak &amp; Usaha</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">Informasi pendukung untuk verifikasi nasabah.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="no_telp" label="Nomor Telepon / WhatsApp" :errors="$errors">
                            <input type="text" id="no_telp" name="no_telp" maxlength="20"
                                   value="{{ old('no_telp', $nasabah->no_telp) }}"
                                   class="form-control @error('no_telp') is-invalid @enderror">
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-field name="jenis_usaha" label="Jenis Usaha Nasabah" :errors="$errors">
                            <input type="text" id="jenis_usaha" name="jenis_usaha" maxlength="100"
                                   value="{{ old('jenis_usaha', $nasabah->jenis_usaha) }}"
                                   class="form-control @error('jenis_usaha') is-invalid @enderror">
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center"
             style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;">
            <a href="{{ route('nasabah.show', $nasabah) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</x-app-layout>
