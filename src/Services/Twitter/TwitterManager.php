<?php

namespace Mansoor\FilamentSocialWall\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Manager;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Tests\Doubles\FakeTwitterClient;

final class TwitterManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->configOptions()['driver'] ?? 'null';
    }

    public function createOauthDriver(): OauthClient
    {
        $options = $this->configOptions();
        $twitter = new TwitterOAuth(
            $options['consumer_key'],
            $options['consumer_secret'],
            $options['access_token'],
            $options['access_token_secret']
        );
        $twitter->setApiVersion('2');

        return new OauthClient($twitter);
    }

    public function createNullDriver(): FakeTwitterClient
    {
        return new FakeTwitterClient();
    }

    private function configOptions(): array
    {
        $provider = SocialProvider::query()
            ->whereBelongsToParent()
            ->whereProviderName(SocialProviderName::Twitter)
            ->firstOrFail();

        return [
            'consumer_key' => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
            'access_token' => $provider->token,
            'access_token_secret' => $provider->token_secret,
        ];
    }
}
