<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Hasil Kalibrasi','pageTitle' => 'Hasil Kalibrasi Ambang']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hasil Kalibrasi','page-title' => 'Hasil Kalibrasi Ambang']); ?>
    <div class="section-header">
        <h1 class="text-h1">Hasil Kalibrasi Ambang Kelayakan</h1>
        <div class="breadcrumb-meta">
            <a href="<?php echo e(route('admin.threshold.index')); ?>">Kalibrasi Ambang</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Pratinjau</span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Ambang Saat Ini','value' => number_format($thetaLama, 0, ',', '.'),'meta' => 'Nilai yang masih dipakai']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ambang Saat Ini','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($thetaLama, 0, ',', '.')),'meta' => 'Nilai yang masih dipakai']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        </div>
        <div class="col-12 col-md-4">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Ambang Disarankan','variant' => 'accept','value' => number_format($hasil['theta'], 0, ',', '.'),'meta' => 'Hasil hitung dari data nyata']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ambang Disarankan','variant' => 'accept','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($hasil['theta'], 0, ',', '.')),'meta' => 'Hasil hitung dari data nyata']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        </div>
        <div class="col-12 col-md-4">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Selisih','value' => ($hasil['theta'] > $thetaLama ? '+' : '') . number_format($hasil['theta'] - $thetaLama, 0, ',', '.'),'meta' => $hasil['kasus'] === 'B' ? 'Ada ' . $hasil['err'] . ' data yang masih tumpang tindih' : 'Data terpisah dengan baik']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Selisih','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($hasil['theta'] > $thetaLama ? '+' : '') . number_format($hasil['theta'] - $thetaLama, 0, ',', '.')),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasil['kasus'] === 'B' ? 'Ada ' . $hasil['err'] . ' data yang masih tumpang tindih' : 'Data terpisah dengan baik')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $attributes = $__attributesOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__attributesOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4ae059936bc185e758290466e2179c1)): ?>
<?php $component = $__componentOriginala4ae059936bc185e758290466e2179c1; ?>
<?php unset($__componentOriginala4ae059936bc185e758290466e2179c1); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h2 class="text-h2">Sebaran Skor Kelayakan per Kelompok</h2></div>
        <div class="card-body">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Kelompok</th>
                        <th class="col-right">Jumlah Nasabah</th>
                        <th class="col-right">Skor Terendah</th>
                        <th class="col-right">Skor Tertinggi</th>
                        <th class="col-right">Skor Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = ['diterima' => 'Pernah Diterima', 'ditolak' => 'Pernah Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $list = $distribusi[$key]; ?>
                        <tr>
                            <td>
                                <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $key]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($key)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                                <span style="margin-left: 6px;"><?php echo e($label); ?></span>
                            </td>
                            <td class="col-nominal"><?php echo e(count($list)); ?></td>
                            <td class="col-nominal"><?php echo e(count($list) > 0 ? number_format(min($list), 2, ',', '.') : '—'); ?></td>
                            <td class="col-nominal"><?php echo e(count($list) > 0 ? number_format(max($list), 2, ',', '.') : '—'); ?></td>
                            <td class="col-nominal"><?php echo e(count($list) > 0 ? number_format(array_sum($list)/count($list), 2, ',', '.') : '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="text-h3">Konfirmasi Penerapan</h3></div>
        <div class="card-body">
            <p class="text-body" style="margin-bottom: 16px;">
                Jika Anda menyetujui, ambang baru sebesar <strong><?php echo e(number_format($hasil['theta'], 0, ',', '.')); ?></strong>
                akan diberlakukan untuk seluruh penilaian berikutnya. Perubahan ini tercatat di
                jejak audit sistem.
            </p>
            <form method="POST" action="<?php echo e(route('admin.threshold.apply')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="theta_baru" value="<?php echo e($hasil['theta']); ?>">
                <div style="display: flex; justify-content: space-between; gap: 12px;">
                    <a href="<?php echo e(route('admin.threshold.index')); ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary-strong">
                        <i class="bi bi-check2"></i> Terapkan Ambang Baru
                    </button>
                </div>
            </form>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/threshold/preview.blade.php ENDPATH**/ ?>