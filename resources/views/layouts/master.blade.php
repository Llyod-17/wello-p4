<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wello - Fresh Groceries</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

  {{-- Navigation --}}
  <nav class="nav">
    <div class="nav-inner">
      <a href="/" class="nav-logo">
        <img src="{{ asset('wello-logo.png') }}" alt="Wello">
      </a>
      <div class="nav-links">
        <a href="/">Katalog</a>
      </div>
    </div>
  </nav>

  {{-- Main Content --}}
  <main class="container py-lg">
    @yield('konten_utama')
  </main>

  {{-- Footer --}}
  <footer class="footer">
    <p>&copy; 2026 Wello - Fresh Groceries. All rights reserved.</p>
  </footer>

</body>
</html>