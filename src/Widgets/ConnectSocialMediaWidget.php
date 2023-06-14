<?php

namespace Mansoor\FilamentSocialWall\Widgets;

use Filament\Widgets\Widget;
use Mansoor\FilamentSocialWall\Models\SocialProvider;

class ConnectSocialMediaWidget extends Widget
{
    protected static string $view = 'filament-social-wall::connect-social-media-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        /**
         * TODO: We can also get the avatar from provider and show it inside our widget that would make it more friendly. User will also be able to see which account they have connect.
         */
        return [
            'socialProviders' => SocialProvider::query()
                ->whereBelongsToParent()
                ->pluck('provider_name'),
        ];
    }
}
