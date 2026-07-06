<x-app-layout title="Ubah Bobot Faktor" page-title="Ubah Bobot Faktor Penilaian">
    <div class="section-header">
        <h1 class="text-h1">Ubah Bobot — {{ $kriteria->nama_kriteria }}</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('admin.kriteria.index') }}">Faktor Penilaian &amp; Bobot</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>{{ $kriteria->kode_kriteria }}</span>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h2 class="text-h2">Edit Bobot</h2></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kriteria.update', $kriteria) }}">
                        @csrf @method('PUT')

                        <x-form-field name="kode" label="Nama Faktor" :errors="$errors">
                            <input type="text" value="{{ $kriteria->nama_kriteria }}" class="form-control" disabled>
                        </x-form-field>

                        <x-form-field name="tipe" label="Sifat Faktor" :errors="$errors">
                            <input type="text"
                                value="{{ $kriteria->tipe === 'benefit' ? 'Semakin besar, semakin baik' : 'Semakin kecil, semakin baik' }}"
                                class="form-control" disabled>
                        </x-form-field>

                        <x-form-field name="bobot_mentah" label="Bobot Baru (1-9)" required :errors="$errors"
                                      helper="Pengaruh terhadap penilaian akan dihitung ulang otomatis untuk semua faktor.">
                            <input type="number" id="bobot_mentah" name="bobot_mentah"
                                   min="1" max="9" step="1"
                                   value="{{ old('bobot_mentah', $kriteria->bobot_mentah) }}"
                                   class="form-control @error('bobot_mentah') is-invalid @enderror" required>
                        </x-form-field>

                        <x-form-field name="satuan" label="Satuan" :errors="$errors">
                            <input type="text" id="satuan" name="satuan" maxlength="30"
                                   value="{{ old('satuan', $kriteria->satuan) }}"
                                   class="form-control @error('satuan') is-invalid @enderror">
                        </x-form-field>

                        <div style="display: flex; justify-content: space-between; margin-top: 24px;">
                            <a href="{{ route('admin.kriteria.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary-strong">
                                <i class="bi bi-check2"></i> Simpan Perubahan Bobot
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Kondisi Saat Ini</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 160px 1fr; gap: 12px 16px;">
                        <dt class="text-label">Bobot Saat Ini</dt>
                        <dd class="font-numeric" style="margin: 0;">{{ $kriteria->bobot_mentah }}</dd>
                        <dt class="text-label">Pengaruh Saat Ini</dt>
                        <dd class="font-numeric" style="margin: 0;">{{ number_format(abs($kriteria->bobot_normalisasi) * 100, 1, ',', '.') }}%</dd>
                        <dt class="text-label">Sifat</dt>
                        <dd style="margin: 0;">
                            <x-criteria-badge :type="$kriteria->tipe" />
                            {{ $kriteria->tipe === 'benefit' ? 'Benefit' : 'Cost' }}
                        </dd>
                    </dl>
                    <hr style="margin: 16px 0; border-color: var(--color-border);">
                    <p class="text-meta" style="margin: 0;">
                        Perubahan akan tercatat di riwayat dan audit log. Setelah ini, dianjurkan
                        melakukan kalibrasi ulang ambang kelayakan agar hasil penilaian tetap akurat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
