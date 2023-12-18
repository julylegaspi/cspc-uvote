<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
     /**
     * Handle an authentication attempt.
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {

        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->onlyInput('username');
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $remember = false;

        if (isset($request->remember))
        {
            $remember = true;
        }

        Auth::login($user, $remember);

        return $this->authenticated($request, $user);

        // $data = $request->validated();

        // $remember = false;

        // if (isset($data['remember']))
        // {
        //     $remember = true;
        // }

        // if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
        //     $request->session()->regenerate();
 
        //     return redirect()->intended('dashboard');
        // }
 
        // return back()->withErrors([
        //     'username' => 'The provided credentials do not match our records.',
        // ])->onlyInput('username');
    }

    protected function authenticated(Request $request, $user) 
    {
        return redirect()->intended();
    }
}
