<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class SocialWallResponse
{
    public SocialProviderName $provider;

    public ?string $title;

    public ?string $description;

    public ?string $imageUrl;

    public ?string $link;

    public ?int $viewCount;

    public ?int $likeCount;

    public ?int $commentCount;
}
