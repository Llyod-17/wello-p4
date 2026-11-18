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
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
        @auth
          <div class="nav-user-dropdown" x-data="{ open: false }" @click.away="open = false">
            <div class="nav-user-chip" @click="open = !open" style="cursor: pointer;">
              <span class="user-avatar-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
              <span class="user-display-name">{{ Auth::user()->name }}</span>
            </div>
            <div x-show="open" x-cloak class="dropdown-menu">
              @can('access-admin')
                <a href="/admin/transactions" class="dropdown-item">Panel Admin</a>
              @endcan
              <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                @csrf
                <button type="submit" class="dropdown-item">Keluar</button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="nav-btn-login">Masuk</a>
        @endauth
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
