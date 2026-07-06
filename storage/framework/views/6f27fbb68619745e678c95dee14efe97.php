<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Hasil Penilaian','pageTitle' => 'Hasil Penilaian','periodeAktif' => $periode]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Hasil Penilaian','page-title' => 'Hasil Penilaian','periode-aktif' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($periode)]); ?>

    <div class="section-header">
        <h1 class="text-h1">Hasil Penilaian Pembiayaan</h1>
        <div class="breadcrumb-meta">
            Skor kelayakan, nilai prioritas, dan status setiap nasabah ·
            Ambang Kelayakan <strong><?php echo e(number_format($theta, 0, ',', '.')); ?></strong> ·
            <?php echo e($topN); ?> nasabah teratas masuk Kuota Prioritas
        </div>
    </div>

    
    <div class="card mb-4">
        <div class="card-body" style="display: flex; align-items: end; gap: 16px; flex-wrap: wrap;">
            <form method="GET" action="<?php echo e(route('hasil.index')); ?>" style="flex: 1; min-width: 280px;">
                <label for="id_periode" class="form-label">Pilih Minggu</label>
                <div style="display: flex; gap: 12px;">
                    <select id="id_periode" name="id_periode" class="form-select" onchange="this.form.submit()">
                        <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p->id_periode); ?>" <?php echo e($periode && $p->id_periode === $periode->id_periode ? 'selected' : ''); ?>>
                                <?php echo e($p->kode_periode); ?>

                                (<?php echo e($p->tanggal_mulai->format('d M')); ?>–<?php echo e($p->tanggal_selesai->format('d M Y')); ?>)
                                <?php if($p->status === 'aktif'): ?> · Sedang Berjalan <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </form>
            <div style="display: flex; gap: 8px;">
                <a href="<?php echo e(route('perhitungan.wp')); ?>" class="btn btn-secondary">
                    <i class="bi bi-calculator"></i> Hitung Ulang
                </a>
                <a href="<?php echo e(route('keputusan.index')); ?>" class="btn btn-primary-strong">
                    <i class="bi bi-check2-square"></i> Tetapkan Keputusan
                </a>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-h2">
                    <?php if($periode): ?>
                        Daftar Penilaian — Minggu <?php echo e($periode->kode_periode); ?>

                    <?php else: ?>
                        Daftar Penilaian
                    <?php endif; ?>
                </h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    <?php echo e($hasil->count()); ?> pengajuan ·
                    <?php echo e($hasil->where('status', 'diterima')->count()); ?> layak ·
                    <?php echo e($hasil->where('status', 'ditolak')->count()); ?> belum layak
                </p>
            </div>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <?php if($hasil->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-calculator','title' => 'Belum ada penilaian','body' => 'Tambahkan pengajuan, lalu jalankan perhitungan kelayakan untuk minggu ini.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-calculator','title' => 'Belum ada penilaian','body' => 'Tambahkan pengajuan, lalu jalankan perhitungan kelayakan untuk minggu ini.']); ?>
                     <?php $__env->slot('action', null, []); ?> 
                        <a href="<?php echo e(route('pengajuan.create')); ?>" class="btn btn-primary-strong">
                            <i class="bi bi-plus-lg"></i> Tambah Pengajuan Baru
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
                    <caption class="visually-hidden">Daftar hasil penilaian seluruh nasabah pada minggu terpilih.</caption>
                    <thead>
                        <tr>
                            <th style="width: 80px;">Urutan</th>
                            <th>Nama Nasabah</th>
                            <th class="col-right">Laba Usaha (Rp)</th>
                            <th class="col-right">Pendapatan (Rp)</th>
                            <th class="col-right">Agunan</th>
                            <th class="col-right">Pembiayaan (Rp)</th>
                            <th class="col-right">Tenor (bln)</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $hasil; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $p = $row->pengajuan;
                                $isTop = $row->ranking <= $topN && $row->status === 'diterima';
                                $badge = match (true) {
                                    $row->status === 'ditolak' => 'ditolak',
                                    $isTop                     => 'diprioritaskan',
                                    default                    => 'diterima_tidak_prio',
                                };
                            ?>
                            <tr>
                                <td><span class="rank-chip"><?php echo e($row->ranking); ?></span></td>
                                <td class="col-nama text-body-strong"><?php echo e($p?->nasabah?->nama_nasabah ?? '—'); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($p?->C1_laba_usaha ?? 0, 0, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($p?->C2_pendapatan_bersih ?? 0, 0, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e($p?->C3_nilai_agunan ?? '—'); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($p?->C4_besar_pembiayaan ?? 0, 0, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e($p?->C5_jangka_waktu ?? '—'); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($row->vektor_S, 2, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($row->vektor_V * 100, 2, ',', '.')); ?>%</td>
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $badge]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badge)]); ?>
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
            <?php endif; ?>
        </div>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/hasil/index.blade.php ENDPATH**/ ?>