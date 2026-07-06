<?php
    $user = auth()->user();
    $isAdmin = $user && $user->peran === 'admin';
    $isPetugas = $user && $user->peran === 'petugas';

    $activeRoute = request()->route()?->getName() ?? '';
    $is = fn (string|array $patterns) =>
        collect((array) $patterns)->contains(fn ($p) => str_starts_with($activeRoute, $p)) ? 'active' : '';
?>

<aside class="app-sidebar">
    <a href="<?php echo e(route('dashboard')); ?>" class="app-sidebar-brand" style="text-decoration: none;">
        
        <img
            src="<?php echo e(asset('images/logo-kspps.png')); ?>"
            alt="Logo KSPPS"
            class="app-sidebar-brand-logo"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"
        >
        <span class="app-sidebar-brand-mark" style="display: none;" aria-hidden="true">SK</span>

        <span class="app-sidebar-brand-text">SPK KSPPS</span>
    </a>

    <nav>
        <div class="app-sidebar-group">
            <div class="app-sidebar-group-label">Beranda</div>
            <a href="<?php echo e(route('dashboard')); ?>" class="app-sidebar-item <?php echo e($is('dashboard')); ?>">
                <i class="bi bi-grid-1x2"></i>
                <span>Beranda</span>
            </a>
        </div>

        <?php if($isPetugas || $isAdmin): ?>
            <div class="app-sidebar-group">
                <div class="app-sidebar-group-label">Pembiayaan</div>
                <a href="<?php echo e(route('nasabah.index')); ?>" class="app-sidebar-item <?php echo e($is('nasabah')); ?>">
                    <i class="bi bi-people"></i>
                    <span>Data Nasabah</span>
                </a>
                <a href="<?php echo e(route('pengajuan.index')); ?>" class="app-sidebar-item <?php echo e($is('pengajuan')); ?>">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Pengajuan</span>
                </a>
                <a href="<?php echo e(route('perhitungan.wp')); ?>" class="app-sidebar-item <?php echo e($is('perhitungan')); ?>">
                    <i class="bi bi-calculator"></i>
                    <span>Hitung Kelayakan</span>
                </a>
                <a href="<?php echo e(route('hasil.index')); ?>" class="app-sidebar-item <?php echo e($is('hasil')); ?>">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Hasil Penilaian</span>
                </a>
                <a href="<?php echo e(route('keputusan.index')); ?>" class="app-sidebar-item <?php echo e($is('keputusan')); ?>">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Penetapan Keputusan</span>
                </a>
            </div>
        <?php endif; ?>

        <?php if($isAdmin): ?>
            <div class="app-sidebar-group">
                <div class="app-sidebar-group-label">Administrasi</div>
                <a href="<?php echo e(route('admin.pengguna.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.pengguna')); ?>">
                    <i class="bi bi-person-gear"></i>
                    <span>Pengguna Sistem</span>
                </a>
                <a href="<?php echo e(route('admin.kriteria.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.kriteria')); ?>">
                    <i class="bi bi-sliders"></i>
                    <span>Faktor Penilaian</span>
                </a>
                <a href="<?php echo e(route('admin.periode.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.periode')); ?>">
                    <i class="bi bi-calendar-week"></i>
                    <span>Minggu Pengajuan</span>
                </a>
                <a href="<?php echo e(route('admin.threshold.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.threshold')); ?>">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Kalibrasi Ambang</span>
                </a>
                <a href="<?php echo e(route('admin.sensitivitas.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.sensitivitas')); ?>">
                    <i class="bi bi-diagram-3"></i>
                    <span>Uji Kestabilan</span>
                </a>
                <a href="<?php echo e(route('admin.loocv.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.loocv')); ?>">
                    <i class="bi bi-bullseye"></i>
                    <span>Uji Akurasi Sistem</span>
                </a>
                <a href="<?php echo e(route('admin.audit.index')); ?>" class="app-sidebar-item <?php echo e($is('admin.audit')); ?>">
                    <i class="bi bi-clock-history"></i>
                    <span>Catatan Aktivitas</span>
                </a>
            </div>
        <?php endif; ?>
    </nav>
</aside>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/sidebar.blade.php ENDPATH**/ ?>