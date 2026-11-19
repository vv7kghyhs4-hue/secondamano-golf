{{-- Logo B: pallina dentro una freccia circolare + scritta. --}}
@props(['size' => 26, 'dark' => false])
@php($green = $dark ? '#4ADE80' : '#15803D')
@php($ink = $dark ? '#FFFFFF' : '#111827')
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5']) }}>
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 64 64" aria-hidden="true">
        <path d="M32 6 A26 26 0 1 1 9.5 19" fill="none" stroke="{{ $green }}" stroke-width="6" stroke-linecap="round"/>
        <polygon points="13,11.5 4.4,16.5 14.4,22.4" fill="{{ $green }}"/>
        <circle cx="32" cy="32" r="12" fill="{{ $ink }}"/>
    </svg>
    <span class="font-display text-[19px] font-extrabold tracking-[-0.03em]" style="color: {{ $ink }}">secondamano<span style="color: {{ $green }}">.golf</span></span>
</span>
