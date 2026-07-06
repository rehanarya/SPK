<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Beranda','pageTitle' => 'Beranda','periodeAktif' => $periodeAktif]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Beranda','page-title' => 'Beranda','periode-aktif' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($periodeAktif)]); ?>

    
    <div class="section-header">
        <h1 class="text-h1">Selamat datang, <?php echo e($pengguna->nama); ?></h1>
        <div class="breadcrumb-meta">
            <span class="status-badge <?php echo e($pengguna->peran === 'admin' ? 'status-priority' : 'status-accept'); ?>" style="font-size: 11px;">
                <?php echo e($pengguna->peran === 'admin' ? 'Administrator' : 'Petugas Pembiayaan'); ?>

            </span>
            <span style="margin-left: 8px;">
                <?php if($periodeAktif): ?>
                    Minggu berjalan: <strong><?php echo e($periodeAktif->kode_periode); ?></strong>
                    (<?php echo e($periodeAktif->tanggal_mulai?->format('d M')); ?>–<?php echo e($periodeAktif->tanggal_selesai?->format('d M Y')); ?>)
                <?php else: ?>
                    Belum ada minggu yang dibuka untuk pengajuan.
                <?php endif; ?>
            </span>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <?php if (isset($component)) { $__componentOriginala4ae059936bc185e758290466e2179c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4ae059936bc185e758290466e2179c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Total Pengajuan','icon' => 'bi-file-earmark-text','value' => $stats['total_pengajuan'],'meta' => 'Pengajuan minggu ini']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Pengajuan','icon' => 'bi-file-earmark-text','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_pengajuan']),'meta' => 'Pengajuan minggu ini']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Layak Dibiayai','icon' => 'bi-check-circle','variant' => 'accept','value' => $stats['diterima'],'meta' => $stats['total_pengajuan'] > 0
                    ? round($stats['diterima'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Layak Dibiayai','icon' => 'bi-check-circle','variant' => 'accept','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['diterima']),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_pengajuan'] > 0
                    ? round($stats['diterima'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—')]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Belum Layak','icon' => 'bi-x-circle','variant' => 'reject','value' => $stats['ditolak'],'meta' => $stats['total_pengajuan'] > 0
                    ? round($stats['ditolak'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Belum Layak','icon' => 'bi-x-circle','variant' => 'reject','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['ditolak']),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['total_pengajuan'] > 0
                    ? round($stats['ditolak'] / $stats['total_pengajuan'] * 100, 1) . '% dari total'
                    : '—')]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.kpi-card','data' => ['label' => 'Prioritas Pencairan','icon' => 'bi-bookmark-star','variant' => 'priority','value' => min($stats['diterima'], $stats['top_n']),'meta' => $stats['top_n'] . ' nasabah teratas minggu ini']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('kpi-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Prioritas Pencairan','icon' => 'bi-bookmark-star','variant' => 'priority','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(min($stats['diterima'], $stats['top_n'])),'meta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['top_n'] . ' nasabah teratas minggu ini')]); ?>
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

    
    <div class="card mb-4">
        <div class="card-header">
            <div>
                <h2 class="text-h2">Nasabah Prioritas Minggu Ini</h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    <?php if($periodeAktif): ?>
                        Lima nasabah teratas pada minggu <strong><?php echo e($periodeAktif->kode_periode); ?></strong>
                    <?php else: ?>
                        Lima nasabah teratas pada minggu aktif
                    <?php endif; ?>
                    · Disusun berdasarkan tingkat prioritas tertinggi
                </p>
            </div>
            <a href="<?php echo e(route('hasil.index')); ?>" class="btn btn-ghost btn-sm">
                Lihat semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if($hasilTerkini && $hasilTerkini->isNotEmpty()): ?>
                <table class="table-finansial">
                    <caption class="visually-hidden">Daftar lima nasabah prioritas tertinggi minggu ini.</caption>
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
                        <?php $__currentLoopData = $hasilTerkini; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isTop = $row->ranking <= $stats['top_n'] && $row->status === 'diterima';
                                $badgeStatus = match (true) {
                                    $row->status === 'ditolak' => 'ditolak',
                                    $isTop                      => 'diprioritaskan',
                                    default                     => 'diterima_tidak_prio',
                                };
                            ?>
                            <tr>
                                <td><span class="rank-chip"><?php echo e($row->ranking); ?></span></td>
                                <td class="col-nama text-body-strong">
                                    <?php echo e($row->pengajuan?->nasabah?->nama_nasabah ?? '—'); ?>

                                </td>
                                <td class="col-nominal"><?php echo e(number_format($row->vektor_S, 2, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($row->vektor_V * 100, 2, ',', '.')); ?>%</td>
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $badgeStatus]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($badgeStatus)]); ?>
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
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-inbox','title' => 'Belum ada penilaian pada minggu ini','body' => 'Tambahkan pengajuan pembiayaan untuk melihat daftar nasabah prioritas.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-inbox','title' => 'Belum ada penilaian pada minggu ini','body' => 'Tambahkan pengajuan pembiayaan untuk melihat daftar nasabah prioritas.']); ?>
                     <?php $__env->slot('action', null, []); ?> 
                        <?php if(auth()->user()->peran === 'petugas' || auth()->user()->peran === 'admin'): ?>
                            <a href="<?php echo e(route('pengajuan.create')); ?>" class="btn btn-primary-strong">
                                <i class="bi bi-plus-lg"></i> Tambah Pengajuan Baru
                            </a>
                        <?php endif; ?>
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
            <?php endif; ?>
        </div>
    </div>

    
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-h3">Aksi Cepat</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <a href="<?php echo e(route('pengajuan.create')); ?>" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-plus-circle me-2"></i> Pengajuan Baru
                                    </div>
                                    <div class="quick-action-meta">Catat pengajuan pembiayaan dari nasabah</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="<?php echo e(route('perhitungan.wp')); ?>" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-calculator me-2"></i> Hitung Kelayakan
                                    </div>
                                    <div class="quick-action-meta">Proses penilaian minggu ini</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="<?php echo e(route('hasil.index')); ?>" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-bar-chart me-2"></i> Hasil &amp; Urutan
                                    </div>
                                    <div class="quick-action-meta">Lihat skor dan ranking nasabah</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                        <div class="col-12 col-md-6">
                            <a href="<?php echo e(route('keputusan.index')); ?>" class="quick-action">
                                <div>
                                    <div class="quick-action-label">
                                        <i class="bi bi-check2-square me-2"></i> Tetapkan Keputusan
                                    </div>
                                    <div class="quick-action-meta">Putuskan pengajuan diterima atau tidak</div>
                                </div>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-h3">Ringkasan Sistem</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div class="text-label">Ambang Kelayakan</div>
                            <div class="text-h2" style="margin-top: 4px;"><?php echo e(number_format($stats['theta'], 0, ',', '.')); ?></div>
                            <div class="text-meta">Skor minimum agar pengajuan dapat diterima</div>
                        </div>
                        <hr style="margin: 4px 0; border-color: var(--color-border);">
                        <div>
                            <div class="text-label">Kuota Prioritas Minggu Ini</div>
                            <div class="text-h2" style="margin-top: 4px;"><?php echo e($stats['top_n']); ?></div>
                            <div class="text-meta">Jumlah nasabah teratas yang diprioritaskan untuk pencairan</div>
                        </div>
                        <hr style="margin: 4px 0; border-color: var(--color-border);">
                        <div>
                            <div class="text-label">Total Nasabah</div>
                            <div class="text-h2" style="margin-top: 4px;"><?php echo e($stats['total_nasabah']); ?></div>
                            <div class="text-meta">Anggota terdaftar di koperasi</div>
                        </div>
                    </div>
                </div>
            </div>
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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/dashboard.blade.php ENDPATH**/ ?>