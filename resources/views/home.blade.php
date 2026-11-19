<x-layouts.app>
    {{-- Ricerca (i filtri saranno attivi nella fase 3) --}}
    <section class="border-b border-line bg-white px-4 py-4">
        <form action="{{ url('/') }}" method="get" class="mx-auto flex max-w-3xl flex-col gap-2.5 sm:flex-row" role="search">
            <label class="flex h-11 flex-1 items-center gap-2 rounded-[10px] border border-gray-300 bg-white px-3 focus-within:border-fairway">
                <svg class="h-[18px] w-[18px] shrink-0 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                <span class="sr-only">Cerca</span>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cosa cerchi? es. driver, putter…" class="min-w-0 flex-1 bg-transparent text-[15px] outline-none">
            </label>
            <div class="grid grid-cols-2 gap-2.5 sm:w-[360px]">
                <label>
                    <span class="sr-only">Zona</span>
                    <select name="zona" class="field">
                        <option value="">Tutte le zone</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->code }}" @selected(request('zona') === $province->code)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>
                    <span class="sr-only">Categoria</span>
                    <select name="categoria" class="field">
                        <option value="">Tutte le categorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('categoria') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </form>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-5">
        <h1 class="mb-3 text-lg font-bold">Ultimi annunci</h1>

        @if ($listings->isEmpty())
            <p class="rounded-xl border border-line bg-white p-6 text-center text-muted">Ancora nessun annuncio pubblicato.</p>
        @else
            <div class="grid gap-2.5 md:grid-cols-2">
                @foreach ($listings as $listing)
                    <x-listing-card :listing="$listing" />
                    @if ($loop->iteration % $adFrequency === 0 && ! $loop->last)
                        <x-ad-slot :position="$feedAd" class="md:col-span-2" />
                    @endif
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
