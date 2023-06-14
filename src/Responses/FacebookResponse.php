<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Illuminate\Support\Arr;
use Facebook\GraphNode\GraphNode;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class FacebookResponse extends SocialWallResponse
{
    public ?Attachment $attachment;

    public function __construct(GraphNode $item)
    {
        $this->provider = SocialProviderName::Facebook;

        $this->description = $item->getField('message');
        $this->link = $item->getField('permalink_url');
        $this->imageUrl = $item->getField('full_picture');
        $this->likeCount = Arr::get($item->getField('likes')->getMetaData(), 'summary.total_count');
        $this->commentCount = Arr::get($item->getField('comments')->getMetaData(), 'summary.total_count');

        // TODO: there could be multiple attachments, but we are taking current/first one for now
        if ($item->getField('attachments') instanceof GraphEdge) {
            $this->attachment = new Attachment($item->getField('attachments')->getIterator()->current());
        }
    }
}
