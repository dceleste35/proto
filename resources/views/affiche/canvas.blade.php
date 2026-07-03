@php
    use App\Enums\QrPosition;

    /** @var \App\Models\Affiche $affiche */
    $a = $affiche;

    $dpeColors = ['A' => '#3A9D4B', 'B' => '#54B14E', 'C' => '#A9CB3A', 'D' => '#F4E11A', 'E' => '#F1A81C', 'F' => '#EA6A1E', 'G' => '#DD2A21'];
    $gesColors = ['A' => '#E9E4F5', 'B' => '#CFC3E9', 'C' => '#B49FDA', 'D' => '#987CCA', 'E' => '#7B58B6', 'F' => '#5C3999', 'G' => '#3F2274'];
    // Lettres sombres sur fonds clairs, blanches ailleurs.
    $dpeDark = ['C', 'D'];
    $gesDark = ['A', 'B', 'C'];

    $qr = $a->qrDataUri();
    $photo = $a->photoUrl();
    $agentPhoto = $a->agentPhotoUrl();
    $showAgent = $a->agent_visible && filled($a->agent_nom);
    // Conseiller masqué → le QR est forcé en bas-gauche (à la place du conseiller) et actif.
    $effQrPos = $a->agent_visible ? $a->qr_position : QrPosition::BasGauche;
    $qrTop = $qr && $effQrPos === QrPosition::HautDroite;
    $qrLeft = $qr && $effQrPos === QrPosition::BasGauche;

    $logoSvg = file_exists(resource_path('svg/orpi/logo.svg')) ? file_get_contents(resource_path('svg/orpi/logo.svg')) : '';

    // Police Orpi : embarquée en base64 pour le PDF (Browsershot, aucune dépendance réseau),
    // servie par URL pour l'aperçu live (plus léger). $embedFonts est passé à true par le PDF.
    $embedFonts = $embedFonts ?? false;
    $orpiWeights = ['Orpi-Light.ttf' => 300, 'Orpi-Regular.ttf' => 400, 'Orpi-Medium.ttf' => 500, 'Orpi-Bold.ttf' => 700];
    $fontFaces = '';
    foreach ($orpiWeights as $file => $weight) {
        $full = public_path('fonts/orpi/'.$file);
        $src = $embedFonts && file_exists($full)
            ? 'data:font/ttf;base64,'.base64_encode(file_get_contents($full))
            : asset('fonts/orpi/'.$file);
        $fontFaces .= "@font-face{font-family:'Orpi';font-style:normal;font-weight:{$weight};src:url('{$src}') format('truetype');}";
    }
@endphp

