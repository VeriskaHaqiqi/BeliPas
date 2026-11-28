<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserMarketDataService;
use App\Services\UserProfilePresenter;
use App\Services\UserWatchlistService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class SettingsController extends Controller
{
    public function __invoke(Request $request): View
    {
        $commodities = UserMarketDataService::commodities();
        $initialTrackedIds = UserWatchlistService::trackedCodes($request->user(), $commodities);

        return view('user.settings', [
            'profile' => UserProfilePresenter::forUser($request->user()),
            'activeNav' => 'settings',
            'commodities' => $commodities,
            'initialTrackedIds' => $initialTrackedIds,
            'watchlistPersisted' => UserWatchlistService::isBackedByDatabase(),
            'detailCode' => $commodities[0]['id'] ?? 'cabai-rawit-merah',
        ]);
    }
}
