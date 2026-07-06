<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Uji Akurasi Sistem','pageTitle' => 'Uji Akurasi Sistem']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Uji Akurasi Sistem','page-title' => 'Uji Akurasi Sistem']); ?>
    <div class="section-header">
        <h1 class="text-h1">Uji Akurasi Sistem (LOOCV)</h1>
        <div class="breadcrumb-meta">
            Mengukur seberapa akurat sistem merekomendasikan keputusan pembiayaan dibandingkan
            dengan keputusan riil para petugas
        </div>
    </div>

    <?php if(! $siap): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning']); ?>
            <strong>Data belum cukup.</strong> Pengujian akurasi memerlukan minimal 20 keputusan riil.
            Saat ini tersedia <?php echo e($jumlah); ?> data.
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

    
    <?php if($hasil): ?>
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Akurasi Sistem','icon' => 'bi-bullseye','variant' => 'accept','value' => number_format($hasil['akurasi'] * 100, 2, ',', '.') . '%','meta' => 'Persentase rekomendasi yang tepat']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Akurasi Sistem','icon' => 'bi-bullseye','variant' => 'accept','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($hasil['akurasi'] * 100, 2, ',', '.') . '%'),'meta' => 'Persentase rekomendasi yang tepat']); ?>
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
            <div class="col-12 col-md-6 col-xl-3">
                <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Presisi','icon' => 'bi-check2-circle','variant' => 'priority','value' => number_format($hasil['presisi'] * 100, 2, ',', '.') . '%','meta' => 'Saat sistem rekomendasi \'Layak\', berapa benar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Presisi','icon' => 'bi-check2-circle','variant' => 'priority','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($hasil['presisi'] * 100, 2, ',', '.') . '%'),'meta' => 'Saat sistem rekomendasi \'Layak\', berapa benar']); ?>
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
            <div class="col-12 col-md-6 col-xl-3">
                <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Recall (Sensitivitas)','icon' => 'bi-search','variant' => 'priority','value' => number_format($hasil['recall'] * 100, 2, ',', '.') . '%','meta' => 'Dari yang seharusnya Layak, berapa terdeteksi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Recall (Sensitivitas)','icon' => 'bi-search','variant' => 'priority','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($hasil['recall'] * 100, 2, ',', '.') . '%'),'meta' => 'Dari yang seharusnya Layak, berapa terdeteksi']); ?>
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
            <div class="col-12 col-md-6 col-xl-3">
                <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Skor F1','icon' => 'bi-graph-up','value' => number_format($hasil['f1'] * 100, 2, ',', '.') . '%','meta' => 'Rata-rata harmonik presisi & recall']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Skor F1','icon' => 'bi-graph-up','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(number_format($hasil['f1'] * 100, 2, ',', '.') . '%'),'meta' => 'Rata-rata harmonik presisi & recall']); ?>
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

        
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card w-100">
                    <div class="card-header">
                        <h3 class="text-h3">Tabel Akurasi (Confusion Matrix)</h3>
                    </div>
                    <div class="card-body" style="padding: 0; overflow-x: auto;">
                        <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th>Hasil Pengujian</th>
                                    <th class="text-end">Aktual: Layak</th>
                                    <th class="text-end">Aktual: Belum Layak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-body-strong">Sistem Bilang Layak</td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-accept-bg); color: var(--color-status-accept-fg);">
                                        <?php echo e($hasil['tp']); ?> <span class="text-meta">(benar)</span>
                                    </td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-reject-bg); color: var(--color-status-reject-fg);">
                                        <?php echo e($hasil['fp']); ?> <span class="text-meta">(salah)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-body-strong">Sistem Bilang Belum Layak</td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-reject-bg); color: var(--color-status-reject-fg);">
                                        <?php echo e($hasil['fn']); ?> <span class="text-meta">(salah)</span>
                                    </td>
                                    <td class="text-end tabular-nums font-medium" style="background: var(--color-status-accept-bg); color: var(--color-status-accept-fg);">
                                        <?php echo e($hasil['tn']); ?> <span class="text-meta">(benar)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card w-100">
                    <div class="card-header">
                        <h3 class="text-h3">Cara Membaca</h3>
                    </div>
                    <div class="card-body">
                        <ul style="margin: 0; padding-left: 18px; color: var(--color-text-body); line-height: 1.8;">
                            <li>
                                <strong>Akurasi <?php echo e(number_format($hasil['akurasi'] * 100, 2, ',', '.')); ?>%</strong>
                                — dari total <?php echo e($jumlah); ?> pengujian, sistem menebak dengan tepat sebanyak
                                <?php echo e($hasil['tp'] + $hasil['tn']); ?> kasus.
                            </li>
                            <li>
                                <strong>Presisi <?php echo e(number_format($hasil['presisi'] * 100, 2, ',', '.')); ?>%</strong>
                                — saat sistem mengatakan "Layak Dibiayai", sebanyak persentase tersebut benar-benar layak.
                            </li>
                            <li>
                                <strong>Recall <?php echo e(number_format($hasil['recall'] * 100, 2, ',', '.')); ?>%</strong>
                                — dari semua nasabah yang seharusnya layak, sistem berhasil mendeteksi sebagian besar.
                            </li>
                            <li>
                                <strong>F1 Score <?php echo e(number_format($hasil['f1'] * 100, 2, ',', '.')); ?>%</strong>
                                — penyeimbang Presisi dan Recall, semakin tinggi semakin baik.
                            </li>
                        </ul>
                        <hr style="margin: 16px 0; border-color: var(--color-border);">
                        <p class="text-meta" style="margin: 0;">
                            Metode pengujian: Leave-One-Out Cross-Validation (LOOCV). Setiap data nasabah
                            dijadikan data uji satu per satu sementara 19 data sisanya dipakai untuk
                            mengkalibrasi ambang kelayakan. Hasilnya dirata-ratakan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card w-100">
            <div class="card-header">
                <div>
                    <h2 class="text-h2">Rincian Pengujian Tiap Nasabah</h2>
                    <p class="text-meta" style="margin: 4px 0 0 0;">
                        Daftar prediksi sistem vs keputusan riil untuk seluruh <?php echo e($jumlah); ?> data uji
                    </p>
                </div>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table table-hover align-middle table-finansial" style="margin: 0;">
                    <thead class="bg-slate-50">
                        <tr>
                            <th>Nama Nasabah</th>
                            <th class="text-end">Skor Kelayakan</th>
                            <th class="text-end">Ambang Kalibrasi</th>
                            <th>Rekomendasi Sistem</th>
                            <th>Keputusan Riil</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $hasil['detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $row = $dataset[$i]; ?>
                            <tr>
                                <td class="text-body-strong col-nama"><?php echo e($row['nasabah']); ?></td>
                                <td class="text-end tabular-nums"><?php echo e(number_format($row['vektor_S'], 2, ',', '.')); ?></td>
                                <td class="text-end tabular-nums"><?php echo e(number_format($d['theta'], 2, ',', '.')); ?></td>
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $d['prediksi']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($d['prediksi'])]); ?>
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
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $d['aktual']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($d['aktual'])]); ?>
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
                                <td>
                                    <?php if($d['benar']): ?>
                                        <span class="status-badge status-accept">
                                            <i class="bi bi-check-circle"></i> Tepat
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-reject">
                                            <i class="bi bi-x-circle"></i> Meleset
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/admin/loocv/index.blade.php ENDPATH**/ ?>