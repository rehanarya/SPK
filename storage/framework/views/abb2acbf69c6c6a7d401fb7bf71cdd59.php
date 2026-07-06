<?php if (isset($component)) { $__componentOriginal4619374cef299e94fd7263111d0abc69 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4619374cef299e94fd7263111d0abc69 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-layout','data' => ['title' => 'Penetapan Keputusan','pageTitle' => 'Penetapan Keputusan','periodeAktif' => $periodeAktif]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Penetapan Keputusan','page-title' => 'Penetapan Keputusan','periode-aktif' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($periodeAktif)]); ?>

    <div class="section-header">
        <h1 class="text-h1">Penetapan Keputusan Akhir</h1>
        <div class="breadcrumb-meta">
            <?php if($periodeAktif): ?>
                Minggu berjalan: <strong><?php echo e($periodeAktif->kode_periode); ?></strong> ·
            <?php endif; ?>
            Petugas menetapkan keputusan pembiayaan berdasarkan hasil penilaian
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-h2">Daftar Penilaian Menunggu Keputusan</h2>
                <p class="text-meta" style="margin: 4px 0 0 0;">
                    <?php echo e($topN); ?> nasabah teratas masuk Kuota Prioritas Minggu Ini
                </p>
            </div>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            <?php if($hasilList->isEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bi-check2-square','title' => 'Belum ada penilaian untuk diputuskan','body' => 'Jalankan perhitungan kelayakan minggu ini terlebih dahulu.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bi-check2-square','title' => 'Belum ada penilaian untuk diputuskan','body' => 'Jalankan perhitungan kelayakan minggu ini terlebih dahulu.']); ?>
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
                            <th style="width: 60px;">Rank</th>
                            <th>Nasabah</th>
                            <th class="col-right">Skor Kelayakan</th>
                            <th class="col-right">Nilai Prioritas</th>
                            <th>Rekomendasi Sistem</th>
                            <th>Keputusan Akhir</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $hasilList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isTop      = $h->ranking <= $topN && $h->status === 'diterima';
                                $saran      = $isTop ? 'diprioritaskan' : $h->status;
                                $keputusan  = $h->logKeputusan->sortByDesc('timestamp')->first();
                            ?>
                            <tr>
                                <td><span class="rank-chip"><?php echo e($h->ranking); ?></span></td>
                                <td class="col-nama text-body-strong"><?php echo e($h->pengajuan?->nasabah?->nama_nasabah ?? '—'); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($h->vektor_S, 4, ',', '.')); ?></td>
                                <td class="col-nominal"><?php echo e(number_format($h->vektor_V * 100, 2, ',', '.')); ?>%</td>
                                <td><?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $saran]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($saran)]); ?>
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
                                    <?php if($keputusan): ?>
                                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $keputusan->keputusan_akhir]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($keputusan->keputusan_akhir)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="col-actions">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#modal-keputusan-<?php echo e($h->id_hasil); ?>">
                                        <i class="bi bi-check2"></i> Tetapkan
                                    </button>
                                    <?php if($h->pengajuan): ?>
                                        <a href="<?php echo e(route('pengajuan.edit', $h->pengajuan)); ?>" class="btn btn-secondary btn-sm"
                                           title="Edit pengajuan lengkap + realisasi & tanda tangan Manager (semua status)">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php if($h->pengajuan): ?>
                                        <a href="<?php echo e(route('pengajuan.cetak', $h->pengajuan)); ?>" class="btn btn-secondary btn-sm"
                                           target="_blank" title="Lihat / cetak formulir Analisis Pembiayaan">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    
    <?php $__currentLoopData = $hasilList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modal-keputusan-<?php echo e($h->id_hasil); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 480px;">
                <div class="modal-content" style="border-radius: 8px; border: 1px solid var(--color-border); box-shadow: var(--elev-2);">
                    <form method="POST" action="<?php echo e(route('keputusan.store', $h)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header" style="border-bottom: 1px solid var(--color-border); padding: 16px 20px;">
                            <h5 class="text-h3" style="margin: 0;">Tetapkan Keputusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 20px;">
                            <div class="text-body" style="margin-bottom: 16px;">
                                Nasabah: <strong><?php echo e($h->pengajuan?->nasabah?->nama_nasabah ?? '—'); ?></strong>
                                <br>
                                Skor Kelayakan: <span class="font-numeric"><?php echo e(number_format($h->vektor_S, 2, ',', '.')); ?></span> ·
                                Urutan: <span class="font-numeric"><?php echo e($h->ranking); ?></span>
                            </div>

                            <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'keputusan_akhir','label' => 'Keputusan Akhir','required' => true,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'keputusan_akhir','label' => 'Keputusan Akhir','required' => true,'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                                <select name="keputusan_akhir" class="form-select" required>
                                    <option value="">— Pilih keputusan —</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="diprioritaskan">Diprioritaskan</option>
                                    <option value="ditolak">Ditolak</option>
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

                            <?php if (isset($component)) { $__componentOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4c8ecf26ef77d4de25edf56eae3a34d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-field','data' => ['name' => 'catatan','label' => 'Catatan (opsional)','errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'catatan','label' => 'Catatan (opsional)','errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
                                <textarea name="catatan" rows="3" class="form-control"></textarea>
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
                        <div class="modal-footer" style="border-top: 1px solid var(--color-border); padding: 12px 20px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Keputusan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/keputusan/index.blade.php ENDPATH**/ ?>