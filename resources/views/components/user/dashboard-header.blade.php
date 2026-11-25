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
            <button
                class="user-dashboard-profile-trigger flex min-h-11 items-center gap-2 rounded-xl px-2.5 py-1.5 text-left transition hover:bg-user-dashboard-surface focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-dashboard-brand"
                type="button"
                data-user-menu-toggle
                aria-controls="user-profile-menu"
                aria-expanded="false"
            >
                <span class="hidden min-w-0 text-right sm:block">
                    <span class="block truncate text-sm font-bold leading-[17.5px] text-user-dashboard-text" data-profile-value="business_name">{{ $profile['business_name'] }}</span>
                    <span class="block truncate text-xs leading-4 text-user-dashboard-secondary">{{ $profile['business_type'] }}</span>
                </span>
                <img class="size-8 rounded-full border border-user-dashboard-border object-cover" src="{{ asset('images/dashboard-profile.png') }}" width="32" height="32" alt="" aria-hidden="true">
                <img class="user-dashboard-chevron" src="{{ asset('images/dashboard-profile-chevron.svg') }}" alt="" aria-hidden="true">
                <span class="sr-only">Buka menu {{ $profile['business_name'] }}</span>
            </button>

            <div id="user-profile-menu" class="user-dashboard-popover absolute right-0 top-[calc(100%+8px)] z-50 w-64 rounded-xl border border-user-dashboard-border bg-white p-2 shadow-xl" data-user-profile-menu hidden>
                <p class="px-3 pb-2 pt-2 text-xs font-semibold uppercase tracking-wide text-user-dashboard-secondary">Pratinjau profil</p>
                <div class="border-b border-user-dashboard-border px-3 pb-3">
                    <p class="text-sm font-semibold text-user-dashboard-text" data-profile-value="business_name">{{ $profile['business_name'] }}</p>
                    <p class="mt-0.5 text-xs text-user-dashboard-secondary"><span data-profile-value="owner_name">{{ $profile['owner_name'] }}</span> · {{ $profile['business_type'] }}</p>
                </div>
                <a class="user-dashboard-popover-action mt-2" href="{{ route('user.profile.show') }}">
                    Profil Saya <span>Lihat &amp; edit</span>
                </a>
                <p class="px-3 pb-2 pt-2 text-[11px] leading-4 text-user-dashboard-secondary">Data akun ini hanya contoh tampilan, belum terhubung ke autentikasi.</p>
            </div>

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
