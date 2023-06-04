<?php

use Illuminate\Support\Facades\Route;
use Mansoor\FilamentSocialWall\Http\Controllers\SocialAccountController;
use Mansoor\FilamentSocialWall\Services\YouTube as ServicesYouTube;

Route::get('test', function () {
    $y = new ServicesYouTube;
    dd($y->getVideoList());
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/social/{provider}/redirect', [SocialAccountController::class, 'redirectToProvider'])
        ->name('social.provider.redirect');

    Route::get('/social/{provider}/callback', [SocialAccountController::class, 'handleProviderCallback'])
        ->name('social.provider.callback');
});
