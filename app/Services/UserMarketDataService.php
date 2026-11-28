<?php

namespace App\Services;

use App\Data\UserDashboardDemoData;
use App\Models\Commodity;
use App\Models\PriceRecord;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class UserMarketDataService
{
    /**
     * Build dashboard payload from database when active commodities exist,
     * otherwise fall back to labeled demo fixtures.
     *
     * @return array<string, mixed>
     */
    public static function dashboard(?User $user = null): array
    {
        $profile = UserProfilePresenter::forUser($user);

        if (self::hasLiveCommodityCatalog()) {
            $commodities = self::databaseCommodities();
            $signalCounts = array_fill_keys(['BUY NOW', 'WAIT', 'MONITOR'], 0);

            foreach ($commodities as $item) {
                if (isset($item['signal'], $signalCounts[$item['signal']])) {
                    $signalCounts[$item['signal']]++;
                }
            }

            $latestRecord = PriceRecord::query()
                ->with('market')
                ->whereHas('commodity', fn ($q) => $q->where('is_active', true))
                ->orderByDesc('price_date')
                ->orderByDesc('id')
                ->first();

            $sources = PriceRecord::query()
                ->whereHas('commodity', fn ($q) => $q->where('is_active', true))
                ->distinct()
                ->pluck('source_name')
                ->filter()
                ->take(3)
                ->implode(', ');

            return [
                'data_source' => 'database',
                'profile' => $profile,
                'market' => $latestRecord?->market?->name ?? 'Belum ada pasar acuan',
                'updated_at_label' => $latestRecord?->price_date?->translatedFormat('d M Y') ?? 'Belum ada pembaruan harga',
                'updated_sources_label' => $sources !== '' ? $sources : 'belum ada sumber harga aktual',
                'commodities' => $commodities,
                'signal_counts' => $signalCounts,
                'demo_savings' => null,
            ];
        }

        $demo = UserDashboardDemoData::dashboard();
        $demo['profile'] = $profile;
        $demo['data_source'] = 'demo';

        return $demo;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function commodities(): array
    {
        if (self::hasLiveCommodityCatalog()) {
            return self::databaseCommodities();
        }

        return UserDashboardDemoData::commodities();
    }

    /**
     * Build commodity detail + historical price series for the given code.
     *
     * @return array<string, mixed>|null
     */
    public static function detail(string $code): ?array
    {
        if (self::hasLiveCommodityCatalog()) {
            $commodity = Commodity::query()
                ->where('code', $code)
                ->where('is_active', true)
                ->first();

            if (! $commodity) {
                return null;
            }

            $summary = self::mapCommodity($commodity);
            $latestMarketId = PriceRecord::query()
                ->where('commodity_id', $commodity->id)
                ->orderByDesc('price_date')
                ->orderByDesc('id')
                ->value('market_id');

            $historyRecords = $latestMarketId
                ? PriceRecord::query()
                    ->where('commodity_id', $commodity->id)
                    ->where('market_id', $latestMarketId)
                    ->orderByDesc('price_date')
                    ->orderByDesc('id')
                    ->limit(14)
                    ->get()
                    ->reverse()
                    ->values()
                : collect();

            $history = $historyRecords->map(fn (PriceRecord $record): array => [
                'label' => $record->price_date->translatedFormat('d M'),
                'value' => (float) $record->price,
            ])->all();

            return [
                ...$summary,
                'description' => 'Pantau pergerakan harga aktual dan riwayat harga komoditas untuk membantu perencanaan belanja usaha Anda.',
                'updated_at_label' => $summary['updated_at_label'] ?? 'Belum ada pembaruan',
                'history' => $history,
                'forecast' => [],
            ];
        }

        $demo = UserDashboardDemoData::detail($code);
        if ($demo !== null) {
            $demo['data_source'] = 'demo';
        }

        return $demo;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function related(string $code): array
    {
        return array_values(array_filter(
            self::commodities(),
            fn (array $item): bool => $item['id'] !== $code,
        ));
    }

    public static function hasLiveCommodityCatalog(): bool
    {
        if (! Schema::hasTable('commodities') || ! Schema::hasTable('price_records')) {
            return false;
        }

        return Commodity::query()->where('is_active', true)->exists();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private static function databaseCommodities(): array
    {
        /** @var Collection<int, Commodity> $commodities */
        $commodities = Commodity::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return $commodities
            ->map(fn (Commodity $commodity): array => self::mapCommodity($commodity))
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private static function mapCommodity(Commodity $commodity): array
    {
        $latest = PriceRecord::query()
            ->with('market')
            ->where('commodity_id', $commodity->id)
            ->orderByDesc('price_date')
            ->orderByDesc('id')
            ->first();

        $previous = $latest
            ? PriceRecord::query()
                ->where('commodity_id', $commodity->id)
                ->where('market_id', $latest->market_id)
                ->where(function ($query) use ($latest) {
                    $query->where('price_date', '<', $latest->price_date)
                        ->orWhere(function ($sub) use ($latest) {
                            $sub->where('price_date', $latest->price_date)
                                ->where('id', '<', $latest->id);
                        });
                })
                ->orderByDesc('price_date')
                ->orderByDesc('id')
                ->first()
            : null;

        $latestPrice = $latest ? (float) $latest->price : null;
        $previousPrice = $previous ? (float) $previous->price : null;
        $nominalDelta = ($latestPrice !== null && $previousPrice !== null)
            ? $latestPrice - $previousPrice
            : null;
        $percentDelta = ($nominalDelta !== null && $previousPrice > 0)
            ? ($nominalDelta / $previousPrice) * 100
            : null;

        [$category, $icon, $iconTone, $chart] = self::visualMeta($commodity);

        $deltaTone = 'monitor';
        $deltaIcon = 'dashboard-price-change.svg';
        $deltaText = 'Belum ada data harga aktual';
        $trendText = 'Belum tersedia';
        $trendTone = 'monitor';

        if ($latestPrice !== null && $nominalDelta === null) {
            $deltaText = 'Data awal (belum ada harga pembanding)';
            $trendText = 'Data awal';
        } elseif ($nominalDelta !== null) {
            $absNominal = number_format(abs($nominalDelta), 0, ',', '.');
            $percentFormatted = number_format(abs($percentDelta ?? 0), 1, ',', '.');

            if ($nominalDelta > 0) {
                $deltaTone = 'buy';
                $deltaIcon = 'dashboard-price-change-up.svg';
                $deltaText = "naik Rp{$absNominal} dari sebelumnya (+{$percentFormatted}%)";
                $trendText = 'Cenderung Naik';
                $trendTone = 'buy';
            } elseif ($nominalDelta < 0) {
                $deltaTone = 'wait';
                $deltaIcon = 'dashboard-price-change-down.svg';
                $deltaText = "turun Rp{$absNominal} dari sebelumnya (-{$percentFormatted}%)";
                $trendText = 'Cenderung Turun';
                $trendTone = 'wait';
            } else {
                $deltaText = 'stabil (selisih Rp0 dari sebelumnya)';
                $trendText = 'Konstan';
            }
        }

        return [
            'id' => $commodity->code,
            'commodity_id' => $commodity->id,
            'name' => $commodity->name,
            'category' => $category,
            'market' => $latest?->market?->name ?? 'Pasar belum ditentukan',
            'icon' => $icon,
            'icon_tone' => $iconTone,
            'signal' => null,
            'signal_icon' => 'dashboard-trend-eye.svg',
            'signal_detail' => 'Prakiraan 1–7 hari menunggu modul ML',
            'signal_direction' => 'stable',
            'price' => $latestPrice !== null ? number_format($latestPrice, 0, ',', '.') : null,
            'price_value' => $latestPrice,
            'previous_price' => $previousPrice !== null ? number_format($previousPrice, 0, ',', '.') : null,
            'previous_price_value' => $previousPrice,
            'nominal_delta' => $nominalDelta,
            'percent_delta' => $percentDelta,
            'unit' => $commodity->unit,
            'delta_icon' => $deltaIcon,
            'delta_tone' => $deltaTone,
            'delta' => $deltaText,
            'trend' => $trendText,
            'trend_tone' => $trendTone,
            'chart' => $chart,
            'reason' => $latestPrice !== null
                ? 'Harga aktual tercatat dari database. Sinyal rekomendasi otomatis aktif setelah hasil prakiraan tersedia.'
                : 'Belum ada catatan harga aktual untuk komoditas ini.',
            'footnote' => $latest?->source_name ?? 'Menunggu data harga',
            'updated_at_label' => $latest?->price_date?->translatedFormat('d M Y') ?? 'Belum tersedia',
            'data_source' => 'database',
        ];
    }

    /**
     * @return array{0: string, 1: string, 2: string, 3: string}
     */
    private static function visualMeta(Commodity $commodity): array
    {
        $haystack = strtoupper($commodity->code.' '.$commodity->name);

        return match (true) {
            str_contains($haystack, 'CABAI') => ['Cabai', 'dashboard-chili.svg', 'buy', 'dashboard-chart-chili.svg'],
            str_contains($haystack, 'BAWANG') => ['Bawang', 'dashboard-onion.svg', 'onion', 'dashboard-chart-onion.svg'],
            str_contains($haystack, 'MINYAK') => ['Minyak Goreng', 'dashboard-oil.svg', 'oil', 'dashboard-chart-oil.svg'],
            str_contains($haystack, 'AYAM') => ['Ayam', 'dashboard-chicken.svg', 'chicken', 'dashboard-chart-chicken.svg'],
            str_contains($haystack, 'TELUR') => ['Telur', 'dashboard-eggs.svg', 'eggs', 'dashboard-chart-eggs.svg'],
            default => ['Lainnya', 'dashboard-nav-commodities.svg', 'wait', 'dashboard-chart-onion.svg'],
        };
    }
}
