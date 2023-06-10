<?php

namespace Mansoor\FilamentSocialWall\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JoelButcher\Facebook\Facebook as FacebookService;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Models\SocialProvider;

class BaseGraphService
{
    protected FacebookService $service;

    public function __construct()
    {
        // TODO: throw exception for no connection?
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

    protected function getUserAccounts(): Collection
    {
        $accounts = $this->service
            ->get('/me/accounts?fields=instagram_business_account')
            ->getDecodedBody();

        return collect($accounts)
            ->flatten(1)
            ->filter(
                fn ($account) => Arr::hasAny($account, ['id', 'instagram_business_account'])
                    ? $account
                    : null
            );
    }

     public function getUserPermissions(): Collection
     {
         $permissions = $this->service->get('/me/permissions')->getDecodedBody();

         return collect($permissions)
             ->flatten(1)
             ->pluck('permission');
     }
}
