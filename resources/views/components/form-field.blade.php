@props([
    'name' => '',
    'label' => '',
    'helper' => null,
    'required' => false,
    'errors' => null,
    'badge' => null,
])

@php
    $hasError = $errors && $errors->has($name);
@endphp

<div class="form-group" style="margin-bottom: 16px;">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            @if ($badge === 'benefit')
                <x-criteria-badge type="benefit" />
            @elseif ($badge === 'cost')
                <x-criteria-badge type="cost" />
            @endif
            {{ $label }}
            @if ($required) <span class="form-required">*</span> @endif
        </label>
    @endif

    {{ $slot }}

    @if ($hasError)
        <div class="form-error">
            <i class="bi bi-exclamation-triangle"></i>
            <span>{{ $errors->first($name) }}</span>
        </div>
    @elseif ($helper)
        <div class="form-helper">{{ $helper }}</div>
    @endif
</div>
