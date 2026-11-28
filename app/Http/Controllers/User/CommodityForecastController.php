<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserMarketDataService;
use App\Services\UserProfilePresenter;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CommodityForecastController extends Controller
{
    public function __invoke(Request $request, string $code): View
    {
        $commodity = UserMarketDataService::detail($code);

        abort_unless($commodity, 404);

        return view('user.commodity-forecast', [
            'profile' => UserProfilePresenter::forUser($request->user()),
            'activeNav' => 'commodities',
            'detailCode' => $code,
            'commodity' => $commodity,
            'commodities' => UserMarketDataService::commodities(),
        ]);
    }
}
