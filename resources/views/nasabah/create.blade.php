<x-app-layout title="Tambah Nasabah" page-title="Tambah Nasabah">
    <div class="section-header">
        <h1 class="text-h1">Tambah Nasabah Baru</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('nasabah.index') }}">Data Nasabah</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Tambah</span>
        </div>
    </div>

    @if ($errors->any() && $errors->count() > 1)
        <x-alert type="danger">
            <strong>Beberapa data belum terisi dengan benar.</strong> Periksa pesan di bawah setiap kolom.
        </x-alert>
    @endif

    <form method="POST" action="{{ route('nasabah.store') }}" class="w-100 d-flex flex-column gap-3">
        @csrf

        {{-- ── Seksi 1: Identitas Nasabah ───────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Bagian 1 — Identitas Nasabah</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">
                        Data pokok keanggotaan yang akan tercatat sebagai master nasabah koperasi.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="no_anggota" label="Nomor Anggota" required :errors="$errors"
                                      helper="Terisi otomatis berurutan mengikuti data terakhir. Contoh: HST-021.">
                            <input type="text" id="no_anggota" name="no_anggota" maxlength="30"
                                   value="{{ old('no_anggota', $noAnggota) }}"
                                   readonly
                                   class="form-control @error('no_anggota') is-invalid @enderror" required>
                        </x-form-field>
                    </div>

                    <div class="col-12 col-md-6">
                        <x-form-field name="nama_nasabah" label="Nama Lengkap" required :errors="$errors"
                                      helper="Tulis nama sesuai KTP nasabah.">
                            <input type="text" id="nama_nasabah" name="nama_nasabah" maxlength="100"
                                   value="{{ old('nama_nasabah') }}"
                                   placeholder="contoh: Budi Santoso"
                                   class="form-control @error('nama_nasabah') is-invalid @enderror" required>
                        </x-form-field>
                    </div>

                    <div class="col-12">
                        <x-form-field name="alamat" label="Alamat Tempat Tinggal" :errors="$errors"
                                      helper="Tulis alamat lengkap nasabah agar mudah dihubungi.">
                            <textarea id="alamat" name="alamat" rows="3"
                                      placeholder="contoh: Dusun Krajan RT 02 RW 04, Girimarto, Wonogiri"
                                      class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Seksi 2: Kontak & Usaha ───────────────────────────────────────────── --}}
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Bagian 2 — Kontak &amp; Usaha</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">
                        Informasi pendukung untuk verifikasi dan komunikasi dengan nasabah.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="no_telp" label="Nomor Telepon / WhatsApp" :errors="$errors"
                                      helper="Boleh dikosongkan jika nasabah tidak memiliki nomor telepon.">
                            <input type="text" id="no_telp" name="no_telp" maxlength="20"
                                   value="{{ old('no_telp') }}"
                                   placeholder="contoh: 0812-3456-7890"
                                   class="form-control @error('no_telp') is-invalid @enderror">
                        </x-form-field>
                    </div>

                    <div class="col-12 col-md-6">
                        <x-form-field name="jenis_usaha" label="Jenis Usaha Nasabah" :errors="$errors"
                                      helper="Sebut profesi atau jenis usaha utama nasabah.">
                            <input type="text" id="jenis_usaha" name="jenis_usaha" maxlength="100"
                                   value="{{ old('jenis_usaha') }}"
                                   placeholder="contoh: Pedagang sayur, Tukang jahit, Petani"
                                   class="form-control @error('jenis_usaha') is-invalid @enderror">
                        </x-form-field>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Action Bar ───────────────────────────────────────────────────────── --}}
        <div class="d-flex justify-content-between align-items-center"
             style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;">
            <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan Data Nasabah
            </button>
        </div>
    </form>
</x-app-layout>
