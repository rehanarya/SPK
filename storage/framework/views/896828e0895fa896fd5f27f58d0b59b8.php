<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Hitung Kelayakan','pageTitle' => 'Hitung Kelayakan Minggu Ini','periodeAktif' => $periodeAktif]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hitung Kelayakan','page-title' => 'Hitung Kelayakan Minggu Ini','periode-aktif' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($periodeAktif)]); ?>

    <div class="section-header">
        <h1 class="text-h1">Hitung Kelayakan Pembiayaan</h1>
        <div class="breadcrumb-meta">
            Minggu berjalan: <strong><?php echo e($periodeAktif->kode_periode); ?></strong>
            (<?php echo e($periodeAktif->tanggal_mulai->format('d M')); ?>–<?php echo e($periodeAktif->tanggal_selesai->format('d M Y')); ?>)
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="text-h2">Data Pengajuan Minggu Ini</h2>
                        <p class="text-meta" style="margin: 4px 0 0 0;">
                            <?php echo e($pengajuanList->count()); ?> pengajuan siap dihitung kelayakannya
                        </p>
                    </div>
                </div>
                <div class="card-body" style="padding: 0; overflow-x: auto;">
                    <?php if($pengajuanList->isEmpty()): ?>
                        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-inbox','title' => 'Belum ada pengajuan minggu ini','body' => 'Tambahkan pengajuan pembiayaan terlebih dahulu, lalu jalankan perhitungan.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-inbox','title' => 'Belum ada pengajuan minggu ini','body' => 'Tambahkan pengajuan pembiayaan terlebih dahulu, lalu jalankan perhitungan.']); ?>
                             <?php $__env->slot('action', null, []); ?> 
                                <a href="<?php echo e(route('pengajuan.create')); ?>" class="btn btn-primary-strong">
                                    <i class="bi bi-plus-lg"></i> Tambah Pengajuan
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
                            <thead>
                                <tr>
                                    <th>Nama Nasabah</th>
                                    <th class="col-right">Laba (Rp)</th>
                                    <th class="col-right">Pendapatan (Rp)</th>
                                    <th class="col-right">Agunan</th>
                                    <th class="col-right">Pembiayaan (Rp)</th>
                                    <th class="col-right">Tenor (bln)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pengajuanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="col-nama text-body-strong"><?php echo e($p->nasabah?->nama_nasabah ?? '—'); ?></td>
                                        <td class="col-nominal"><?php echo e(number_format($p->C1_laba_usaha, 0, ',', '.')); ?></td>
                                        <td class="col-nominal"><?php echo e(number_format($p->C2_pendapatan_bersih, 0, ',', '.')); ?></td>
                                        <td class="col-nominal"><?php echo e($p->C3_nilai_agunan); ?></td>
                                        <td class="col-nominal"><?php echo e(number_format($p->C4_besar_pembiayaan, 0, ',', '.')); ?></td>
                                        <td class="col-nominal"><?php echo e($p->C5_jangka_waktu); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header"><h3 class="text-h3">Bobot Faktor Penilaian</h3></div>
                <div class="card-body">
                    <table class="table-finansial" style="width: 100%; border: none;">
                        <thead>
                            <tr>
                                <th>Faktor</th>
                                <th class="col-right">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $kriteriaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => $k->tipe]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($k->tipe)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
                                        <?php echo e($k->nama_kriteria); ?>

                                    </td>
                                    <td class="col-nominal"><?php echo e(number_format(abs($k->bobot_normalisasi) * 100, 1, ',', '.')); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <form method="POST" action="<?php echo e(route('perhitungan.wp.hitung')); ?>" style="margin-top: 16px;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary-strong" style="width: 100%;"
                                <?php if($pengajuanList->isEmpty()): ?> disabled <?php endif; ?>>
                            <i class="bi bi-calculator"></i> Hitung Kelayakan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if($hasilList->isNotEmpty()): ?>
        <div class="card">
            <div class="card-header">
                <h2 class="text-h2">Hasil Perhitungan Terakhir</h2>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                <table class="table-finansial">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Urutan</th>
                            <th>Nama Nasabah</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $hasilList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="rank-chip"><?php echo e($h->ranking); ?></span></td>
                                <td class="col-nama text-body-strong"><?php echo e($h->pengajuan?->nasabah?->nama_nasabah ?? '—'); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($h->vektor_S, 2, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($h->vektor_V * 100, 2, ',', '.')); ?>%</td>
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $h->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($h->status)]); ?>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/penilaian/wp.blade.php ENDPATH**/ ?>