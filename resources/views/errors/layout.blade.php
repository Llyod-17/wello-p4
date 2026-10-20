<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, follow">
  <title>{{ $title ?? 'Error' }} &middot; {{ config('app.name', 'Wello') }}</title>

  <link rel="icon" href="{{ asset('wello-logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/error.css') }}">
  @if($character === 'broccoli')
    <link rel="stylesheet" href="{{ asset('css/404.css') }}">
  @elseif($character === 'apple')
    <link rel="stylesheet" href="{{ asset('css/5xx.css') }}">
  @endif
</head>
<body class="error-body">

<a class="error-skip" href="#error-actions">Langsung ke tombol aksi</a>

<main class="error" data-error="{{ $character }}">

  {{-- SVG Sprite Library --}}
  <svg class="error-sprite" aria-hidden="true" focusable="false" width="0" height="0">
    <defs>
      <symbol id="vg-carrot" viewBox="0 0 40 40">
        <path d="M20 12 L31 34 Q20 40 9 34 Z" fill="#FB8C00"/>
        <path d="M15 22 h10 M13.5 27 h9" stroke="#E68900" stroke-width="2.4" stroke-linecap="round" fill="none"/>
        <path d="M20 13 q-7 -9 -13 -7 q5 5 7 10 q2 -6 6 -3z" fill="#7CB342"/>
        <path d="M20 13 q7 -9 13 -7 q-5 5 -7 10 q-2 -6 -6 -3z" fill="#9DD761"/>
      </symbol>
      <symbol id="vg-leaf" viewBox="0 0 40 40">
        <path d="M6 34 C6 16 20 6 35 6 C35 22 24 35 8 34 Z" fill="#9DD761"/>
        <path d="M8 33 C16 26 24 18 33 8" stroke="#3C6A00" stroke-width="2.6" fill="none" stroke-linecap="round"/>
      </symbol>
      <symbol id="vg-broc" viewBox="0 0 40 40">
        <path d="M15 22 h10 l-2 14 h-6 z" fill="#9DD761"/>
        <circle cx="13" cy="18" r="8" fill="#3C6A00"/>
        <circle cx="27" cy="18" r="8" fill="#3C6A00"/>
        <circle cx="20" cy="12" r="9.5" fill="#7CB342"/>
        <circle cx="16.5" cy="10" r="4.5" fill="#9DD761"/>
      </symbol>
      <symbol id="vg-bean" viewBox="0 0 40 40">
        <path d="M8 12 q14 -6 26 6 q-6 14 -20 10 q-10 -4 -6 -16z" fill="#7CB342"/>
        <path d="M12 22 q10 2 18 -2" stroke="#3C6A00" stroke-width="2.4" fill="none" stroke-linecap="round"/>
      </symbol>
      <symbol id="vg-pepper" viewBox="0 0 40 40">
        <path d="M20 9 c8 0 13 7 13 15 c0 7 -5 11 -13 11 c-8 0 -13 -4 -13 -11 c0 -8 5 -15 13 -15z" fill="#E68900"/>
        <path d="M20 9 V5" stroke="#3C6A00" stroke-width="3" stroke-linecap="round"/>
        <path d="M13 19 q5 -4 8 0" stroke="#FB8C00" stroke-width="2.6" fill="none" stroke-linecap="round"/>
      </symbol>
      <symbol id="vg-tomato" viewBox="0 0 40 40">
        <circle cx="20" cy="23" r="14" fill="#C8562F"/>
        <circle cx="15.5" cy="18.5" r="4.5" fill="#DE7A52" opacity=".7"/>
        <path d="M20 11 l8 -5 -2 7 -6 4z" fill="#3C6A00"/>
      </symbol>
    </defs>
  </svg>

  {{-- Brand --}}
  <a class="error-brand" href="/" aria-label="Wello, kembali ke beranda">
    <img src="{{ asset('wello-logo.png') }}" alt="Wello" width="132" height="40">
  </a>

  {{-- Ambient Floating Vegetables --}}
  <div class="error-decor" aria-hidden="true">
    <div class="veg" data-depth="0.30" style="--x:7%;  --y:17%; --size:54px; --dur:8.5s;  --delay:-1.2s; --spin:14deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-carrot"/></svg></div>
    </div>
    <div class="veg" data-depth="0.62" style="--x:87%; --y:13%; --size:40px; --dur:7s;    --delay:-3.4s; --spin:-10deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-leaf"/></svg></div>
    </div>
    <div class="veg" data-depth="0.90" style="--x:11%; --y:66%; --size:46px; --dur:9.2s;  --delay:-5.1s; --spin:18deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-broc"/></svg></div>
    </div>
    <div class="veg" data-depth="0.22" style="--x:92%; --y:60%; --size:34px; --dur:6.4s;  --delay:-2.6s; --spin:-16deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-tomato"/></svg></div>
    </div>
    <div class="veg" data-depth="0.48" style="--x:20%; --y:88%; --size:32px; --dur:10s;   --delay:-7.3s; --spin:22deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-bean"/></svg></div>
    </div>
    <div class="veg" data-depth="0.74" style="--x:80%; --y:86%; --size:44px; --dur:7.8s;  --delay:-4.4s; --spin:-20deg">
      <div class="veg__float"><svg viewBox="0 0 40 40"><use href="#vg-pepper"/></svg></div>
    </div>
  </div>

  {{-- Character Scene --}}
  <div class="error-scene">
    <span class="error-halo" aria-hidden="true"></span>
    
    {{-- Big Error Code (Behind) --}}
    @if($character === 'broccoli')
      <span class="e404-digits" aria-hidden="true">
        <span class="e404-digits__text" data-404-digits contenteditable="true" spellcheck="false" inputmode="numeric" role="textbox" aria-label="Nomor halaman, klik lalu ketik untuk mengubah">{{ $code ?? '404' }}</span>
        <span class="e404-digits__hint" data-404-hint aria-hidden="true">klik untuk ubah</span>
      </span>
    @elseif($character === 'apple')
      <span class="error-digits-5xx" aria-hidden="true">{{ $code ?? '500' }}</span>
    @endif
    
    {{-- Character (Front) --}}
    <div class="error-actor" data-character="{{ $character }}">
      @yield('character')
    </div>
  </div>

  {{-- Copy --}}
  <span class="error-badge">{{ $badge }}</span>
  <h1 class="error-title">{{ $title }}</h1>
  <p class="error-text">{{ $message }}</p>

  {{-- Actions --}}
  <div class="error-actions" id="error-actions">
    @yield('actions')
  </div>

  <p class="error-hint">
    <svg viewBox="0 0 40 40" aria-hidden="true" width="20" height="20"><use href="#vg-leaf"/></svg>
    {{ $hint ?? 'Klik di mana saja untuk menyemai benih' }}
  </p>

  <p class="error-foot">&copy; {{ date('Y') }} Wello &mdash; Fresh Groceries</p>

  <div class="error-particles" data-error-particles aria-hidden="true"></div>
</main>

<script src="{{ asset('js/error.js') }}" defer></script>
@if($character === 'broccoli')
  <script src="{{ asset('js/404.js') }}" defer></script>
@elseif($character === 'apple')
  <script src="{{ asset('js/5xx.js') }}" defer></script>
@endif
</body>
</html>
