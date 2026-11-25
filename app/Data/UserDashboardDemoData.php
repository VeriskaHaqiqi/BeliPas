<?php

namespace App\Data;

/**
 * Static visual fixture transcribed from the BeliPas dashboard design.
 * These values are illustrative only and must never be treated as live market data.
 */
final class UserDashboardDemoData
{
    public static function dashboard(): array
    {
        $commodities = self::commodities();
        $signalCounts = array_fill_keys(['BUY NOW', 'WAIT', 'MONITOR'], 0);

        foreach ($commodities as $commodity) {
            $signalCounts[$commodity['signal']]++;
        }

        return [
            'profile' => [
                'owner_name' => 'Bu Tya',
                'business_name' => 'Dapur Bu Tya',
                'business_type' => 'Warung & Catering',
                'contact' => 'tya@example.com',
                'registered_at_label' => '12 Okt 2026',
                'avatar_initials' => 'DT',
            ],
            'market' => 'Surabaya & Sekitarnya',
            'updated_at_label' => 'Hari ini, 06:00 WIB',
            'updated_sources_label' => 'Pasar Pucang Anom dan Pasar Turi',
            'commodities' => $commodities,
            'signal_counts' => $signalCounts,
            'demo_savings' => '340.000',
        ];
    }

    public static function commodities(): array
    {
        return [
            [
                'id' => 'cabai-rawit-merah',
                'name' => 'Cabai Rawit Merah',
                'category' => 'Cabai',
                'market' => 'Pasar Manyar · Grade A',
                'icon' => 'dashboard-chili.svg',
                'icon_tone' => 'buy',
                'signal' => 'BUY NOW',
                'signal_icon' => 'dashboard-estimate-up.svg',
                'signal_detail' => '+8% estimasi naik 3 hari ke depan',
                'signal_direction' => 'up',
                'price' => '50.000',
                'unit' => 'kg',
                'delta_icon' => 'dashboard-price-change-up.svg',
                'delta_tone' => 'buy',
                'delta' => 'naik Rp2.000 dari kemarin (+4.1%)',
                'trend' => 'Tren Naik Cepat',
                'trend_tone' => 'buy',
                'chart' => 'dashboard-chart-chili.svg',
                'reason' => 'Beli sekarang untuk stok 3–5 hari ke depan, pasokan pasar sedang melambat akibat cuaca di sentra panen.',
                'footnote' => 'Stok Aman',
            ],
            [
                'id' => 'bawang-merah-brebes',
                'name' => 'Bawang Merah Brebes',
                'category' => 'Bawang',
                'market' => 'Pasar Turi · Sedang',
                'icon' => 'dashboard-onion.svg',
                'icon_tone' => 'onion',
                'signal' => 'MONITOR',
                'signal_icon' => 'dashboard-trend-eye.svg',
                'signal_detail' => 'Tren stabil · Fluktuasi rendah',
                'signal_direction' => 'stable',
                'price' => '36.000',
                'unit' => 'kg',
                'delta_icon' => 'dashboard-price-change.svg',
                'delta_tone' => 'monitor',
                'delta' => 'stabil (selisih Rp0 dari kemarin)',
                'trend' => 'Konstan',
                'trend_tone' => 'monitor',
                'chart' => 'dashboard-chart-onion.svg',
                'reason' => 'Harga di tingkat distributor stabil, belum ada lonjakan pasokan baru dari sentra Jawa Tengah.',
                'footnote' => 'Update 2 jam lalu',
            ],
            [
                'id' => 'minyak-goreng-curah',
                'name' => 'Minyak Goreng Curah',
                'category' => 'Minyak Goreng',
                'market' => 'Pasar Pucang Anom',
                'icon' => 'dashboard-oil.svg',
                'icon_tone' => 'oil',
                'signal' => 'MONITOR',
                'signal_icon' => 'dashboard-trend-eye.svg',
                'signal_detail' => 'Fluktuasi wajar · Pantau rutin',
                'signal_direction' => 'stable',
                'price' => '16.500',
                'unit' => 'liter',
                'delta_icon' => 'dashboard-oil-price-change.svg',
                'delta_tone' => 'monitor',
                'delta' => 'naik Rp200 dari kemarin (+1.2%)',
                'trend' => 'Sedikit Naik',
                'trend_tone' => 'monitor',
                'chart' => 'dashboard-chart-oil.svg',
                'reason' => 'Stok distributor mencukupi, beli secukupnya untuk konsumsi normal tanpa penimbunan berlebih.',
                'footnote' => 'DMO Normal',
            ],
            [
                'id' => 'daging-ayam-broiler',
                'name' => 'Daging Ayam Broiler',
                'category' => 'Ayam',
                'market' => 'Pasar Wonokromo · Karkas Utuh',
                'icon' => 'dashboard-chicken.svg',
                'icon_tone' => 'chicken',
                'signal' => 'WAIT',
                'signal_icon' => 'dashboard-trend-down.svg',
                'signal_detail' => 'Turun 5% minggu ini · Menuju titik terendah',
                'signal_direction' => 'down',
                'price' => '38.000',
                'unit' => 'kg',
                'delta_icon' => 'dashboard-price-change-down.svg',
                'delta_tone' => 'wait',
                'delta' => 'turun Rp1.500 dari kemarin (-3.8%)',
                'trend' => 'Tren Menurun',
                'trend_tone' => 'wait',
                'chart' => 'dashboard-chart-chicken.svg',
                'reason' => 'Tunda pembelian stok besar. Panen peternak lokal Jawa Barat melimpah pekan ini, potensi harga turun lagi.',
                'footnote' => 'Tunggu 1–2 hari',
            ],
            [
                'id' => 'telur-ayam-ras',
                'name' => 'Telur Ayam Ras',
                'category' => 'Telur',
                'market' => 'Pasar Kapasan · Curah Rak',
                'icon' => 'dashboard-eggs.svg',
                'icon_tone' => 'eggs',
                'signal' => 'WAIT',
                'signal_icon' => 'dashboard-trend-down.svg',
                'signal_detail' => 'Potensi hemat tambahan Rp1.000',
                'signal_direction' => 'down',
                'price' => '27.500',
                'unit' => 'kg',
                'delta_icon' => 'dashboard-price-change-down.svg',
                'delta_tone' => 'wait',
                'delta' => 'turun Rp500 dari kemarin (-1.8%)',
                'trend' => 'Turun Bertahap',
                'trend_tone' => 'wait',
                'chart' => 'dashboard-chart-eggs.svg',
                'reason' => 'Harga pakan jagung stabil dan pasokan kandang lancar, potensi turun lagi Rp1.000 dalam 48 jam.',
                'footnote' => 'Tahan Pembelian',
            ],
        ];
    }

