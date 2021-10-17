<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginGoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->setScopes(['openid', 'email'])->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $socialuser = Socialite::driver('google')->stateless()->user();
            //dd($socialuser);
        } catch (\Exception $e) {
           return redirect('/login');
        }

       $user = User::where('email', $socialuser->email)->first();
       //dd($user)
       if ($user != null) {
        try {
                Auth::loginUsingId($user->id, true);
                return redirect()->intended('home');
                
            } catch (Throwable $th) {
                return Redirect::back()->withErrors(['global' => 'This user is not activated', 'activate_contact' => 1]);
            }
       }
        return Redirect::back()->withErrors(['global' => 'Login problem please contact the administrator']);
    }
}
