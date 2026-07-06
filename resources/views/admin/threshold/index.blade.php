<x-app-layout title="Kalibrasi Ambang Kelayakan" page-title="Kalibrasi Ambang Kelayakan">
    <div class="section-header">
        <h1 class="text-h1">Kalibrasi Ambang Kelayakan</h1>
        <div class="breadcrumb-meta">
            Sesuaikan ambang kelayakan berdasarkan data nasabah yang sudah pernah diputuskan
        </div>
    </div>

    @isset($error)
        <x-alert type="danger">{{ $error }}</x-alert>
    @endisset

    @if ($errors->has('theta_manual'))
        <x-alert type="danger">{{ $errors->first('theta_manual') }}</x-alert>
    @endif

    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <x-kpi-card
                label="Ambang Kelayakan Saat Ini"
                icon="bi-rulers"
                :value="number_format($theta, 0, ',', '.')"
                meta="Skor minimum agar nasabah dianggap layak"
            />
        </div>
        <div class="col-12 col-lg-6">
            <x-kpi-card
                label="Riwayat Keputusan Tersedia"
                icon="bi-clipboard-data"
                :variant="$siap ? 'accept' : 'pending'"
                :value="$jumlahLog"
                :meta="$siap ? 'Data cukup untuk kalibrasi otomatis' : 'Perlu minimal 20 data untuk kalibrasi otomatis'"
            />
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header"><h2 class="text-h2">Atur Ambang Kelayakan</h2></div>
        <div class="card-body">
            <p class="text-body" style="margin-bottom: 16px;">
                Sistem dapat menghitung ambang kelayakan baru secara otomatis dari riwayat keputusan
                yang telah dibuat. Anda juga dapat mengatur nilainya secara manual bila ingin
                mengembalikan ke standar tertentu (misal kembali ke nilai 250).
            </p>
            <p class="text-meta" style="margin-bottom: 16px;">
                Untuk kalibrasi otomatis, hasilnya hanya akan disimpan setelah Anda mengkonfirmasinya
                pada langkah berikutnya.
            </p>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <form method="POST" action="{{ route('admin.threshold.preview') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-primary-strong" {{ $siap ? '' : 'disabled' }}>
                        <i class="bi bi-play-circle"></i> Lihat Hasil Kalibrasi
                    </button>
                </form>

                <button type="button" class="btn btn-secondary"
                        data-bs-toggle="modal" data-bs-target="#modalAmbangManual">
                    <i class="bi bi-pencil-square"></i> Atur Ambang Manual
                </button>

                @unless ($siap)
                    <span class="text-meta" style="margin-left: 8px;">
                        Kalibrasi otomatis belum tersedia — baru {{ $jumlahLog }} dari minimal 20 data.
                    </span>
                @endunless
            </div>
        </div>
    </div>

    {{-- ── Modal Atur Ambang Manual ─────────────────────────────────────────── --}}
    <div class="modal fade"
         id="modalAmbangManual"
         tabindex="-1"
         aria-labelledby="modalAmbangManualTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content"
                 style="border-radius: 12px; border: 1px solid var(--color-border); box-shadow: var(--elev-3);">

                <form method="POST" action="{{ route('admin.threshold.manual') }}">
                    @csrf

                    <div class="modal-header"
                         style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                        <h3 class="text-h3" style="margin: 0;" id="modalAmbangManualTitle">
                            Atur Ambang Kelayakan Secara Manual
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body" style="padding: 20px;">
                        <p class="text-meta" style="margin: 0 0 16px 0;">
                            Masukkan skor minimum agar pengajuan dianggap layak. Nilai standar awal sistem adalah
                            <strong>250</strong>.
                        </p>

                        <x-form-field name="theta_manual"
                                      label="Ambang Kelayakan Baru"
                                      required
                                      :errors="$errors"
                                      helper="Bilangan bulat ≥ 1. Hindari angka terlalu kecil agar penilaian tetap selektif.">
                            <input
                                type="number"
                                id="theta_manual"
                                name="theta_manual"
                                value="{{ old('theta_manual', (int) $theta) }}"
                                min="1"
                                max="99999"
                                step="1"
                                inputmode="numeric"
                                placeholder="contoh: 250"
                                class="form-control @error('theta_manual') is-invalid @enderror"
                                required
                                autofocus
                            >
                        </x-form-field>

                        <div class="text-meta" style="margin-top: 8px;">
                            Nilai saat ini: <strong class="font-numeric">{{ number_format($theta, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="modal-footer"
                         style="border-top: 1px solid var(--color-border); padding: 12px 20px; display: flex; justify-content: space-between; gap: 12px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-strong">
                            <i class="bi bi-check2-circle"></i> Simpan Ambang Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->has('theta_manual'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('modalAmbangManual'));
                modal.show();
            });
        </script>
    @endif
</x-app-layout>
