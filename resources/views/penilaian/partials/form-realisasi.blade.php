{{--
    Partial "Realisasi & Tanda Tangan Manager" — hanya tampil di form EDIT
    pengajuan (termasuk edit dari Penetapan Keputusan), untuk SEMUA status.

    Variabel:
      $pengajuan     : Pengajuan (dengan relasi hasilPerhitungan bila ada)
      $denganTanggal : bool — sertakan input tanggal realisasi di seksi ini
                       (true untuk mode fallback historis; pada mode analisis
                       tanggal realisasi sudah ada di kartu Persetujuan)
--}}
@php
    $hasilWp = $pengajuan?->hasilPerhitungan;
    $denganTanggal ??= false;
@endphp

<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Realisasi &amp; Tanda Tangan Manager</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Opsional — biasanya diisi setelah keputusan pembiayaan disetujui petugas.
                Boleh dikosongkan untuk pengajuan yang masih menunggu atau ditolak.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @if ($denganTanggal)
                <div class="col-12 col-md-6">
                    <x-form-field name="tanggal_realisasi" label="Tanggal Realisasi" :errors="$errors"
                        helper="Tidak boleh sebelum tanggal pengajuan. Kosongkan bila belum direalisasikan.">
                        <input type="date" id="tanggal_realisasi" name="tanggal_realisasi"
                            value="{{ old('tanggal_realisasi', $pengajuan?->tanggal_realisasi?->format('Y-m-d')) }}"
                            class="form-control @error('tanggal_realisasi') is-invalid @enderror">
                    </x-form-field>
                </div>
            @endif
            <div class="col-12 col-md-6">
                <x-form-field name="nama_manager" label="Nama Manager" :errors="$errors"
                    helper="Nama yang tercetak di bawah tanda tangan Manager pada formulir.">
                    <input type="text" id="nama_manager" name="nama_manager"
                        value="{{ old('nama_manager', $hasilWp?->nama_manager) }}"
                        maxlength="100" placeholder="{{ auth()->user()?->nama }}"
                        class="form-control @error('nama_manager') is-invalid @enderror">
                </x-form-field>
            </div>
            <div class="col-12 col-md-8">
                <x-form-field name="ttd_manager" label="Tanda Tangan Manager" :errors="$errors">
                    <x-signature-pad name="ttd_manager" label="Manager"
                        :person="old('nama_manager', $hasilWp?->nama_manager ?? auth()->user()?->nama)"
                        :existing="$hasilWp?->ttd_manager" />
                </x-form-field>
            </div>
        </div>
    </div>
</div>
