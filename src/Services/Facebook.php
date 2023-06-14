<?php

namespace Mansoor\FilamentSocialWall\Services;

use Facebook\GraphNode\GraphEdge;
use Facebook\GraphNode\GraphNode;
use Illuminate\Support\Collection;
use Mansoor\FilamentSocialWall\Responses\FacebookResponse;

class Facebook extends BaseGraphService
{
    public function getPageFeedCollection(string|int $pageId, int $perPage = 10): Collection
    {
        $pageFeed = $this->getPageFeed($pageId, $perPage)->getIterator();

        return collect($pageFeed)
            ->filter(fn (GraphNode $item) => filled($item->getField('from')))
            ->map(fn ($item) => new FacebookResponse($item));
    }

    public function getPageFeed(string|int $pageId, int $perPage = 10): GraphEdge
    {
        /**
         * TODO: Support batch request to send it for multiple page feeds
         * TODO: get pageId(s) from $this->getUserAccounts()
         */

        return $this->service->get("/{$pageId}/feed", [
            'fields' => 'id,created_time,message,from,full_picture,permalink_url,likes.limit(0).summary(true),comments.limit(0).summary(true),attachments{unshimmed_url,description,media,title}',
            'limit' => $perPage,
        ])->getGraphEdge();
    }
}
