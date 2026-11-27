<?php

namespace App\Http\Controllers;

use App\Data\PublicLandingPageData;
use App\Data\UserDashboardDemoData;
use Illuminate\View\View;

final class PublicLandingController extends Controller
{
    public function __invoke(): View
    {
        $commodities = UserDashboardDemoData::commodities();
        $previewIds = ['cabai-rawit-merah', 'daging-ayam-broiler', 'minyak-goreng-curah'];

        return view('public.landing', [
            ...PublicLandingPageData::content(),
            'previewCommodities' => array_map(
                fn (string $id): array => current(array_filter(
                    $commodities,
                    fn (array $commodity): bool => $commodity['id'] === $id,
                )),
                $previewIds,
            ),
        ]);
    }
}
