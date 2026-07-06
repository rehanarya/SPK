<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Periode Mingguan','pageTitle' => 'Periode Mingguan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Periode Mingguan','page-title' => 'Periode Mingguan']); ?>
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1">Periode Mingguan</h1>
            <div class="breadcrumb-meta">Atur jadwal minggu pengajuan pembiayaan dan status aktif/tutup</div>
        </div>
        <a href="<?php echo e(route('admin.periode.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Periode
        </a>
    </div>

    <div class="card">
        <div class="card-header"><h2 class="text-h2">Daftar Periode</h2></div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Kode Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $periode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-body-strong font-numeric"><?php echo e($p->kode_periode); ?></td>
                            <td class="font-numeric"><?php echo e($p->tanggal_mulai->format('d M Y')); ?></td>
                            <td class="font-numeric"><?php echo e($p->tanggal_selesai->format('d M Y')); ?></td>
                            <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $p->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($p->status)]); ?>
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
                            <td class="text-meta"><?php echo e($p->created_at?->format('d M Y') ?? '—'); ?></td>
                            <td class="col-actions">
                                <?php if($p->status === 'aktif'): ?>
                                    
                                    <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmTutupPeriodeModal-<?php echo e($p->id_periode); ?>">
                                        Tutup
                                    </button>
                                <?php else: ?>
                                    
                                    <form method="POST" action="<?php echo e(route('admin.periode.toggle', $p)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-secondary btn-sm">Aktifkan</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($periode->hasPages()): ?>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan <?php echo e($periode->firstItem()); ?>–<?php echo e($periode->lastItem()); ?> dari <?php echo e($periode->total()); ?>

                </div>
                <?php echo e($periode->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    
    <?php $__currentLoopData = $periode->where('status', 'aktif'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade"
             id="confirmTutupPeriodeModal-<?php echo e($p->id_periode); ?>"
             tabindex="-1"
             aria-labelledby="confirmTutupTitle-<?php echo e($p->id_periode); ?>"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
                <div class="modal-content"
                     style="border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--elev-2);">

                    <div class="modal-header"
                         style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                        <h3 class="text-h3" style="margin: 0;" id="confirmTutupTitle-<?php echo e($p->id_periode); ?>">
                            Konfirmasi Penutupan Periode Mingguan
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body" style="padding: 20px;">
                        <p style="margin: 0 0 12px 0; color: var(--color-text-body);">
                            Apakah Anda yakin ingin menutup periode mingguan
                            <strong class="font-numeric"><?php echo e($p->kode_periode); ?></strong>
                            (<?php echo e($p->tanggal_mulai->format('d M')); ?>–<?php echo e($p->tanggal_selesai->format('d M Y')); ?>)?
                        </p>
                        <p style="margin: 0; color: var(--color-text-muted); font-size: 13px;">
                            Tindakan ini akan mengunci seluruh pengajuan nasabah pada minggu berjalan
                            dan tidak dapat dibatalkan.
                        </p>
                    </div>

                    <div class="modal-footer"
                         style="border-top: 1px solid var(--color-border); padding: 12px 20px; display: flex; justify-content: space-between; gap: 12px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form method="POST"
                              action="<?php echo e(route('admin.periode.toggle', $p)); ?>"
                              style="margin: 0; display: inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-lock"></i> Ya, Tutup Periode
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/periode/index.blade.php ENDPATH**/ ?>