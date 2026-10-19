<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, follow">
  <title>404 &middot; Halaman Tidak Ditemukan &mdash; Wello</title>

  <link rel="icon" href="{{ asset('wello-logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/404.css') }}">
</head>
<body class="e404-body">

<a class="e404-skip" href="#e404-actions">Langsung ke tombol kembali ke beranda</a>

<main class="e404" data-404>

  {{-- Pustaka simbol vegetables, dipakai juga oleh partikel di 404.js --}}
  <svg class="e404-sprite" aria-hidden="true" focusable="false" width="0" height="0">
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
  <a class="e404-brand" href="/" aria-label="Wello, kembali ke beranda">
    <img src="{{ asset('wello-logo.png') }}" alt="Wello" width="132" height="40">
  </a>

  {{-- Sayuran ambient (parallax + idle float) --}}
  <div class="e404-decor" aria-hidden="true">
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

  {{-- Scene: angka 404 besar + karakter --}}
  <div class="e404-scene">

    <span class="e404-halo" aria-hidden="true"></span>

    <div class="e404-digits">
      <span class="e404-digits__text"
            data-404-digits
            contenteditable="true"
            spellcheck="false"
            inputmode="numeric"
            role="textbox"
            aria-label="Nomor halaman, klik lalu ketik untuk mengubah">404</span>
      <span class="e404-digits__hint" data-404-hint aria-hidden="true">klik untuk ubah</span>
    </div>

    <div class="e404-actor" data-depth="0.55">
      <svg class="bd" viewBox="0 0 320 400" role="img" aria-label="Brokoli detektif sedang mencari dengan kacamata pembesar">
        <defs>
          <clipPath id="bd-crown-clip">
            <circle cx="112" cy="200" r="46"/>
            <circle cx="208" cy="200" r="46"/>
            <circle cx="140" cy="152" r="48"/>
            <circle cx="184" cy="152" r="48"/>
            <circle cx="160" cy="122" r="44"/>
            <circle cx="160" cy="212" r="54"/>
          </clipPath>
        </defs>

        <ellipse class="bd-shadow" cx="160" cy="352" rx="86" ry="12" fill="#1B3022" opacity=".13"/>

        <g class="bd-bob">
          <g class="bd-lean">

            {{-- Lengan Belakang --}}
            <g class="bd-arm-back">
              <path d="M96 208 Q72 226 62 256" stroke="#234100" stroke-width="16" stroke-linecap="round" fill="none"/>
              <circle cx="60" cy="262" r="11" fill="#234100"/>
            </g>

            {{-- Kaki Belakang --}}
            <g class="bd-leg bd-leg--back">
              <path d="M150 300 L134 342" stroke="#234100" stroke-width="15" stroke-linecap="round" fill="none"/>
              <ellipse cx="132" cy="348" rx="15" ry="6" fill="#234100"/>
            </g>

            {{-- Tangkai --}}
            <g class="bd-stem">
              <path d="M124 232 C120 270 128 300 136 306 L184 306 C192 300 200 270 196 232 Z" fill="#9DD761"/>
              <path d="M148 236 C146 272 150 298 154 306 L166 306 C170 298 174 272 172 236 Z" fill="#B8F47A"/>
            </g>

            {{-- Kaki Depan --}}
            <g class="bd-leg bd-leg--front">
              <path d="M172 300 L188 342" stroke="#3C6A00" stroke-width="16" stroke-linecap="round" fill="none"/>
              <ellipse cx="190" cy="348" rx="16" ry="6.5" fill="#3C6A00"/>
            </g>

            {{-- Mahkota brokoli --}}
            <g class="bd-crown">
              <g fill="#3C6A00" clip-path="url(#bd-crown-clip)">
                <circle cx="112" cy="200" r="46"/>
                <circle cx="208" cy="200" r="46"/>
                <circle cx="140" cy="152" r="48"/>
                <circle cx="184" cy="152" r="48"/>
                <circle cx="160" cy="122" r="44"/>
                <circle cx="160" cy="212" r="54"/>
              </g>
              <g clip-path="url(#bd-crown-clip)">
                <ellipse cx="122" cy="142" rx="132" ry="92" fill="#7CB342" opacity=".85"/>
                <ellipse cx="214" cy="278" rx="130" ry="86" fill="#1E3A00" opacity=".38"/>
              </g>
              <g fill="#9DD761" opacity=".4" clip-path="url(#bd-crown-clip)">
                <circle cx="96" cy="168" r="7"/>
                <circle cx="122" cy="140" r="6"/>
                <circle cx="150" cy="118" r="7"/>
                <circle cx="182" cy="132" r="5.5"/>
                <circle cx="216" cy="164" r="7"/>
                <circle cx="238" cy="196" r="5.5"/>
                <circle cx="84"  cy="212" r="6"/>
                <circle cx="112" cy="238" r="5"/>
                <circle cx="160" cy="152" r="6.5"/>
                <circle cx="196" cy="232" r="6"/>
                <circle cx="140" cy="186" r="5"/>
                <circle cx="228" cy="220" r="5"/>
                <circle cx="100" cy="192" r="4.5"/>
                <circle cx="176" cy="176" r="5"/>
                <circle cx="204" cy="140" r="5"/>
              </g>
            </g>

            {{-- Kepala: topi + wajah --}}
            <g class="bd-head">

              <g class="bd-flower" aria-hidden="true">
                <circle cx="104" cy="88" r="5.5" fill="#FB8C00"/>
                <circle cx="104" cy="74" r="5" fill="#FB8C00"/>
                <circle cx="92"  cy="83" r="5" fill="#FB8C00"/>
                <circle cx="116" cy="83" r="5" fill="#FB8C00"/>
                <circle cx="104" cy="88" r="4" fill="#E68900"/>
              </g>

              <g class="bd-hat">
                <path d="M116 130 V94 C116 76 204 76 204 94 V130 Z" fill="#1B3022"/>
                <rect x="114" y="114" width="92" height="17" rx="5" fill="#FB8C00"/>
                <ellipse cx="160" cy="134" rx="92" ry="15" fill="#1B3022"/>
                <ellipse cx="160" cy="131" rx="92" ry="13" fill="#2C5000" opacity=".55"/>
              </g>

              <g class="bd-brows">
                <path d="M108 168 q17 -11 34 -3" stroke="#1B3022" stroke-width="8" stroke-linecap="round" fill="none" opacity=".85"/>
                <path d="M158 165 q17 -8 34 3"  stroke="#1B3022" stroke-width="8" stroke-linecap="round" fill="none" opacity=".85"/>
              </g>

              <g class="bd-eyes">
                <ellipse cx="126" cy="198" rx="22" ry="24" fill="#FFFFFF"/>
                <ellipse cx="198" cy="198" rx="22" ry="24" fill="#FFFFFF"/>
                <g class="bd-pupil bd-pupil--l">
                  <circle cx="126" cy="202" r="10" fill="#191C1A"/>
                  <circle cx="122" cy="196" r="3.4" fill="#FFFFFF"/>
                </g>
                <g class="bd-pupil bd-pupil--r">
                  <circle cx="198" cy="202" r="10" fill="#191C1A"/>
                  <circle cx="194" cy="196" r="3.4" fill="#FFFFFF"/>
                </g>
              </g>

              <path class="bd-smile" d="M136 242 Q160 261 184 242" stroke="#1B3022" stroke-width="7" stroke-linecap="round" fill="none"/>

              <g class="bd-monocle">
                <path d="M224 240 q12 22 -4 38" stroke="#1B3022" stroke-width="4" fill="none" stroke-linecap="round" opacity=".75"/>
                <circle cx="228" cy="216" r="24" fill="#D0E9D4" fill-opacity=".3" stroke="#1B3022" stroke-width="5"/>
              </g>
            </g>

            {{-- Lengan Depan (pegang kacamata) --}}
            <g class="bd-arm-front">
              <path d="M228 212 Q258 218 286 238" stroke="#3C6A00" stroke-width="17" stroke-linecap="round" fill="none"/>
              <circle class="bd-hand" cx="288" cy="240" r="12" fill="#9DD761"/>
            </g>

            {{-- Kacamata Pembesar (bisa digeser) --}}
            <g class="bd-glass" data-404-glass tabindex="0" role="button"
               aria-label="Kacamata pembesar. Gunakan panah keyboard untuk menggerakkan, atau seret dengan mouse.">
              <circle cx="252" cy="176" r="35" fill="#D0E9D4" fill-opacity=".5" stroke="#1B3022" stroke-width="9"/>
              <path d="M232 162 a26 26 0 0 1 14 -12" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round" fill="none" opacity=".7"/>
              <path d="M278 202 L290 238" stroke="#1B3022" stroke-width="13" stroke-linecap="round" fill="none"/>
            </g>

          </g>
        </g>
      </svg>
    </div>
  </div>

  {{-- Copy --}}
  <span class="e404-badge">Error 404</span>

  <h1 class="e404-title">Halaman Tidak Ditemukan</h1>

  <p class="e404-text">
    Brokoli Detektif kami sudah keliling ke seluruh garden&nbsp;&mdash; tapi halaman ini tetap tak ditemukan.
    Mungkin produknya sudah habis, atau tautannya keliru.
  </p>

  <div class="e404-actions" id="e404-actions">
    <a class="e404-btn e404-btn--primary" href="/" data-404-cta>
      <svg viewBox="0 0 20 20" aria-hidden="true" width="18" height="18">
        <path d="M11 4 L5 10 L11 16" fill="none" stroke="currentColor" stroke-width="2.2"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      Kembali ke Beranda
    </a>
    <a class="e404-btn e404-btn--ghost" href="/">Lihat Katalog</a>
  </div>

  <p class="e404-hint" data-404-seed-hint>
    <svg viewBox="0 0 40 40" aria-hidden="true" width="20" height="20"><use href="#vg-leaf"/></svg>
    Klik di mana saja untuk menyemaiBuscar
  </p>

  <p class="e404-foot">&copy; {{ date('Y') }} Wello &mdash; Fresh Groceries</p>

  <div class="e404-particles" data-404-particles aria-hidden="true"></div>
</main>

<script src="{{ asset('js/404.js') }}" defer></script>
</body>
</html>