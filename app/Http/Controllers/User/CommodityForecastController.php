<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class CommodityForecastController extends Controller
{
    public function __invoke(string $code): View
    {
        $commodity = UserDashboardDemoData::detail($code);

        abort_unless($commodity, 404);

        return view('user.commodity-forecast', [
            'profile' => UserDashboardDemoData::dashboard()['profile'],
            'activeNav' => 'commodities',
            'detailCode' => $code,
            'commodity' => $commodity,
            'commodities' => UserDashboardDemoData::commodities(),
        ]);
    }
}
