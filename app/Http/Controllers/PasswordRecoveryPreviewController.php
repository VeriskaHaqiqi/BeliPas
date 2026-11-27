<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PasswordRecoveryPreviewController extends Controller
{
    public function forgot(): View
    {
        return $this->preview('auth.recovery.forgot', 'Lupa Password');
    }

    public function verify(): View
    {
        return $this->preview('auth.recovery.verify', 'Kode Verifikasi');
    }

    public function reset(): View
    {
        return $this->preview('auth.recovery.reset', 'Password Baru');
    }

    public function updated(): View
    {
        return $this->preview('auth.recovery.updated', 'Konfirmasi Pemulihan');
    }

    private function preview(string $view, string $title): View
    {
        abort_unless(app()->environment('local'), 404);

        return view($view, ['recoveryTitle' => $title]);
    }
}
