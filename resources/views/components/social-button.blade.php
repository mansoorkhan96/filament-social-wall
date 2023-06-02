<button
    {{ $attributes->merge(['class' => 'inline-flex items-center space-x-2 rounded px-4 py-2 font-semibold text-white transition duration-150 ease-in-out focus:outline-none focus:ring-0']) }}
>
    <x-dynamic-component component="{{ 'filament-social-wall::icons.' . $icon }}" />

    <span>{{ $slot }}</span>
</button>
