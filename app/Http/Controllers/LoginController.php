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
        $data = $request->validated();

        $remember = false;

        if (isset($data['remember']))
        {
            $remember = true;
        }

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
