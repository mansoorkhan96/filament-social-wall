<x-filament::widget>
    <x-filament::card>
        <h1 class="text-3xl font-semibold text-blue-500">Connect your social media accounts</h1>

        <div class="flex flex-col sm:flex-row gap-4">
            @foreach (\Mansoor\FilamentSocialWall\Enums\SocialProviderName::cases() as $provider)
                <x-filament-social-wall::social-connect-button
                    :icon="$provider->value"
                    style="background-color: {{ $provider->color() }}"
                    :link="$socialProviders->contains($provider)
                        ? null
                        : route('social.provider.redirect', $provider->value)
                    "
                >
                    {{ $socialProviders->contains($provider) ? 'Connected' : $provider->name }}
                </x-filament-social-wall::social-connect-button>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
