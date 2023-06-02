@php
    $tag = blank($link) ? 'button' : 'a'
@endphp

<{{ $tag }}
    {{ $attributes }}
    @if($link)
        href="{{ $link }}"
    @else
        disabled="true"
    @endif
    @class([
        blank($link) ? 'cursor-not-allowed opacity-70' : '',
        'inline-flex items-center space-x-2 rounded px-4 py-2 font-semibold text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg'
    ])
>
    <x-dynamic-component component="{{ 'filament-social-wall::icons.' . $icon }}" />

    <span>{{ $slot }}</span>
</{{ $tag }}>
