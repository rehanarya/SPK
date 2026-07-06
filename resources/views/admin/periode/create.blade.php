<x-app-layout title="Tambah Minggu Pengajuan" page-title="Tambah Minggu Pengajuan">
    <div class="section-header">
        <h1 class="text-h1">Tambah Minggu Pengajuan</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('admin.periode.index') }}">Minggu Pengajuan</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Tambah</span>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.periode.store') }}" id="formPeriode" class="w-100 d-flex flex-column gap-3">
        @csrf

        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Pilih Minggu Pengajuan Baru</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">
                        Cukup pilih satu hari dalam minggu yang ingin Anda buat. Sistem otomatis
                        menentukan Senin sebagai hari mulai dan Jumat sebagai hari selesai.
                    </p>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <x-form-field name="tanggal_acuan" label="Hari Apa Saja dalam Minggu yang Diinginkan" required :errors="$errors"
                                      helper="Misal: pilih Selasa 19 Mei 2026 — sistem otomatis membuat minggu 18–22 Mei 2026.">
                            <input type="date" id="tanggal_acuan" name="tanggal_acuan"
                                   value="{{ old('tanggal_acuan', now()->toDateString()) }}"
                                   class="form-control @error('tanggal_acuan') is-invalid @enderror" required>
                        </x-form-field>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Kode Minggu (otomatis)</label>
                        <input type="text" id="preview_kode" class="form-control font-numeric"
                               readonly tabindex="-1"
                               style="background-color: var(--color-bg-subtle); cursor: default;">
                        <div class="form-helper">
                            Kode minggu mengikuti format <strong>Tahun-Wmm</strong> (contoh: 2026-W21).
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Hari Mulai (Senin)</label>
                        <input type="text" id="preview_mulai" class="form-control"
                               readonly tabindex="-1"
                               style="background-color: var(--color-bg-subtle); cursor: default;">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Hari Selesai (Jumat)</label>
                        <input type="text" id="preview_selesai" class="form-control"
                               readonly tabindex="-1"
                               style="background-color: var(--color-bg-subtle); cursor: default;">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center"
             style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;">
            <a href="{{ route('admin.periode.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan Minggu Baru
            </button>
        </div>
    </form>

    <script>
        (function () {
            const acuanInput   = document.getElementById('tanggal_acuan');
            const prevMulai    = document.getElementById('preview_mulai');
            const prevSelesai  = document.getElementById('preview_selesai');
            const prevKode     = document.getElementById('preview_kode');

            const HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const BULAN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            function formatLong(d) {
                return `${HARI[d.getDay()]}, ${d.getDate()} ${BULAN[d.getMonth()]} ${d.getFullYear()}`;
            }

            function startOfWeekMonday(d) {
                const day = d.getDay();
                const offset = day === 0 ? -6 : 1 - day;
                const senin = new Date(d);
                senin.setDate(d.getDate() + offset);
                senin.setHours(0, 0, 0, 0);
                return senin;
            }

            function isoWeek(d) {
                const target = new Date(d);
                target.setHours(0, 0, 0, 0);
                target.setDate(target.getDate() + 3 - ((target.getDay() + 6) % 7));
                const firstThursday = new Date(target.getFullYear(), 0, 4);
                const diff = (target - firstThursday) / 86400000;
                return {
                    year: target.getFullYear(),
                    week: 1 + Math.round((diff - 3 + ((firstThursday.getDay() + 6) % 7)) / 7),
                };
            }

            function compute() {
                if (!acuanInput.value) {
                    prevMulai.value = prevSelesai.value = prevKode.value = '';
                    return;
                }
                const acuan = new Date(acuanInput.value + 'T00:00:00');
                if (isNaN(acuan)) return;

                const senin = startOfWeekMonday(acuan);
                const jumat = new Date(senin);
                jumat.setDate(senin.getDate() + 4);

                prevMulai.value   = formatLong(senin);
                prevSelesai.value = formatLong(jumat);

                const iso = isoWeek(senin);
                prevKode.value = `${iso.year}-W${String(iso.week).padStart(2, '0')}`;
            }

            acuanInput.addEventListener('change', compute);
            compute();
        })();
    </script>
</x-app-layout>
