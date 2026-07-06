<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Detail Nasabah','pageTitle' => 'Detail Nasabah']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail Nasabah','page-title' => 'Detail Nasabah']); ?>
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1"><?php echo e($nasabah->nama_nasabah); ?></h1>
            <div class="breadcrumb-meta">
                <a href="<?php echo e(route('nasabah.index')); ?>">Data Nasabah</a>
                <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
                <span><?php echo e($nasabah->no_anggota); ?></span>
            </div>
        </div>
        <a href="<?php echo e(route('nasabah.edit', $nasabah)); ?>" class="btn btn-secondary">
            <i class="bi bi-pencil"></i> Ubah Data
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Identitas</h3></div>
                <div class="card-body">
                    <dl style="margin: 0; display: grid; grid-template-columns: 120px 1fr; gap: 8px 16px;">
                        <dt class="text-label">No. Anggota</dt><dd class="font-numeric" style="margin: 0;"><?php echo e($nasabah->no_anggota); ?></dd>
                        <dt class="text-label">Nama</dt><dd style="margin: 0;"><?php echo e($nasabah->nama_nasabah); ?></dd>
                        <dt class="text-label">Jenis Usaha</dt><dd style="margin: 0;"><?php echo e($nasabah->jenis_usaha ?? '—'); ?></dd>
                        <dt class="text-label">Telepon</dt><dd style="margin: 0;"><?php echo e($nasabah->no_telp ?? '—'); ?></dd>
                        <dt class="text-label">Alamat</dt><dd style="margin: 0;"><?php echo e($nasabah->alamat ?? '—'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Riwayat Pengajuan</h3></div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    <?php if($nasabah->pengajuan->isEmpty()): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-file-earmark-text','title' => 'Belum ada pengajuan','body' => 'Nasabah ini belum pernah mengajukan pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-file-earmark-text','title' => 'Belum ada pengajuan','body' => 'Nasabah ini belum pernah mengajukan pembiayaan.']); ?>
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
                                    <th>Minggu</th>
                                    <th class="col-right">Laba Usaha</th>
                                    <th class="col-right">Pembiayaan</th>
                                    <th class="col-right">Skor Kelayakan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $nasabah->pengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="font-numeric"><?php echo e($p->periode?->kode_periode ?? '—'); ?></td>
                                        <td class="col-nominal"><?php echo e(number_format($p->C1_laba_usaha, 0, ',', '.')); ?></td>
                                        <td class="col-nominal"><?php echo e(number_format($p->C4_besar_pembiayaan, 0, ',', '.')); ?></td>
                                        <td class="col-nominal">
                                            <?php echo e($p->hasilPerhitungan ? number_format($p->hasilPerhitungan->vektor_S, 2, ',', '.') : '—'); ?>

                                        </td>
                                        <td>
                                            <?php if($p->hasilPerhitungan): ?>
                                                <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $p->hasilPerhitungan->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->hasilPerhitungan->status)]); ?>
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
                                            <?php else: ?>
                                                <span class="status-badge status-pending">Belum dihitung</span>
                                            <?php endif; ?>
                                        </td>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/nasabah/show.blade.php ENDPATH**/ ?>