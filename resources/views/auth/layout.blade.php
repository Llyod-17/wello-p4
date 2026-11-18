<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Akun Wello')</title>
    <link rel="icon" href="{{ asset('wello-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-page">
    <main class="auth-shell">
        <div class="auth-logo">
            <a href="/" title="Kembali ke Beranda">
                <img src="{{ asset('wello-logo.png') }}" alt="Wello">
            </a>
        </div>

        <section class="auth-panel">
            @yield('auth-content')
        </section>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
