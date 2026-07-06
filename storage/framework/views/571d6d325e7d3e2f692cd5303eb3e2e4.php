
<?php
    $batasiTanggal ??= false;
?>

<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Bagian 1 — Data Nasabah</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                <?php echo e($pengajuan ? 'Nasabah dan tanggal pengajuan pada periode ' . ($periode?->kode_periode ?? '—') . '.' : 'Pilih nasabah dan tetapkan tanggal pengajuan minggu ini.'); ?>

            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6" style="min-width: 0;">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'id_nasabah','label' => 'Nama Nasabah','required' => true,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'id_nasabah','label' => 'Nama Nasabah','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <div class="position-relative" style="width: 100%; max-width: 100%; min-width: 0;">
                        <input
                            type="text"
                            id="nasabah_search"
                            data-filters-select="#id_nasabah"
                            class="form-control mb-2"
                            placeholder="Ketik nama atau nomor anggota..."
                            autocomplete="off"
                        >
                        <select id="id_nasabah" name="id_nasabah" size="6"
                                class="form-select form-select-listbox <?php $__errorArgs = ['id_nasabah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">— Pilih nasabah —</option>
                            <?php $__currentLoopData = $nasabahList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nasabah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($nasabah->id_nasabah); ?>"
                                    data-search="<?php echo e(strtolower($nasabah->nama_nasabah . ' ' . $nasabah->no_anggota)); ?>"
                                    data-nama="<?php echo e($nasabah->nama_nasabah); ?>"
                                    data-alamat="<?php echo e($nasabah->alamat); ?>"
                                    title="<?php echo e($nasabah->nama_nasabah); ?> (<?php echo e($nasabah->no_anggota); ?>)"
                                    <?php echo e((string) old('id_nasabah', $pengajuan?->id_nasabah) === (string) $nasabah->id_nasabah ? 'selected' : ''); ?>>
                                    <?php echo e($nasabah->nama_nasabah); ?> (<?php echo e($nasabah->no_anggota); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                     <?php $__env->slot('helper', null, []); ?> 
                        Tidak menemukan nama? <a href="<?php echo e(route('nasabah.create')); ?>">Tambahkan nasabah baru</a>.
                     <?php $__env->endSlot(); ?>
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

            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'periode','label' => 'Minggu Pengajuan','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'periode','label' => 'Minggu Pengajuan','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo e($periode?->kode_periode); ?> · <?php echo e($periode?->tanggal_mulai?->format('d M')); ?>–<?php echo e($periode?->tanggal_selesai?->format('d M Y')); ?>"
                        disabled
                    >
                     <?php $__env->slot('helper', null, []); ?> 
                        <?php echo e($pengajuan ? 'Periode pengajuan tidak dapat diubah.' : 'Pengajuan otomatis tercatat pada minggu yang sedang berjalan.'); ?>

                     <?php $__env->endSlot(); ?>
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

            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'tanggal_pengajuan','label' => 'Tanggal Pengajuan','required' => true,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tanggal_pengajuan','label' => 'Tanggal Pengajuan','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input
                        type="date"
                        id="tanggal_pengajuan"
                        name="tanggal_pengajuan"
                        value="<?php echo e(old('tanggal_pengajuan', $pengajuan?->tanggal_pengajuan?->format('Y-m-d') ?? now()->format('Y-m-d'))); ?>"
                        <?php if($batasiTanggal && $periode): ?>
                            min="<?php echo e($periode->tanggal_mulai->format('Y-m-d')); ?>"
                            max="<?php echo e($periode->tanggal_selesai->format('Y-m-d')); ?>"
                        <?php endif; ?>
                        class="form-control <?php $__errorArgs = ['tanggal_pengajuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/partials/form-nasabah.blade.php ENDPATH**/ ?>