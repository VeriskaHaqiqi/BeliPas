<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\Market;
use App\Models\PriceRecord;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalCommodities' => Commodity::count(),
            'activeCommodities' => Commodity::where('is_active', true)->count(),
            'totalMarkets' => Market::count(),
            'totalPrices' => PriceRecord::count(),
            'totalUmkmUsers' => User::where('role', 'user')->count(),
            'latestPrices' => PriceRecord::with([
                'commodity',
                'market',
            ])
                ->orderByDesc('price_date')
                ->orderByDesc('id')
                ->limit(5)
                ->get(),
        ]);
    }
}
