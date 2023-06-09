<?php

namespace Mansoor\FilamentSocialWall\Services;

use Google\Client;
use Google\Service\YouTube as YouTubeService;
use Google\Service\YouTube\VideoListResponse;
use Illuminate\Support\Collection;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Exceptions\Exception;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Responses\SocialWallItem;

class YouTube
{
    protected YouTubeService $service;

    public function __construct()
    {
        try {
            $provider = SocialProvider::query()
                ->whereBelongsToOwner()
                ->whereProviderName(SocialProviderName::Google)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            // TODO: a better approach other than throwing exception may be? User will have other accounts connected and this might annoy.
            throw new Exception('YouTube account not connected.', 404);
        }

        $client = new Client([
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
        ]);
        $client->setAccessToken($provider->token);
        $client->refreshToken($provider->refresh_token);

        $this->service = new YouTubeService($client);
    }

    public function getVideoList(): Collection
    {
        return collect($this->getVideos())
            ->map(fn ($item) => new SocialWallItem($item));
    }

    public function getVideos(): VideoListResponse
    {
        return $this->service->videos->listVideos(
            ['player', 'snippet', 'statistics'],
            ['chart' => 'mostPopular']
        );
    }
}
