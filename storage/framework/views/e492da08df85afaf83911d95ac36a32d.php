<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => '',
    'label' => '',
    'helper' => null,
    'required' => false,
    'errors' => null,
    'badge' => null,
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
    'name' => '',
    'label' => '',
    'helper' => null,
    'required' => false,
    'errors' => null,
    'badge' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $hasError = $errors && $errors->has($name);
?>

<div class="form-group" style="margin-bottom: 16px;">
    <?php if($label): ?>
        <label for="<?php echo e($name); ?>" class="form-label">
            <?php if($badge === 'benefit'): ?>
                <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => 'benefit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'benefit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
            <?php elseif($badge === 'cost'): ?>
                <?php if (isset($component)) { $__componentOriginal6c65a205b141c5041f4b50f4caab2f41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.criteria-badge','data' => ['type' => 'cost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('criteria-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'cost']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $attributes = $__attributesOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__attributesOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41)): ?>
<?php $component = $__componentOriginal6c65a205b141c5041f4b50f4caab2f41; ?>
<?php unset($__componentOriginal6c65a205b141c5041f4b50f4caab2f41); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php echo e($label); ?>

            <?php if($required): ?> <span class="form-required">*</span> <?php endif; ?>
        </label>
    <?php endif; ?>

    <?php echo e($slot); ?>


    <?php if($hasError): ?>
        <div class="form-error">
            <i class="bi bi-exclamation-triangle"></i>
            <span><?php echo e($errors->first($name)); ?></span>
        </div>
    <?php elseif($helper): ?>
        <div class="form-helper"><?php echo e($helper); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/form-field.blade.php ENDPATH**/ ?>