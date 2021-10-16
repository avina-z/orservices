<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

   public function callback()
   {
      $socialuser = Socialite::driver('facebook')->user();
      $user = User::where('email', $socialuser->email)->first();
      // dd($user);

      try {
            //Auth::login($user, true);   
            Auth::loginUsingId($user->id, true);
            return redirect()->intended('home');
            
        } catch (Throwable $th) {
            return Redirect::back()->withErrors(['global' => 'This user is not activated', 'activate_contact' => 1]);
        }
        return Redirect::back()->withErrors(['global' => 'Login problem please contact the administrator']);
   }
}
