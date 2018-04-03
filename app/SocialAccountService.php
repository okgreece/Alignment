<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $routeName = request()->route()->getName();
        if ($routeName == "github.callback"){
            $provider = 'github';
        }
        else if ($routeName == 'google.callback'){
            $provider = "google";
        }
        else if ($routeName == 'facebook.callback'){
            $provider = "facebook";
        }
        $account = SocialAccount::whereProvider($provider)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                try{
                    $user = User::create([
                                'email' => $providerUser->offsetExists("email") ? $providerUser->getEmail() : "no email",
                                'name' => $providerUser->offsetExists("name") ? $providerUser->getName() : "default name",
                                'avatar' => $providerUser->offsetExists("avatar") ? $providerUser->getAvatar() : "",
                            ]);                    
                } catch (Exception $ex) {
                    return $ex;
                }                
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}