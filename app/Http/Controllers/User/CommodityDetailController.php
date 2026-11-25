<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class CommodityDetailController extends Controller
{
    public function __invoke(string $code): View
    {
        $commodity = UserDashboardDemoData::detail($code);

        abort_unless($commodity, 404);

        return view('user.commodity-detail', [
            'profile' => UserDashboardDemoData::dashboard()['profile'],
            'commodity' => $commodity,
            'activeNav' => 'commodities',
            'detailCode' => $code,
            'relatedCommodities' => array_values(array_filter(
                UserDashboardDemoData::commodities(),
                fn (array $item): bool => $item['id'] !== $code,
            )),
        ]);
    }
}
