
<header class="topbar">
    <div class="topbar-search">
        <span class="topbar-label">
            BeliPas Admin Panel
        </span>
    </div>

    <div class="admin-account">
        <div class="avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="admin-account-info">
            <strong>{{ auth()->user()->name }}</strong>
            <div class="topbar-label">Administrator</div>
        </div>
    </div>
</header>
