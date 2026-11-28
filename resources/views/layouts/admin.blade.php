<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') - BeliPas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --teal: #1F6B67;
            --mint: #A5E9DD;
            --border: #DAE5E3;
            --text: #223432;
            --muted: #657370;
            --surface: #F5FAF9;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #fff;
        }

        a { color: inherit; text-decoration: none; }

        .admin-shell {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 248px;
            flex-shrink: 0;
            padding: 22px 12px;
            border-right: 1px solid var(--border);
            background: #fff;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 30px;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: var(--teal);
            color: white;
            font-weight: 700;
            font-size: 22px;
        }

        .brand strong {
            font-size: 20px;
            color: #164D49;
        }

        .brand small {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .nav-group { margin: 15px 0 23px; }

        .nav-heading {
            padding: 0 10px;
            margin-bottom: 10px;
            color: #89938F;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            border-radius: 10px;
            padding: 13px 12px;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 600;
        }

        .nav-link.active {
            background: #A5E9DD;
            color: #165853;
            border-left: none;
        }

        .nav-link.active::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 9px;
            bottom: 9px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: #1F6B67;
        }

        .nav-link.disabled {
            color: #929C99;
            cursor: not-allowed;
        }

        .main-area {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 69px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            border-bottom: 1px solid var(--border);
        }

        .topbar-label {
            color: var(--muted);
            font-size: 13px;
        }

        .admin-account {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--teal);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .content {
            padding: 32px 40px;
            max-width: 1700px;
            margin: auto;
        }

        h1, h2, h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1 {
            font-size: 29px;
            font-weight: 600;
            margin: 10px 0 7px;
        }

        .breadcrumb {
            color: var(--teal);
            font-size: 12px;
            font-weight: 600;
        }

        .subtitle {
            color: var(--muted);
            margin: 0 0 28px;
            font-size: 14px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.025);
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
        }

        .stat-number {
            margin-top: 12px;
            font-size: 26px;
            font-weight: 700;
        }

        .section-title {
            font-size: 18px;
            margin: 30px 0 16px;
        }

        .table-wrap { overflow-x: auto; }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        th {
            text-align: left;
            color: #495B57;
            background: var(--surface);
            font-size: 12px;
            padding: 15px;
        }

        td {
            border-bottom: 1px solid var(--border);
            padding: 17px 15px;
        }

        .empty-state {
            padding: 42px 20px;
            text-align: center;
            color: var(--muted);
        }

        @media (max-width: 1100px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .sidebar { width: 215px; }
            .content { padding: 25px; }
        }

        @media (max-width: 700px) {
            .admin-shell { flex-direction: column; }
            .sidebar { width: 100%; }
            .topbar { padding: 0 20px; }
            .stat-grid { grid-template-columns: 1fr; }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="admin-shell">

    <x-admin.sidebar />

    <div class="main-area">
        <x-admin.topbar />

        <main class="content">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
