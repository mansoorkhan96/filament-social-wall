<?php

namespace Mansoor\FilamentSocialWall\Services;

use Google\Client;
use Google\Service\YouTube as YouTubeService;
use Google\Service\YouTube\VideoListResponse;
use Illuminate\Support\Collection;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Exceptions\Exception;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Responses\YouTubeResponse;

class YouTube
{
    protected YouTubeService $service;

    public function __construct()
    {
        try {
            $provider = SocialProvider::query()
                ->whereBelongsToParent()
                ->whereProviderName(SocialProviderName::Youtube)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            // TODO: a better approach other than throwing exception may be? User will have other accounts connected and this might annoy.
            throw new Exception('YouTube account not connected.', 404);
        }

        $client = new Client([
            'client_id' => config('services.youtube.client_id'),
            'client_secret' => config('services.youtube.client_secret'),
        ]);
        $client->setAccessToken($provider->token);
        $client->refreshToken($provider->refresh_token);

        $this->service = new YouTubeService($client);
    }

    public function getVideoList(): Collection
    {
        return collect($this->getVideos())
            ->map(fn ($item) => new YouTubeResponse($item));
    }

    public function getVideos(): VideoListResponse
    {
        // TODO: add option to specifiy: channel or playist etc
        return $this->service->videos->listVideos(
            ['player', 'snippet', 'statistics'],
            ['chart' => 'mostPopular']
        );
    }
}
