<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'value' => 0,
    'meta'  => null,
    'icon'  => null,
    'variant' => 'default',
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
    'label' => '',
    'value' => 0,
    'meta'  => null,
    'icon'  => null,
    'variant' => 'default',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $variantClass = match ($variant) {
        'accept'   => 'kpi-accept',
        'reject'   => 'kpi-reject',
        'priority' => 'kpi-priority',
        'pending'  => 'kpi-pending',
        default    => '',
    };
?>

<div class="kpi-card <?php echo e($variantClass); ?>">
    <div class="kpi-card-label">
        <span><?php echo e($label); ?></span>
        <?php if($icon): ?>
            <i class="bi <?php echo e($icon); ?>"></i>
        <?php endif; ?>
    </div>
    <div class="kpi-card-value"><?php echo e($value); ?></div>
    <?php if($meta): ?>
        <div class="kpi-card-meta"><?php echo e($meta); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/kpi-card.blade.php ENDPATH**/ ?>