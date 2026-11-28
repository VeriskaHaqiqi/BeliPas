<aside class="sidebar">
    <div class="brand">
        <div class="brand-mark">↗</div>

        <div>
            <strong>BeliPas</strong>
            <small>Admin Dashboard</small>
        </div>
    </div>

    <nav aria-label="Navigasi Admin">

        <div class="nav-group">
            <div class="nav-heading">OVERVIEW</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               @if(request()->routeIs('admin.dashboard'))
                   aria-current="page"
               @endif>
                <span>▦</span>
                <span>Dashboard Admin</span>
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-heading">DATA MANAGEMENT</div>

            @if(Route::has('admin.prices.index'))
                <a href="{{ route('admin.prices.index') }}"
                   class="nav-link {{ request()->routeIs('admin.prices.*') ? 'active' : '' }}"
                   @if(request()->routeIs('admin.prices.*'))
                       aria-current="page"
                   @endif>
                    <span>▤</span>
                    <span>Manajemen Data Harga</span>
                </a>
            @else
                <span class="nav-link disabled">
                    ▤ &nbsp; Manajemen Data Harga
                </span>
            @endif

            @if(Route::has('admin.commodities.index'))
                <a href="{{ route('admin.commodities.index') }}"
                   class="nav-link {{ request()->routeIs('admin.commodities.*') || request()->routeIs('admin.markets.*') ? 'active' : '' }}"
                   @if(request()->routeIs('admin.commodities.*') || request()->routeIs('admin.markets.*'))
                       aria-current="page"
                   @endif>
                    <span>◇</span>
                    <span>Manajemen Komoditas & Pasar</span>
                </a>
            @else
                <span class="nav-link disabled">
                    ◇ &nbsp; Manajemen Komoditas & Pasar
                </span>
            @endif
        </div>

        <div class="nav-group">
            <div class="nav-heading">MACHINE LEARNING</div>

            <span class="nav-link disabled">
                ◇ &nbsp; Manajemen Model & Evaluasi
            </span>

            <span class="nav-link disabled">
                ⌁ &nbsp; Monitoring Forecasting
            </span>

            <span class="nav-link disabled">
                ✧ &nbsp; Recommendation Engine
            </span>
        </div>

    </nav>
</aside>
