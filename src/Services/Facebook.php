<?php

namespace Mansoor\FilamentSocialWall\Services;

use Facebook\GraphNode\GraphEdge;
use Facebook\GraphNode\GraphNode;
use Illuminate\Support\Collection;
use JoelButcher\Facebook\Facebook as FacebookService;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Responses\SocialContentItem;

class Facebook
{
    public FacebookService $service;

    public function __construct()
    {
        $provider = SocialProvider::query()
            ->whereBelongsToOwner()
            ->whereProviderName(SocialProviderName::Facebook)
            ->firstOrFail();

        $this->service = new FacebookService([
            'app_id' => config('services.facebook.client_id'),
            'app_secret' => config('services.facebook.client_secret'),
            'default_graph_version' => 'v17.0',
        ]);

        $this->service->setDefaultAccessToken($provider->token);
    }

    public function getPageFeedCollection(string | int $pageId): Collection
    {
        return collect($this->getPageFeed($pageId)->getIterator())
            ->filter(fn (GraphNode $item) => filled($item->getField('from')))
            ->map(fn ($item) => new SocialContentItem($item));
    }

    public function getPageFeed(string | int $pageId): GraphEdge
    {
        return $this->service->get("/{$pageId}/feed", [
            'fields' => 'id,created_time,message,from,full_picture,permalink_url,likes.limit(0).summary(true),comments.limit(0).summary(true)',
            'limit' => 10,
            'is_published' => true,
        ])->getGraphEdge();
    }
}