    /**
     * View data for the recommendation center. A sample signal is exposed only
     * when the demo price is valid and all seven future forecast values exist.
     * The live RecommendationService contract will replace this demo adapter.
     */
    public static function recommendations(): array
    {
        $items = [];
        $counts = array_fill_keys(['BUY NOW', 'WAIT', 'MONITOR'], 0);

        foreach (self::commodities() as $commodity) {
            $detail = self::detail($commodity['id']);
            $currentPrice = (int) str_replace('.', '', $commodity['price']);
            $futureForecast = array_slice($detail['forecast'] ?? [], 1);
            $forecastIsComplete = $currentPrice > 0 && count($futureForecast) === 7;
            $forecastValues = [];

            foreach ($futureForecast as $forecast) {
                $forecastIsComplete = $forecastIsComplete
                    && isset($forecast['value'])
                    && is_numeric($forecast['value'])
                    && (float) $forecast['value'] > 0;

                if (isset($forecast['value']) && is_numeric($forecast['value'])) {
                    $forecastValues[] = (float) $forecast['value'];
                }
            }

            $averageForecast = $forecastIsComplete ? array_sum($forecastValues) / 7 : null;
            $expectedChangePercent = $forecastIsComplete
                ? (($averageForecast - $currentPrice) / $currentPrice) * 100
                : null;
            $signal = match (true) {
                !$forecastIsComplete => null,
                $expectedChangePercent >= 5.0 => 'BUY NOW',
                $expectedChangePercent <= -5.0 => 'WAIT',
                default => 'MONITOR',
            };

            if ($signal !== null) {
                $counts[$signal]++;
            }

            $recommendationReason = match ($signal) {
                'BUY NOW' => 'Rata-rata forecast demo 1–7 hari sekitar '.number_format($expectedChangePercent, 1, ',', '.').'% di atas harga sekarang. Pertimbangkan membeli sesuai kebutuhan usaha.',
                'WAIT' => 'Rata-rata forecast demo 1–7 hari sekitar '.number_format(abs($expectedChangePercent), 1, ',', '.').'% di bawah harga sekarang. Pertimbangkan menunda jika stok masih cukup.',
                'MONITOR' => 'Perubahan rata-rata forecast demo 1–7 hari berada di bawah ambang ±5%. Pantau pembaruan dan beli sesuai kebutuhan.',
                default => 'Forecast harga 1–7 hari belum tersedia atau belum tervalidasi.',
            };

            $items[] = [
                ...$commodity,
                'current_price_value' => $currentPrice,
                'recommendation_available' => $signal !== null,
                'recommendation' => $signal,
                'average_forecast_value' => $averageForecast,
                'expected_change_percent' => $expectedChangePercent,
                'forecast_3d_value' => $signal !== null ? $futureForecast[2]['value'] : null,
                'forecast_3d_change_percent' => $signal !== null ? ($futureForecast[2]['change_percent'] ?? null) : null,
                'recommendation_reason' => $recommendationReason,
            ];
        }

        return [
            'items' => $items,
            'counts' => $counts,
            'unavailable_count' => count($items) - array_sum($counts),
            'updated_at_label' => self::dashboard()['updated_at_label'],
            'market' => 'Pasar Manyar dan pasar acuan demo lainnya',
            'demo_savings' => self::dashboard()['demo_savings'],
        ];
    }

