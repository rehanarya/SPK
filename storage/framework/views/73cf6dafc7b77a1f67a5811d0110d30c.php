<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Detail Penilaian','pageTitle' => 'Detail Penilaian Nasabah']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail Penilaian','page-title' => 'Detail Penilaian Nasabah']); ?>
    <?php $p = $hasil->pengajuan; ?>

    <div class="section-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="text-h1">Detail Penilaian — <?php echo e($p?->nasabah?->nama_nasabah ?? '—'); ?></h1>
                <div class="breadcrumb-meta">
                    <a href="<?php echo e(route('hasil.index')); ?>">Hasil Penilaian</a>
                    <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
                    <span>Detail #<?php echo e($hasil->id_hasil); ?></span>
                </div>
            </div>
            <?php if($p): ?>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('pengajuan.edit', $p)); ?>" class="btn btn-secondary">
                        <i class="bi bi-pencil-square"></i> Ubah Pengajuan
                    </a>
                    <a href="<?php echo e(route('pengajuan.cetak', $p)); ?>" class="btn btn-primary-strong" target="_blank">
                        <i class="bi bi-printer"></i> Cetak Formulir
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Data Penilaian Nasabah</h3></div>
                <div class="card-body" style="padding: 0;">
                    <table class="table-finansial">
                        <thead>
                            <tr>
                                <th>Faktor Penilaian</th>
                                <th>Sifat</th>
                                <th class="col-right">Nilai Nasabah</th>
                                <th class="col-right">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $kriteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $field = match ($k->kode_kriteria) {
                                        'C1' => 'C1_laba_usaha',
                                        'C2' => 'C2_pendapatan_bersih',
                                        'C3' => 'C3_nilai_agunan',
                                        'C4' => 'C4_besar_pembiayaan',
                                        'C5' => 'C5_jangka_waktu',
                                    };
                                    $nilai = $p?->{$field};
                                    $sifatLabel = $k->tipe === 'benefit' ? 'Semakin besar, semakin baik' : 'Semakin kecil, semakin baik';
                                ?>
                                <tr>
                                    <td>
                                        <div class="text-body-strong"><?php echo e($k->nama_kriteria); ?></div>
                                        <div class="text-meta"><?php echo e($sifatLabel); ?></div>
                                    </td>
                                    <td><?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => $k->tipe]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($k->tipe)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?> <?php echo e(ucfirst($k->tipe)); ?></td>
                                    <td class="col-nominal"><?php echo e(is_numeric($nilai) ? number_format($nilai, 0, ',', '.') : '—'); ?></td>
                                    <td class="col-nominal"><?php echo e(number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.')); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="card" style="margin-top: 16px;">
                <div class="card-header"><h3 class="text-h3">Rincian Analisis Pembiayaan</h3></div>
                <div class="card-body" <?php if($p?->punyaRincianAnalisis()): ?> style="padding: 0;" <?php endif; ?>>
                    <?php if($p?->punyaRincianAnalisis()): ?>
                        <?php $fmtRp = fn ($v) => $v !== null ? 'Rp ' . number_format((float) $v, fmod((float) $v, 1) != 0 ? 2 : 0, ',', '.') : '—'; ?>
                        <table class="table-finansial">
                            <tbody>
                                <tr><td>Penjualan Usaha</td><td class="col-nominal"><?php echo e($fmtRp($p->penjualan_usaha)); ?></td></tr>
                                <tr><td>Harga Pokok Jual</td><td class="col-nominal"><?php echo e($fmtRp($p->harga_pokok_jual)); ?></td></tr>
                                <tr><td>Biaya Usaha</td><td class="col-nominal"><?php echo e($fmtRp($p->biaya_usaha)); ?></td></tr>
                                <tr><td class="text-body-strong">Laba Usaha (C1)</td><td class="col-nominal text-body-strong"><?php echo e($fmtRp($p->C1_laba_usaha)); ?></td></tr>
                                <tr><td>Pendapatan dari Istri/Suami</td><td class="col-nominal"><?php echo e($fmtRp($p->pendapatan_pasangan)); ?></td></tr>
                                <tr><td>Pendapatan Lainnya</td><td class="col-nominal"><?php echo e($fmtRp($p->pendapatan_lainnya)); ?></td></tr>
                                <tr><td>Kebutuhan Rumah Tangga</td><td class="col-nominal"><?php echo e($fmtRp($p->kebutuhan_rumah_tangga)); ?></td></tr>
                                <tr><td>Biaya Pendidikan</td><td class="col-nominal"><?php echo e($fmtRp($p->biaya_pendidikan)); ?></td></tr>
                                <tr><td>Biaya Lainnya</td><td class="col-nominal"><?php echo e($fmtRp($p->biaya_lainnya)); ?></td></tr>
                                <tr><td class="text-body-strong">Pendapatan Bersih (C2)</td><td class="col-nominal text-body-strong"><?php echo e($fmtRp($p->C2_pendapatan_bersih)); ?></td></tr>
                                <tr><td>Rasio Angsuran</td><td class="col-nominal"><?php echo e($p->rasio_angsuran !== null ? rtrim(rtrim(number_format($p->rasio_angsuran, 2, ',', '.'), '0'), ',') . ' %' : '—'); ?></td></tr>
                                <tr><td class="text-body-strong">Plafon Pembiayaan</td><td class="col-nominal text-body-strong"><?php echo e($fmtRp($p->plafon_pembiayaan)); ?></td></tr>
                                <tr><td>Angsuran Pokok</td><td class="col-nominal"><?php echo e($fmtRp($p->angsuran_pokok)); ?></td></tr>
                                <tr><td>Bagi Hasil</td><td class="col-nominal"><?php echo e($fmtRp($p->bagi_hasil)); ?></td></tr>
                                <tr><td>Simpanan</td><td class="col-nominal"><?php echo e($fmtRp($p->simpanan)); ?></td></tr>
                                <tr><td class="text-body-strong">Jumlah Angsuran</td><td class="col-nominal text-body-strong"><?php echo e($fmtRp($p->jumlah_angsuran)); ?></td></tr>
                                <tr><td>Jenis Akad</td><td class="col-nominal"><?php echo e($p->jenis_akad ?? '—'); ?></td></tr>
                                <tr><td>Agunan</td><td class="col-nominal"><?php echo e($p->labelAgunan()); ?></td></tr>
                                <tr><td>Tanggal Realisasi</td><td class="col-nominal"><?php echo e($p->tanggal_realisasi?->format('d/m/Y') ?? '—'); ?></td></tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-meta" style="margin: 0;">
                            <i class="bi bi-info-circle"></i>
                            Rincian analisis belum tersedia untuk data historis — hanya nilai kriteria C1–C5 yang tersimpan.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Ringkasan Skor</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 160px 1fr; gap: 12px 16px;">
                        <dt class="text-label">Skor Kelayakan</dt>
                        <dd class="font-numeric text-h2" style="margin: 0;"><?php echo e(number_format($hasil->vektor_S, 2, ',', '.')); ?></dd>
                        <dt class="text-label">Nilai Prioritas</dt>
                        <dd class="font-numeric text-h2" style="margin: 0;"><?php echo e(number_format($hasil->vektor_V * 100, 2, ',', '.')); ?>%</dd>
                        <dt class="text-label">Urutan</dt>
                        <dd class="font-numeric" style="margin: 0;"><?php echo e($hasil->ranking ?? '—'); ?></dd>
                        <dt class="text-label">Status</dt>
                        <dd style="margin: 0;"><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $hasil->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasil->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></dd>
                        <dt class="text-label">Minggu Penilaian</dt>
                        <dd class="font-numeric" style="margin: 0;"><?php echo e($p?->periode?->kode_periode ?? '—'); ?></dd>
                    </dl>
                </div>
            </div>

            <div class="card" style="margin-top: 16px;">
                <div class="card-header"><h3 class="text-h3">Riwayat Keputusan</h3></div>
                <div class="card-body" style="padding: 0;">
                    <?php if($hasil->logKeputusan->isEmpty()): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-clipboard','title' => 'Belum ada keputusan','body' => 'Tetapkan keputusan akhir dari menu Penetapan Keputusan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-clipboard','title' => 'Belum ada keputusan','body' => 'Tetapkan keputusan akhir dari menu Penetapan Keputusan.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                    <?php else: ?>
                        <table class="table-finansial">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Petugas</th>
                                    <th>Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $hasil->logKeputusan->sortByDesc('timestamp'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-meta"><?php echo e($k->timestamp?->format('d/m H:i') ?? '—'); ?></td>
                                        <td><?php echo e($k->pengguna?->nama ?? '—'); ?></td>
                                        <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $k->keputusan_akhir]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($k->keputusan_akhir)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $attributes = $__attributesOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__attributesOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4619374cef299e94fd7263111d0abc69)): ?>
<?php $component = $__componentOriginal4619374cef299e94fd7263111d0abc69; ?>
<?php unset($__componentOriginal4619374cef299e94fd7263111d0abc69); ?>
<?php endif; ?>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/hasil/show.blade.php ENDPATH**/ ?>