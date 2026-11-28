<?php

namespace App\Services;

use App\Models\Commodity;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class UserWatchlistService
{
    public static function isBackedByDatabase(): bool
    {
        return Schema::hasTable('user_watchlists')
            && UserMarketDataService::hasLiveCommodityCatalog();
    }

    /**
     * Return tracked commodity codes for the given user.
     *
     * @param  array<int, array<string, mixed>>  $allCommodities
     * @return array<int, string>
     */
    public static function trackedCodes(?User $user, array $allCommodities): array
    {
        if ($user && self::isBackedByDatabase()) {
            $savedCodes = $user->watchedCommodities()
                ->where('commodities.is_active', true)
                ->orderBy('commodities.id')
                ->pluck('commodities.code')
                ->all();

            if ($savedCodes !== []) {
                return $savedCodes;
            }
        }

        return array_values(array_column($allCommodities, 'id'));
    }

    /**
     * Sync the authenticated user's watched commodities.
     *
     * @param  array<int, string>  $codes
     * @return array<int, string>
     */
    public static function syncForUser(User $user, array $codes): array
    {
        $commodities = Commodity::query()
            ->whereIn('code', $codes)
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'code']);

        $user->watchedCommodities()->sync($commodities->pluck('id')->all());

        return $commodities->pluck('code')->all();
    }
}
