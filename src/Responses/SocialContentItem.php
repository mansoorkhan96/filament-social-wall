<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Google\Service\YouTube\Video;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class SocialContentItem
{
    public readonly string $title;

    public readonly string $description;

    public readonly SocialThumbnail $thumbnails;

    public readonly string $player;

    public readonly string $link;

    public readonly int $viewCount;

    public readonly int $likeCount;

    public readonly int $commentCount;

    public readonly SocialProviderName $provider;

    public function __construct(Video $item)
    {
        if ($item instanceof Video) {
            $this->fromYoutube($item);
        }
    }

    public function fromYoutube(Video $item): void
    {
        $this->title = $item->getSnippet()->getTitle();
        $this->description = $item->getSnippet()->getDescription();
        $this->thumbnails = new SocialThumbnail($item->getSnippet()->getThumbnails());
        $this->player = $item->getPlayer()->embedHtml;
        $this->viewCount = $item->getStatistics()->getViewCount();
        $this->likeCount = $item->getStatistics()->getLikeCount();
        $this->commentCount = $item->getStatistics()->getCommentCount();
        // TODO: lets change provider from google to youtube. Makes sense for icons, login, and overall. niche and specific. Google is very top-level as it has many services. we can also add socialprovider = youtube. hence youtube profile avatar etc.
        $this->provider = SocialProviderName::Google;
    }
}
