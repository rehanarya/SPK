<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status' => 'pending']));

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

foreach (array_filter((['status' => 'pending']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $map = [
        'diprioritaskan'         => ['class' => 'status-priority', 'label' => 'Diprioritaskan'],
        'diterima'               => ['class' => 'status-accept',   'label' => 'Diterima'],
        'diterima_tidak_prio'    => ['class' => 'status-accept-secondary', 'label' => 'Diterima'],
        'ditolak'                => ['class' => 'status-reject',   'label' => 'Ditolak'],
        'menunggu'               => ['class' => 'status-pending',  'label' => 'Menunggu'],
        'aktif'                  => ['class' => 'status-accept',   'label' => 'Aktif'],
        'tutup'                  => ['class' => 'status-reject',   'label' => 'Tutup'],
    ];
    $entry = $map[$status] ?? ['class' => 'status-pending', 'label' => ucfirst($status)];
?>

<span class="status-badge <?php echo e($entry['class']); ?>"><?php echo e($entry['label']); ?></span>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/status-badge.blade.php ENDPATH**/ ?>