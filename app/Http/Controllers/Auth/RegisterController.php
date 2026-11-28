<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthRedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function show(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, AuthRedirectService $redirectService): RedirectResponse
    {
        $validated = $request->validated();

        $attributes = [
            'name' => trim($validated['owner_name']),
            'email' => strtolower(trim($validated['identity'])),
            'password' => $validated['password'],
        ];

        if (Schema::hasColumn('users', 'business_name')) {
            $attributes['business_name'] = trim($validated['business_name']);
        }

        $user = new User($attributes);
        $user->role = 'user';
        $user->is_active = true;
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return $redirectService->redirectFor($user, useIntended: false);
    }
}
