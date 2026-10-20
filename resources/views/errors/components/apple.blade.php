<div class="apple-shake">
  <svg class="apple" viewBox="0 0 320 400" role="img" aria-label="Apel merah terbakar kepanikan">
    <ellipse class="apple-shadow" cx="160" cy="360" rx="80" ry="12" fill="#E65100" opacity=".2"/>

    {{-- Smoke background --}}
    <g class="apple-smoke" opacity="0.6">
      <path d="M140 100 Q130 70 150 40 T130 10" stroke="#CBD5E1" stroke-width="12" stroke-linecap="round" fill="none" opacity="0.5"/>
      <path d="M180 100 Q190 70 170 40 T190 10" stroke="#CBD5E1" stroke-width="16" stroke-linecap="round" fill="none" opacity="0.4"/>
    </g>

    {{-- Fire on top --}}
    <g class="apple-fire">
      <path d="M160 30 Q140 0 160 -30 Q180 0 160 30 Z" fill="#FB8C00"/>
      <path d="M160 20 Q145 -5 160 -20 Q175 -5 160 20 Z" fill="#FFEB3B"/>
    </g>

    <g class="apple-face">
      {{-- Apple Body --}}
      <path d="M160 70 C220 70 260 120 250 180 C240 240 210 320 160 320 C110 320 80 240 70 180 C60 120 100 70 160 70 Z" fill="#C8562F"/>
      {{-- Apple highlight --}}
      <ellipse cx="120" cy="130" rx="18" ry="30" fill="#DE7A52" opacity=".6" transform="rotate(-20 120 130)"/>

      {{-- Eyes (Dizzy spiral/X) --}}
      <g class="apple-eyes">
        <circle cx="125" cy="180" r="14" fill="#191C1A"/>
        <circle cx="121" cy="176" r="4" fill="#FFFFFF"/>
        <circle cx="195" cy="180" r="14" fill="#191C1A"/>
        <circle cx="191" cy="176" r="4" fill="#FFFFFF"/>
      </g>

      {{-- Mouth screaming --}}
      <path d="M145 220 Q160 250 175 220 Q160 210 145 220 Z" fill="#191C1A"/>
      <rect x="152" y="222" width="16" height="6" fill="#FFFFFF" rx="2"/>

      {{-- Sweat drops --}}
      <path d="M95 160 Q90 170 95 180 Q100 170 95 160 Z" fill="#64B5F6"/>
      <path d="M225 150 Q220 160 225 170 Q230 160 225 150 Z" fill="#64B5F6"/>
    </g>

    {{-- Bucket of water held by panic hand --}}
    <g class="apple-bucket">
      <path d="M210 240 L220 290 H260 L270 240 Z" fill="#94A3B8"/>
      <ellipse cx="240" cy="240" rx="30" ry="8" fill="#64748B"/>
      <ellipse cx="240" cy="242" rx="26" ry="6" fill="#38BDF8"/>
    </g>
  </svg>
</div>
