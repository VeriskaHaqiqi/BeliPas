<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserMarketDataService;
use App\Services\UserProfilePresenter;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CommodityDetailController extends Controller
{
    public function __invoke(Request $request, string $code): View
    {
        $commodity = UserMarketDataService::detail($code);

        abort_unless($commodity, 404);

        return view('user.commodity-detail', [
            'profile' => UserProfilePresenter::forUser($request->user()),
            'commodity' => $commodity,
            'activeNav' => 'commodities',
            'detailCode' => $code,
            'relatedCommodities' => UserMarketDataService::related($code),
        ]);
    }
}
