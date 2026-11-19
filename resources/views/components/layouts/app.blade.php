<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' · ' : '' }}Secondamano.golf</title>
    <meta name="description" content="Annunci di attrezzatura da golf usata e nuova in Italia e Canton Ticino.">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <meta name="theme-color" content="#15803D">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <header class="sticky top-0 z-10 border-b border-line bg-white">
        <div class="mx-auto flex h-[60px] max-w-5xl items-center justify-between px-4">
            <a href="{{ url('/') }}" aria-label="Secondamano.golf, vai alla home"><x-logo /></a>
            <nav class="flex items-center gap-2">
                <a href="#" class="btn-secondary hidden h-10 sm:inline-flex">Pubblica annuncio</a>
                <a href="#" class="inline-flex h-11 w-11 items-center justify-center rounded-full text-ink hover:bg-gray-100" aria-label="Accedi">
                    <svg class="h-[22px] w-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"/></svg>
                </a>
            </nav>
        </div>
    </header>

    <main class="w-full flex-1">
        {{ $slot }}
    </main>

    <footer class="border-t border-line bg-white">
        <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-3 px-4 py-6 text-sm text-muted">
            <x-logo :size="20" />
            <nav class="flex flex-wrap gap-4">
                <a href="#">Contatti</a>
                <a href="#">Termini d'uso</a>
                <a href="#">Privacy</a>
                <a href="#">Cookie</a>
            </nav>
        </div>
    </footer>
</body>
</html>
