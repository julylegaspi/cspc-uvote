<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function signin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
     
            $googleUser = Socialite::driver('google')->user();
      
            $user = User::where('email', $googleUser->email)->first();
      
            if ($user)
            {
      
                if (!$user->is_active)
                {
                    return "<h1>Error: Inactive user. Contact system administrator.</h1>";
                }

                Auth::login($user);
     
                if ($user->isAdmin())
                {
                    return redirect('/admin');
                }

                return redirect('/');
      
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => 'password',
                    'is_admin' => false,
                ]);
     
                Auth::login($newUser);
      
                return redirect('/');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
