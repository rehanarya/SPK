@props([
    'title' => '',
    'breadcrumb' => null,
])

<div class="section-header">
    <h1 class="text-h1">{{ $title }}</h1>
    @if ($breadcrumb)
        <div class="breadcrumb-meta">{{ $breadcrumb }}</div>
    @endif
    @if (isset($description))
        <p class="text-meta" style="margin-top: 4px;">{{ $description }}</p>
    @endif
</div>
