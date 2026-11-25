@props([
    'label',
    'icon',
    'routeName' => null,
    'active' => false,
    'notice' => null,
    'routeParameters' => [],
])

@php
    $baseClass = 'user-dashboard-nav-item inline-flex h-16 shrink-0 items-center gap-2 border-b-[3px] px-1 text-sm transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-dashboard-brand focus-visible:ring-offset-2';
    $stateClass = $active
        ? 'border-user-dashboard-brand font-semibold text-user-dashboard-brand'
        : 'border-transparent font-medium text-user-dashboard-nav hover:border-user-dashboard-border hover:text-user-dashboard-brand';
@endphp

@if ($routeName)
    <a {{ $attributes->merge(['class' => $baseClass.' '.$stateClass]) }} href="{{ route($routeName, $routeParameters) }}" @if ($active) aria-current="page" @endif>
        <img class="user-dashboard-icon" src="{{ asset('images/'.$icon) }}" alt="" aria-hidden="true">
        <span>{{ $label }}</span>
    </a>
@else
    <button
        {{ $attributes->merge(['class' => $baseClass.' '.$stateClass]) }}
        type="button"
        data-dashboard-notice="{{ $notice ?? $label.' belum tersedia pada MVP v1.' }}"
    >
        <img class="user-dashboard-icon" src="{{ asset('images/'.$icon) }}" alt="" aria-hidden="true">
        <span>{{ $label }}</span>
        <span class="sr-only">Belum tersedia pada MVP v1</span>
    </button>
@endif
