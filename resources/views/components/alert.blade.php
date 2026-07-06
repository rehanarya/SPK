@props([
    'type' => 'info',
    'autoDismiss' => null,
    'dismissible' => true,
])

@php
    $icons = [
        'success' => 'bi-check-circle',
        'danger'  => 'bi-exclamation-triangle',
        'warning' => 'bi-exclamation-circle',
        'info'    => 'bi-info-circle',
    ];
    $iconClass = $icons[$type] ?? 'bi-info-circle';
    $auto = in_array($type, ['success', 'info']) ? ($autoDismiss ?? 5000) : null;
@endphp

<div
    class="alert alert-{{ $type }}"
    role="alert"
    @if ($auto) data-auto-dismiss="{{ $auto }}" @endif
>
    <i class="alert-icon bi {{ $iconClass }}"></i>
    <div class="alert-body">{{ $slot }}</div>
    @if ($dismissible)
        <button type="button" class="alert-close" aria-label="Tutup">
            <i class="bi bi-x-lg"></i>
        </button>
    @endif
</div>
