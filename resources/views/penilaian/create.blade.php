<x-app-layout title="Pengajuan Pembiayaan Baru" page-title="Pengajuan Pembiayaan Baru" :periode-aktif="$periodeAktif">

    <div class="section-header">
        <h1 class="text-h1">Pengajuan Pembiayaan Baru</h1>
        <div class="breadcrumb-meta">
            <a href="{{ route('pengajuan.index') }}">Pengajuan</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Tambah pengajuan</span>
        </div>
    </div>

    @if ($errors->any() && $errors->count() > 1)
        <x-alert type="danger">
            <strong>Beberapa data belum terisi dengan benar.</strong> Periksa pesan di bawah setiap kolom.
        </x-alert>
    @endif

    <form
        method="POST"
        action="{{ route('pengajuan.store') }}"
        novalidate
        autocomplete="off"
    >
        @csrf

        {{-- ── Bagian 1: Identitas Nasabah (partial bersama create/edit) ───────── --}}
        @include('penilaian.partials.form-nasabah', [
            'pengajuan'     => null,
            'periode'       => $periodeAktif,
            'batasiTanggal' => true,
        ])

        {{-- ── Formulir Analisis Pembiayaan (replika formulir manual koperasi) ─── --}}
        @include('penilaian.partials.form-analisis', ['pengajuan' => null])

        {{-- ── Action Bar ───────────────────────────────────────────────────────── --}}
        <div
            class="d-flex justify-content-between align-items-center"
            style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;"
        >
            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan &amp; Nilai Kelayakan
            </button>
        </div>
    </form>

</x-app-layout>
