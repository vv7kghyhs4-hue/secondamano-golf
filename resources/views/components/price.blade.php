{{-- Prezzo con valuta e bandierina, oppure "Gratis". CHF all'uso svizzero (1'250), EUR all'uso italiano (1.250). --}}
@props(['listing'])
@php($chf = $listing->currency === \App\Enums\Currency::CHF)
@php($decimals = (float) $listing->price == floor((float) $listing->price) ? 0 : 2)
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-display font-extrabold text-fairway']) }}>
    @if ($listing->is_free)
        Gratis
    @else
        <x-currency-flag :currency="$listing->currency" />
        {{ $listing->currency->value }} {{ number_format((float) $listing->price, $decimals, $chf ? '.' : ',', $chf ? "'" : '.') }}
    @endif
</span>
