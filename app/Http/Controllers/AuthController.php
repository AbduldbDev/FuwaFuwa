<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    protected AuthService $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function show()
    {
        return view('Auth/login');
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $this->authService->login($request->validated());

            return redirect()
                ->intended('/')
                ->with('success', 'Welcome back!');
        } catch (\Throwable $e) {
            return back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }

    public function showForm()
    {
        $user = $this->authService->getUserFromSession();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Session expired. Please login again.'
            ]);
        }

        return view('Auth/firstreset', compact('user'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = $this->authService->getUserFromSession();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Session expired. Please login again.'
            ]);
        }

        $this->authService->resetPassword($user, $request->password);

        return redirect()->route('dashboard.index')
            ->with('success', 'Password updated successfully!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
