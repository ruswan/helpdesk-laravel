<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialiteUser;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider);

        // login user
        Auth()->login($authUser, true);

        // setelah login redirect ke dashboard
        return redirect()->route('filament.pages.dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // Get Social Account
        $socialAccount = SocialiteUser::where('provider_id', $socialUser->id)
            ->where('provider', $provider)
            ->first();

        // If it already exists.
        if ($socialAccount) {
            // return user
            return $socialAccount->user;
            // If there isn't yet.
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        // If there are no users.
        if (!$user) {
            // Create a new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'email_verified_at' => Carbon::now()->timestamp,
            ]);
        }

        // Buat a new socialite user
        $user->socialiteUsers()->create([
            'provider_id' => $socialUser->getId(),
            'provider' => $provider,
        ]);

        // return user
        return $user;
    }
}
