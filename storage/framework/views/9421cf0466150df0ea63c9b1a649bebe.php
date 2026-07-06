<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Manajemen Pengguna','pageTitle' => 'Manajemen Pengguna']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Manajemen Pengguna','page-title' => 'Manajemen Pengguna']); ?>
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="text-h1">Manajemen Pengguna</h1>
            <div class="breadcrumb-meta">Kelola akun Administrator dan Petugas Pembiayaan</div>
        </div>
        <a href="<?php echo e(route('admin.pengguna.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">Daftar Pengguna
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;"><?php echo e($pengguna->total()); ?> akun</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <table class="table-finansial">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Peran</th>
                        <th>Dibuat</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pengguna; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="font-numeric"><?php echo e($p->username); ?></td>
                            <td class="col-nama text-body-strong"><?php echo e($p->nama); ?></td>
                            <td>
                                <span class="status-badge <?php echo e($p->peran === 'admin' ? 'status-priority' : 'status-accept'); ?>">
                                    <?php echo e($p->peran === 'admin' ? 'Administrator' : 'Petugas'); ?>

                                </span>
                            </td>
                            <td class="text-meta"><?php echo e($p->created_at?->format('d M Y') ?? '—'); ?></td>
                            <td class="col-actions">
                                <a href="<?php echo e(route('admin.pengguna.edit', $p)); ?>" class="btn btn-ghost btn-icon" title="Ubah">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php if($p->id_pengguna !== auth()->id()): ?>
                                    <form method="POST" action="<?php echo e(route('admin.pengguna.destroy', $p)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger-ghost btn-icon"
                                                title="Hapus"
                                                data-confirm="Hapus pengguna <?php echo e($p->username); ?>?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($pengguna->hasPages()): ?>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan <?php echo e($pengguna->firstItem()); ?>–<?php echo e($pengguna->lastItem()); ?> dari <?php echo e($pengguna->total()); ?>

                </div>
                <?php echo e($pengguna->links()); ?>

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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/pengguna/index.blade.php ENDPATH**/ ?>