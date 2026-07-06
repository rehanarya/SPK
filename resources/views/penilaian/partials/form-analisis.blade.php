{{--
    Partial formulir "ANALISIS PEMBIAYAAN" — replikasi 1:1 formulir manual
    KSPPS Berkah Sakinah Almughni (revisi pasca-sidang).

    Dipakai oleh penilaian/create.blade.php dan penilaian/edit.blade.php.
    Variabel: $pengajuan (Pengajuan|null — null saat create), $errors.

    Baris "HITUNG OTOMATIS" = field readonly tanpa atribut name (tidak dikirim
    ke server); sumber kebenaran perhitungan ada di AnalisisPembiayaanService.
--}}

@php
    $nilai = fn (string $field, $default = null) => old($field, $pengajuan?->{$field} ?? $default);
    $fmt   = fn ($v) => $v !== null && $v !== '' ? number_format((float) $v, 0, ',', '.') : '';
@endphp

<input type="hidden" name="mode_input" value="analisis">

{{-- ══ Kartu ANALISIS PEMBIAYAAN (Seksi 1–6 formulir manual) ══════════════ --}}
<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Analisis Pembiayaan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Isi angka sesuai formulir manual koperasi. Baris bertanda
                <span class="badge text-bg-light" style="font-weight: 600;">otomatis</span> dihitung langsung oleh sistem.
                Tanda <x-criteria-badge type="benefit" /> berarti <em>semakin besar semakin baik</em>;
                tanda <x-criteria-badge type="cost" /> berarti <em>semakin kecil semakin baik</em>.
            </p>
        </div>
    </div>
    <div class="card-body">

        {{-- ── 1. Perhitungan Laba Usaha (dalam 1 bulan) ─────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">1. Perhitungan Laba Usaha <span class="text-meta">(dalam 1 bulan)</span></h3>

        {{-- Alat bantu UI untuk nasabah pegawai — bukan kriteria, tidak menyentuh model WP --}}
        <x-form-field name="sumber_penghasilan" label="Sumber Penghasilan Utama" :errors="$errors"
            helper="Untuk pegawai/karyawan: isi gaji bulanan pada kolom Penjualan Usaha; HPP dan Biaya Usaha biarkan 0.">
            <div class="d-flex gap-4" style="padding: 4px 0;">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sumber_penghasilan" id="sumber_usaha" value="usaha"
                        {{ $nilai('sumber_penghasilan', 'usaha') !== 'gaji' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sumber_usaha">Usaha</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sumber_penghasilan" id="sumber_gaji" value="gaji"
                        {{ $nilai('sumber_penghasilan') === 'gaji' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sumber_gaji">Gaji / Pegawai</label>
                </div>
            </div>
        </x-form-field>

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <x-form-field name="penjualan_usaha" label="Penjualan Usaha (Rp)" required :errors="$errors"
                    helper="Omzet penjualan usaha nasabah dalam satu bulan.">
                    <input type="text" id="penjualan_usaha" name="penjualan_usaha"
                        value="{{ $nilai('penjualan_usaha') }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 33.400.000"
                        class="form-control @error('penjualan_usaha') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="harga_pokok_jual" label="Harga Pokok Jual (Rp)" :errors="$errors"
                    helper="Modal / harga pokok barang yang dijual dalam satu bulan. Boleh 0 / kosong untuk pegawai.">
                    <input type="text" id="harga_pokok_jual" name="harga_pokok_jual"
                        value="{{ $nilai('harga_pokok_jual') }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 24.500.000"
                        class="form-control @error('harga_pokok_jual') is-invalid @enderror">
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="biaya_usaha" label="Biaya Usaha (Rp)" :errors="$errors"
                    helper="Biaya operasional usaha (listrik, transport, tenaga, dll). Boleh 0 / kosong untuk pegawai.">
                    <input type="text" id="biaya_usaha" name="biaya_usaha"
                        value="{{ $nilai('biaya_usaha') }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 5.000.000"
                        class="form-control @error('biaya_usaha') is-invalid @enderror">
                </x-form-field>
            </div>
        </div>
        <x-form-field name="laba_usaha_display" label="Laba Usaha (Rp) — otomatis" badge="benefit" :errors="$errors"
            helper="Kriteria C1. Dihitung otomatis: Penjualan Usaha − Harga Pokok Jual − Biaya Usaha.">
            <input type="text" id="laba_usaha_display" class="form-control font-numeric" data-hitung="laba_usaha" readonly tabindex="-1" value="{{ $fmt($pengajuan?->C1_laba_usaha) }}">
        </x-form-field>

        <hr style="margin: 20px 0;">

        {{-- ── 2. Perhitungan Kemampuan Bayar ─────────────────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">2. Perhitungan Kemampuan Bayar</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <x-form-field name="laba_usaha_echo" label="Laba Usaha (Rp) — otomatis" :errors="$errors">
                    <input type="text" class="form-control font-numeric" data-hitung="laba_usaha" readonly tabindex="-1" value="{{ $fmt($pengajuan?->C1_laba_usaha) }}">
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="pendapatan_pasangan" label="Pendapatan dari Istri/Suami (Rp)" required :errors="$errors"
                    helper="Isi 0 bila tidak ada.">
                    <input type="text" id="pendapatan_pasangan" name="pendapatan_pasangan"
                        value="{{ $nilai('pendapatan_pasangan', 0) }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control @error('pendapatan_pasangan') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="pendapatan_lainnya" label="Pendapatan Lainnya (Rp)" required :errors="$errors"
                    helper="Isi 0 bila tidak ada.">
                    <input type="text" id="pendapatan_lainnya" name="pendapatan_lainnya"
                        value="{{ $nilai('pendapatan_lainnya', 0) }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control @error('pendapatan_lainnya') is-invalid @enderror" required>
                </x-form-field>
            </div>
        </div>
        <x-form-field name="jumlah_pendapatan_display" label="Jumlah Pendapatan (Rp) — otomatis" :errors="$errors"
            helper="Dihitung otomatis: Laba Usaha + Pendapatan Istri/Suami + Pendapatan Lainnya.">
            <input type="text" class="form-control font-numeric" data-hitung="jumlah_pendapatan" readonly tabindex="-1">
        </x-form-field>

        <hr style="margin: 20px 0;">

        {{-- ── 3. Biaya dan Pengeluaran di Luar Usaha ─────────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">3. Biaya dan Pengeluaran di Luar Usaha</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <x-form-field name="kebutuhan_rumah_tangga" label="Kebutuhan Rmh. Tangga (Rp)" required :errors="$errors">
                    <input type="text" id="kebutuhan_rumah_tangga" name="kebutuhan_rumah_tangga"
                        value="{{ $nilai('kebutuhan_rumah_tangga') }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 2.500.000"
                        class="form-control @error('kebutuhan_rumah_tangga') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="biaya_pendidikan" label="Biaya Pendidikan (Rp)" required :errors="$errors"
                    helper="Isi 0 bila tidak ada.">
                    <input type="text" id="biaya_pendidikan" name="biaya_pendidikan"
                        value="{{ $nilai('biaya_pendidikan', 0) }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control @error('biaya_pendidikan') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="biaya_lainnya" label="Biaya Lainnya (Rp)" required :errors="$errors"
                    helper="Isi 0 bila tidak ada.">
                    <input type="text" id="biaya_lainnya" name="biaya_lainnya"
                        value="{{ $nilai('biaya_lainnya', 0) }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control @error('biaya_lainnya') is-invalid @enderror" required>
                </x-form-field>
            </div>
        </div>
        <x-form-field name="jumlah_pengeluaran_display" label="Jumlah Pengeluaran (Rp) — otomatis" :errors="$errors"
            helper="Dihitung otomatis: Kebutuhan Rmh. Tangga + Biaya Pendidikan + Biaya Lainnya.">
            <input type="text" class="form-control font-numeric" data-hitung="jumlah_pengeluaran" readonly tabindex="-1">
        </x-form-field>

        <hr style="margin: 20px 0;">

        {{-- ── 4. Jumlah Pendapatan Bersih ────────────────────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">4. Jumlah Pendapatan Bersih</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <x-form-field name="jumlah_pendapatan_echo" label="Jumlah Pendapatan (Rp) — otomatis" :errors="$errors">
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_pendapatan" readonly tabindex="-1">
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="jumlah_pengeluaran_echo" label="Jumlah Pengeluaran (Rp) — otomatis" :errors="$errors">
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_pengeluaran" readonly tabindex="-1">
                </x-form-field>
            </div>
            <div class="col-12 col-md-4">
                <x-form-field name="pendapatan_bersih_display" label="Pendapatan Bersih (Rp) — otomatis" badge="benefit" :errors="$errors"
                    helper="Kriteria C2. Jumlah Pendapatan − Jumlah Pengeluaran; wajib lebih dari Rp 0.">
                    <input type="text" class="form-control font-numeric" data-hitung="pendapatan_bersih" readonly tabindex="-1" value="{{ $fmt($pengajuan?->C2_pendapatan_bersih) }}">
                </x-form-field>
            </div>
        </div>

        <hr style="margin: 20px 0;">

        {{-- ── 5. Rasio Angsuran ──────────────────────────────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">5. Rasio Angsuran</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <x-form-field name="rasio_angsuran" label="Rasio Angsuran (%)" required :errors="$errors"
                    helper="Persentase pendapatan bersih yang boleh dipakai mengangsur. Standar koperasi: 40%.">
                    <input type="number" id="rasio_angsuran" name="rasio_angsuran"
                        value="{{ $nilai('rasio_angsuran', 40) }}" min="1" max="100" step="0.01" data-komponen
                        class="form-control @error('rasio_angsuran') is-invalid @enderror" required>
                </x-form-field>
            </div>
        </div>

        <hr style="margin: 20px 0;">

        {{-- ── 6. Jumlah Pembiayaan Yang Dapat Diberikan ──────────────────── --}}
        <h3 class="text-h3" style="margin-bottom: 12px;">6. Jumlah Pembiayaan Yang Dapat Diberikan</h3>
        <div class="row g-3">
            <div class="col-12 col-md-3">
                <x-form-field name="rasio_echo" label="Rasio Angsuran — otomatis" :errors="$errors">
                    <input type="text" class="form-control font-numeric" data-hitung="rasio_echo" readonly tabindex="-1">
                </x-form-field>
            </div>
            <div class="col-12 col-md-3">
                <x-form-field name="pendapatan_bersih_echo" label="Pendapatan Bersih (Rp) — otomatis" :errors="$errors">
                    <input type="text" class="form-control font-numeric" data-hitung="pendapatan_bersih" readonly tabindex="-1">
                </x-form-field>
            </div>
            <div class="col-12 col-md-3">
                <x-form-field name="C5_jangka_waktu" label="Jangka Waktu (bulan)" required badge="cost" :errors="$errors"
                    helper="Kriteria C5. Lama angsuran, maksimal 48 bulan.">
                    <input type="number" id="C5_jangka_waktu" name="C5_jangka_waktu"
                        value="{{ $nilai('C5_jangka_waktu') }}" min="1" max="48" step="1" data-komponen
                        placeholder="contoh: 24"
                        class="form-control @error('C5_jangka_waktu') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-3">
                <x-form-field name="plafon_display" label="Jumlah Pembiayaan / Plafon (Rp) — otomatis" :errors="$errors"
                    helper="Pendapatan Bersih × Rasio Angsuran × Jangka Waktu.">
                    <input type="text" class="form-control font-numeric" data-hitung="plafon" readonly tabindex="-1" value="{{ $fmt($pengajuan?->plafon_pembiayaan) }}">
                </x-form-field>
            </div>
        </div>

    </div>
</div>

{{-- ══ Kartu USULAN PEMBIAYAAN ═════════════════════════════════════════════ --}}
<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Usulan Pembiayaan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">Rincian usulan sesuai blok "USULAN PEMBIAYAAN" formulir manual.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <x-form-field name="C4_besar_pembiayaan" label="1. Besarnya Pembiayaan (Rp)" required badge="cost" :errors="$errors"
                    helper="Kriteria C4. Nominal pinjaman yang diajukan nasabah.">
                    <input type="text" id="C4_besar_pembiayaan" name="C4_besar_pembiayaan"
                        value="{{ $nilai('C4_besar_pembiayaan') }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 8.000.000"
                        class="form-control @error('C4_besar_pembiayaan') is-invalid @enderror" required>
                    <div id="indikator_plafon" class="form-helper" style="display: none; margin-top: 6px; font-weight: 600;"></div>
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="jangka_echo" label="2. Jangka Waktu (bulan) — otomatis" :errors="$errors"
                    helper="Mengikuti Jangka Waktu pada Seksi 6 Analisis Pembiayaan.">
                    <input type="text" class="form-control font-numeric" data-hitung="jangka_echo" readonly tabindex="-1">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="angsuran_pokok_display" label="3. Angsuran Pokok (Rp) — otomatis" :errors="$errors"
                    helper="Besarnya Pembiayaan ÷ Jangka Waktu.">
                    <input type="text" class="form-control font-numeric" data-hitung="angsuran_pokok" readonly tabindex="-1" value="{{ $fmt($pengajuan?->angsuran_pokok) }}">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="bagi_hasil_display" label="4. Bagi Hasil (Rp / bulan) — otomatis" :errors="$errors"
                    helper="Dihitung otomatis: {{ \App\Services\AnalisisPembiayaanService::BAGI_HASIL_PERSEN }}% × Besarnya Pembiayaan.">
                    <input type="text" class="form-control font-numeric" data-hitung="bagi_hasil" readonly tabindex="-1" value="{{ $fmt($pengajuan?->bagi_hasil) }}">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="simpanan" label="5. Simpanan (Rp / bulan)" required :errors="$errors"
                    helper="Simpanan wajib per bulan. Standar koperasi: Rp 10.000.">
                    <input type="text" id="simpanan" name="simpanan"
                        value="{{ $nilai('simpanan', 10000) }}" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control @error('simpanan') is-invalid @enderror" required>
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="jumlah_angsuran_display" label="6. Jumlah Angsuran (Rp) — otomatis" :errors="$errors"
                    helper="Angsuran Pokok + Bagi Hasil + Simpanan.">
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_angsuran" readonly tabindex="-1" value="{{ $fmt($pengajuan?->jumlah_angsuran) }}">
                </x-form-field>
            </div>
        </div>
    </div>
</div>

{{-- ══ Kartu PERSETUJUAN (DISETUJUI / TIDAK DISETUJUI) ═════════════════════ --}}
<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Persetujuan (Disetujui / Tidak Disetujui)</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Data blok "DISETUJUI / TIDAK DISETUJUI" formulir manual. Status akhir ditentukan
                hasil perhitungan sistem dan keputusan petugas.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <x-form-field name="nama_persetujuan" label="1. Nama — otomatis" :errors="$errors"
                    helper="Terisi otomatis dari nasabah yang dipilih pada Bagian 1.">
                    <input type="text" class="form-control" data-hitung="nama_nasabah" readonly tabindex="-1" value="{{ $pengajuan?->nasabah?->nama_nasabah }}">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="alamat_persetujuan" label="2. Alamat — otomatis" :errors="$errors">
                    <input type="text" class="form-control" data-hitung="alamat_nasabah" readonly tabindex="-1" value="{{ $pengajuan?->nasabah?->alamat }}">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="jenis_akad" label="3. Pembiayaan (Jenis Akad)" required :errors="$errors"
                    helper="Jenis akad syariah pembiayaan.">
                    <select id="jenis_akad" name="jenis_akad" class="form-select @error('jenis_akad') is-invalid @enderror" required>
                        <option value="">— Pilih jenis akad —</option>
                        @foreach (\App\Models\Pengajuan::AKAD_LIST as $akad)
                            <option value="{{ $akad }}" {{ $nilai('jenis_akad') === $akad ? 'selected' : '' }}>{{ $akad }}</option>
                        @endforeach
                    </select>
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="nominal_persetujuan" label="Nominal &amp; Terbilang — otomatis" :errors="$errors"
                    helper="Mengikuti Besarnya Pembiayaan pada Usulan Pembiayaan.">
                    <input type="text" class="form-control font-numeric mb-1" data-hitung="nominal_pembiayaan" readonly tabindex="-1">
                    <input type="text" class="form-control" data-hitung="terbilang_pembiayaan" readonly tabindex="-1" style="font-style: italic;">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                @php
                    $tglRealisasi = $nilai('tanggal_realisasi');
                    $tglRealisasi = $tglRealisasi instanceof \Carbon\CarbonInterface ? $tglRealisasi->format('Y-m-d') : $tglRealisasi;
                @endphp
                <x-form-field name="tanggal_realisasi" label="4. Realisasi (Tanggal)" :errors="$errors"
                    helper="Boleh dikosongkan bila belum direalisasikan.">
                    <input type="date" id="tanggal_realisasi" name="tanggal_realisasi"
                        value="{{ $tglRealisasi }}"
                        class="form-control @error('tanggal_realisasi') is-invalid @enderror">
                </x-form-field>
            </div>
            <div class="col-12 col-md-6">
                <x-form-field name="C3_nilai_agunan" label="5. Agunan" required badge="benefit" :errors="$errors"
                    helper="Kriteria C3. Pilihan agunan otomatis dipetakan ke skala ordinal 1–4.">
                    <select id="C3_nilai_agunan" name="C3_nilai_agunan" class="form-select @error('C3_nilai_agunan') is-invalid @enderror" required>
                        <option value="">— Pilih agunan —</option>
                        @foreach (\App\Models\Pengajuan::AGUNAN_LABELS as $skala => $label)
                            <option value="{{ $skala }}" {{ (string) $nilai('C3_nilai_agunan') === (string) $skala ? 'selected' : '' }}>
                                {{ $label }} (skala {{ $skala }})
                            </option>
                        @endforeach
                    </select>
                </x-form-field>
            </div>
        </div>
    </div>
</div>

{{-- ══ Kartu TANDA TANGAN (Anggota + Petugas — Manager menandatangani di Penetapan Keputusan) ══ --}}
<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Tanda Tangan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Goreskan tanda tangan Anggota dan Petugas dengan mouse/jari. Opsional —
                bila dikosongkan, formulir cetak menyisakan ruang tanda tangan basah.
                Tanda tangan Manager dibubuhkan di halaman Penetapan Keputusan.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <x-signature-pad name="ttd_anggota" label="Anggota"
                    person-hook="nama_nasabah"
                    :person="$pengajuan?->nasabah?->nama_nasabah"
                    :existing="$pengajuan?->ttd_anggota" />
            </div>
            <div class="col-12 col-md-6">
                <x-signature-pad name="ttd_petugas" label="Petugas"
                    :person="auth()->user()?->nama"
                    :existing="$pengajuan?->ttd_petugas" />
            </div>
        </div>
    </div>
</div>

{{-- ══ JavaScript hitung langsung (tampilan saja — server tetap menghitung ulang) ══ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil angka polos dari input bermask rupiah / number
    function angka(id) {
        var el = document.getElementById(id);
        if (!el) return 0;
        // Input bermask memakai titik ribuan — buang semua titik lalu parse
        var n = parseFloat(String(el.value).replace(/\./g, '').replace(',', '.'));
        return isNaN(n) ? 0 : n;
    }

    var fmt = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 });

    function tulis(kunci, teks) {
        document.querySelectorAll('[data-hitung="' + kunci + '"]').forEach(function (el) {
            el.value = teks;
        });
    }

    // Terbilang bahasa Indonesia sederhana (padanan App\Support\Terbilang)
    var SATUAN = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
    function terbilang(n) {
        n = Math.floor(Math.abs(n));
        if (n < 12) return SATUAN[n];
        if (n < 20) return terbilang(n - 10) + ' belas';
        if (n < 100) return (terbilang(Math.floor(n / 10)) + ' puluh ' + terbilang(n % 10)).trim();
        if (n < 200) return ('seratus ' + terbilang(n - 100)).trim();
        if (n < 1000) return (terbilang(Math.floor(n / 100)) + ' ratus ' + terbilang(n % 100)).trim();
        if (n < 2000) return ('seribu ' + terbilang(n - 1000)).trim();
        if (n < 1e6) return (terbilang(Math.floor(n / 1000)) + ' ribu ' + terbilang(n % 1000)).trim();
        if (n < 1e9) return (terbilang(Math.floor(n / 1e6)) + ' juta ' + terbilang(n % 1e6)).trim();
        return (terbilang(Math.floor(n / 1e9)) + ' miliar ' + terbilang(n % 1e9)).trim();
    }

    function hitungUlang() {
        // Seksi 1 — Laba Usaha = Penjualan − HPP − Biaya Usaha
        var laba = angka('penjualan_usaha') - angka('harga_pokok_jual') - angka('biaya_usaha');
        // Seksi 2 — Jumlah Pendapatan
        var jumlahPendapatan = laba + angka('pendapatan_pasangan') + angka('pendapatan_lainnya');
        // Seksi 3 — Jumlah Pengeluaran
        var jumlahPengeluaran = angka('kebutuhan_rumah_tangga') + angka('biaya_pendidikan') + angka('biaya_lainnya');
        // Seksi 4 — Pendapatan Bersih
        var bersih = jumlahPendapatan - jumlahPengeluaran;
        // Seksi 5–6 — Plafon
        var rasio = angka('rasio_angsuran') || 40;
        var jangka = angka('C5_jangka_waktu');
        var plafon = bersih * (rasio / 100) * jangka;
        // Usulan — bagi hasil otomatis 2% × Besarnya Pembiayaan (per bulan)
        var besar = angka('C4_besar_pembiayaan');
        var pokok = jangka > 0 ? Math.round((besar / jangka) * 100) / 100 : 0;
        var bagiHasil = Math.round(besar * {{ \App\Services\AnalisisPembiayaanService::BAGI_HASIL_PERSEN }} ) / 100;
        var jumlahAngsuran = pokok + bagiHasil + angka('simpanan');

        tulis('laba_usaha', fmt.format(laba));
        tulis('jumlah_pendapatan', fmt.format(jumlahPendapatan));
        tulis('jumlah_pengeluaran', fmt.format(jumlahPengeluaran));
        tulis('pendapatan_bersih', fmt.format(bersih));
        tulis('rasio_echo', fmt.format(rasio) + ' %');
        tulis('jangka_echo', jangka > 0 ? jangka + ' bulan' : '');
        tulis('plafon', fmt.format(plafon));
        tulis('angsuran_pokok', fmt.format(pokok));
        tulis('bagi_hasil', besar > 0 ? fmt.format(bagiHasil) : '');
        tulis('jumlah_angsuran', fmt.format(jumlahAngsuran));
        tulis('nominal_pembiayaan', besar > 0 ? 'Rp ' + fmt.format(besar) : '');
        tulis('terbilang_pembiayaan', besar > 0 ? (terbilang(besar) + ' rupiah').replace(/^./, function (c) { return c.toUpperCase(); }) : '');

        // Indikator hijau (≤ plafon) / kuning (> plafon) untuk Besarnya Pembiayaan
        var ind = document.getElementById('indikator_plafon');
        if (ind) {
            if (besar > 0 && plafon > 0) {
                ind.style.display = 'block';
                if (besar <= plafon) {
                    ind.className = 'form-helper text-success';
                    ind.textContent = '✔ Dalam batas plafon (Rp ' + fmt.format(plafon) + ')';
                } else {
                    ind.className = 'form-helper text-warning';
                    ind.textContent = '⚠ Melebihi plafon hitung (Rp ' + fmt.format(plafon) + ') — keputusan tetap di petugas';
                }
            } else {
                ind.style.display = 'none';
            }
        }
    }

    // Nama & alamat otomatis dari nasabah terpilih (Bagian 1)
    var selectNasabah = document.getElementById('id_nasabah');
    function isiIdentitas() {
        if (!selectNasabah) return;
        var opt = selectNasabah.options[selectNasabah.selectedIndex];
        var nama = opt && opt.value ? (opt.dataset.nama || opt.text.trim()) : '';
        tulis('nama_nasabah', nama);
        tulis('alamat_nasabah', opt && opt.value ? (opt.dataset.alamat || '') : '');
        // Nama di pad tanda tangan Anggota (elemen teks, bukan input)
        document.querySelectorAll('[data-hitung-teks="nama_nasabah"]').forEach(function (el) {
            el.textContent = nama || '—';
        });
    }
    if (selectNasabah) selectNasabah.addEventListener('change', isiIdentitas);

    // ── Sumber penghasilan: mode Gaji/Pegawai ────────────────────────────
    // Label "Penjualan Usaha" berubah tampil jadi "Penjualan Usaha / Gaji
    // Bulanan"; HPP & Biaya Usaha otomatis 0 (tetap bisa diubah manual).
    function terapkanSumber() {
        var gaji = document.getElementById('sumber_gaji');
        var modeGaji = gaji && gaji.checked;

        var label = document.querySelector('label[for="penjualan_usaha"]');
        if (label) {
            label.childNodes.forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE && node.nodeValue.trim() !== '') {
                    node.nodeValue = modeGaji ? ' Penjualan Usaha / Gaji Bulanan (Rp) ' : ' Penjualan Usaha (Rp) ';
                }
            });
        }

        var grup = document.getElementById('penjualan_usaha');
        var helper = grup ? grup.closest('.form-group').querySelector('.form-helper') : null;
        if (helper) {
            helper.textContent = modeGaji
                ? 'Masukkan gaji bulanan di kolom ini; HPP dan Biaya Usaha biarkan 0.'
                : 'Omzet penjualan usaha nasabah dalam satu bulan.';
        }

        if (modeGaji) {
            ['harga_pokok_jual', 'biaya_usaha'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el && angka(id) === 0) {
                    el.value = '0';
                    el.dispatchEvent(new Event('input', { bubbles: true })); // sinkron IMask + hitung ulang
                }
            });
        }
    }
    ['sumber_usaha', 'sumber_gaji'].forEach(function (id) {
        var radio = document.getElementById(id);
        if (radio) radio.addEventListener('change', terapkanSumber);
    });

    document.querySelectorAll('[data-komponen]').forEach(function (el) {
        el.addEventListener('input', hitungUlang);
    });

    hitungUlang();
    isiIdentitas();
    terapkanSumber();
});
</script>
