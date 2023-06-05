<?php

namespace Mansoor\FilamentSocialWall\Enums;

enum SocialProviderName: string
{
    case Facebook = 'facebook';
    case Instagram = 'instagram';
    case Twitter = 'twitter';
    case Google = 'google';

    public function backgroundColor(): string
    {
        return match ($this) {
            self::Facebook => '#4267B2',
            self::Instagram => '#C13584',
            self::Google => '#FF0000',
            self::Twitter => '#1DA1F2',
        };
    }
}
