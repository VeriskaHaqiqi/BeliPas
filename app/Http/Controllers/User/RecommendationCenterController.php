<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class RecommendationCenterController extends Controller
{
    public function __invoke(): View
    {
        return view('user.recommendations', [
            'profile' => UserDashboardDemoData::dashboard()['profile'],
            'activeNav' => 'recommendations',
            'detailCode' => 'cabai-rawit-merah',
            ...UserDashboardDemoData::recommendations(),
        ]);
    }
}
