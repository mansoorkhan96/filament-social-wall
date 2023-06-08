<?php

namespace Mansoor\FilamentSocialWall\Services;

use Illuminate\Support\Collection;

class SocialWall
{
    protected YouTube $youtube;

    protected Facebook $facebook;

    public function __construct()
    {
        $this->facebook = new Facebook;
        $this->youtube = new YouTube;
    }

    public function getData(int|string $facebookPageId): Collection
    {
        return Collection::make()
            ->merge($this->youtube->getVideoList())
            ->merge($this->facebook->getPageFeedCollection($facebookPageId));
    }
}
