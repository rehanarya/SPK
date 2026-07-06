<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Audit Log','pageTitle' => 'Audit Log']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Audit Log','page-title' => 'Audit Log']); ?>
    <div class="section-header">
        <h1 class="text-h1">Audit Log</h1>
        <div class="breadcrumb-meta">
            Catatan semua aktivitas penting pengguna pada sistem
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.audit.index')); ?>"
                  style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="modul" class="form-label">Modul</label>
                    <select id="modul" name="modul" class="form-select">
                        <option value="">Semua modul</option>
                        <?php $__currentLoopData = $modulList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m); ?>" <?php echo e(request('modul') === $m ? 'selected' : ''); ?>><?php echo e(ucfirst($m)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="<?php echo e(request('tanggal')); ?>" class="form-control">
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <?php if(request('modul') || request('tanggal')): ?>
                    <a href="<?php echo e(route('admin.audit.index')); ?>" class="btn btn-ghost">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">Jejak Audit
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;"><?php echo e($log->total()); ?> entri</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <?php if($log->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-clock-history','title' => 'Tidak ada audit log','body' => 'Belum ada aksi tercatat sesuai filter Anda.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-clock-history','title' => 'Tidak ada audit log','body' => 'Belum ada aksi tercatat sesuai filter Anda.']); ?>
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
                            <th>Pengguna</th>
                            <th>Modul</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $log; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-meta font-numeric"><?php echo e($l->created_at?->format('d/m/Y H:i:s') ?? '—'); ?></td>
                                <td><?php echo e($l->pengguna?->nama ?? '—'); ?></td>
                                <td><span class="status-badge status-priority"><?php echo e($l->modul); ?></span></td>
                                <td class="text-body-strong"><?php echo e($l->aksi); ?></td>
                                <td class="text-meta" style="max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                    title="<?php echo e(json_encode($l->detail)); ?>">
                                    <?php echo e(json_encode($l->detail)); ?>

                                </td>
                                <td class="font-numeric text-meta"><?php echo e($l->ip_address ?? '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php if($log->hasPages()): ?>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan <?php echo e($log->firstItem()); ?>–<?php echo e($log->lastItem()); ?> dari <?php echo e($log->total()); ?>

                </div>
                <?php echo e($log->links()); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/audit/index.blade.php ENDPATH**/ ?>