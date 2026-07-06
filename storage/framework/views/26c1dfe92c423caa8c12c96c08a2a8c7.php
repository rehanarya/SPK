<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Faktor Penilaian','pageTitle' => 'Faktor Penilaian & Bobot']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Faktor Penilaian','page-title' => 'Faktor Penilaian & Bobot']); ?>
    <div class="section-header">
        <h1 class="text-h1">Faktor Penilaian &amp; Bobot</h1>
        <div class="breadcrumb-meta">
            Pengaturan lima faktor yang menentukan kelayakan pembiayaan · Bobot dihitung otomatis
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><h2 class="text-h2">Daftar Faktor Penilaian</h2></div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="">Faktor Penilaian</th>
                                <th class="">Sifat</th>
                                <th class="">Satuan</th>
                                <th class="text-end">Bobot Awal</th>
                                <th class="text-end">Pengaruh</th>
                                <th class="col-actions">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $kriteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="">
                                        <div class="text-body-strong"><?php echo e($k->nama_kriteria); ?></div>
                                        <div class="text-meta">Kode <?php echo e($k->kode_kriteria); ?></div>
                                    </td>
                                    <td class="">
                                        <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
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
<?php endif; ?>
                                        <?php echo e($k->tipe === 'benefit' ? 'Semakin besar, semakin baik' : 'Semakin kecil, semakin baik'); ?>

                                    </td>
                                    <td class="text-meta"><?php echo e($k->satuan ?? '—'); ?></td>
                                    <td class="text-end tabular-nums font-medium"><?php echo e($k->bobot_mentah); ?></td>
                                    <td class="text-end tabular-nums font-medium"><?php echo e(number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.')); ?>%</td>
                                    <td class="col-actions">
                                        <a href="<?php echo e(route('admin.kriteria.edit', $k)); ?>" class="btn btn-ghost btn-icon" title="Ubah bobot">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr style="background-color: var(--color-bg-subtle);">
                                <td colspan="3" class="text-label text-end">Total</td>
                                <td class="text-end tabular-nums text-body-strong"><?php echo e($kriteria->sum('bobot_mentah')); ?></td>
                                <td class="text-end tabular-nums text-body-strong">
                                    <?php echo e(number_format($kriteria->sum(fn ($k) => abs($k->bobot_normalisasi)) * 100, 1, ',', '.')); ?>%
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Hal yang Perlu Diingat</h3></div>
                <div class="card-body">
                    <ul style="margin: 0; padding-left: 18px; color: var(--color-text-body); font-size: 13px; line-height: 1.7;">
                        <li>Faktor bertanda <strong>B</strong>: nilai besar = nasabah lebih layak.</li>
                        <li>Faktor bertanda <strong>C</strong>: nilai besar = nasabah kurang layak.</li>
                        <li>Setiap perubahan bobot otomatis tercatat di riwayat.</li>
                        <li>Setelah bobot diubah, sebaiknya lakukan kalibrasi ambang kelayakan.</li>
                    </ul>
                    <div style="margin-top: 16px;">
                        <a href="<?php echo e(route('admin.threshold.index')); ?>" class="btn btn-secondary" style="width: 100%;">
                            <i class="bi bi-arrow-repeat"></i> Kalibrasi Ambang Kelayakan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 16px;">
        <div class="card-header"><h3 class="text-h3">Riwayat Perubahan Bobot (20 Terakhir)</h3></div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <?php if($history->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-clock-history','title' => 'Belum ada riwayat perubahan','body' => 'Setiap perubahan bobot oleh Administrator akan tercatat di sini.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-clock-history','title' => 'Belum ada riwayat perubahan','body' => 'Setiap perubahan bobot oleh Administrator akan tercatat di sini.']); ?>
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
                <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="">Waktu</th>
                            <th class="">Faktor</th>
                            <th class="">Minggu</th>
                            <th class="text-end">Bobot</th>
                            <th class="text-end">Pengaruh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-meta tabular-nums"><?php echo e($h->created_at?->format('d M Y H:i') ?? '—'); ?></td>
                                <td class=""><?php echo e($h->kriteria?->nama_kriteria ?? '—'); ?></td>
                                <td class="tabular-nums"><?php echo e($h->periode?->kode_periode ?? '—'); ?></td>
                                <td class="text-end tabular-nums font-medium"><?php echo e($h->bobot_mentah); ?></td>
                                <td class="text-end tabular-nums font-medium"><?php echo e(number_format(abs($h->bobot_normalisasi) * 100, 1, ',', '.')); ?>%</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/kriteria/index.blade.php ENDPATH**/ ?>