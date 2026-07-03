<div>
    @php $inp = 'w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm focus:border-[#E2001A] focus:ring-1 focus:ring-[#E2001A] outline-none'; @endphp

    {{-- Barre d'actions --}}
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-neutral-800">
                {{ $afficheId ? 'Modifier l\'affiche' : 'Nouvelle affiche' }}
            </h1>
            <p class="text-sm text-neutral-500">Aperçu temps réel · export PDF A4 paysage</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('affiches.index') }}" wire:navigate
               class="rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm font-medium hover:bg-neutral-50">
                ← Liste
            </a>
            <button wire:click="save"
                    class="rounded-lg bg-neutral-800 px-4 py-2 text-sm font-semibold text-white hover:bg-neutral-700">
                <span wire:loading.remove wire:target="save">Enregistrer</span>
                <span wire:loading wire:target="save">Enregistrement…</span>
            </button>
            @if($afficheId)
                <a href="{{ route('affiches.pdf', $afficheId) }}" target="_blank"
                   class="rounded-lg bg-[#E2001A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#c40017]">
                    ⬇ Télécharger le PDF
                </a>
            @endif
        </div>
    </div>

    @if(session('saved'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm text-green-800">
            {{ session('saved') }}
        </div>
    @endif
    @if(session('imported'))
        <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2 text-sm text-blue-800">
            {{ session('imported') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,420px)_1fr]">
        {{-- ===================== FORMULAIRE ===================== --}}
        <div class="space-y-5">
            {{-- Agence : conseillers + biens (SweepBright = source de vérité) --}}
            <section class="rounded-xl border border-[#E2001A]/30 bg-[#E2001A]/5 p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-[#E2001A]">Agence {{ $agencyCode }}</h2>
                    <span class="text-xs text-neutral-500" wire:loading.remove wire:target="selectEstate">SweepBright · Télémaque</span>
                    <span class="text-xs text-[#E2001A]" wire:loading wire:target="selectEstate">chargement du bien…</span>
                </div>

                {{-- Conseillers --}}
                <div class="mb-4">
                    <label class="mb-2 flex cursor-pointer items-center gap-2.5 rounded-lg border border-neutral-300 bg-white p-3 text-sm font-semibold text-neutral-800">
                        <input type="checkbox" wire:model.live="agent_visible" class="h-5 w-5 rounded border-neutral-300 text-[#E2001A] focus:ring-[#E2001A]">
                        Afficher les infos du conseiller
                    </label>

                    @if($agent_visible)
                        <span class="mb-2 block text-xs font-semibold uppercase text-neutral-500">Conseiller ({{ count($advisors) }})</span>
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            @forelse($advisors as $a)
                                <button type="button" wire:key="adv-{{ $a['email'] }}" wire:click="selectAdvisor('{{ $a['email'] }}')"
                                        class="flex items-center gap-2 rounded-lg border p-2 text-left transition {{ $selectedAdvisorEmail === $a['email'] ? 'border-[#E2001A] ring-1 ring-[#E2001A] bg-white' : 'border-neutral-200 bg-white hover:border-neutral-300' }}">
                                    @if($a['photo'])
                                        <img src="{{ $a['photo'] }}" class="h-9 w-9 flex-none rounded-full object-cover" alt="">
                                    @else
                                        <div class="h-9 w-9 flex-none rounded-full bg-neutral-200"></div>
                                    @endif
                                    <span class="min-w-0">
                                        <span class="block truncate text-sm font-medium text-neutral-800">{{ $a['nom'] }}</span>
                                        <span class="block truncate text-xs text-neutral-500">{{ $a['tel'] ?: '—' }}</span>
                                    </span>
                                </button>
                            @empty
                                <p class="text-xs text-neutral-500">Aucun conseiller actif.</p>
                            @endforelse
                        </div>
                    @else
                        <p class="rounded-lg bg-neutral-50 px-3 py-2 text-xs text-neutral-500">Conseiller masqué — le QR code prend sa place (bas gauche) et reste actif.</p>
                    @endif
                </div>

                {{-- Biens --}}
                <div>
                    <span class="mb-2 block text-xs font-semibold uppercase text-neutral-500">Bien à afficher ({{ count($estates) }})</span>
                    <div class="max-h-80 space-y-2 overflow-auto pr-1">
                        @forelse($estates as $e)
                            <button type="button" wire:key="est-{{ $e['id'] }}" wire:click="selectEstate('{{ $e['id'] }}')"
                                    class="flex w-full items-center gap-3 rounded-lg border p-2 text-left transition {{ $selectedEstateId === $e['id'] ? 'border-[#E2001A] ring-1 ring-[#E2001A] bg-white' : 'border-neutral-200 bg-white hover:border-neutral-300' }}">
                                @if($e['thumb'])
                                    <img src="{{ $e['thumb'] }}" class="h-12 w-16 flex-none rounded object-cover" alt="">
                                @else
                                    <div class="flex h-12 w-16 flex-none items-center justify-center rounded bg-neutral-100 text-[10px] text-neutral-400">—</div>
                                @endif
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-medium text-neutral-800">{{ $e['ville'] }} · {{ $e['type'] }}</span>
                                    <span class="block truncate text-xs text-neutral-500">Réf {{ $e['reference'] ?? '—' }}</span>
                                </span>
                                @if($e['prix'])
                                    <span class="flex-none text-sm font-semibold text-[#E2001A]">{{ number_format($e['prix'], 0, ',', ' ') }} €</span>
                                @endif
                            </button>
                        @empty
                            <p class="text-xs text-neutral-500">Aucun bien pour cette agence.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- Statut --}}
            <section class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-neutral-500">Statut / badge</h2>
                <div class="grid grid-cols-2 gap-3">
                    <label class="block text-sm {{ $statutRequiertJours ? '' : 'col-span-2' }}">
                        <span class="mb-1 block font-medium text-neutral-600">Statut</span>
                        <select class="{{ $inp }}" wire:model.live="statut">
                            @foreach($statuts as $value => $label) <option value="{{ $value }}">{{ $label }}</option> @endforeach
                        </select>
                    </label>
                    @if($statutRequiertJours)
                        <label class="block text-sm">
                            <span class="mb-1 block font-medium text-neutral-600">Nombre de jours</span>
                            <input type="number" class="{{ $inp }}" wire:model.live.debounce.300ms="statut_jours" placeholder="17">
                        </label>
                    @endif
                </div>
            </section>

            {{-- Photo du bien : choix parmi les photos du bucket --}}
            <section class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-neutral-500">Photo du bien</h2>
                @if($estatePhotos)
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($estatePhotos as $url)
                            <button type="button" wire:key="photo-{{ md5($url) }}" wire:click="selectPhoto('{{ $url }}')"
                                    class="relative overflow-hidden rounded-lg border-2 transition {{ $photo_path === $url ? 'border-[#E2001A]' : 'border-transparent hover:border-neutral-300' }}">
                                <img src="{{ $url }}" class="h-20 w-full object-cover" alt="">
                                @if($photo_path === $url)
                                    <span class="absolute right-1 top-1 rounded-full bg-[#E2001A] px-1.5 text-[11px] font-bold text-white">✓</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-500">Sélectionnez un bien pour choisir sa photo.</p>
                @endif
            </section>

            {{-- QR --}}
            <section class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-neutral-500">QR code</h2>
                <div class="space-y-3">
                    <label class="block text-sm">
                        <span class="mb-1 block font-medium text-neutral-600">Emplacement</span>
                        <select class="{{ $inp }} disabled:bg-neutral-100 disabled:text-neutral-400" wire:model.live="qr_position" @disabled(! $agent_visible)>
                            @foreach($qrPositions as $value => $label) <option value="{{ $value }}">{{ $label }}</option> @endforeach
                        </select>
                        @unless($agent_visible)
                            <span class="mt-1 block text-xs text-neutral-500">Forcé en bas gauche (conseiller masqué).</span>
                        @endunless
                    </label>
                    <p class="text-xs text-neutral-500">Le QR pointe automatiquement vers la page du bien.</p>
                </div>
            </section>

            {{-- Contenu --}}
            <section class="rounded-xl border border-neutral-200 bg-white p-4">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-neutral-500">Contenu</h2>
                <div class="space-y-3">
                    <label class="block text-sm">
                        <span class="mb-1 block font-medium text-neutral-600">Accroche « Le + »</span>
                        <input type="text" class="{{ $inp }}" wire:model.live.debounce.300ms="accroche" placeholder="Le + : Jardin paysagé de 800 m²">
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1 block font-medium text-neutral-600">Description</span>
                        <textarea rows="4" class="{{ $inp }}" wire:model.live.debounce.400ms="description" placeholder="Charmante maison construite en 1974…"></textarea>
                    </label>
                    <label class="block text-sm">
                        <span class="mb-1 block font-medium text-neutral-600">Mentions légales</span>
                        <textarea rows="2" class="{{ $inp }}" wire:model.live.debounce.400ms="mentions_legales"></textarea>
                    </label>
                </div>
            </section>
        </div>

        {{-- ===================== APERÇU ===================== --}}
        <div class="lg:sticky lg:top-6 lg:self-start">
            <div class="mb-2 flex items-center justify-between">
                <span class="text-sm font-medium text-neutral-500">Aperçu — A4 paysage (297 × 210 mm)</span>
                <span wire:loading class="text-xs text-neutral-400">mise à jour…</span>
            </div>
            <div class="overflow-auto rounded-xl border border-neutral-300 bg-neutral-200 p-4 shadow-inner">
                <div class="mx-auto origin-top" style="zoom:.52" wire:key="preview-canvas">
                    @include('affiche.canvas', ['affiche' => $preview])
                </div>
            </div>
        </div>
    </div>
</div>
