<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'benefit']));

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

foreach (array_filter((['type' => 'benefit']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $class = $type === 'cost' ? 'badge-criteria-cost' : 'badge-criteria-benefit';
    $label = $type === 'cost' ? 'C' : 'B';
    $aria  = $type === 'cost' ? 'Cost (lebih kecil lebih baik)' : 'Benefit (lebih besar lebih baik)';
?>

<span class="badge-criteria <?php echo e($class); ?>" aria-label="<?php echo e($aria); ?>" title="<?php echo e($aria); ?>"><?php echo e($label); ?></span>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/criteria-badge.blade.php ENDPATH**/ ?>