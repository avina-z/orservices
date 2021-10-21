<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Log;
use App\Model\Role;

class SocialAccountService
{

    public function findOrCreate(ProviderUser $providerUser, $provider)
    {

        $account = LinkedSocialAccount::whereProviderName($provider)
                   ->whereProviderId($providerUser->getId())
                   ->first();

        if ($account) {
            //Log::info('SocialAccountService: '.$account->user);
            return $account->user;
        } else {
        
        $user = User::whereEmail($providerUser->getEmail())->first();


        if (! $user) {
            $user = User::create([  
                'email' => $providerUser->getEmail(),
                'first_name'  => $providerUser->getName(),
                'role_id' => Role::where('name', '=', 'user')->first()->id,
            ]);
        }

        $user->accounts()->create([
            'provider_id'   => $providerUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;

        }

    }

    public function findAccount($email)
    {
        $account = LinkedSocialAccount::whereUserId( User::whereEmail($email)->first()->id)->first();
        return $account;
    }
}