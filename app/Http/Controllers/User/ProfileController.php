<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserMarketDataService;
use App\Services\UserProfilePresenter;
use App\Services\UserWatchlistService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProfileController extends Controller
{
    public function __invoke(Request $request): View
    {
        $commodities = UserMarketDataService::commodities();
        $trackedCodes = UserWatchlistService::trackedCodes($request->user(), $commodities);
        $trackedCommodities = array_values(array_filter(
            $commodities,
            fn (array $item): bool => in_array($item['id'], $trackedCodes, true),
        ));

        return view('user.profile', [
            'profile' => UserProfilePresenter::forUser($request->user()),
            'commodities' => $trackedCommodities,
            'activeNav' => 'profile',
            'detailCode' => $commodities[0]['id'] ?? 'cabai-rawit-merah',
        ]);
    }
}
