@props(['profile'])

<div class="user-profile-menu-root relative">
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

    <div id="user-profile-menu" class="user-dashboard-popover user-profile-dropdown absolute right-0 top-[calc(100%+8px)] z-50 w-64 rounded-2xl border border-user-dashboard-border bg-white p-2" data-user-profile-menu hidden>
        <div class="user-profile-dropdown-identity">
            <span class="user-profile-dropdown-avatar" aria-hidden="true">{{ $profile['avatar_initials'] ?? 'DT' }}</span>
            <span class="user-profile-dropdown-copy">
                <strong data-profile-value="business_name">{{ $profile['business_name'] }}</strong>
                <span data-profile-value="contact">{{ $profile['contact'] ?? 'Akun demo' }}</span>
            </span>
        </div>

        <div class="user-profile-dropdown-divider" aria-hidden="true"></div>

        <nav class="user-profile-dropdown-nav" aria-label="Menu pengguna">
            <a class="user-dashboard-popover-action user-profile-dropdown-item" href="{{ route('user.profile.show') }}" data-profile-menu-link>
                <img class="user-profile-menu-icon" src="{{ asset('images/user-menu-profile.svg') }}" alt="" aria-hidden="true">
                <span class="user-profile-dropdown-label">Profil Saya</span>
            </a>
            <button class="user-dashboard-popover-action user-profile-dropdown-item is-danger" type="button" data-open-logout-dialog>
                <img class="user-profile-menu-icon" src="{{ asset('images/user-menu-logout.svg') }}" alt="" aria-hidden="true">
                <span class="user-profile-dropdown-label">Keluar</span>
            </button>
        </nav>
    </div>
</div>
