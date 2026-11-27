<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5fbf8">
    <title>@yield('title', 'Sistem Prediksi Harga untuk UMKM') · BeliPas</title>
    <meta name="description" content="BeliPas membantu UMKM kuliner memahami harga komoditas dan estimasi 1–7 hari sebagai bahan pertimbangan belanja.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="user-app-page public-landing-page">
    @yield('content')
</body>
</html>
