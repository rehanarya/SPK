@props(['type' => 'benefit'])

@php
    $class = $type === 'cost' ? 'badge-criteria-cost' : 'badge-criteria-benefit';
    $label = $type === 'cost' ? 'C' : 'B';
    $aria  = $type === 'cost' ? 'Cost (lebih kecil lebih baik)' : 'Benefit (lebih besar lebih baik)';
@endphp

<span class="badge-criteria {{ $class }}" aria-label="{{ $aria }}" title="{{ $aria }}">{{ $label }}</span>
