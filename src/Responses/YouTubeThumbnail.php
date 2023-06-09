<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Google\Service\YouTube\ThumbnailDetails;

class YouTubeThumbnail
{
    public readonly ?string $default;

    public readonly ?string $medium;

    public readonly ?string $high;

    public readonly ?string $standard;

    public readonly ?string $maxres;

    public function __construct(ThumbnailDetails $thumbnails)
    {
        $this->default = $thumbnails->getDefault()?->getUrl();
        $this->medium = $thumbnails->getMedium()?->getUrl();
        $this->high = $thumbnails->getHigh()?->getUrl();
        $this->standard = $thumbnails->getStandard()?->getUrl();
        $this->maxres = $thumbnails->getMaxres()?->getUrl();
    }
}
