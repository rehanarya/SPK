@props(['title' => 'Login'])

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
    <main class="auth-shell">
        @if (session('success'))
            <div style="width: 100%; max-width: 400px; margin-bottom: 16px;">
                <x-alert type="success">{{ session('success') }}</x-alert>
            </div>
        @endif

        @if ($errors->has('username') || $errors->has('password'))
            @if ($errors->count() === 1 && ($errors->has('username') || $errors->has('password')))
                {{-- Errors akan ditampilkan inline pada form, tidak perlu global alert --}}
            @endif
        @endif

        {{ $slot }}

        <div class="auth-footer">
            &copy; {{ date('Y') }} KSPPS Berkah Sakinah Almughni Girimarto
        </div>
    </main>
</body>
</html>
