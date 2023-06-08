<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Route;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Http\Controllers\SocialAccountController;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Services\Facebook;
use Mansoor\FilamentSocialWall\Services\YouTube;

Route::get('test', function () {
    // $y = new YouTube;
    // dd($y->getVideoList());
    // $f = new Facebook;
    // dd($f->getPageFeedCollection(pageId));

    $provider = SocialProvider::query()
        ->whereBelongsToOwner()
        ->whereProviderName(SocialProviderName::Twitter)
        ->firstOrFail();

    $querier = \Atymic\Twitter\Facade\Twitter::forApiV2()
        ->getQuerier();

    // dd($querier);
    $result = $querier
        ->usingCredentials(
            $provider->token,
            $provider->token_secret,
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
        )
        ->get('users/me');

    $connection = new TwitterOAuth(
        config('services.twitter.client_id'),
        config('services.twitter.client_secret'),
        $provider->token,
        $provider->refresh_token,
    );

    $connection->setApiVersion('2');

    dd($statuses = $connection->get('/users/me'));

    $twitter = Twitter::usingCredentials(
        $provider->token,
        $provider->token_secret,
        config('services.twitter.client_id'),
        config('services.twitter.client_secret')
    );

    dd($twitter->getAccessToken());
    dd($token = $twitter->getAccessToken(request('oauth_verifier')));

    $altInstance = Twitter::usingConfiguration(
        $provider->token,
        $provider->token_secret,
        config('services.twitter.client_id'),
        config('services.twitter.client_secret')
    );
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/social/{provider}/redirect', [SocialAccountController::class, 'redirectToProvider'])
        ->name('social.provider.redirect');

    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'handleProviderCallback'])
        ->name('social.provider.callback');
});
