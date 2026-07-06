
<?php
    use App\Support\Terbilang;

    $p       = $pengajuan;
    $nasabah = $p->nasabah;
    $hasil   = $p->hasilPerhitungan;
    $rincian = $p->punyaRincianAnalisis();

    // Kolom kosong ditulis "-" mengikuti gaya formulir asli; rekord historis
    // tanpa rincian sama sekali memakai garis titik-titik (formulir kosong).
    $rp = function ($v) use ($rincian) {
        if ($v === null) {
            return $rincian ? '-' : '..............................';
        }
        return 'Rp ' . number_format((float) $v, fmod((float) $v, 1) != 0 ? 2 : 0, ',', '.');
    };
    $tgl = fn ($t) => $t?->translatedFormat('d F Y') ?? '.........................';

    $jumlahPendapatan  = $rincian ? $p->C1_laba_usaha + $p->pendapatan_pasangan + $p->pendapatan_lainnya : null;
    $jumlahPengeluaran = $rincian ? $p->kebutuhan_rumah_tangga + $p->biaya_pendidikan + $p->biaya_lainnya : null;
    $rasioTeks = $p->rasio_angsuran !== null
        ? rtrim(rtrim(number_format($p->rasio_angsuran, 2, ',', '.'), '0'), ',') . ' %'
        : '.............. %';

    /*
     * Keputusan FINAL petugas = baris log_keputusan terbaru (modul Penetapan
     * Keputusan). hasil_perhitungan.status hanyalah REKOMENDASI sistem (S vs θ)
     * dan tidak boleh memicu coretan sebelum petugas menetapkan keputusan.
     */
    $logTerbaru     = $hasil?->logKeputusan?->sortByDesc('timestamp')->first();
    $keputusanFinal = $logTerbaru?->keputusan_akhir;                          // null = menunggu
    $ditetapkan     = $keputusanFinal !== null;
    $disetujui      = in_array($keputusanFinal, ['diterima', 'diprioritaskan'], true);

    $tanggalSurat = $p->tanggal_realisasi ?? $p->tanggal_pengajuan;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Pembiayaan — <?php echo e($nasabah?->nama_nasabah); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('images/logo-kspps.png')); ?>" type="image/x-icon">
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <style>
        /* ── Lembar formulir: hitam-putih formal, terisolasi dari tema ── */
        .lembar, .lembar * {
            font-family: 'Times New Roman', Times, serif;
            margin: 0; padding: 0; box-sizing: border-box;
            color: #000;
        }
        .lembar {
            width: 210mm; /* A4 potret */
            min-height: 275mm;
            margin: 0 auto 24px;
            padding: 12mm 16mm;
            background: #fff;
            font-size: 11.5pt;
            border-radius: 6px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.14);
        }

        /* ── Kop ── */
        .kop { display: flex; align-items: center; gap: 10px; border-bottom: 3.5px double #000; padding-bottom: 6px; }
        .kop-logo { width: 64px; height: 64px; object-fit: contain; flex: 0 0 auto; }
        .kop-logo-placeholder { width: 64px; height: 64px; border: 1px dashed #999; flex: 0 0 auto; }
        .kop-teks { flex: 1; text-align: center; }
        .kop-teks h1 { font-size: 15pt; letter-spacing: 1px; font-weight: bold; }
        .kop-teks p { font-size: 9.5pt; line-height: 1.35; }

        .judul { text-align: center; font-size: 13pt; font-weight: bold; text-decoration: underline; margin: 12px 0 8px; letter-spacing: 1px; }

        /* ── Rincian bergaya formulir: * label : Rp nilai (rata kanan) ── */
        .seksi { margin-bottom: 7px; }
        .seksi-judul { font-weight: bold; }
        table.rincian { width: 88%; border-collapse: collapse; margin-left: 18px; }
        table.rincian td { padding: 1px 0; vertical-align: bottom; font-size: 11pt; }
        td.label { width: 48%; }
        td.titik { width: 3%; text-align: center; }
        td.nilai { width: 49%; text-align: right; white-space: nowrap; }
        td.nilai.subtotal { border-top: 1px solid #000; border-bottom: 2px solid #000; font-weight: bold; }

        .blok-judul { font-weight: bold; text-decoration: underline; margin: 10px 0 4px; font-size: 12pt; }
        .terbilang { font-style: italic; }

        /* Kata yang TIDAK berlaku dicoret + diredupkan — garis coret tetap
           tercetak jelas pada print hitam-putih */
        .status-judul { text-align: center; font-weight: bold; font-size: 12.5pt; margin: 12px 0 6px; letter-spacing: 1px; }
        .tercoret { text-decoration: line-through; color: #777; }

        .ttd-tanggal { text-align: right; margin-top: 10px; padding-right: 6mm; }
        .ttd-baris { display: flex; justify-content: space-between; text-align: center; margin-top: 4px; }
        .ttd-kolom { width: 38%; }
        .ttd-kolom-kanan { width: 38%; margin-left: auto; }
        .ttd-ruang { height: 70px; display: flex; align-items: center; justify-content: center; }
        .ttd-ruang img { max-height: 66px; max-width: 100%; }
        .ttd-nama { font-weight: bold; text-decoration: underline; }

        /* ── Pratinjau layar: latar & toolbar mengikuti tema aplikasi ── */
        body { background: var(--color-bg-app, #f1f3f5); }
        .toolbar-cetak {
            max-width: 210mm;
            margin: 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ── Cetak: WAJIB muat tepat 1 halaman A4 potret ── */
        @media print {
            @page { size: A4 portrait; margin: 10mm 14mm; }

            body { background: #fff; }
            .no-print { display: none !important; }

            .lembar {
                width: auto; min-height: auto; margin: 0; padding: 0;
                border-radius: 0; box-shadow: none;
                font-size: 11px; /* ±10–11px, tetap terbaca */
            }
            .kop-logo, .kop-logo-placeholder { width: 50px; height: 50px; }
            .kop-teks h1 { font-size: 13px; }
            .kop-teks p { font-size: 9px; }
            .judul { font-size: 12px; margin: 6px 0 4px; }
            .seksi { margin-bottom: 3px; }
            table.rincian td { font-size: 10.5px; padding: 0.5px 0; }
            .blok-judul { font-size: 11px; margin: 5px 0 2px; }
            .status-judul { font-size: 11.5px; margin: 6px 0 3px; }
            .ttd-tanggal { margin-top: 4px; }
            .ttd-ruang { height: 56px; }
            .ttd-ruang img { max-height: 52px; }

            /* Jangan biarkan blok terpotong antar halaman */
            .kop, .seksi, table.rincian, .ttd-baris, .status-judul, .blok-judul { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

    
    <div class="no-print toolbar-cetak">
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div class="text-meta" style="flex: 1; text-align: center;">
            Pastikan pratinjau 1 halaman — nonaktifkan "Headers and footers" di dialog print.
        </div>
        <button type="button" class="btn btn-primary-strong" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak / Simpan PDF
        </button>
    </div>

    <div class="lembar">

        
        <div class="kop">
            <?php if(file_exists(public_path('images/logo-kspps.png'))): ?>
                <img class="kop-logo" src="<?php echo e(asset('images/logo-kspps.png')); ?>" alt="Logo KSPPS">
            <?php else: ?>
                <div class="kop-logo-placeholder"></div>
            <?php endif; ?>
            <div class="kop-teks">
                <h1>KSPPS BERKAH SAKINAH ALMUGHNI</h1>
                
                <p><?php echo e(\App\Support\KopSurat::nomorBh()); ?></p>
                <p><?php echo e(\App\Support\KopSurat::tanggal()); ?></p>
                <p>Jln. Sinuwun &ndash;Girimarto, Rt. 01, Rw. 01 Kec. Girimarto</p>
            </div>
            <?php if(file_exists(public_path('images/logo-kspps.png'))): ?>
                <img class="kop-logo" src="<?php echo e(asset('images/logo-kspps.png')); ?>" alt="Logo KSPPS">
            <?php else: ?>
                <div class="kop-logo-placeholder"></div>
            <?php endif; ?>
        </div>

        <div class="judul">ANALISIS PEMBIAYAAN</div>

        
        <div class="seksi">
            <div class="seksi-judul">1. Perhitungan Laba Usaha (dalam 1 bulan)</div>
            <table class="rincian">
                <tr><td class="label">* Penjualan Usaha</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->penjualan_usaha)); ?></td></tr>
                <tr><td class="label">* Harga Pokok Jual</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->harga_pokok_jual)); ?></td></tr>
                <tr><td class="label">* Biaya Usaha</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->biaya_usaha)); ?></td></tr>
                <tr><td class="label">* Laba Usaha</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($p->C1_laba_usaha)); ?></td></tr>
            </table>
        </div>

        
        <div class="seksi">
            <div class="seksi-judul">2. Perhitungan Kemampuan Bayar</div>
            <table class="rincian">
                <tr><td class="label">* Laba Usaha</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->C1_laba_usaha)); ?></td></tr>
                <tr><td class="label">* Pendapatan dari Istri/Suami</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->pendapatan_pasangan)); ?></td></tr>
                <tr><td class="label">* Pendapatan Lainnya</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->pendapatan_lainnya)); ?></td></tr>
                <tr><td class="label">* Jumlah Pendapatan</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($jumlahPendapatan)); ?></td></tr>
            </table>
        </div>

        
        <div class="seksi">
            <div class="seksi-judul">3. Biaya dan Pengeluaran di Luar Usaha</div>
            <table class="rincian">
                <tr><td class="label">* Kebutuhan Rmh. Tangga</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->kebutuhan_rumah_tangga)); ?></td></tr>
                <tr><td class="label">* Biaya Pendidikan</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->biaya_pendidikan)); ?></td></tr>
                <tr><td class="label">* Biaya Lainnya</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->biaya_lainnya)); ?></td></tr>
                <tr><td class="label">* Jumlah Pengeluaran</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($jumlahPengeluaran)); ?></td></tr>
            </table>
        </div>

        
        <div class="seksi">
            <div class="seksi-judul">4. Jumlah Pendapatan Bersih</div>
            <table class="rincian">
                <tr><td class="label">* Jumlah Pendapatan</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($jumlahPendapatan)); ?></td></tr>
                <tr><td class="label">* Jumlah Pengeluaran</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($jumlahPengeluaran)); ?></td></tr>
                <tr><td class="label">* Pendapatan Bersih</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($p->C2_pendapatan_bersih)); ?></td></tr>
            </table>
        </div>

        
        <div class="seksi">
            <div class="seksi-judul">5. Rasio Angsuran &nbsp;:&nbsp; <span style="font-weight: normal;"><?php echo e($rasioTeks); ?></span></div>
        </div>

        
        <div class="seksi">
            <div class="seksi-judul">6. Jumlah Pembiayaan Yang Dapat Diberikan</div>
            <table class="rincian">
                <tr><td class="label">* Rasio Angsuran</td><td class="titik">:</td><td class="nilai"><?php echo e($rasioTeks); ?></td></tr>
                <tr><td class="label">* Pendapatan Bersih</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->C2_pendapatan_bersih)); ?></td></tr>
                <tr><td class="label">* Jangka Waktu</td><td class="titik">:</td><td class="nilai"><?php echo e($p->C5_jangka_waktu); ?> bulan</td></tr>
                <tr><td class="label">* Jumlah Pembiayaan (plafon)</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($p->plafon_pembiayaan)); ?></td></tr>
            </table>
        </div>

        
        <div class="blok-judul">USULAN PEMBIAYAAN</div>
        <table class="rincian">
            <tr><td class="label">1. Besarnya Pembiayaan</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->C4_besar_pembiayaan)); ?></td></tr>
            <tr><td class="label">2. Jangka Waktu</td><td class="titik">:</td><td class="nilai"><?php echo e($p->C5_jangka_waktu); ?> bulan</td></tr>
            <tr><td class="label">3. Angsuran Pokok</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->angsuran_pokok)); ?></td></tr>
            <tr><td class="label">4. Bagi Hasil</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->bagi_hasil)); ?></td></tr>
            <tr><td class="label">5. Simpanan</td><td class="titik">:</td><td class="nilai"><?php echo e($rp($p->simpanan)); ?></td></tr>
            <tr><td class="label">6. Jumlah Angsuran</td><td class="titik">:</td><td class="nilai subtotal"><?php echo e($rp($p->jumlah_angsuran)); ?></td></tr>
        </table>

        
        <div class="ttd-tanggal">Girimarto, <?php echo e($tgl($tanggalSurat)); ?></div>
        <div class="ttd-baris">
            <div class="ttd-kolom">
                Anggota
                <div class="ttd-ruang">
                    <?php if($p->ttd_anggota): ?>
                        <img src="<?php echo e(asset('storage/' . $p->ttd_anggota)); ?>" alt="Tanda tangan anggota">
                    <?php endif; ?>
                </div>
                <div class="ttd-nama"><?php echo e($nasabah?->nama_nasabah ?? '(............................)'); ?></div>
            </div>
            <div class="ttd-kolom">
                Petugas
                <div class="ttd-ruang">
                    <?php if($p->ttd_petugas): ?>
                        <img src="<?php echo e(asset('storage/' . $p->ttd_petugas)); ?>" alt="Tanda tangan petugas">
                    <?php endif; ?>
                </div>
                <div class="ttd-nama"><?php echo e($petugas?->nama ?? '(............................)'); ?></div>
            </div>
        </div>

        
        <div class="status-judul">
            <?php if($ditetapkan): ?>
                <?php if($disetujui): ?><span>DISETUJUI</span> / <span class="tercoret">TIDAK DISETUJUI</span><?php else: ?><span class="tercoret">DISETUJUI</span> / <span>TIDAK DISETUJUI</span><?php endif; ?>
            <?php else: ?>
                DISETUJUI / TIDAK DISETUJUI
            <?php endif; ?>
        </div>
        <table class="rincian">
            <tr><td class="label">1. Nama</td><td class="titik">:</td><td class="nilai"><?php echo e($nasabah?->nama_nasabah ?? '.........................'); ?></td></tr>
            <tr><td class="label">2. Alamat</td><td class="titik">:</td><td class="nilai"><?php echo e($nasabah?->alamat ?? '.........................'); ?></td></tr>
            <tr>
                <td class="label">3. Pembiayaan</td><td class="titik">:</td>
                <td class="nilai">
                    <?php echo e($p->jenis_akad ?? '.........................'); ?> &mdash; <?php echo e($rp($p->C4_besar_pembiayaan)); ?><br>
                    <span class="terbilang">(<?php echo e($p->C4_besar_pembiayaan !== null ? Terbilang::rupiah($p->C4_besar_pembiayaan) : 'terbilang: .........................'); ?>)</span>
                </td>
            </tr>
            
            <tr><td class="label">4. Realisasi</td><td class="titik">:</td><td class="nilai"><?php echo e($ditetapkan ? $tgl($p->tanggal_realisasi) : '-'); ?></td></tr>
            <tr><td class="label">5. Agunan</td><td class="titik">:</td><td class="nilai"><?php echo e($p->labelAgunan()); ?></td></tr>
        </table>

        
        <div class="ttd-tanggal">Girimarto, <?php echo e($tgl($tanggalSurat)); ?></div>
        <div class="ttd-baris">
            <div class="ttd-kolom-kanan">
                Manager
                <div class="ttd-ruang">
                    
                    <?php if($ditetapkan && $hasil?->ttd_manager): ?>
                        <img src="<?php echo e(asset('storage/' . $hasil->ttd_manager)); ?>" alt="Tanda tangan manager">
                    <?php endif; ?>
                </div>
                <div class="ttd-nama" style="text-transform: uppercase;"><?php echo e($hasil?->nama_manager ?? '(............................)'); ?></div>
            </div>
        </div>

    </div>
</body>
</html>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/cetak.blade.php ENDPATH**/ ?>