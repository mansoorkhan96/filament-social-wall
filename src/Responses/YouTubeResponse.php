<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Google\Service\YouTube\Video;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class YouTubeResponse extends SocialWallResponse
{
    public ?YouTubeThumbnail $thumbnails;

    public ?string $player;

    public function __construct(Video $video)
    {
        $this->provider = SocialProviderName::Youtube;

        $this->title = $video->getSnippet()->getTitle();
        $this->description = $video->getSnippet()->getDescription();
        $this->thumbnails = new YouTubeThumbnail($video->getSnippet()->getThumbnails());
        $this->imageUrl = $this->thumbnails->medium;
        $this->player = $video->getPlayer()->embedHtml;
        $this->viewCount = $video->getStatistics()->getViewCount();
        $this->likeCount = $video->getStatistics()->getLikeCount();
        $this->commentCount = $video->getStatistics()->getCommentCount();
    }
}