    /**
     * Illustrative detail-series data for the User UI only. The price shown in
     * the detail page always comes from the same commodity fixture as Beranda.
     */
    public static function detail(string $id): ?array
    {
        $commodity = collect(self::commodities())->firstWhere('id', $id);

        if (!$commodity) {
            return null;
        }

        $commodity['description'] = match ($commodity['id']) {
            'cabai-rawit-merah' => 'Pantau pergerakan harga dan sinyal pembelian untuk membantu perencanaan belanja usaha Anda.',
            default => 'Ringkasan tren harga dan rekomendasi pembelian untuk komoditas yang Anda pantau.',
        };
        $commodity['updated_at_label'] = self::dashboard()['updated_at_label'];
        $commodity['history'] = [];
        $commodity['forecast'] = [];

        if ($commodity['id'] === 'cabai-rawit-merah') {
            $commodity['history'] = [
                ['label' => '15 Mar', 'value' => 44500], ['label' => '16 Mar', 'value' => 45200],
                ['label' => '17 Mar', 'value' => 44800], ['label' => '18 Mar', 'value' => 46100],
                ['label' => '19 Mar', 'value' => 45500], ['label' => '20 Mar', 'value' => 46700],
                ['label' => '21 Mar', 'value' => 46300], ['label' => '22 Mar', 'value' => 47200],
                ['label' => '23 Mar', 'value' => 46800], ['label' => '24 Mar', 'value' => 48100],
                ['label' => '25 Mar', 'value' => 47500], ['label' => '26 Mar', 'value' => 48600],
                ['label' => '27 Mar', 'value' => 48000], ['label' => 'Hari ini', 'value' => 50000],
            ];
            $commodity['forecast'] = [
                ['label' => 'Hari ini', 'date' => '28 Mar 2025', 'weekday' => 'Hari ini', 'value' => 50000, 'change' => 0, 'change_percent' => '0.0%', 'signal' => 'BUY NOW'],
                ['label' => '+1 hari', 'date' => '29 Mar 2025', 'weekday' => 'Sabtu', 'value' => 51500, 'change' => 1500, 'change_percent' => '3.0%', 'signal' => 'BUY NOW'],
                ['label' => '+2 hari', 'date' => '30 Mar 2025', 'weekday' => 'Minggu', 'value' => 53000, 'change' => 3000, 'change_percent' => '6.0%', 'signal' => 'BUY NOW'],
                ['label' => '+3 hari', 'date' => '31 Mar 2025', 'weekday' => 'Senin', 'value' => 54000, 'change' => 4000, 'change_percent' => '8.0%', 'signal' => 'BUY NOW'],
                ['label' => '+4 hari', 'date' => '01 Apr 2025', 'weekday' => 'Selasa', 'value' => 54500, 'change' => 4500, 'change_percent' => '9.0%', 'signal' => 'MONITOR'],
                ['label' => '+5 hari', 'date' => '02 Apr 2025', 'weekday' => 'Rabu', 'value' => 54200, 'change' => 4200, 'change_percent' => '8.4%', 'signal' => 'MONITOR'],
                ['label' => '+6 hari', 'date' => '03 Apr 2025', 'weekday' => 'Kamis', 'value' => 53800, 'change' => 3800, 'change_percent' => '7.6%', 'signal' => 'MONITOR'],
                ['label' => '+7 hari', 'date' => '04 Apr 2025', 'weekday' => 'Jumat', 'value' => 53000, 'change' => 3000, 'change_percent' => '6.0%', 'signal' => 'MONITOR'],
            ];
        }

        return $commodity;
    }
}
