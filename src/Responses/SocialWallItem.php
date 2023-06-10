<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Facebook\GraphNode\GraphEdge;
use Facebook\GraphNode\GraphNode;
use Google\Service\YouTube\Video;
use Illuminate\Support\Arr;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

// TODO: cleanup, create base class and extend it for each i.e fb, insta, youtube

class SocialWallItem
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

    public readonly ?Attachment $attachment;

    public readonly SocialProviderName $provider;

    public function __construct($item, ?SocialProviderName $socialProvider = null)
    {
        if ($item instanceof Video) {
            $this->fromYoutube($item);
        }

        if ($item instanceof GraphNode) {
            $this->fromFacebook($item);
        }

        if ($socialProvider === SocialProviderName::Instagram) {
            $this->fromInstagram($item);
        }
    }

    protected function fromInstagram(object $item): void
    {
        $this->description = $item->caption;
        $this->imageUrl = $item->media_url;
        $this->likeCount = $item->like_count;
        $this->commentCount = $item->comments_count;

        $this->provider = SocialProviderName::Instagram;
    }

    protected function fromFacebook(GraphNode $item): void
    {
        $this->description = $item->getField('message');
        $this->link = $item->getField('permalink_url');
        $this->imageUrl = $item->getField('full_picture');
        $this->likeCount = Arr::get($item->getField('likes')->getMetaData(), 'summary.total_count');
        $this->commentCount = Arr::get($item->getField('comments')->getMetaData(), 'summary.total_count');

        // TODO: there could be multiple attachments, but we are taking current/first one for now
        if ($item->getField('attachments') instanceof GraphEdge) {
            $this->attachment = new Attachment($item->getField('attachments')->getIterator()->current());
        }

        $this->provider = SocialProviderName::Facebook;
    }

    protected function fromYoutube(Video $item): void
    {
        $this->title = $item->getSnippet()->getTitle();
        $this->description = $item->getSnippet()->getDescription();
        $this->thumbnails = new SocialThumbnail($item->getSnippet()->getThumbnails());
        $this->player = $item->getPlayer()->embedHtml;
        $this->viewCount = $item->getStatistics()->getViewCount();
        $this->likeCount = $item->getStatistics()->getLikeCount();
        $this->commentCount = $item->getStatistics()->getCommentCount();
        $this->provider = SocialProviderName::Youtube;
    }
}
