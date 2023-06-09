<?php

namespace Mansoor\FilamentSocialWall\Http\Controllers;

use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Services\Facebook;

class SocialAccountController extends Controller
{
    public function redirectToProvider(Request $request, SocialProviderName $provider)
    {
        $provider = $provider === SocialProviderName::Instagram
            ? SocialProviderName::Facebook
            : $provider;

        $socialite = Socialite::driver($provider->value);

        // if ($provider === SocialProviderName::Twitter) {
        //     $socialite->scopes(['offline.access', 'users.read', 'tweet.read']);
        // }

        if ($provider === SocialProviderName::Google) {
            $socialite
                ->scopes(['https://www.googleapis.com/auth/youtube.readonly'])
                ->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
        }

        if ($provider === SocialProviderName::Facebook) {
            $socialite
                ->usingGraphVersion('v17.0')
                ->scopes([
                    'pages_show_list',
                    'pages_read_user_content',
                    'pages_manage_metadata',
                    'pages_read_engagement ',
                    'instagram_basic',
                    'business_management', // we need this to access page/insta accounts that are type=business
                ]);
        }

        return $socialite->redirect();
    }

    public function handleProviderCallback(Request $request, SocialProviderName $provider)
    {
        /**
         * TODO: \App\Models\Website::current() makes plugin not reusable
         */
        $websiteId = \App\Models\Website::current()?->id;

        try {
            $socialAccount = Socialite::driver($provider->value)->user();
        } catch (\Throwable $th) {
            Notification::make()
                ->danger()
                ->title("Could not connect {$provider->name} account!")
                ->body('Please try again or contact Admin.')
                ->send();

            return redirect("/admin/websites/{$websiteId}/edit");
        }

        SocialProvider::updateOrCreate(
            [
                'website_id' => $websiteId,
                'provider_name' => $provider,
            ],
            [
                'provider_user_id' => $socialAccount->id,
                'token' => $socialAccount->token,
                'refresh_token' => $socialAccount->refreshToken,
                'token_secret' => $socialAccount->tokenSecret,
            ]
        );

        // TODO: create a provider in instagram if
        // $facebook->getUserPermissions() code does not work due to invalid token, may be session and cookes are not set yet.
        // Add ->state(['provider' => 'fb']) and check if its set in request?

        // if ($provider === SocialProviderName::Facebook) {
        //     $facebook = new Facebook;

        //     if ($facebook->getUserPermissions()->contains('instagram_basic')) {
        //         SocialProvider::updateOrCreate([
        //             'website_id' => $websiteId,
        //             'provider_name' => SocialProviderName::Instagram,
        //         ]);
        //     }
        // }

        return redirect("/admin/websites/{$websiteId}/edit");
    }
}
