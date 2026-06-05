<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // --- LÓGICA GOOGLE ---
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(Str::random(16)),
                ]);
                Auth::login($user);
            }
            return redirect($this->redirectTo);
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Error con Google.');
        }
    }

    // --- LÓGICA GITHUB ---
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            $user = User::where('email', $githubUser->getEmail())->first();
            
            if ($user) {
                Auth::login($user);
            } else {
                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'email' => $githubUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    // 'github_id' => $githubUser->getId(), // Descomenta solo si tienes la columna en tu BD
                ]);
                Auth::login($user);
            }
            return redirect($this->redirectTo);
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Error con GitHub.');
        }
    }
}