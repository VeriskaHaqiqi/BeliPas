@props(['commodity'])

@php
    $iconTone = match ($commodity['icon_tone']) {
        'buy' => 'bg-user-dashboard-buy-bg',
        'onion' => 'bg-[#eee9dd]',
        'oil' => 'bg-[#f6efdc]',
        'chicken' => 'bg-[#b4f1eb]',
        default => 'bg-user-dashboard-wait-bg',
    };
    $textTone = match ($commodity['delta_tone']) {
        'buy' => 'text-user-dashboard-buy-dot',
        'wait' => 'text-user-dashboard-wait-dot',
        default => 'text-user-dashboard-monitor-dot',
    };
    $trendTone = match ($commodity['trend_tone']) {
        'buy' => 'text-user-dashboard-buy-dot',
        'wait' => 'text-user-dashboard-brand-light',
        default => 'text-user-dashboard-monitor-text',
    };
    $edgeTone = match ($commodity['signal']) {
        'BUY NOW' => 'border-l-4 border-l-user-dashboard-buy-dot',
        default => 'border-l border-l-user-dashboard-border',
    };
@endphp

<article
    class="user-dashboard-commodity-card flex min-w-0 flex-col rounded-xl bg-white p-5 shadow-[0_1px_2px_rgba(0,0,0,.05)] {{ $edgeTone }}"
    data-commodity-card
    data-category="{{ Str::slug($commodity['category']) }}"
    aria-label="{{ $commodity['name'] }}, sinyal demo {{ $commodity['signal'] }}"
>
    <div class="flex items-start justify-between gap-2 pl-1">
        <div class="flex min-w-0 items-center gap-2.5">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-lg {{ $iconTone }}">
                <img class="user-dashboard-icon" src="{{ asset('images/'.$commodity['icon']) }}" alt="" aria-hidden="true">
            </span>
            <span class="min-w-0">
                <span class="block font-user-display text-xl font-semibold leading-[25px] text-user-dashboard-text">{{ $commodity['name'] }}</span>
                <span class="block truncate text-xs leading-4 text-user-dashboard-secondary">{{ $commodity['market'] }}</span>
            </span>
        </div>
        <x-user.signal-badge :signal="$commodity['signal']" />
    </div>

    <p class="mt-3 flex items-center gap-1.5 pl-1 text-xs leading-4 {{ $textTone }}">
        <img class="user-dashboard-icon" src="{{ asset('images/'.$commodity['signal_icon']) }}" alt="" aria-hidden="true">
        <span>{{ $commodity['signal_detail'] }}</span>
    </p>

    <div class="mt-2 flex items-baseline gap-1.5 pl-1">
        @if ($commodity['price'] !== null)
            <span class="font-user-display text-[40px] font-bold leading-[48px] tracking-[-.02em] text-user-dashboard-text">Rp{{ $commodity['price'] }}</span>
            <span class="text-sm font-medium leading-5 text-user-dashboard-secondary">/{{ $commodity['unit'] }}</span>
        @else
            <span class="font-user-display text-2xl font-bold leading-9 text-user-dashboard-secondary">Harga belum tersedia</span>
        @endif
    </div>

    <p class="mt-0.5 flex items-center gap-1 pl-1 text-[13px] font-medium leading-5 {{ $textTone }}">
        <img class="user-dashboard-icon" src="{{ asset('images/'.$commodity['delta_icon']) }}" alt="" aria-hidden="true">
        <span>{{ $commodity['delta'] }}</span>
    </p>

    <div class="mt-3 grid gap-1 pl-1">
        <div class="flex items-center justify-between gap-3 text-xs leading-4">
            <span class="text-user-dashboard-secondary">Tren 7 Hari</span>
            <span class="font-semibold {{ $trendTone }}">{{ $commodity['trend'] }}</span>
        </div>
        <div class="flex h-11 items-center overflow-hidden rounded-lg bg-user-dashboard-surface px-1.5 py-1.5">
            <img class="user-dashboard-chart" src="{{ asset('images/'.$commodity['chart']) }}" alt="Ilustrasi tren tujuh hari untuk {{ $commodity['name'] }}; DATA DEMO, bukan data harga aktual.">
        </div>
    </div>

    <div class="mt-3 flex min-h-[74px] items-start gap-2 rounded-xl bg-user-dashboard-surface p-3 text-[13px] leading-[21px] text-user-dashboard-secondary">
        <img class="user-dashboard-insight-icon mt-0.5 shrink-0" src="{{ asset('images/dashboard-insight.svg') }}" alt="" aria-hidden="true">
        <p>{{ $commodity['reason'] }}</p>
    </div>

    <div class="mt-auto flex items-center justify-between gap-3 pt-4">
        <a class="user-dashboard-detail-action" href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}">
            <span>Lihat detail</span>
            <img class="user-dashboard-icon" src="{{ asset('images/dashboard-detail-arrow.svg') }}" alt="" aria-hidden="true">
        </a>
        <span class="text-right text-[10px] leading-4 text-user-dashboard-secondary">{{ $commodity['footnote'] }}</span>
    </div>
</article>
