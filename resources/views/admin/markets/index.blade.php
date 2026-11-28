
@extends('layouts.admin')

@section('title', 'Manajemen Komoditas & Pasar')

@push('styles')
<style>
    .market-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .market-tabs {
        display: flex;
        gap: 28px;
        border-bottom: 1px solid #DAE5E3;
        margin: 26px 0 24px;
    }

    .market-tab {
        display: inline-block;
        padding: 12px 3px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: #657370;
    }

    .market-tab.active {
        color: #1F6B67;
        border-bottom: 3px solid #1F6B67;
    }

    .market-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .market-input {
        min-width: 0;
        padding: 12px;
        border: 1px solid #BFCFCC;
        border-radius: 9px;
        font: inherit;
        font-size: 13px;
        background: #fff;
    }

    .market-search {
        flex: 1;
        min-width: 180px;
    }

    .market-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        border: 1px solid #1F6B67;
        border-radius: 9px;
        background: #1F6B67;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .market-button.secondary {
        background: #fff;
        color: #1F6B67;
    }

    .market-button.small {
        padding: 7px 10px;
        font-size: 12px;
    }

    .market-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .market-status {
        display: inline-block;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .market-status.active {
        color: #266B36;
        background: #E7F6E9;
    }

    .market-status.inactive {
        color: #657370;
        background: #EEF1F0;
    }

    .market-success {
        padding: 14px;
        border: 1px solid #B4DCCB;
        border-radius: 10px;
        margin-bottom: 20px;
        color: #1F6B4E;
    }

    @media(max-width: 700px) {
        .market-toolbar { flex-direction: column; align-items: stretch; }
        .market-filters { flex-direction: column; }
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        BeliPas Admin / Manajemen Komoditas & Pasar
    </div>

    <h1>Manajemen Komoditas & Pasar</h1>

    <div class="market-toolbar">
        <p class="subtitle" style="margin: 0">
            Kelola komoditas dan lokasi acuan harga BeliPas.
        </p>

        <a href="{{ route('admin.markets.create') }}"
           class="market-button">
            + Tambah Pasar/Wilayah
        </a>
    </div>

    @if(session('success'))
        <div class="market-success" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="stat-grid">
        <div class="card">
            <div class="stat-label">Total Wilayah/Pasar</div>
            <div class="stat-number">{{ $totalMarkets }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Aktif</div>
            <div class="stat-number">{{ $activeMarkets }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Nonaktif</div>
            <div class="stat-number">{{ $inactiveMarkets }}</div>
        </div>
    </div>

    <nav class="market-tabs" aria-label="Tab manajemen">
        <a href="{{ route('admin.commodities.index') }}"
           class="market-tab">
            Daftar Komoditas
        </a>

        <a href="{{ route('admin.markets.index') }}"
           class="market-tab active"
           aria-current="page">
            Wilayah & Pasar
        </a>
    </nav>

    <div class="card">
        <form method="GET"
              action="{{ route('admin.markets.index') }}"
              class="market-filters">

            <input type="search"
                   name="search"
                   class="market-input market-search"
                   value="{{ $search }}"
                   placeholder="Cari wilayah, pasar, atau kode..."
                   aria-label="Cari pasar atau wilayah">

            <select name="scope"
                    class="market-input"
                    aria-label="Filter cakupan">
                <option value="all">Semua Cakupan</option>
                @foreach([
                    'market' => 'Pasar',
                    'city' => 'Kota',
                    'province' => 'Provinsi',
                    'national' => 'Nasional'
                ] as $value => $label)
                    <option value="{{ $value }}"
                        @selected($scope === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select name="status"
                    class="market-input"
                    aria-label="Filter status">
                <option value="all">Semua Status</option>
                <option value="active"
                    @selected($status === 'active')>Aktif</option>
                <option value="inactive"
                    @selected($status === 'inactive')>Nonaktif</option>
            </select>

            <button type="submit" class="market-button secondary">
                Filter
            </button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Wilayah/Pasar</th>
                        <th>Cakupan</th>
                        <th>Kota/Provinsi</th>
                        <th>Record Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($markets as $market)
                        <tr>
                            <td>{{ $market->code }}</td>
                            <td>{{ $market->name }}</td>
                            <td>
                                {{ [
                                    'market' => 'Pasar',
                                    'city' => 'Kota',
                                    'province' => 'Provinsi',
                                    'national' => 'Nasional'
                                ][$market->scope_type] ?? $market->scope_type }}
                            </td>
                            <td>
                                {{ collect([
                                    $market->city,
                                    $market->province
                                ])->filter()->join(', ') ?: '—' }}
                            </td>
                            <td>{{ $market->price_records_count }}</td>
                            <td>
                                <span class="market-status {{ $market->is_active ? 'active' : 'inactive' }}">
                                    {{ $market->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="market-actions">
                                    <a class="market-button secondary small"
                                       href="{{ route('admin.markets.edit', $market) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.markets.toggle-status', $market) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="market-button secondary small">
                                            {{ $market->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    Belum ada pasar/wilayah yang sesuai.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px">
            {{ $markets->links() }}
        </div>
    </div>
@endsection
