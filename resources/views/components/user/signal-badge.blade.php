@props(['signal'])

@php
    $signalStyles = match ($signal) {
        'BUY NOW' => ['wrap' => 'bg-user-dashboard-buy-bg text-user-dashboard-buy-text', 'dot' => 'bg-user-dashboard-buy-dot'],
        'WAIT' => ['wrap' => 'bg-user-dashboard-wait-bg text-user-dashboard-wait-text', 'dot' => 'bg-user-dashboard-wait-dot'],
        default => ['wrap' => 'bg-user-dashboard-monitor-bg text-user-dashboard-monitor-text', 'dot' => 'bg-user-dashboard-monitor-dot'],
    };
@endphp

<span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold uppercase leading-4 {{ $signalStyles['wrap'] }}">
    <span class="size-2 rounded-full {{ $signalStyles['dot'] }}" aria-hidden="true"></span>
    {{ $signal }}
</span>
