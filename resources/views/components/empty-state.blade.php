@props([
    'icon'  => 'bi-inbox',
    'title' => 'Belum ada data',
    'body'  => null,
])

<div class="empty-state">
    <i class="bi {{ $icon }} empty-state-icon"></i>
    <div class="empty-state-title">{{ $title }}</div>
    @if ($body)
        <p class="empty-state-body">{{ $body }}</p>
    @endif
    @if (isset($action))
        <div class="empty-state-action">{{ $action }}</div>
    @endif
</div>
