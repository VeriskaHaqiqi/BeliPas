<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthRedirectService
{
    /**
     * Resolve a safe redirect destination based on the user's role.
     * Admin redirect target is deferred until the Admin module routes are available.
     */
    public function redirectFor(User $user, bool $useIntended = true): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()
                ->route('landing')
                ->with('status', 'Login admin berhasil. Halaman Dashboard Admin akan dihubungkan setelah modul Admin tersedia.');
        }

        $target = route('user.dashboard');

        return $useIntended
            ? redirect()->intended($target)
            : redirect()->to($target);
    }
}
