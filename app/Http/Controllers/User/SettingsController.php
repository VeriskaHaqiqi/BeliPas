<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class SettingsController extends Controller
{
    public function __invoke(): View
    {
        $dashboard = UserDashboardDemoData::dashboard();

        return view('user.settings', [
            'profile' => $dashboard['profile'],
            'activeNav' => 'settings',
            'commodities' => $dashboard['commodities'],
            'initialTrackedIds' => array_column($dashboard['commodities'], 'id'),
        ]);
    }
}
