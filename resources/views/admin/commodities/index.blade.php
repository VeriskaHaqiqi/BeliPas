@extends('layouts.admin')

@section('title', 'Manajemen Komoditas & Pasar')

@push('styles')
<style>
    .page-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .admin-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #1F6B67;
        border-radius: 10px;
        padding: 12px 18px;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        background: #1F6B67;
        color: #fff;
    }

    .admin-button.secondary {
        background: #fff;
        color: #1F6B67;
    }

    .admin-button.small {
        padding: 7px 10px;
        font-size: 12px;
    }

    .admin-tabs {
        display: flex;
        gap: 28px;
        border-bottom: 1px solid #DAE5E3;
        margin: 24px 0;
    }

    .admin-tab {
        padding: 12px 3px;
        font-size: 14px;
        font-weight: 600;
        color: #687672;
    }

    .admin-tab.active {
        border-bottom: 3px solid #1F6B67;
        color: #1F6B67;
    }

    .filter-row {
        display: flex;
        gap: 12px;
        margin-bottom: 18px;
    }

    .admin-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #BFCFCC;
        border-radius: 9px;
        background: #fff;
        font: inherit;
        font-size: 13px;
    }

    .filter-row .search-field {
        flex: 1;
    }

    .filter-row select {
        max-width: 190px;
    }

    .status-pill {
        display: inline-block;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pill.active {
        background: #E7F6E9;
        color: #266B36;
    }

    .status-pill.inactive {
        background: #F0F1F1;
        color: #64716F;
    }

    .action-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .success-message {
        padding: 13px 16px;
        border: 1px solid #B4DCCB;
        border-radius: 10px;
        margin-bottom: 20px;
        color: #1F6B4E;
    }

    @media (max-width: 700px) {
        .page-actions,
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-row select {
            max-width: none;
        }
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        BeliPas Admin / Manajemen Komoditas & Pasar
    </div>

    <h1>Manajemen Komoditas & Pasar</h1>

    <div class="page-actions">
        <p class="subtitle" style="margin: 0">
            Kelola master komoditas dan wilayah acuan harga BeliPas.
        </p>

        <a href="{{ route('admin.commodities.create') }}"
           class="admin-button">
            + Tambah Komoditas
        </a>
    </div>

    @if(session('success'))
        <div class="success-message" role="status">
            {{ session('success') }}
        </div>
    @endif

    <div class="stat-grid">
        <div class="card">
            <div class="stat-label">Total Komoditas</div>
            <div class="stat-number">{{ $totalCommodities }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Komoditas Aktif</div>
            <div class="stat-number">{{ $activeCommodities }}</div>
        </div>

        <div class="card">
            <div class="stat-label">Komoditas Nonaktif</div>
            <div class="stat-number">{{ $inactiveCommodities }}</div>
        </div>
    </div>


    <nav class="admin-tabs" aria-label="Tab manajemen">
        <a href="{{ route('admin.commodities.index') }}"
        class="admin-tab active"
        aria-current="page">
            Daftar Komoditas
        </a>

        <a href="{{ route('admin.markets.index') }}"
        class="admin-tab">
            Wilayah & Pasar
        </a>
    </nav>


    <div class="card">
        <form method="GET"
              action="{{ route('admin.commodities.index') }}"
              class="filter-row">

            <input
                class="admin-input search-field"
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Cari kode atau nama komoditas..."
                aria-label="Cari komoditas"
            >

            <select class="admin-input"
                    name="status"
                    aria-label="Filter status">
                <option value="all" @selected($status === 'all')>
                    Semua Status
                </option>
                <option value="active" @selected($status === 'active')>
                    Aktif
                </option>
                <option value="inactive" @selected($status === 'inactive')>
                    Nonaktif
                </option>
            </select>

            <button class="admin-button secondary" type="submit">
                Filter
            </button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Komoditas</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($commodities as $commodity)
                    <tr>
                        <td>{{ $commodity->code }}</td>
                        <td>{{ $commodity->name }}</td>
                        <td>Rp/{{ $commodity->unit }}</td>

                        <td>
                            <span class="status-pill {{ $commodity->is_active ? 'active' : 'inactive' }}">
                                {{ $commodity->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <td>
                            {{ $commodity->updated_at?->format('d M Y') ?? '—' }}
                        </td>

                        <td>
                            <div class="action-row">
                                <a class="admin-button secondary small"
                                   href="{{ route('admin.commodities.edit', $commodity) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.commodities.toggle-status', $commodity) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="admin-button secondary small"
                                            type="submit">
                                        {{ $commodity->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada komoditas yang sesuai.
                                Tambahkan komoditas atau ubah filter pencarian.
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px">
            {{ $commodities->links() }}
        </div>
    </div>
@endsection
