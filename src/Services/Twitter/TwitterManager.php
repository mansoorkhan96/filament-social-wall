<?php

namespace Mansoor\FilamentSocialWall\Services\Twitter;

use Illuminate\Support\Manager;
use Tests\Doubles\FakeTwitterClient;
use Abraham\TwitterOAuth\TwitterOAuth;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

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
            ->whereBelongsToOwner()
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
