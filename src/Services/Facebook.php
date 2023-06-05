<?php

namespace Mansoor\FilamentSocialWall\Services;

use Facebook\Facebook as FacebookService;

class Facebook
{
    public function __construct()
    {
        $fb = new FacebookService([
            'app_id' => '{app-id}',
            'app_secret' => '{app-secret}',
            'default_graph_version' => 'v2.10',
        ]);

        // Since all the requests will be sent on behalf of the same user,
        // we'll set the default fallback access token here.
        $fb->setDefaultAccessToken('user-access-token');

        dd($requestUserLikes = $fb->request('GET', '/me/likes?fields=id,name&limit=1'));
    }
}
