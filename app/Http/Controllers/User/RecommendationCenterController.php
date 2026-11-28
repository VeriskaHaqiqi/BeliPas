<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use App\Services\UserMarketDataService;
use App\Services\UserProfilePresenter;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class RecommendationCenterController extends Controller
{
    public function __invoke(Request $request): View
    {
        $commodities = UserMarketDataService::commodities();
        $firstCode = $commodities[0]['id'] ?? 'cabai-rawit-merah';

        return view('user.recommendations', [
            'profile' => UserProfilePresenter::forUser($request->user()),
            'activeNav' => 'recommendations',
            'detailCode' => $firstCode,
            ...UserDashboardDemoData::recommendations(),
        ]);
    }
}
