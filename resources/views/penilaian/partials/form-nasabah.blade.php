{{--
    Partial "Bagian 1 — Data Nasabah" — dipakai bersama oleh form create
    dan edit pengajuan (termasuk edit dari Penetapan Keputusan).

    Variabel:
      $pengajuan   : Pengajuan|null (null saat create)
      $periode     : Periode yang ditampilkan (periode aktif saat create,
                     periode pengajuan saat edit)
      $nasabahList : daftar nasabah untuk pilihan
      $batasiTanggal : bool — batasi tanggal ke rentang periode (create)
--}}
@php
    $batasiTanggal ??= false;
@endphp

<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Bagian 1 — Data Nasabah</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                {{ $pengajuan ? 'Nasabah dan tanggal pengajuan pada periode ' . ($periode?->kode_periode ?? '—') . '.' : 'Pilih nasabah dan tetapkan tanggal pengajuan minggu ini.' }}
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6" style="min-width: 0;">
                <x-form-field name="id_nasabah" label="Nama Nasabah" required :errors="$errors">
                    <div class="position-relative" style="width: 100%; max-width: 100%; min-width: 0;">
                        <input
                            type="text"
                            id="nasabah_search"
                            data-filters-select="#id_nasabah"
                            class="form-control mb-2"
                            placeholder="Ketik nama atau nomor anggota..."
                            autocomplete="off"
                        >
                        <select id="id_nasabah" name="id_nasabah" size="6"
                                class="form-select form-select-listbox @error('id_nasabah') is-invalid @enderror" required>
                            <option value="">— Pilih nasabah —</option>
                            @foreach ($nasabahList as $nasabah)
                                <option value="{{ $nasabah->id_nasabah }}"
                                    data-search="{{ strtolower($nasabah->nama_nasabah . ' ' . $nasabah->no_anggota) }}"
                                    data-nama="{{ $nasabah->nama_nasabah }}"
                                    data-alamat="{{ $nasabah->alamat }}"
                                    title="{{ $nasabah->nama_nasabah }} ({{ $nasabah->no_anggota }})"
                                    {{ (string) old('id_nasabah', $pengajuan?->id_nasabah) === (string) $nasabah->id_nasabah ? 'selected' : '' }}>
                                    {{ $nasabah->nama_nasabah }} ({{ $nasabah->no_anggota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-slot:helper>
                        Tidak menemukan nama? <a href="{{ route('nasabah.create') }}">Tambahkan nasabah baru</a>.
                    </x-slot:helper>
                </x-form-field>
            </div>

            <div class="col-12 col-md-6">
                <x-form-field name="periode" label="Minggu Pengajuan" :errors="$errors">
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $periode?->kode_periode }} · {{ $periode?->tanggal_mulai?->format('d M') }}–{{ $periode?->tanggal_selesai?->format('d M Y') }}"
                        disabled
                    >
                    <x-slot:helper>
                        {{ $pengajuan ? 'Periode pengajuan tidak dapat diubah.' : 'Pengajuan otomatis tercatat pada minggu yang sedang berjalan.' }}
                    </x-slot:helper>
                </x-form-field>
            </div>

            <div class="col-12 col-md-6">
                <x-form-field name="tanggal_pengajuan" label="Tanggal Pengajuan" required :errors="$errors">
                    <input
                        type="date"
                        id="tanggal_pengajuan"
                        name="tanggal_pengajuan"
                        value="{{ old('tanggal_pengajuan', $pengajuan?->tanggal_pengajuan?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                        @if ($batasiTanggal && $periode)
                            min="{{ $periode->tanggal_mulai->format('Y-m-d') }}"
                            max="{{ $periode->tanggal_selesai->format('Y-m-d') }}"
                        @endif
                        class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                        required
                    >
                </x-form-field>
            </div>
        </div>
    </div>
</div>
