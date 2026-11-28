<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuthRedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request, AuthRedirectService $redirectService): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $validated = $request->validated();

        $credentials = [
            'email' => strtolower(trim($validated['identity'])),
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->hitRateLimiter();

            return back()
                ->withInput($request->only('identity', 'remember'))
                ->withErrors([
                    'identity' => 'Email atau password yang Anda masukkan tidak sesuai.',
                ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('identity'))
                ->withErrors([
                    'identity' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ]);
        }

        $request->clearRateLimiter();
        $request->session()->regenerate();

        return $redirectService->redirectFor($user);
    }
}
