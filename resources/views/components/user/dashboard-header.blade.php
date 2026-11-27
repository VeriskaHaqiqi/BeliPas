@props(['profile', 'activeNav' => 'dashboard', 'detailCode' => 'cabai-rawit-merah'])

<header class="user-dashboard-header fixed inset-x-0 top-0 z-40 h-16 border-b border-user-dashboard-border bg-white">
    <div class="mx-auto flex h-full max-w-[1280px] items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a class="flex shrink-0 items-center gap-2 rounded-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-dashboard-brand" href="{{ route('user.dashboard') }}" aria-label="BeliPas, Beranda">
            <img class="user-dashboard-mark" src="{{ asset('images/dashboard-brand-mark.png') }}" width="32" height="32" alt="">
            <span class="font-user-display text-xl font-bold leading-5 text-user-dashboard-mark">BeliPas</span>
        </a>

        <nav class="user-dashboard-desktop-nav flex h-full items-center gap-6" aria-label="Navigasi utama">
            <x-user.dashboard-nav-item label="Beranda" icon="dashboard-nav-home.svg" route-name="user.dashboard" :active="$activeNav === 'dashboard'" />
            @if ($activeNav === 'commodities')
                <x-user.dashboard-nav-item label="Komoditas" icon="dashboard-nav-commodities.svg" route-name="user.commodities.show" :route-parameters="['code' => $detailCode]" active />
            @else
                <x-user.dashboard-nav-item label="Komoditas" icon="dashboard-nav-commodities.svg" />
            @endif
            <x-user.dashboard-nav-item label="Pusat Rekomendasi Belanja" icon="dashboard-nav-recommendations.svg" route-name="user.recommendations.index" :active="$activeNav === 'recommendations'" />
            <x-user.dashboard-nav-item label="Pengaturan" icon="dashboard-nav-settings.svg" route-name="user.settings.index" :active="$activeNav === 'settings'" />
            <x-user.dashboard-nav-item label="Bantuan" icon="dashboard-nav-help.svg" />
        </nav>

        <div class="user-dashboard-header-actions relative ml-auto flex shrink-0 items-center gap-2">
            <x-user.profile-dropdown :profile="$profile" />

            <button class="user-dashboard-mobile-nav-toggle rounded-lg border border-user-dashboard-border px-3 py-2 text-sm font-semibold text-user-dashboard-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-dashboard-brand" type="button" data-mobile-nav-toggle aria-controls="user-mobile-nav" aria-expanded="false">
                Menu
            </button>
        </div>
    </div>

    <nav id="user-mobile-nav" class="user-dashboard-mobile-nav absolute inset-x-0 top-16 z-40 border-b border-user-dashboard-border bg-white px-4 pb-3 shadow-lg sm:px-6" aria-label="Navigasi utama" data-mobile-nav hidden>
        <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Beranda" icon="dashboard-nav-home.svg" route-name="user.dashboard" :active="$activeNav === 'dashboard'" />
        @if ($activeNav === 'commodities')
            <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Komoditas" icon="dashboard-nav-commodities.svg" route-name="user.commodities.show" :route-parameters="['code' => $detailCode]" active />
        @else
            <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Komoditas" icon="dashboard-nav-commodities.svg" />
        @endif
        <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Pusat Rekomendasi Belanja" icon="dashboard-nav-recommendations.svg" route-name="user.recommendations.index" :active="$activeNav === 'recommendations'" />
        <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Pengaturan" icon="dashboard-nav-settings.svg" route-name="user.settings.index" :active="$activeNav === 'settings'" />
        <x-user.dashboard-nav-item class="user-dashboard-mobile-nav-item" label="Bantuan" icon="dashboard-nav-help.svg" />
    </nav>
</header>
