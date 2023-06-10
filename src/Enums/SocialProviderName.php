<?php

namespace Mansoor\FilamentSocialWall\Enums;

enum SocialProviderName: string
{
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Twitter = 'twitter';
    case Youtube = 'youtube';

    public function color(): string
    {
        return match ($this) {
            self::Facebook => '#4267B2',
            self::Instagram => '#C13584',
            self::Youtube => '#FF0000',
            self::Twitter => '#1DA1F2',
        };
    }
}
