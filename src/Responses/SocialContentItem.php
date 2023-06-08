<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Facebook\GraphNode\GraphNode;
use Google\Service\YouTube\Video;
use Illuminate\Support\Arr;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class SocialContentItem
{
    public readonly ?string $title;

    public readonly ?string $description;

    public readonly ?SocialThumbnail $thumbnails;

    public readonly ?string $imageUrl;

    public readonly ?string $player;

    public readonly ?string $link;

    public readonly ?int $viewCount;

    public readonly ?int $likeCount;

    public readonly ?int $commentCount;

    public readonly SocialProviderName $provider;

    public function __construct(Video|GraphNode $item)
    {
        if ($item instanceof Video) {
            $this->fromYoutube($item);
        }

        if ($item instanceof GraphNode) {
            $this->fromFacebook($item);
        }
    }

    public function fromFacebook(GraphNode $item): void
    {
        $this->description = $item->getField('message');
        $this->link = $item->getField('permalink_url');
        $this->imageUrl = $item->getField('full_picture');
        $this->likeCount = Arr::get($item->getField('likes')->getMetaData(), 'summary.total_count');
        $this->commentCount = Arr::get($item->getField('comments')->getMetaData(), 'summary.total_count');

        $this->provider = SocialProviderName::Facebook;
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
