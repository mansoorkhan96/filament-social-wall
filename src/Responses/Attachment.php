<?php

namespace Mansoor\FilamentSocialWall\Responses;

use Facebook\GraphNode\GraphNode;
use Illuminate\Support\Arr;

class Attachment
{
    public readonly ?string $title;
    public readonly ?string $description;
    public readonly ?string $url;
    public readonly ?string $imageUrl;

    public function __construct(GraphNode $attachment)
    {
        $attachment = $attachment->asArray();

        $this->title = Arr::get($attachment, 'title');
        $this->description = Arr::get($attachment, 'description');
        $this->url = Arr::get($attachment, 'unshimmed_url');
        $this->imageUrl = Arr::get($attachment, 'media.image.src');
    }
}
