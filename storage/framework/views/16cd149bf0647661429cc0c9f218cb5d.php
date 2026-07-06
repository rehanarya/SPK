
<?php
    $hasilWp = $pengajuan?->hasilPerhitungan;
    $denganTanggal ??= false;
?>

<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Realisasi &amp; Tanda Tangan Manager</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Opsional — biasanya diisi setelah keputusan pembiayaan disetujui petugas.
                Boleh dikosongkan untuk pengajuan yang masih menunggu atau ditolak.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php if($denganTanggal): ?>
                <div class="col-12 col-md-6">
                    <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'tanggal_realisasi','label' => 'Tanggal Realisasi','errors' => $errors,'helper' => 'Tidak boleh sebelum tanggal pengajuan. Kosongkan bila belum direalisasikan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tanggal_realisasi','label' => 'Tanggal Realisasi','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Tidak boleh sebelum tanggal pengajuan. Kosongkan bila belum direalisasikan.']); ?>
                        <input type="date" id="tanggal_realisasi" name="tanggal_realisasi"
                            value="<?php echo e(old('tanggal_realisasi', $pengajuan?->tanggal_realisasi?->format('Y-m-d'))); ?>"
                            class="form-control <?php $__errorArgs = ['tanggal_realisasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $attributes = $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $component = $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'nama_manager','label' => 'Nama Manager','errors' => $errors,'helper' => 'Nama yang tercetak di bawah tanda tangan Manager pada formulir.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'nama_manager','label' => 'Nama Manager','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Nama yang tercetak di bawah tanda tangan Manager pada formulir.']); ?>
                    <input type="text" id="nama_manager" name="nama_manager"
                        value="<?php echo e(old('nama_manager', $hasilWp?->nama_manager)); ?>"
                        maxlength="100" placeholder="<?php echo e(auth()->user()?->nama); ?>"
                        class="form-control <?php $__errorArgs = ['nama_manager'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $attributes = $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $component = $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
            </div>
            <div class="col-12 col-md-8">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'ttd_manager','label' => 'Tanda Tangan Manager','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ttd_manager','label' => 'Tanda Tangan Manager','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <?php if (isset($component)) { $__componentOriginal72332feea9f878ab2343bb6e35d6719d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72332feea9f878ab2343bb6e35d6719d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.signature-pad','data' => ['name' => 'ttd_manager','label' => 'Manager','person' => old('nama_manager', $hasilWp?->nama_manager ?? auth()->user()?->nama),'existing' => $hasilWp?->ttd_manager]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('signature-pad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ttd_manager','label' => 'Manager','person' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nama_manager', $hasilWp?->nama_manager ?? auth()->user()?->nama)),'existing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hasilWp?->ttd_manager)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72332feea9f878ab2343bb6e35d6719d)): ?>
<?php $attributes = $__attributesOriginal72332feea9f878ab2343bb6e35d6719d; ?>
<?php unset($__attributesOriginal72332feea9f878ab2343bb6e35d6719d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72332feea9f878ab2343bb6e35d6719d)): ?>
<?php $component = $__componentOriginal72332feea9f878ab2343bb6e35d6719d; ?>
<?php unset($__componentOriginal72332feea9f878ab2343bb6e35d6719d); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $attributes = $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d)): ?>
<?php $component = $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d; ?>
<?php unset($__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/partials/form-realisasi.blade.php ENDPATH**/ ?>