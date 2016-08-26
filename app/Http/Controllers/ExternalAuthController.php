<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Socialite;

class ExternalAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $userInfo = Socialite::driver($provider)->user();

        $user = User::where($provider, '=', $userInfo->id)->orWhere('email', '=', $userInfo->email)->first();

        if(!$user) {
            $user = User::create([
                'name' => $userInfo->name,
                'email' => $userInfo->email,
                $provider => $userInfo->id,
                'avatar' => $userInfo->avatar
            ]);
        } else {
            $user->update([
                'avatar' => $userInfo->avatar
            ]);
        }

        Auth::login($user);

        return redirect('/home');
    }
}
