<?php

use Atymic\Twitter\Twitter;
use Facebook\Facebook;
use Illuminate\Database\Eloquent\Builder;
// use Mansoor\FilamentSocialWall\Services\Facebook;
use Illuminate\Support\Facades\Route;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Http\Controllers\SocialAccountController;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Services\YouTube as ServicesYouTube;

Route::get('test', function () {
    // $y = new ServicesYouTube;
    // dd($y->getVideoList());

    $fb = new Facebook;
    $provider = SocialProvider::query()
        ->when(
            filled(config('filament-social-wall.social_provider_relation')),
            fn (Builder $query) => $query->whereBelongsTo(\App\Models\Website::current(), 'owner')
        )
        ->whereProviderName(SocialProviderName::Twitter)->firstOrFail();

    $altInstance = Twitter::usingConfiguration(\Atymic\Twitter\Configuration::withOauthCredentials(
        $provider->token,
        $provider->token_secret,
        config('services.twitter.client_id'),
        config('services.twitter.client_secret')
    ));
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/social/{provider}/redirect', [SocialAccountController::class, 'redirectToProvider'])
        ->name('social.provider.redirect');

    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'handleProviderCallback'])
        ->name('social.provider.callback');
});
