<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5fbf8">
    <title>@yield('title', 'Beranda') · BeliPas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="user-app-page">
    <x-user.dashboard-header :profile="$profile" :active-nav="$activeNav ?? 'dashboard'" :detail-code="$detailCode ?? 'cabai-rawit-merah'" />
    @yield('content')
    <x-user.logout-confirmation-dialog />
    <div class="user-dashboard-toast" data-dashboard-toast role="status" aria-live="polite" hidden></div>
</body>
</html>
