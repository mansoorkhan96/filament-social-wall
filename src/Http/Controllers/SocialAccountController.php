<?php

namespace Mansoor\FilamentSocialWall\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Filament\Notifications\Notification;
use Laravel\Socialite\Facades\Socialite;
use Mansoor\FilamentSocialWall\Models\SocialProvider;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;

class SocialAccountController extends Controller
{
    public function redirectToProvider(Request $request, SocialProviderName $provider)
    {
        $socialite = Socialite::driver($provider->value);

        if ($provider === SocialProviderName::Google) {
            $socialite
                ->scopes(['https://www.googleapis.com/auth/youtube.readonly'])
                ->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
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
            ['token' => $socialAccount->token, 'refresh_token' => $socialAccount->refreshToken]
        );

        return redirect("/admin/websites/{$websiteId}/edit");
    }
}
