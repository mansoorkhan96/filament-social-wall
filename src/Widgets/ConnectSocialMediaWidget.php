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
