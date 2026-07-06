

<?php
    $nilai = fn (string $field, $default = null) => old($field, $pengajuan?->{$field} ?? $default);
    $fmt   = fn ($v) => $v !== null && $v !== '' ? number_format((float) $v, 0, ',', '.') : '';
?>

<input type="hidden" name="mode_input" value="analisis">


<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Analisis Pembiayaan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Isi angka sesuai formulir manual koperasi. Baris bertanda
                <span class="badge text-bg-light" style="font-weight: 600;">otomatis</span> dihitung langsung oleh sistem.
                Tanda <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => 'benefit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'benefit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?> berarti <em>semakin besar semakin baik</em>;
                tanda <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => 'cost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'cost']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?> berarti <em>semakin kecil semakin baik</em>.
            </p>
        </div>
    </div>
    <div class="card-body">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">1. Perhitungan Laba Usaha <span class="text-meta">(dalam 1 bulan)</span></h3>

        
        <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'sumber_penghasilan','label' => 'Sumber Penghasilan Utama','errors' => $errors,'helper' => 'Untuk pegawai/karyawan: isi gaji bulanan pada kolom Penjualan Usaha; HPP dan Biaya Usaha biarkan 0.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'sumber_penghasilan','label' => 'Sumber Penghasilan Utama','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Untuk pegawai/karyawan: isi gaji bulanan pada kolom Penjualan Usaha; HPP dan Biaya Usaha biarkan 0.']); ?>
            <div class="d-flex gap-4" style="padding: 4px 0;">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sumber_penghasilan" id="sumber_usaha" value="usaha"
                        <?php echo e($nilai('sumber_penghasilan', 'usaha') !== 'gaji' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="sumber_usaha">Usaha</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sumber_penghasilan" id="sumber_gaji" value="gaji"
                        <?php echo e($nilai('sumber_penghasilan') === 'gaji' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="sumber_gaji">Gaji / Pegawai</label>
                </div>
            </div>
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

        <div class="row g-3">
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'penjualan_usaha','label' => 'Penjualan Usaha (Rp)','required' => true,'errors' => $errors,'helper' => 'Omzet penjualan usaha nasabah dalam satu bulan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'penjualan_usaha','label' => 'Penjualan Usaha (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Omzet penjualan usaha nasabah dalam satu bulan.']); ?>
                    <input type="text" id="penjualan_usaha" name="penjualan_usaha"
                        value="<?php echo e($nilai('penjualan_usaha')); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 33.400.000"
                        class="form-control <?php $__errorArgs = ['penjualan_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'harga_pokok_jual','label' => 'Harga Pokok Jual (Rp)','errors' => $errors,'helper' => 'Modal / harga pokok barang yang dijual dalam satu bulan. Boleh 0 / kosong untuk pegawai.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'harga_pokok_jual','label' => 'Harga Pokok Jual (Rp)','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Modal / harga pokok barang yang dijual dalam satu bulan. Boleh 0 / kosong untuk pegawai.']); ?>
                    <input type="text" id="harga_pokok_jual" name="harga_pokok_jual"
                        value="<?php echo e($nilai('harga_pokok_jual')); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 24.500.000"
                        class="form-control <?php $__errorArgs = ['harga_pokok_jual'];
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'biaya_usaha','label' => 'Biaya Usaha (Rp)','errors' => $errors,'helper' => 'Biaya operasional usaha (listrik, transport, tenaga, dll). Boleh 0 / kosong untuk pegawai.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'biaya_usaha','label' => 'Biaya Usaha (Rp)','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Biaya operasional usaha (listrik, transport, tenaga, dll). Boleh 0 / kosong untuk pegawai.']); ?>
                    <input type="text" id="biaya_usaha" name="biaya_usaha"
                        value="<?php echo e($nilai('biaya_usaha')); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 5.000.000"
                        class="form-control <?php $__errorArgs = ['biaya_usaha'];
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
        </div>
        <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'laba_usaha_display','label' => 'Laba Usaha (Rp) — otomatis','badge' => 'benefit','errors' => $errors,'helper' => 'Kriteria C1. Dihitung otomatis: Penjualan Usaha − Harga Pokok Jual − Biaya Usaha.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'laba_usaha_display','label' => 'Laba Usaha (Rp) — otomatis','badge' => 'benefit','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Kriteria C1. Dihitung otomatis: Penjualan Usaha − Harga Pokok Jual − Biaya Usaha.']); ?>
            <input type="text" id="laba_usaha_display" class="form-control font-numeric" data-hitung="laba_usaha" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->C1_laba_usaha)); ?>">
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

        <hr style="margin: 20px 0;">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">2. Perhitungan Kemampuan Bayar</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'laba_usaha_echo','label' => 'Laba Usaha (Rp) — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'laba_usaha_echo','label' => 'Laba Usaha (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="laba_usaha" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->C1_laba_usaha)); ?>">
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'pendapatan_pasangan','label' => 'Pendapatan dari Istri/Suami (Rp)','required' => true,'errors' => $errors,'helper' => 'Isi 0 bila tidak ada.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pendapatan_pasangan','label' => 'Pendapatan dari Istri/Suami (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Isi 0 bila tidak ada.']); ?>
                    <input type="text" id="pendapatan_pasangan" name="pendapatan_pasangan"
                        value="<?php echo e($nilai('pendapatan_pasangan', 0)); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control <?php $__errorArgs = ['pendapatan_pasangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'pendapatan_lainnya','label' => 'Pendapatan Lainnya (Rp)','required' => true,'errors' => $errors,'helper' => 'Isi 0 bila tidak ada.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pendapatan_lainnya','label' => 'Pendapatan Lainnya (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Isi 0 bila tidak ada.']); ?>
                    <input type="text" id="pendapatan_lainnya" name="pendapatan_lainnya"
                        value="<?php echo e($nilai('pendapatan_lainnya', 0)); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control <?php $__errorArgs = ['pendapatan_lainnya'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
        <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jumlah_pendapatan_display','label' => 'Jumlah Pendapatan (Rp) — otomatis','errors' => $errors,'helper' => 'Dihitung otomatis: Laba Usaha + Pendapatan Istri/Suami + Pendapatan Lainnya.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jumlah_pendapatan_display','label' => 'Jumlah Pendapatan (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Dihitung otomatis: Laba Usaha + Pendapatan Istri/Suami + Pendapatan Lainnya.']); ?>
            <input type="text" class="form-control font-numeric" data-hitung="jumlah_pendapatan" readonly tabindex="-1">
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

        <hr style="margin: 20px 0;">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">3. Biaya dan Pengeluaran di Luar Usaha</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'kebutuhan_rumah_tangga','label' => 'Kebutuhan Rmh. Tangga (Rp)','required' => true,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'kebutuhan_rumah_tangga','label' => 'Kebutuhan Rmh. Tangga (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" id="kebutuhan_rumah_tangga" name="kebutuhan_rumah_tangga"
                        value="<?php echo e($nilai('kebutuhan_rumah_tangga')); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 2.500.000"
                        class="form-control <?php $__errorArgs = ['kebutuhan_rumah_tangga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'biaya_pendidikan','label' => 'Biaya Pendidikan (Rp)','required' => true,'errors' => $errors,'helper' => 'Isi 0 bila tidak ada.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'biaya_pendidikan','label' => 'Biaya Pendidikan (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Isi 0 bila tidak ada.']); ?>
                    <input type="text" id="biaya_pendidikan" name="biaya_pendidikan"
                        value="<?php echo e($nilai('biaya_pendidikan', 0)); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control <?php $__errorArgs = ['biaya_pendidikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'biaya_lainnya','label' => 'Biaya Lainnya (Rp)','required' => true,'errors' => $errors,'helper' => 'Isi 0 bila tidak ada.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'biaya_lainnya','label' => 'Biaya Lainnya (Rp)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Isi 0 bila tidak ada.']); ?>
                    <input type="text" id="biaya_lainnya" name="biaya_lainnya"
                        value="<?php echo e($nilai('biaya_lainnya', 0)); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control <?php $__errorArgs = ['biaya_lainnya'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
        <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jumlah_pengeluaran_display','label' => 'Jumlah Pengeluaran (Rp) — otomatis','errors' => $errors,'helper' => 'Dihitung otomatis: Kebutuhan Rmh. Tangga + Biaya Pendidikan + Biaya Lainnya.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jumlah_pengeluaran_display','label' => 'Jumlah Pengeluaran (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Dihitung otomatis: Kebutuhan Rmh. Tangga + Biaya Pendidikan + Biaya Lainnya.']); ?>
            <input type="text" class="form-control font-numeric" data-hitung="jumlah_pengeluaran" readonly tabindex="-1">
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

        <hr style="margin: 20px 0;">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">4. Jumlah Pendapatan Bersih</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jumlah_pendapatan_echo','label' => 'Jumlah Pendapatan (Rp) — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jumlah_pendapatan_echo','label' => 'Jumlah Pendapatan (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_pendapatan" readonly tabindex="-1">
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jumlah_pengeluaran_echo','label' => 'Jumlah Pengeluaran (Rp) — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jumlah_pengeluaran_echo','label' => 'Jumlah Pengeluaran (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_pengeluaran" readonly tabindex="-1">
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
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'pendapatan_bersih_display','label' => 'Pendapatan Bersih (Rp) — otomatis','badge' => 'benefit','errors' => $errors,'helper' => 'Kriteria C2. Jumlah Pendapatan − Jumlah Pengeluaran; wajib lebih dari Rp 0.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pendapatan_bersih_display','label' => 'Pendapatan Bersih (Rp) — otomatis','badge' => 'benefit','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Kriteria C2. Jumlah Pendapatan − Jumlah Pengeluaran; wajib lebih dari Rp 0.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="pendapatan_bersih" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->C2_pendapatan_bersih)); ?>">
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

        <hr style="margin: 20px 0;">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">5. Rasio Angsuran</h3>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'rasio_angsuran','label' => 'Rasio Angsuran (%)','required' => true,'errors' => $errors,'helper' => 'Persentase pendapatan bersih yang boleh dipakai mengangsur. Standar koperasi: 40%.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'rasio_angsuran','label' => 'Rasio Angsuran (%)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Persentase pendapatan bersih yang boleh dipakai mengangsur. Standar koperasi: 40%.']); ?>
                    <input type="number" id="rasio_angsuran" name="rasio_angsuran"
                        value="<?php echo e($nilai('rasio_angsuran', 40)); ?>" min="1" max="100" step="0.01" data-komponen
                        class="form-control <?php $__errorArgs = ['rasio_angsuran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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

        <hr style="margin: 20px 0;">

        
        <h3 class="text-h3" style="margin-bottom: 12px;">6. Jumlah Pembiayaan Yang Dapat Diberikan</h3>
        <div class="row g-3">
            <div class="col-12 col-md-3">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'rasio_echo','label' => 'Rasio Angsuran — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'rasio_echo','label' => 'Rasio Angsuran — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="rasio_echo" readonly tabindex="-1">
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
            <div class="col-12 col-md-3">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'pendapatan_bersih_echo','label' => 'Pendapatan Bersih (Rp) — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pendapatan_bersih_echo','label' => 'Pendapatan Bersih (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="pendapatan_bersih" readonly tabindex="-1">
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
            <div class="col-12 col-md-3">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'C5_jangka_waktu','label' => 'Jangka Waktu (bulan)','required' => true,'badge' => 'cost','errors' => $errors,'helper' => 'Kriteria C5. Lama angsuran, maksimal 48 bulan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'C5_jangka_waktu','label' => 'Jangka Waktu (bulan)','required' => true,'badge' => 'cost','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Kriteria C5. Lama angsuran, maksimal 48 bulan.']); ?>
                    <input type="number" id="C5_jangka_waktu" name="C5_jangka_waktu"
                        value="<?php echo e($nilai('C5_jangka_waktu')); ?>" min="1" max="48" step="1" data-komponen
                        placeholder="contoh: 24"
                        class="form-control <?php $__errorArgs = ['C5_jangka_waktu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
            <div class="col-12 col-md-3">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'plafon_display','label' => 'Jumlah Pembiayaan / Plafon (Rp) — otomatis','errors' => $errors,'helper' => 'Pendapatan Bersih × Rasio Angsuran × Jangka Waktu.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'plafon_display','label' => 'Jumlah Pembiayaan / Plafon (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Pendapatan Bersih × Rasio Angsuran × Jangka Waktu.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="plafon" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->plafon_pembiayaan)); ?>">
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


<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Usulan Pembiayaan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">Rincian usulan sesuai blok "USULAN PEMBIAYAAN" formulir manual.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'C4_besar_pembiayaan','label' => '1. Besarnya Pembiayaan (Rp)','required' => true,'badge' => 'cost','errors' => $errors,'helper' => 'Kriteria C4. Nominal pinjaman yang diajukan nasabah.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'C4_besar_pembiayaan','label' => '1. Besarnya Pembiayaan (Rp)','required' => true,'badge' => 'cost','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Kriteria C4. Nominal pinjaman yang diajukan nasabah.']); ?>
                    <input type="text" id="C4_besar_pembiayaan" name="C4_besar_pembiayaan"
                        value="<?php echo e($nilai('C4_besar_pembiayaan')); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        placeholder="contoh: 8.000.000"
                        class="form-control <?php $__errorArgs = ['C4_besar_pembiayaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <div id="indikator_plafon" class="form-helper" style="display: none; margin-top: 6px; font-weight: 600;"></div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jangka_echo','label' => '2. Jangka Waktu (bulan) — otomatis','errors' => $errors,'helper' => 'Mengikuti Jangka Waktu pada Seksi 6 Analisis Pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jangka_echo','label' => '2. Jangka Waktu (bulan) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Mengikuti Jangka Waktu pada Seksi 6 Analisis Pembiayaan.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="jangka_echo" readonly tabindex="-1">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'angsuran_pokok_display','label' => '3. Angsuran Pokok (Rp) — otomatis','errors' => $errors,'helper' => 'Besarnya Pembiayaan ÷ Jangka Waktu.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'angsuran_pokok_display','label' => '3. Angsuran Pokok (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Besarnya Pembiayaan ÷ Jangka Waktu.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="angsuran_pokok" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->angsuran_pokok)); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'bagi_hasil_display','label' => '4. Bagi Hasil (Rp / bulan) — otomatis','errors' => $errors,'helper' => 'Dihitung otomatis: '.e(\App\Services\AnalisisPembiayaanService::BAGI_HASIL_PERSEN).'% × Besarnya Pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bagi_hasil_display','label' => '4. Bagi Hasil (Rp / bulan) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Dihitung otomatis: '.e(\App\Services\AnalisisPembiayaanService::BAGI_HASIL_PERSEN).'% × Besarnya Pembiayaan.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="bagi_hasil" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->bagi_hasil)); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'simpanan','label' => '5. Simpanan (Rp / bulan)','required' => true,'errors' => $errors,'helper' => 'Simpanan wajib per bulan. Standar koperasi: Rp 10.000.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'simpanan','label' => '5. Simpanan (Rp / bulan)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Simpanan wajib per bulan. Standar koperasi: Rp 10.000.']); ?>
                    <input type="text" id="simpanan" name="simpanan"
                        value="<?php echo e($nilai('simpanan', 10000)); ?>" data-mask="rupiah" data-komponen inputmode="numeric"
                        class="form-control <?php $__errorArgs = ['simpanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jumlah_angsuran_display','label' => '6. Jumlah Angsuran (Rp) — otomatis','errors' => $errors,'helper' => 'Angsuran Pokok + Bagi Hasil + Simpanan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jumlah_angsuran_display','label' => '6. Jumlah Angsuran (Rp) — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Angsuran Pokok + Bagi Hasil + Simpanan.']); ?>
                    <input type="text" class="form-control font-numeric" data-hitung="jumlah_angsuran" readonly tabindex="-1" value="<?php echo e($fmt($pengajuan?->jumlah_angsuran)); ?>">
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


<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Persetujuan (Disetujui / Tidak Disetujui)</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Data blok "DISETUJUI / TIDAK DISETUJUI" formulir manual. Status akhir ditentukan
                hasil perhitungan sistem dan keputusan petugas.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'nama_persetujuan','label' => '1. Nama — otomatis','errors' => $errors,'helper' => 'Terisi otomatis dari nasabah yang dipilih pada Bagian 1.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'nama_persetujuan','label' => '1. Nama — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Terisi otomatis dari nasabah yang dipilih pada Bagian 1.']); ?>
                    <input type="text" class="form-control" data-hitung="nama_nasabah" readonly tabindex="-1" value="<?php echo e($pengajuan?->nasabah?->nama_nasabah); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'alamat_persetujuan','label' => '2. Alamat — otomatis','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'alamat_persetujuan','label' => '2. Alamat — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                    <input type="text" class="form-control" data-hitung="alamat_nasabah" readonly tabindex="-1" value="<?php echo e($pengajuan?->nasabah?->alamat); ?>">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'jenis_akad','label' => '3. Pembiayaan (Jenis Akad)','required' => true,'errors' => $errors,'helper' => 'Jenis akad syariah pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'jenis_akad','label' => '3. Pembiayaan (Jenis Akad)','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Jenis akad syariah pembiayaan.']); ?>
                    <select id="jenis_akad" name="jenis_akad" class="form-select <?php $__errorArgs = ['jenis_akad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">— Pilih jenis akad —</option>
                        <?php $__currentLoopData = \App\Models\Pengajuan::AKAD_LIST; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $akad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($akad); ?>" <?php echo e($nilai('jenis_akad') === $akad ? 'selected' : ''); ?>><?php echo e($akad); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'nominal_persetujuan','label' => 'Nominal &amp; Terbilang — otomatis','errors' => $errors,'helper' => 'Mengikuti Besarnya Pembiayaan pada Usulan Pembiayaan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'nominal_persetujuan','label' => 'Nominal &amp; Terbilang — otomatis','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Mengikuti Besarnya Pembiayaan pada Usulan Pembiayaan.']); ?>
                    <input type="text" class="form-control font-numeric mb-1" data-hitung="nominal_pembiayaan" readonly tabindex="-1">
                    <input type="text" class="form-control" data-hitung="terbilang_pembiayaan" readonly tabindex="-1" style="font-style: italic;">
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
                <?php
                    $tglRealisasi = $nilai('tanggal_realisasi');
                    $tglRealisasi = $tglRealisasi instanceof \Carbon\CarbonInterface ? $tglRealisasi->format('Y-m-d') : $tglRealisasi;
                ?>
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'tanggal_realisasi','label' => '4. Realisasi (Tanggal)','errors' => $errors,'helper' => 'Boleh dikosongkan bila belum direalisasikan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tanggal_realisasi','label' => '4. Realisasi (Tanggal)','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Boleh dikosongkan bila belum direalisasikan.']); ?>
                    <input type="date" id="tanggal_realisasi" name="tanggal_realisasi"
                        value="<?php echo e($tglRealisasi); ?>"
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
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'C3_nilai_agunan','label' => '5. Agunan','required' => true,'badge' => 'benefit','errors' => $errors,'helper' => 'Kriteria C3. Pilihan agunan otomatis dipetakan ke skala ordinal 1–4.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'C3_nilai_agunan','label' => '5. Agunan','required' => true,'badge' => 'benefit','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Kriteria C3. Pilihan agunan otomatis dipetakan ke skala ordinal 1–4.']); ?>
                    <select id="C3_nilai_agunan" name="C3_nilai_agunan" class="form-select <?php $__errorArgs = ['C3_nilai_agunan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">— Pilih agunan —</option>
                        <?php $__currentLoopData = \App\Models\Pengajuan::AGUNAN_LABELS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skala => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($skala); ?>" <?php echo e((string) $nilai('C3_nilai_agunan') === (string) $skala ? 'selected' : ''); ?>>
                                <?php echo e($label); ?> (skala <?php echo e($skala); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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


<div class="card mb-4">
    <div class="card-header">
        <div>
            <h2 class="text-h2">Tanda Tangan</h2>
            <p class="text-meta" style="margin: 4px 0 0 0;">
                Goreskan tanda tangan Anggota dan Petugas dengan mouse/jari. Opsional —
                bila dikosongkan, formulir cetak menyisakan ruang tanda tangan basah.
                Tanda tangan Manager dibubuhkan di halaman Penetapan Keputusan.
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginal72332feea9f878ab2343bb6e35d6719d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72332feea9f878ab2343bb6e35d6719d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.signature-pad','data' => ['name' => 'ttd_anggota','label' => 'Anggota','personHook' => 'nama_nasabah','person' => $pengajuan?->nasabah?->nama_nasabah,'existing' => $pengajuan?->ttd_anggota]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('signature-pad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ttd_anggota','label' => 'Anggota','person-hook' => 'nama_nasabah','person' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pengajuan?->nasabah?->nama_nasabah),'existing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pengajuan?->ttd_anggota)]); ?>
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
            </div>
            <div class="col-12 col-md-6">
                <?php if (isset($component)) { $__componentOriginal72332feea9f878ab2343bb6e35d6719d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72332feea9f878ab2343bb6e35d6719d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.signature-pad','data' => ['name' => 'ttd_petugas','label' => 'Petugas','person' => auth()->user()?->nama,'existing' => $pengajuan?->ttd_petugas]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('signature-pad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'ttd_petugas','label' => 'Petugas','person' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()?->nama),'existing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pengajuan?->ttd_petugas)]); ?>
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
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Ambil angka polos dari input bermask rupiah / number
    function angka(id) {
        var el = document.getElementById(id);
        if (!el) return 0;
        // Input bermask memakai titik ribuan — buang semua titik lalu parse
        var n = parseFloat(String(el.value).replace(/\./g, '').replace(',', '.'));
        return isNaN(n) ? 0 : n;
    }

    var fmt = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 });

    function tulis(kunci, teks) {
        document.querySelectorAll('[data-hitung="' + kunci + '"]').forEach(function (el) {
            el.value = teks;
        });
    }

    // Terbilang bahasa Indonesia sederhana (padanan App\Support\Terbilang)
    var SATUAN = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
    function terbilang(n) {
        n = Math.floor(Math.abs(n));
        if (n < 12) return SATUAN[n];
        if (n < 20) return terbilang(n - 10) + ' belas';
        if (n < 100) return (terbilang(Math.floor(n / 10)) + ' puluh ' + terbilang(n % 10)).trim();
        if (n < 200) return ('seratus ' + terbilang(n - 100)).trim();
        if (n < 1000) return (terbilang(Math.floor(n / 100)) + ' ratus ' + terbilang(n % 100)).trim();
        if (n < 2000) return ('seribu ' + terbilang(n - 1000)).trim();
        if (n < 1e6) return (terbilang(Math.floor(n / 1000)) + ' ribu ' + terbilang(n % 1000)).trim();
        if (n < 1e9) return (terbilang(Math.floor(n / 1e6)) + ' juta ' + terbilang(n % 1e6)).trim();
        return (terbilang(Math.floor(n / 1e9)) + ' miliar ' + terbilang(n % 1e9)).trim();
    }

    function hitungUlang() {
        // Seksi 1 — Laba Usaha = Penjualan − HPP − Biaya Usaha
        var laba = angka('penjualan_usaha') - angka('harga_pokok_jual') - angka('biaya_usaha');
        // Seksi 2 — Jumlah Pendapatan
        var jumlahPendapatan = laba + angka('pendapatan_pasangan') + angka('pendapatan_lainnya');
        // Seksi 3 — Jumlah Pengeluaran
        var jumlahPengeluaran = angka('kebutuhan_rumah_tangga') + angka('biaya_pendidikan') + angka('biaya_lainnya');
        // Seksi 4 — Pendapatan Bersih
        var bersih = jumlahPendapatan - jumlahPengeluaran;
        // Seksi 5–6 — Plafon
        var rasio = angka('rasio_angsuran') || 40;
        var jangka = angka('C5_jangka_waktu');
        var plafon = bersih * (rasio / 100) * jangka;
        // Usulan — bagi hasil otomatis 2% × Besarnya Pembiayaan (per bulan)
        var besar = angka('C4_besar_pembiayaan');
        var pokok = jangka > 0 ? Math.round((besar / jangka) * 100) / 100 : 0;
        var bagiHasil = Math.round(besar * <?php echo e(\App\Services\AnalisisPembiayaanService::BAGI_HASIL_PERSEN); ?> ) / 100;
        var jumlahAngsuran = pokok + bagiHasil + angka('simpanan');

        tulis('laba_usaha', fmt.format(laba));
        tulis('jumlah_pendapatan', fmt.format(jumlahPendapatan));
        tulis('jumlah_pengeluaran', fmt.format(jumlahPengeluaran));
        tulis('pendapatan_bersih', fmt.format(bersih));
        tulis('rasio_echo', fmt.format(rasio) + ' %');
        tulis('jangka_echo', jangka > 0 ? jangka + ' bulan' : '');
        tulis('plafon', fmt.format(plafon));
        tulis('angsuran_pokok', fmt.format(pokok));
        tulis('bagi_hasil', besar > 0 ? fmt.format(bagiHasil) : '');
        tulis('jumlah_angsuran', fmt.format(jumlahAngsuran));
        tulis('nominal_pembiayaan', besar > 0 ? 'Rp ' + fmt.format(besar) : '');
        tulis('terbilang_pembiayaan', besar > 0 ? (terbilang(besar) + ' rupiah').replace(/^./, function (c) { return c.toUpperCase(); }) : '');

        // Indikator hijau (≤ plafon) / kuning (> plafon) untuk Besarnya Pembiayaan
        var ind = document.getElementById('indikator_plafon');
        if (ind) {
            if (besar > 0 && plafon > 0) {
                ind.style.display = 'block';
                if (besar <= plafon) {
                    ind.className = 'form-helper text-success';
                    ind.textContent = '✔ Dalam batas plafon (Rp ' + fmt.format(plafon) + ')';
                } else {
                    ind.className = 'form-helper text-warning';
                    ind.textContent = '⚠ Melebihi plafon hitung (Rp ' + fmt.format(plafon) + ') — keputusan tetap di petugas';
                }
            } else {
                ind.style.display = 'none';
            }
        }
    }

    // Nama & alamat otomatis dari nasabah terpilih (Bagian 1)
    var selectNasabah = document.getElementById('id_nasabah');
    function isiIdentitas() {
        if (!selectNasabah) return;
        var opt = selectNasabah.options[selectNasabah.selectedIndex];
        var nama = opt && opt.value ? (opt.dataset.nama || opt.text.trim()) : '';
        tulis('nama_nasabah', nama);
        tulis('alamat_nasabah', opt && opt.value ? (opt.dataset.alamat || '') : '');
        // Nama di pad tanda tangan Anggota (elemen teks, bukan input)
        document.querySelectorAll('[data-hitung-teks="nama_nasabah"]').forEach(function (el) {
            el.textContent = nama || '—';
        });
    }
    if (selectNasabah) selectNasabah.addEventListener('change', isiIdentitas);

    // ── Sumber penghasilan: mode Gaji/Pegawai ────────────────────────────
    // Label "Penjualan Usaha" berubah tampil jadi "Penjualan Usaha / Gaji
    // Bulanan"; HPP & Biaya Usaha otomatis 0 (tetap bisa diubah manual).
    function terapkanSumber() {
        var gaji = document.getElementById('sumber_gaji');
        var modeGaji = gaji && gaji.checked;

        var label = document.querySelector('label[for="penjualan_usaha"]');
        if (label) {
            label.childNodes.forEach(function (node) {
                if (node.nodeType === Node.TEXT_NODE && node.nodeValue.trim() !== '') {
                    node.nodeValue = modeGaji ? ' Penjualan Usaha / Gaji Bulanan (Rp) ' : ' Penjualan Usaha (Rp) ';
                }
            });
        }

        var grup = document.getElementById('penjualan_usaha');
        var helper = grup ? grup.closest('.form-group').querySelector('.form-helper') : null;
        if (helper) {
            helper.textContent = modeGaji
                ? 'Masukkan gaji bulanan di kolom ini; HPP dan Biaya Usaha biarkan 0.'
                : 'Omzet penjualan usaha nasabah dalam satu bulan.';
        }

        if (modeGaji) {
            ['harga_pokok_jual', 'biaya_usaha'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el && angka(id) === 0) {
                    el.value = '0';
                    el.dispatchEvent(new Event('input', { bubbles: true })); // sinkron IMask + hitung ulang
                }
            });
        }
    }
    ['sumber_usaha', 'sumber_gaji'].forEach(function (id) {
        var radio = document.getElementById(id);
        if (radio) radio.addEventListener('change', terapkanSumber);
    });

    document.querySelectorAll('[data-komponen]').forEach(function (el) {
        el.addEventListener('input', hitungUlang);
    });

    hitungUlang();
    isiIdentitas();
    terapkanSumber();
});
</script>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/partials/form-analisis.blade.php ENDPATH**/ ?>