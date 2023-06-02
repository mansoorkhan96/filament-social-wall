<?php

use Google\Service\YouTube;
use Illuminate\Support\Facades\Route;
use Mansoor\FilamentSocialWall\Http\Controllers\SocialAccountController;

Route::get('test', function () {
    $client = new Google_Client();
    $client->setApplicationName('API code samples');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube.readonly',
    ]);
    $client->setAccessToken(env('GOOGLE_TOKEN'));
    $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));
    $service = new YouTube($client);

    // player gives the iframe video player
    // snippet gives access to thumbnails.
    $response = $service->videos->listVideos('player', [
        'chart' => 'mostPopular',
    ]);
    dd($response);
});

Route::middleware('web')->group(function () {
    Route::get('/social/{provider}/redirect', [SocialAccountController::class, 'redirectToProvider'])
        ->name('social.provider.redirect');

    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'handleProviderCallback'])
        ->name('social.provider.callback');
});
