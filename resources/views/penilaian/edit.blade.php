<x-app-layout title="Ubah Pengajuan" page-title="Ubah Pengajuan Pembiayaan">

    <div class="section-header">
        <h1 class="text-h1">Ubah Pengajuan — {{ $pengajuan->nasabah?->nama_nasabah ?? '—' }}</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('pengajuan.index') }}">Pengajuan</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Ubah pengajuan #{{ $pengajuan->id_pengajuan }}</span>
        </div>
    </div>

    @if ($errors->any() && $errors->count() > 1)
        <x-alert type="danger">
            <strong>Beberapa data belum terisi dengan benar.</strong> Periksa pesan di bawah setiap kolom.
        </x-alert>
    @endif

    @if ($isHistoris ?? false)
        <x-alert type="info">
            <strong>Data historis.</strong> Rincian analisis pembiayaan belum tersedia untuk pengajuan ini,
            sehingga formulir diisi otomatis dari nilai kriteria tersimpan
            (Penjualan Usaha = Laba Usaha; HPP, Biaya Usaha, dan pendapatan lain = 0;
            Kebutuhan Rmh. Tangga = selisih Laba Usaha − Pendapatan Bersih).
            Skor tidak berubah selama angka tidak diubah — periksa rinciannya, lengkapi Jenis Akad, lalu simpan.
        </x-alert>
    @endif

    <form
        method="POST"
        action="{{ route('pengajuan.update', $pengajuan) }}"
        novalidate
        autocomplete="off"
    >
        @csrf
        @method('PUT')

        {{-- ── Bagian 1: Identitas Nasabah (partial bersama create/edit) ───────── --}}
        @include('penilaian.partials.form-nasabah', [
            'pengajuan'     => $pengajuan,
            'periode'       => $pengajuan->periode,
            'batasiTanggal' => false,
        ])

        {{-- ── Formulir Analisis Pembiayaan LENGKAP untuk semua rekord — rekord
             historis di-prefill dari kriteria oleh PenilaianController@edit ──── --}}
        @include('penilaian.partials.form-analisis', ['pengajuan' => $pengajuan])

        {{-- ── Realisasi & Tanda Tangan Manager (semua status keputusan;
             tanggal realisasi sudah ada di kartu Persetujuan) ──────────────────── --}}
        @include('penilaian.partials.form-realisasi', [
            'pengajuan'     => $pengajuan,
            'denganTanggal' => false,
        ])

        {{-- ── Action Bar ───────────────────────────────────────────────────────── --}}
        <div
            class="d-flex justify-content-between align-items-center"
            style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;"
        >
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan Perubahan &amp; Hitung Ulang
            </button>
        </div>
    </form>

</x-app-layout>
