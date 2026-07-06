<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Data Nasabah','pageTitle' => 'Data Nasabah']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Data Nasabah','page-title' => 'Data Nasabah']); ?>

    <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
        <div>
            <h1 class="text-h1">Data Nasabah</h1>
            <div class="breadcrumb-meta">Master data anggota KSPPS yang dapat mengajukan pembiayaan</div>
        </div>
        <a href="<?php echo e(route('nasabah.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Nasabah
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body" style="padding: 16px 20px;">
            <form method="GET" action="<?php echo e(route('nasabah.index')); ?>" style="display: flex; gap: 12px;">
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Cari berdasarkan nama atau no. anggota..."
                    class="form-control"
                    style="flex: 1;"
                >
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('nasabah.index')); ?>" class="btn btn-ghost">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-h2">
                Daftar Nasabah
                <span class="text-meta" style="font-weight: 400; margin-left: 8px;"><?php echo e($nasabah->total()); ?> entri</span>
            </h2>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <?php if($nasabah->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-people','title' => 'Belum ada data nasabah','body' => 'Tambahkan nasabah pertama untuk mulai memasukkan pengajuan pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-people','title' => 'Belum ada data nasabah','body' => 'Tambahkan nasabah pertama untuk mulai memasukkan pengajuan pembiayaan.']); ?>
                     <?php $__env->slot('action', null, []); ?> 
                        <a href="<?php echo e(route('nasabah.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Nasabah Pertama
                        </a>
                     <?php $__env->endSlot(); ?>
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
                    <caption class="visually-hidden">Daftar seluruh nasabah terdaftar di sistem.</caption>
                    <thead>
                        <tr>
                            <th style="width: 140px;">No. Anggota</th>
                            <th>Nama Nasabah</th>
                            <th>Jenis Usaha</th>
                            <th>No. Telepon</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $nasabah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="font-numeric"><?php echo e($n->no_anggota); ?></td>
                                <td class="col-nama text-body-strong"><?php echo e($n->nama_nasabah); ?></td>
                                <td><?php echo e($n->jenis_usaha ?? '—'); ?></td>
                                <td><?php echo e($n->no_telp ?? '—'); ?></td>
                                <td class="col-actions">
                                    <a href="<?php echo e(route('nasabah.show', $n)); ?>" class="btn btn-ghost btn-icon" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('nasabah.edit', $n)); ?>" class="btn btn-ghost btn-icon" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('nasabah.destroy', $n)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger-ghost btn-icon"
                                                title="Hapus"
                                                data-confirm="Hapus nasabah <?php echo e($n->nama_nasabah); ?>?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php if($nasabah->hasPages()): ?>
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-meta">
                    Menampilkan <?php echo e($nasabah->firstItem()); ?>–<?php echo e($nasabah->lastItem()); ?> dari <?php echo e($nasabah->total()); ?>

                </div>
                <?php echo e($nasabah->links()); ?>

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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/nasabah/index.blade.php ENDPATH**/ ?>