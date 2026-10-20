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