<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Affiches Vitrine' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-neutral-100 text-neutral-800 antialiased">
    <header class="border-b border-neutral-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
            <a href="{{ route('affiches.index') }}" class="flex items-center gap-2 font-extrabold tracking-tight">
                <span class="text-[#E2001A]">Orpi</span>
                <span class="text-neutral-400">·</span>
                <span class="text-neutral-700">Affiches Vitrine</span>
            </a>
            <a href="{{ route('affiches.create') }}"
               class="rounded-lg bg-[#E2001A] px-4 py-2 text-sm font-semibold text-white hover:bg-[#c40017]">
                + Nouvelle affiche
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
