<?php

namespace Mansoor\FilamentSocialWall\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Mansoor\FilamentSocialWall\Models\SocialProvider;

class ConnectSocialMediaWidget extends Widget
{
    protected static string $view = 'filament-social-wall::connect-social-media-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        /**
         * TODO: \App\Models\Website::current() makes plugin not reusable
         * TODO: We can also get the avatar from provider and show it inside our widget that would make it more friendly. User will also be able to see which account they have connect.
         */
        return [
            'socialProviders' => SocialProvider::query()
                ->when(
                    filled(config('filament-social-wall.social_provider_relation')),
                    fn (Builder $query) => $query->whereBelongsTo(\App\Models\Website::current(), 'owner')
                )
                ->pluck('provider_name'),
        ];
    }
}
