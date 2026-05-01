<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller {
    // Login 
    public function showLogin(): View {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Las credenciales no son correctas.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('vacations.index'))
            ->with('success', '¡Bienvenido, ' . Auth::user()->name . '!');
    }

    // Logout
    public function logout(Request $request): RedirectResponse {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}