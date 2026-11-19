@props(['listing'])
<article class="flex gap-3 rounded-xl border border-line bg-white p-2.5">
    <div class="flex h-[88px] w-[88px] shrink-0 items-center justify-center overflow-hidden rounded-lg bg-gray-200">
        @if ($listing->mainPhoto)
            <img src="{{ asset('storage/'.$listing->mainPhoto->path) }}" alt="" class="h-full w-full object-cover" loading="lazy">
        @else
            <svg class="h-7 w-7 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="M21 17l-5-5-8 8"/></svg>
        @endif
    </div>
    <div class="flex min-w-0 flex-col gap-1">
        <h3 class="truncate font-sans text-[15px] font-semibold">{{ $listing->title }}</h3>
        <x-price :listing="$listing" class="text-[17px]" />
        <p class="text-xs text-muted">
            {{ $listing->city }} ({{ $listing->province->code }}) · {{ $listing->condition->label() }}
            @if ($listing->shipping_available)
                · Spedizione
            @endif
        </p>
    </div>
</article>
