<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info',
    'autoDismiss' => null,
    'dismissible' => true,
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
    'type' => 'info',
    'autoDismiss' => null,
    'dismissible' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $icons = [
        'success' => 'bi-check-circle',
        'danger'  => 'bi-exclamation-triangle',
        'warning' => 'bi-exclamation-circle',
        'info'    => 'bi-info-circle',
    ];
    $iconClass = $icons[$type] ?? 'bi-info-circle';
    $auto = in_array($type, ['success', 'info']) ? ($autoDismiss ?? 5000) : null;
?>

<div
    class="alert alert-<?php echo e($type); ?>"
    role="alert"
    <?php if($auto): ?> data-auto-dismiss="<?php echo e($auto); ?>" <?php endif; ?>
>
    <i class="alert-icon bi <?php echo e($iconClass); ?>"></i>
    <div class="alert-body"><?php echo e($slot); ?></div>
    <?php if($dismissible): ?>
        <button type="button" class="alert-close" aria-label="Tutup">
            <i class="bi bi-x-lg"></i>
        </button>
    <?php endif; ?>
</div>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/alert.blade.php ENDPATH**/ ?>