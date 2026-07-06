<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Pengajuan Pembiayaan Baru','pageTitle' => 'Pengajuan Pembiayaan Baru','periodeAktif' => $periodeAktif]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pengajuan Pembiayaan Baru','page-title' => 'Pengajuan Pembiayaan Baru','periode-aktif' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($periodeAktif)]); ?>

    <div class="section-header">
        <h1 class="text-h1">Pengajuan Pembiayaan Baru</h1>
        <div class="breadcrumb-meta">
            <a href="<?php echo e(route('pengajuan.index')); ?>">Pengajuan</a>
            <span style="margin: 0 6px; color: var(--color-text-muted);">›</span>
            <span>Tambah pengajuan</span>
        </div>
    </div>

    <?php if($errors->any() && $errors->count() > 1): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger']); ?>
            <strong>Beberapa data belum terisi dengan benar.</strong> Periksa pesan di bawah setiap kolom.
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
    <?php endif; ?>

    <form
        method="POST"
        action="<?php echo e(route('pengajuan.store')); ?>"
        novalidate
        autocomplete="off"
    >
        <?php echo csrf_field(); ?>

        
        <?php echo $__env->make('penilaian.partials.form-nasabah', [
            'pengajuan'     => null,
            'periode'       => $periodeAktif,
            'batasiTanggal' => true,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <?php echo $__env->make('penilaian.partials.form-analisis', ['pengajuan' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div
            class="d-flex justify-content-between align-items-center"
            style="position: sticky; bottom: 0; background: var(--color-bg-app); padding: 16px 0; border-top: 1px solid var(--color-border); margin-top: 8px;"
        >
            <a href="<?php echo e(route('pengajuan.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary-strong">
                <i class="bi bi-check2-circle"></i> Simpan &amp; Nilai Kelayakan
            </button>
        </div>
    </form>

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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/create.blade.php ENDPATH**/ ?>