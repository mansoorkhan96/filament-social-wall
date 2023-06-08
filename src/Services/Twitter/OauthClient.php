<?php

namespace Mansoor\FilamentSocialWall\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Contracts\Services\Twitter;

class OauthClient implements Twitter
{
    public function __construct(private TwitterOAuth $client)
    {
    }

    public function tweet(string $message): void
    {
        $this->client->post('tweets', ['text' => $message], true);
    }
}
