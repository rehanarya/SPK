<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => '',
    'periodeAktif' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => '',
    'periodeAktif' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $user = auth()->user();
    $initials = $user ? collect(explode(' ', $user->nama))->take(2)->map(fn ($p) => mb_substr($p, 0, 1))->implode('') : 'NN';
?>

<header class="app-topbar">
    <button class="app-topbar-burger" type="button" data-sidebar-toggle aria-label="Buka navigasi">
        <i class="bi bi-list"></i>
    </button>

    <h2 class="app-topbar-title"><?php echo e($title); ?></h2>

    <div style="flex: 1;"></div>

    <?php if($periodeAktif): ?>
        <div class="app-topbar-periode" title="Periode aktif sistem">
            <span class="dot <?php echo e($periodeAktif->status === 'aktif' ? 'aktif' : ''); ?>"></span>
            <i class="bi bi-calendar3"></i>
            <span>
                <?php echo e($periodeAktif->kode_periode); ?>

                <span class="text-muted-strong">
                    (<?php echo e($periodeAktif->tanggal_mulai?->format('d M')); ?>–<?php echo e($periodeAktif->tanggal_selesai?->format('d M Y')); ?>)
                </span>
            </span>
        </div>
    <?php else: ?>
        <div class="app-topbar-periode" style="color: var(--color-text-muted);">
            <span class="dot"></span>
            <i class="bi bi-calendar3"></i>
            <span>Tidak ada periode aktif</span>
        </div>
    <?php endif; ?>

    <div class="dropdown">
        <button class="app-topbar-avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu pengguna">
            <?php echo e(strtoupper($initials)); ?>

        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 220px;">
            <li class="dropdown-item-text" style="padding: 12px 16px;">
                <div class="text-body-strong"><?php echo e($user->nama); ?></div>
                <div class="text-meta">
                    <span class="status-badge <?php echo e($user->peran === 'admin' ? 'status-priority' : 'status-accept'); ?>" style="font-size: 11px;">
                        <?php echo e($user->peran === 'admin' ? 'Administrator' : 'Petugas Pembiayaan'); ?>

                    </span>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="<?php echo e(route('profil.show')); ?>">
                    <i class="bi bi-person me-2"></i> Profil Saya
                </a>
            </li>
            <li>
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/topbar.blade.php ENDPATH**/ ?>