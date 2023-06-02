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
            self::Facebook => '#1877f2',
            self::Instagram => '#c13584',
            self::Google => '#ea4335',
            self::Twitter => '#1da1f2',
        };
    }
}
