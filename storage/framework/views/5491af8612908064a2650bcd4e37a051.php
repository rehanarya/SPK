<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon'  => 'bi-inbox',
    'title' => 'Belum ada data',
    'body'  => null,
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
    'icon'  => 'bi-inbox',
    'title' => 'Belum ada data',
    'body'  => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="empty-state">
    <i class="bi <?php echo e($icon); ?> empty-state-icon"></i>
    <div class="empty-state-title"><?php echo e($title); ?></div>
    <?php if($body): ?>
        <p class="empty-state-body"><?php echo e($body); ?></p>
    <?php endif; ?>
    <?php if(isset($action)): ?>
        <div class="empty-state-action"><?php echo e($action); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/empty-state.blade.php ENDPATH**/ ?>