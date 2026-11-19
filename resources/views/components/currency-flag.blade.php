{{-- Bandierina accanto al prezzo: svizzera per CHF, italiana per EUR. --}}
@props(['currency'])
@php($c = $currency instanceof \App\Enums\Currency ? $currency : \App\Enums\Currency::from($currency))
@if ($c === \App\Enums\Currency::CHF)
    <svg {{ $attributes->merge(['class' => 'inline-block h-3.5 w-3.5 rounded-[2px] align-[-1px]']) }} viewBox="0 0 32 32" role="img" aria-label="Franchi svizzeri">
        <rect width="32" height="32" fill="#DA291C"/>
        <path d="M13 6h6v7h7v6h-7v7h-6v-7H6v-6h7z" fill="#fff"/>
    </svg>
@else
    <svg {{ $attributes->merge(['class' => 'inline-block h-3 w-[18px] rounded-[2px] align-[-1px] ring-1 ring-gray-200']) }} viewBox="0 0 3 2" role="img" aria-label="Euro">
        <rect width="1" height="2" fill="#009246"/>
        <rect x="1" width="1" height="2" fill="#fff"/>
        <rect x="2" width="1" height="2" fill="#CE2B37"/>
    </svg>
@endif
