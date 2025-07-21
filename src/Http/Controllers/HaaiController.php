<?php

namespace Biigle\Modules\AuthHaai\Http\Controllers;

use Biigle\User;
use Biigle\Http\Controllers\Controller;
use Biigle\Modules\AuthHaai\HelmholtzId;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class HaaiController extends Controller
{
    /**
     * Redirect to the authentication provider
     *
     * @return mixed
     */
    public function redirect()
    {
        return Socialite::driver('haai')->redirect();
    }

    /**
     * Handle the authentication response
     *
     * @param Request $request
     * @return mixed
     */
    public function callback(Request $request)
    {
        try {
            $user = Socialite::driver('haai')->user();
        } catch (Exception $e) {
            $route = $request->user() ? 'settings-authentication' : 'login';

            return redirect()
                ->route($route)
                ->withErrors(['haai-id' => 'There was an unexpected error. Please try again.']);
        }

        $lslId = HelmholtzId::with('user')->find($user->id);

        if ($request->user()) {
            // Case: The authenticated user wants to connect the account with Helmholtz AAI.
            if (!$lslId) {
                HelmholtzId::create([
                    'id' => $user->id,
                    'user_id' => $request->user()->id,
                ]);

                return redirect()->route('settings-authentication')
                    ->with('message', 'Your account is now connected to Helmholtz AAI.')
                    ->with('messageType', 'success');

            // Case: The authenticated user already connected their account with Helmholtz AAI.
            } elseif ($lslId->user_id === $request->user()->id) {
                return redirect()->route('settings-authentication');

            // Case: Another user already connected their account with Helmholtz AAI.
            } else {
                return redirect()
                    ->route('settings-authentication')
                    ->withErrors(['haai-id' => 'The Helmholtz ID is already connected to another account.']);
            }
        }

        // Case: The user wants to log in with Helmholtz AAI
        if ($lslId) {
            Auth::login($lslId->user);

            return redirect()->route('home');
        }

        // Case: A new user wants to register using Helmholtz AAI.
        if (config('biigle.user_registration')) {
            $request->session()->put('haai-token', $user->token);

            return redirect()->route('haai-register-form');
        }

        // Case: The account exists but must be connected first.
        if (User::where('email', $user->email)->exists()) {
            return redirect()
                ->route('login')
                ->withErrors(['haai-id' => 'The email has already been taken. You can connect your existing account to Helmholtz AAI in the account authorization settings.']);
        }

        // Case: The account does not exist yet and new registrations are disabled.
        return redirect()
            ->route('login')
            ->withErrors(['haai-id' => 'The user does not exist and new registrations are disabled.']);

    }
}
