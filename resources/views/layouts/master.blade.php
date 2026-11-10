<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('judul', 'Wello - Fresh Groceries')</title>

  <link rel="icon" href="{{ asset('wello-logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  {{-- Sticky footer: footer selalu di bawah walau konten pendek --}}
  <style>
    body { min-height: 100vh; display: flex; flex-direction: column; margin: 0; }
    main { flex: 1; }
  </style>

  @stack('styles')
</head>
<body>

  {{-- Navigation --}}
  <nav class="nav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <img src="{{ asset('wello-logo.png') }}" alt="Wello">
      </a>

      {{-- Global Search Bar (P11) --}}
      <div class="nav-search-container">
        <form action="/" method="GET" class="nav-search-form">
          @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
          @endif
          <div class="search-input-group">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari buah, sayur, atau sembako segar..." 
                   class="nav-search-input" autocomplete="off" data-live-search>
            <button type="submit" class="nav-search-btn" aria-label="Cari">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
          </div>
        </form>
      </div>

      <div class="nav-links">
        <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Katalog</a>
        <a href="/admin/transactions" class="admin-link">Panel Admin</a>
      </div>
    </div>
  </nav>

  {{-- Main Content --}}
  <main class="container py-lg">
    @yield('konten_utama')
  </main>

  {{-- Footer --}}
  <footer class="footer">
    <p>&copy; {{ date('Y') }} Wello - Fresh Groceries. All rights reserved.</p>
  </footer>

  @stack('scripts')
</body>
</html>
