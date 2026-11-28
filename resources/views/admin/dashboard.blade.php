@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="breadcrumb">
        BeliPas Admin / Dashboard Admin
    </div>

    <h1>Dashboard Admin</h1>
    <p class="subtitle">
        Pantau kondisi data dan aktivitas operasional BeliPas.
    </p>

    <div class="stat-grid">
        <div class="card">
            <div class="stat-label">Komoditas Aktif</div>
            <div class="stat-number">
                {{ number_format($activeCommodities, 0, ',', '.') }}
            </div>
            <div class="stat-label">
                Dari {{ $totalCommodities }} komoditas
            </div>
        </div>

        <div class="card">
            <div class="stat-label">Dataset Records</div>
            <div class="stat-number">
                {{ number_format($totalPrices, 0, ',', '.') }}
            </div>
            <div class="stat-label">Data harga aktual</div>
        </div>

        <div class="card">
            <div class="stat-label">Wilayah / Pasar</div>
            <div class="stat-number">
                {{ number_format($totalMarkets, 0, ',', '.') }}
            </div>
            <div class="stat-label">Lokasi referensi harga</div>
        </div>

        <div class="card">
            <div class="stat-label">Pengguna UMKM</div>
            <div class="stat-number">
                {{ number_format($totalUmkmUsers, 0, ',', '.') }}
            </div>
            <div class="stat-label">Akun dengan role user</div>
        </div>
    </div>

    <h2 class="section-title">Data Harga Terbaru</h2>

    <div class="card table-wrap">
        @if($latestPrices->isEmpty())
            <div class="empty-state">
                <strong>Belum ada data harga</strong>
                <p>
                    Data harga akan ditampilkan setelah
                    Admin melakukan input atau import dataset.
                </p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Komoditas</th>
                        <th>Wilayah / Pasar</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Sumber</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestPrices as $record)
                        <tr>
                            <td>
                                {{ $record->price_date->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $record->commodity->name }}
                            </td>
                            <td>
                                {{ $record->market->name }}
                            </td>
                            <td>
                                Rp{{ number_format($record->price, 2, ',', '.') }}
                            </td>
                            <td>
                                Rp/{{ $record->commodity->unit }}
                            </td>
                            <td>
                                {{ $record->source_name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <h2 class="section-title">Status Integrasi</h2>

    <div class="card">
        <p><strong>Database:</strong> Supabase PostgreSQL</p>
        <p><strong>Harga aktual:</strong> Terhubung melalui Laravel Eloquent</p>
        <p><strong>Forecasting:</strong> Menunggu integrasi model ML</p>
        <p><strong>Recommendation Engine:</strong> Belum diintegrasikan</p>
    </div>
@endsection
