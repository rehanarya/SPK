@props([
    'label' => '',
    'value' => 0,
    'meta'  => null,
    'icon'  => null,
    'variant' => 'default',
])

@php
    $variantClass = match ($variant) {
        'accept'   => 'kpi-accept',
        'reject'   => 'kpi-reject',
        'priority' => 'kpi-priority',
        'pending'  => 'kpi-pending',
        default    => '',
    };
@endphp

<div class="kpi-card {{ $variantClass }}">
    <div class="kpi-card-label">
        <span>{{ $label }}</span>
        @if ($icon)
            <i class="bi {{ $icon }}"></i>
        @endif
    </div>
    <div class="kpi-card-value">{{ $value }}</div>
    @if ($meta)
        <div class="kpi-card-meta">{{ $meta }}</div>
    @endif
</div>
