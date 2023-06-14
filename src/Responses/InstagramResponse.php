<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class InstagramResponse extends SocialWallResponse
{
    public function __construct(object $post)
    {
        $this->description = $post->caption;
        $this->imageUrl = $post->media_url;
        $this->likeCount = $post->like_count;
        $this->commentCount = $post->comments_count;

        $this->provider = SocialProviderName::Instagram;
    }
}