<div class="av-root">
    <style>
        {!! $fontFaces !!}

        .av-root { --red:#E2001A; --ink:#3b3b3b; --beige:#E9E5D9; --accent:{{ $a->accentColor() }}; }
        .av-root * { margin:0; padding:0; box-sizing:border-box; }
        .av {
            position:relative; width:297mm; height:210mm; background:#fff; overflow:hidden;
            font-family:'Orpi','Helvetica Neue',Arial,sans-serif; color:var(--ink);
            -webkit-font-smoothing:antialiased;
        }

        /* ---- Colonne gauche : panneau beige ---- */
        .av-panel {
            position:absolute; top:0; left:0; width:96mm; height:150mm;
            background:var(--beige); border-bottom-right-radius:16mm; padding:12mm 9mm 0;
        }
        .av-ville { color:var(--red); font-weight:700; font-size:44px; line-height:1; letter-spacing:-.5px; }
        .av-type { font-weight:500; font-size:25px; margin-top:7px; color:#4a4a4a; }
        .av-pieces { font-weight:400; font-size:21px; color:#5a5a5a; margin-top:2px; }
        .av-prix { color:var(--red); font-weight:700; font-size:42px; margin-top:12px; line-height:1; white-space:nowrap; }

        /* ---- Diagnostics DPE / GES ---- */
        .av-diag { margin-top:15px; }
        .av-diag-title { font-weight:700; font-size:11px; color:#555; text-transform:uppercase; letter-spacing:.3px; }
        .av-scale { display:flex; gap:3px; margin-top:6px; }
        .av-cell {
            flex:1; height:25px; border-radius:4px; display:flex; align-items:center; justify-content:center;
            font-weight:700; font-size:12px; color:#fff;
        }
        .av-cell.dark { color:#3b3b3b; }
        .av-cell.active { transform:scaleY(1.35); box-shadow:0 0 0 2px #3b3b3b; border-radius:5px; z-index:2; }
        .av-value { display:flex; align-items:center; gap:5px; margin-top:10px; font-size:12px; color:#444; }
        .av-value .tri { color:#3b3b3b; font-size:11px; }
        .av-value b { font-weight:700; font-size:15px; }

        /* ---- Bloc agent (bas gauche) ---- */
        .av-agent { position:absolute; left:0; top:150mm; width:96mm; height:56mm; padding:0 8mm; display:flex; align-items:center; gap:5mm; }
        .av-agent-photo { width:27mm; height:33mm; border-radius:4mm; object-fit:cover; background:#cfcabb; flex:none; }
        .av-agent-box { flex:1; background:var(--accent); color:#fff; border-radius:7px; padding:8px 11px; }
        .av-agent-nom { font-weight:500; font-size:14px; line-height:1.15; }
        .av-agent-tel { font-weight:700; font-size:17px; margin-top:3px; white-space:nowrap; }

        /* ---- QR bas gauche ---- */
        .av-qr-left { position:absolute; left:9mm; top:154mm; width:42mm; height:42mm; background:#fff; padding:2mm; }
        .av-qr-left img { width:100%; height:100%; display:block; }

        /* ---- Photo principale ---- */
        .av-photo {
            position:absolute; top:5mm; left:99mm; width:193mm; height:150mm;
            background:#d9d5cd center/cover no-repeat; overflow:hidden;
        }
        .av-photo .ph { width:100%; height:100%; object-fit:cover; display:block; }
        .av-photo .empty { width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#9a958b; font-size:14px; }
        .av-watermark {
            position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
            pointer-events:none; color:rgba(227,6,19,.13);
        }
        .av-watermark svg { width:115mm; height:auto; }

        /* ---- QR haut droite ---- */
        .av-qr-top { position:absolute; top:9mm; right:9mm; width:36mm; height:36mm; background:#fff; padding:2mm; box-shadow:0 1px 4px rgba(0,0,0,.15); }
        .av-qr-top img { width:100%; height:100%; display:block; }

        /* ---- Badge statut ---- */
        .av-badge {
            position:absolute; top:132mm; right:0; height:23mm; min-width:70mm;
            display:flex; align-items:center; gap:5mm; padding:0 12mm 0 9mm;
            background:var(--st); color:#fff; border-top-left-radius:12mm; border-bottom-left-radius:12mm;
        }
        .av-badge .ic { width:15mm; height:15mm; flex:none; }
        .av-badge .txt { font-weight:700; font-size:34px; letter-spacing:.5px; white-space:nowrap; }

        /* ---- Contenu bas (Le + / description) ---- */
        /* Hauteur bornée (jusqu'au-dessus du footer) : la description remplit l'espace restant,
           sa taille de police est ajustée par copyfitting (JS) pour éviter blanc/troncature. */
        .av-content { position:absolute; top:158mm; left:99mm; right:6mm; bottom:11mm; display:flex; flex-direction:column; overflow:hidden; }
        .av-accroche { color:var(--red); font-weight:700; font-size:19px; flex:none; }
        .av-desc { flex:1 1 auto; min-height:0; overflow:hidden; color:#454545; margin-top:5px; font-size:14.5px; line-height:1.42; }

        /* ---- Footer ---- */
        .av-footer { position:absolute; bottom:3.5mm; left:9mm; right:6mm; display:flex; align-items:flex-end; justify-content:space-between; gap:8mm; }
        .av-mentions { font-size:9.5px; color:#8a8a8a; line-height:1.3; max-width:200mm; }
        .av-logo { display:flex; align-items:flex-end; gap:1.5mm; flex:none; color:var(--red); }
        .av-logo svg { height:7mm; width:auto; display:block; }
        .av-logo .dotcom { font-size:16px; font-weight:700; color:#3b3b3b; line-height:1; padding-bottom:.6mm; }
    </style>

    <div class="av">
        {{-- Panneau beige --}}
        <div class="av-panel">
            <div class="av-ville">{{ $a->ville }}</div>
            <div class="av-type">{{ $a->type_bien }}</div>
            <div class="av-pieces">{{ collect([$a->pieces, $a->surface ? $a->surface.' m²' : null])->filter()->join(' • ') }}</div>
            @if($a->prixFormate())
                <div class="av-prix">{{ $a->prixFormate() }}</div>
            @endif

            {{-- DPE : consommation énergétique --}}
            <div class="av-diag">
                <div class="av-diag-title">Consommation énergétique</div>
                <div class="av-scale">
                    @foreach($dpeColors as $letter => $color)
                        <div class="av-cell {{ in_array($letter, $dpeDark) ? 'dark' : '' }} {{ $a->dpe_classe === $letter ? 'active' : '' }}" style="background:{{ $color }}">{{ $letter }}</div>
                    @endforeach
                </div>
                <div class="av-value"><span class="tri">▲</span><b>{{ $a->dpe_valeur ?? '—' }}</b> kWh/m².an</div>
            </div>

            {{-- GES : émissions de gaz --}}
            <div class="av-diag">
                <div class="av-diag-title">Émissions de gaz</div>
                <div class="av-scale">
                    @foreach($gesColors as $letter => $color)
                        <div class="av-cell {{ in_array($letter, $gesDark) ? 'dark' : '' }} {{ $a->ges_classe === $letter ? 'active' : '' }}" style="background:{{ $color }}">{{ $letter }}</div>
                    @endforeach
                </div>
                <div class="av-value"><span class="tri">▲</span><b>{{ $a->ges_valeur ?? '—' }}</b> KgeqCO₂/m².an</div>
            </div>
        </div>

        {{-- Bloc agent OU QR bas-gauche --}}
        @if($showAgent)
            <div class="av-agent">
                @if($agentPhoto)
                    <img src="{{ $agentPhoto }}" class="av-agent-photo" alt="">
                @else
                    <div class="av-agent-photo"></div>
                @endif
                <div class="av-agent-box">
                    <div class="av-agent-nom">{{ $a->agent_nom }}</div>
                    @if($a->agent_telephone)
                        <div class="av-agent-tel">{{ $a->agent_telephone }}</div>
                    @endif
                </div>
            </div>
        @elseif($qrLeft)
            <div class="av-qr-left"><img src="{{ $qr }}" alt="QR"></div>
        @endif

        {{-- Photo principale + watermark --}}
        <div class="av-photo">
            @if($photo)
                <img src="{{ $photo }}" class="ph" alt="">
            @else
                <div class="empty">Photo du bien</div>
            @endif
            @if($logoSvg)
                <div class="av-watermark">{!! $logoSvg !!}</div>
            @endif
        </div>

        {{-- QR haut-droite --}}
        @if($qrTop)
            <div class="av-qr-top"><img src="{{ $qr }}" alt="QR"></div>
        @endif

        {{-- Badge statut --}}
        <div class="av-badge" style="--st:{{ $a->statut->couleur() }}">
            @if($a->statut->afficheIcone())
                <svg class="ic" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 11.5 12 4l9 7.5"/><path d="M5 10v9h14v-9"/>
                    <text x="12" y="17" font-size="8" fill="#fff" stroke="none" text-anchor="middle" font-family="Arial" font-weight="bold">€</text>
                </svg>
            @endif
            <span class="txt">{{ $a->badgeLabel() }}</span>
        </div>

        {{-- Contenu bas --}}
        <div class="av-content">
            @if($a->accroche)
                <div class="av-accroche">{{ $a->accroche }}</div>
            @endif
            @if($a->description)
                <div class="av-desc">{{ $a->description }}</div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="av-footer">
            <div class="av-mentions">{{ $a->mentions_legales }}</div>
            <div class="av-logo">{!! $logoSvg !!}<span class="dotcom">.com</span></div>
        </div>
    </div>

    {{-- Copyfitting : ajuste la taille de la description pour remplir l'espace (aperçu live + PDF). --}}
    <script>
        (function () {
            function fitOne(desc) {
                var avail = desc.clientHeight;
                if (!avail) { return; }
                desc.style.lineHeight = '1.42';
                var lo = 8.5, hi = 22, best = 8.5;
                for (var i = 0; i < 14; i++) {
                    var mid = (lo + hi) / 2;
                    desc.style.fontSize = mid + 'px';
                    if (desc.scrollHeight <= avail) { best = mid; lo = mid; } else { hi = mid; }
                }
                desc.style.fontSize = best + 'px';
            }
            function fitAll() {
                document.querySelectorAll('.av-desc').forEach(fitOne);
                window.__afficheFitted = true;
            }
            function schedule() { window.__afficheFitted = false; requestAnimationFrame(fitAll); }

            if (document.fonts && document.fonts.ready) { document.fonts.ready.then(schedule); }
            window.addEventListener('load', schedule);

            // Réajuste quand le contenu change (aperçu Livewire).
            var t;
            new MutationObserver(function () { clearTimeout(t); t = setTimeout(schedule, 60); })
                .observe(document.documentElement, { subtree: true, childList: true, characterData: true });
        })();
    </script>
</div>
