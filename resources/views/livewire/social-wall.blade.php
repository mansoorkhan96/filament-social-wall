<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex space-x-3 justify-center">
        @foreach (\Mansoor\FilamentSocialWall\Enums\SocialProviderName::cases() as $provider)
            <x-filament-social-wall::social-button
                :icon="$provider->value"
                style="background-color: {{ $provider->backgroundColor() }}"
            >
                {{ $provider->name }}
            </x-filament-social-wall::social-button>
        @endforeach
    </div>
</div>
