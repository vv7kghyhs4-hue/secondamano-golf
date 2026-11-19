{{-- Spazio pubblicitario: compare solo se nel CMS è attivo e ha un codice AdSense. --}}
@props(['position'])
@php($ad = $position instanceof \App\Models\AdSlot ? $position : \App\Models\AdSlot::firstWhere('key', $position))
@if ($ad?->isRenderable())
    <aside {{ $attributes->merge(['class' => 'ad-slot']) }} aria-label="Pubblicità">
        <span class="text-[11px] uppercase tracking-[0.1em] text-muted">Pubblicità</span>
        {!! $ad->adsense_code !!}
    </aside>
@endif
