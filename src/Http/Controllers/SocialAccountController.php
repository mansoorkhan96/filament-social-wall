<?php

namespace Mansoor\FilamentSocialWall\Http\Controllers;

use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Mansoor\FilamentSocialWall\Enums\SocialProviderName;
use Mansoor\FilamentSocialWall\SocialProvider;

class SocialAccountController extends Controller
{
    public function redirectToProvider(Request $request, string $provider)
    {
        $socialite = Socialite::driver($provider);

        if ($provider === SocialProviderName::Google) {
            $socialite
                ->scopes(['https://www.googleapis.com/auth/youtube.readonly'])
                ->with(['access_type' => 'offline', 'prompt' => 'consent select_account']);
        }

        return $socialite->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        /**
         * TODO: \App\Models\Website::current() makes plugin not reusable
         */
        $websiteId = \App\Models\Website::current()?->id;

        try {
            $socialAccount = Socialite::driver($provider)->user();
        } catch (\Throwable $th) {
            $socialProviderName = ucfirst($provider);

            Notification::make()
                ->danger()
                ->title("Could not connect {$socialProviderName} account!")
                ->body('Please try again or contact Admin.')
                ->send();

            return redirect("/admin/websites/{$websiteId}/edit");
        }

        SocialProvider::updateOrCreate(
            [
                'website_id' => $websiteId,
                'provider_name' => SocialProviderName::tryFrom($provider),
            ],
            ['token' => $socialAccount->token, 'refresh_token' => $socialAccount->refreshToken]
        );

        return redirect("/admin/websites/{$websiteId}/edit");
    }
}
