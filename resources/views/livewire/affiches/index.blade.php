<div>
    @if(session('saved'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm text-green-800">
            {{ session('saved') }}
        </div>
    @endif

    @if($affiches->isEmpty())
        <div class="rounded-xl border border-dashed border-neutral-300 bg-white p-12 text-center">
            <p class="text-neutral-500">Aucune affiche pour l'instant.</p>
            <a href="{{ route('affiches.create') }}" wire:navigate
               class="mt-4 inline-block rounded-lg bg-[#E2001A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#c40017]">
                Créer la première affiche
            </a>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 text-left text-xs uppercase tracking-wide text-neutral-500">
                    <tr>
                        <th class="px-4 py-3">Bien</th>
                        <th class="px-4 py-3">Prix</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Modifié</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach($affiches as $affiche)
                        <tr wire:key="affiche-{{ $affiche->id }}" class="hover:bg-neutral-50">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-neutral-800">{{ $affiche->ville }}</div>
                                <div class="text-xs text-neutral-500">{{ collect([$affiche->type_bien, $affiche->pieces])->filter()->join(' · ') }}</div>
                            </td>
                            <td class="px-4 py-3 text-neutral-700">{{ $affiche->prixFormate() ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold text-white"
                                      style="background:{{ $affiche->statut->couleur() }}">
                                    {{ $affiche->badgeLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-neutral-500">{{ $affiche->updated_at->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('affiches.edit', $affiche) }}" wire:navigate
                                       class="rounded-md border border-neutral-300 px-3 py-1.5 text-xs font-medium hover:bg-neutral-100">Éditer</a>
                                    <a href="{{ route('affiches.pdf', $affiche) }}" target="_blank"
                                       class="rounded-md bg-[#E2001A] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#c40017]">PDF</a>
                                    <button wire:click="delete({{ $affiche->id }})"
                                            wire:confirm="Supprimer cette affiche ?"
                                            class="rounded-md border border-neutral-300 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">Suppr.</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
