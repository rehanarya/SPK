@props([
    'title' => 'Dasbor',
    'pageTitle' => null,
    'periodeAktif' => null,
])

@php
    $pageTitle ??= $title;
    if (! $periodeAktif) {
        $periodeAktif = \App\Models\Periode::where('status', 'aktif')->first();
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · {{ config('app.name') }}</title>

    {{-- Favicon resmi KSPPS Berkah Sakinah Almughni --}}
    <link rel="shortcut icon" href="{{ asset('images/logo-kspps.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/logo-kspps.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- ── Struktur: sidebar fixed + content offset ── --}}
    <div class="d-flex w-100 m-0 p-0">
        <x-sidebar />

        <div class="flex-grow-1 min-vh-100 d-flex flex-column app-content">
            <x-topbar :title="$pageTitle" :periode-aktif="$periodeAktif" />

            <main class="app-main flex-grow-1">
                @if (session('success'))
                    <x-alert type="success">{{ session('success') }}</x-alert>
                @endif
                @if (session('error'))
                    <x-alert type="danger">{{ session('error') }}</x-alert>
                @endif
                @if (session('warning'))
                    <x-alert type="warning">{{ session('warning') }}</x-alert>
                @endif
                @if (session('info'))
                    <x-alert type="info">{{ session('info') }}</x-alert>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Backdrop sidebar mobile — di luar flex container agar tidak mengganggu grid --}}
    <div class="sidebar-backdrop"></div>
</body>
</html>
