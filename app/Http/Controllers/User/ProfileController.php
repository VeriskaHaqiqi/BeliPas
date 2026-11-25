<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    public function __invoke(): View
    {
        $dashboard = UserDashboardDemoData::dashboard();

        return view('user.profile', [
            'profile' => $dashboard['profile'],
            'commodities' => $dashboard['commodities'],
            'activeNav' => 'profile',
        ]);
    }
}
