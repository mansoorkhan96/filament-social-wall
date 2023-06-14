<?php

namespace Mansoor\FilamentSocialWall\Services;

use Mansoor\FilamentSocialWall\Exceptions\Exception;
use Mansoor\FilamentSocialWall\Responses\InstagramResponse;

class Instagram extends BaseGraphService
{
    protected function getAccountId(): string
    {
        $accountId = $this->getUserAccounts()->value('instagram_business_account.id');

        if (blank($accountId)) {
            throw new Exception('Instagram account permission not granted.', 404);
        }

        return $accountId;
    }

    public function getFeed(int $perPage = 10)
    {
        $media = $this->service
            ->get("/{$this->getAccountId()}/media", ['limit' => $perPage])
            ->getDecodedBody();

        $mediaBatchRequest = collect($media)
            ->flatten(1)
            ->pluck('id')
            ->filter()
            ->map(fn ($mediaId) => $this->service->request(
                'GET',
                "/{$mediaId}?fields=id,media_type,media_url,timestamp,caption,comments_count,like_count"
            ))
            ->toArray();

        $feed = $this->service->sendBatchRequest($mediaBatchRequest)->getDecodedBody();

        return collect($feed)
            ->pluck('body')
            // TODO: can we filter from api?
            ->filter(
                fn ($item) => str_contains($item, '"media_type":"IMAGE"')
                    ? $item
                    : null
            )
            ->filter()
            ->map(fn ($item) => new InstagramResponse(json_decode($item)));
    }
}
