@props(['commodity'])

@php
    $history = $commodity['history'] ?? [];
    $forecast = $commodity['forecast'] ?? [];
    $values = array_merge(array_column($history, 'value'), array_column($forecast, 'value'));
    $minimum = count($values) ? floor(min($values) / 2000) * 2000 : 0;
    $maximum = count($values) ? ceil(max($values) / 2000) * 2000 : 60000;
    $range = max(1, $maximum - $minimum);
    $historyX = fn (int $index, int $count): float => 64 + ($count > 1 ? ($index / ($count - 1)) * 586 : 0);
    $forecastX = fn (int $index, int $count): float => 650 + ($count > 1 ? ($index / ($count - 1)) * 294 : 0);
    $pointY = fn (int $value): float => 286 - ((($value - $minimum) / $range) * 240);
    $historyPoints = [];
    foreach ($history as $index => $point) {
        $historyPoints[] = ['x' => $historyX($index, count($history)), 'y' => $pointY($point['value']), ...$point];
    }
    $forecastPoints = [];
    foreach ($forecast as $index => $point) {
        $forecastPoints[] = ['x' => $forecastX($index, count($forecast)), 'y' => $pointY($point['value']), ...$point];
    }
    $historyPath = implode(' ', array_map(fn ($point) => $point['x'].','.$point['y'], $historyPoints));
    $forecastStart = $forecastPoints[0] ?? null;
    $futurePoints = array_slice($forecastPoints, 1);
    $forecastPath = $forecastStart
        ? $forecastStart['x'].','.$forecastStart['y'].' '.implode(' ', array_map(fn ($point) => $point['x'].','.$point['y'], $futurePoints))
        : '';
    $areaPath = count($futurePoints)
        ? $forecastStart['x'].',286 '.$forecastPath.' '.$futurePoints[array_key_last($futurePoints)]['x'].',286'
        : '';
@endphp

<div class="user-detail-chart-wrap relative mt-5 rounded-xl bg-[#fbfdfc] p-2 sm:p-4" data-price-chart data-chart-unit="{{ $commodity['unit'] }}">
    <p class="mb-2 text-[11px] font-medium text-user-dashboard-secondary">Harga historis dan proyeksi contoh · Rupiah per {{ $commodity['unit'] }}</p>
    <div class="user-detail-chart-scroll">
        <svg class="user-detail-chart" viewBox="0 0 1000 340" role="img" aria-labelledby="price-chart-title price-chart-desc" preserveAspectRatio="none">
            <title id="price-chart-title">Grafik harga demo {{ $commodity['name'] }}</title>
            <desc id="price-chart-desc">Garis hijau solid menunjukkan nilai historis ilustratif. Garis putus-putus menunjukkan proyeksi demo, bukan keluaran model produksi.</desc>
            @for ($tick = 0; $tick < 5; $tick++)
                @php $tickValue = $maximum - (($range / 4) * $tick); $tickY = 46 + (60 * $tick); @endphp
                <line x1="64" y1="{{ $tickY }}" x2="944" y2="{{ $tickY }}" stroke="#e3e9e7" stroke-width="1" />
                <text x="54" y="{{ $tickY + 4 }}" text-anchor="end" fill="#6b7674" font-size="12">Rp{{ number_format($tickValue, 0, ',', '.') }}</text>
            @endfor
            <line x1="650" y1="36" x2="650" y2="302" stroke="#9ba9a6" stroke-dasharray="4 5" />
            <text x="658" y="34" fill="#56615f" font-size="11">Hari ini</text>
            @if ($areaPath)
                <polygon points="{{ $areaPath }}" fill="#9af2ec" opacity=".22" data-forecast-area />
                <polyline points="{{ $forecastPath }}" fill="none" stroke="#006a66" stroke-width="3" stroke-dasharray="9 7" stroke-linecap="round" stroke-linejoin="round" data-forecast-line />
            @endif
            @if (count($historyPoints) > 1)
                <polyline points="{{ $historyPath }}" fill="none" stroke="#00524f" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
            @endif
            @foreach ($historyPoints as $point)
                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4" fill="#00524f" stroke="white" stroke-width="2" data-chart-point data-chart-label="{{ $point['label'] }}" data-chart-value="{{ number_format($point['value'], 0, ',', '.') }}" tabindex="0" aria-label="{{ $point['label'] }}: Rp{{ number_format($point['value'], 0, ',', '.') }} (demo)" />
            @endforeach
            @foreach ($futurePoints as $index => $point)
                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="5" fill="white" stroke="#006a66" stroke-width="3" data-forecast-point data-chart-point data-day-index="{{ $index + 1 }}" data-chart-label="{{ $point['label'] }}" data-chart-value="{{ number_format($point['value'], 0, ',', '.') }}" tabindex="0" aria-label="{{ $point['label'] }}: Rp{{ number_format($point['value'], 0, ',', '.') }} (proyeksi demo)" />
            @endforeach
            <text x="64" y="324" fill="#6b7674" font-size="11">{{ $history[0]['label'] ?? 'Riwayat' }}</text>
            <text x="370" y="324" text-anchor="middle" fill="#6b7674" font-size="11">14 hari terakhir</text>
            <text x="650" y="324" text-anchor="middle" fill="#6b7674" font-size="11">Hari ini</text>
            <text x="944" y="324" text-anchor="end" fill="#6b7674" font-size="11">+7 hari</text>
        </svg>
    </div>
    <div class="user-detail-tooltip" role="status" aria-live="polite" data-chart-tooltip hidden></div>
</div>
