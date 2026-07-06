<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Kalibrasi Ambang Kelayakan','pageTitle' => 'Kalibrasi Ambang Kelayakan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kalibrasi Ambang Kelayakan','page-title' => 'Kalibrasi Ambang Kelayakan']); ?>
    <div class="section-header">
        <h1 class="text-h1">Kalibrasi Ambang Kelayakan</h1>
        <div class="breadcrumb-meta">
            Sesuaikan ambang kelayakan berdasarkan data nasabah yang sudah pernah diputuskan
        </div>
    </div>

    <?php if(isset($error)): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger']); ?><?php echo e($error); ?> <?php echo $__env->renderComponent(); ?>
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

    <?php if($errors->has('theta_manual')): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'danger']); ?><?php echo e($errors->first('theta_manual')); ?> <?php echo $__env->renderComponent(); ?>
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

    <div class="row g-3">
        <div class="col-12 col-lg-6">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Ambang Kelayakan Saat Ini','icon' => 'bi-rulers','value' => number_format($theta, 0, ',', '.'),'meta' => 'Skor minimum agar nasabah dianggap layak']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Ambang Kelayakan Saat Ini','icon' => 'bi-rulers','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($theta, 0, ',', '.')),'meta' => 'Skor minimum agar nasabah dianggap layak']); ?>
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
        <div class="col-12 col-lg-6">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Riwayat Keputusan Tersedia','icon' => 'bi-clipboard-data','variant' => $siap ? 'accept' : 'pending','value' => $jumlahLog,'meta' => $siap ? 'Data cukup untuk kalibrasi otomatis' : 'Perlu minimal 20 data untuk kalibrasi otomatis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Riwayat Keputusan Tersedia','icon' => 'bi-clipboard-data','variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siap ? 'accept' : 'pending'),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jumlahLog),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siap ? 'Data cukup untuk kalibrasi otomatis' : 'Perlu minimal 20 data untuk kalibrasi otomatis')]); ?>
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

    <div class="card" style="margin-top: 16px;">
        <div class="card-header"><h2 class="text-h2">Atur Ambang Kelayakan</h2></div>
        <div class="card-body">
            <p class="text-body" style="margin-bottom: 16px;">
                Sistem dapat menghitung ambang kelayakan baru secara otomatis dari riwayat keputusan
                yang telah dibuat. Anda juga dapat mengatur nilainya secara manual bila ingin
                mengembalikan ke standar tertentu (misal kembali ke nilai 250).
            </p>
            <p class="text-meta" style="margin-bottom: 16px;">
                Untuk kalibrasi otomatis, hasilnya hanya akan disimpan setelah Anda mengkonfirmasinya
                pada langkah berikutnya.
            </p>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <form method="POST" action="<?php echo e(route('admin.threshold.preview')); ?>" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary-strong" <?php echo e($siap ? '' : 'disabled'); ?>>
                        <i class="bi bi-play-circle"></i> Lihat Hasil Kalibrasi
                    </button>
                </form>

                <button type="button" class="btn btn-secondary"
                        data-bs-toggle="modal" data-bs-target="#modalAmbangManual">
                    <i class="bi bi-pencil-square"></i> Atur Ambang Manual
                </button>

                <?php if (! ($siap)): ?>
                    <span class="text-meta" style="margin-left: 8px;">
                        Kalibrasi otomatis belum tersedia — baru <?php echo e($jumlahLog); ?> dari minimal 20 data.
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="modal fade"
         id="modalAmbangManual"
         tabindex="-1"
         aria-labelledby="modalAmbangManualTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content"
                 style="border-radius: 12px; border: 1px solid var(--color-border); box-shadow: var(--elev-3);">

                <form method="POST" action="<?php echo e(route('admin.threshold.manual')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="modal-header"
                         style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                        <h3 class="text-h3" style="margin: 0;" id="modalAmbangManualTitle">
                            Atur Ambang Kelayakan Secara Manual
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body" style="padding: 20px;">
                        <p class="text-meta" style="margin: 0 0 16px 0;">
                            Masukkan skor minimum agar pengajuan dianggap layak. Nilai standar awal sistem adalah
                            <strong>250</strong>.
                        </p>

                        <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'theta_manual','label' => 'Ambang Kelayakan Baru','required' => true,'errors' => $errors,'helper' => 'Bilangan bulat ≥ 1. Hindari angka terlalu kecil agar penilaian tetap selektif.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'theta_manual','label' => 'Ambang Kelayakan Baru','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors),'helper' => 'Bilangan bulat ≥ 1. Hindari angka terlalu kecil agar penilaian tetap selektif.']); ?>
                            <input
                                type="number"
                                id="theta_manual"
                                name="theta_manual"
                                value="<?php echo e(old('theta_manual', (int) $theta)); ?>"
                                min="1"
                                max="99999"
                                step="1"
                                inputmode="numeric"
                                placeholder="contoh: 250"
                                class="form-control <?php $__errorArgs = ['theta_manual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                                autofocus
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

                        <div class="text-meta" style="margin-top: 8px;">
                            Nilai saat ini: <strong class="font-numeric"><?php echo e(number_format($theta, 0, ',', '.')); ?></strong>
                        </div>
                    </div>

                    <div class="modal-footer"
                         style="border-top: 1px solid var(--color-border); padding: 12px 20px; display: flex; justify-content: space-between; gap: 12px;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-strong">
                            <i class="bi bi-check2-circle"></i> Simpan Ambang Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if($errors->has('theta_manual')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('modalAmbangManual'));
                modal.show();
            });
        </script>
    <?php endif; ?>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/threshold/index.blade.php ENDPATH**/ ?>