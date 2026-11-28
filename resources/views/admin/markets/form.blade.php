@extends('layouts.admin')

@php
    $editing = $market->exists;
@endphp

@section('title', $editing ? 'Edit Pasar/Wilayah' : 'Tambah Pasar/Wilayah')

@push('styles')
<style>
    .market-form { max-width: 700px; }
    .market-field { margin-bottom: 20px; }
    .market-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
    }
    .market-control {
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #BFCFCC;
        border-radius: 9px;
        background: white;
        font: inherit;
    }
    .market-hint {
        margin-top: 6px;
        font-size: 12px;
        color: #657370;
    }
    .market-error {
        margin-top: 6px;
        font-size: 12px;
        color: #B42318;
    }
    .market-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
    }
    .market-form-button {
        display: inline-flex;
        padding: 12px 18px;
        border-radius: 9px;
        border: 1px solid #1F6B67;
        background: #1F6B67;
        color: #fff;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }
    .market-form-button.secondary {
        background: white;
        color: #1F6B67;
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        BeliPas Admin / Manajemen Komoditas & Pasar
    </div>

    <h1>{{ $editing ? 'Edit Pasar/Wilayah' : 'Tambah Pasar/Wilayah' }}</h1>

    <p class="subtitle">
        Kelola lokasi acuan untuk data harga bahan pangan.
    </p>

    <div class="card market-form">
        <form method="POST"
              action="{{ $editing
                  ? route('admin.markets.update', $market)
                  : route('admin.markets.store') }}">
            @csrf
            @if($editing)
                @method('PUT')
            @endif

            <div class="market-field">
                <label for="code">Kode Wilayah/Pasar *</label>
                <input id="code"
                       name="code"
                       type="text"
                       class="market-control"
                       maxlength="50"
                       pattern="[A-Z0-9_]+"
                       required
                       value="{{ old('code', $market->code) }}"
                       placeholder="Contoh: SURABAYA">

                <div class="market-hint">
                    Gunakan huruf kapital, angka, atau underscore.
                </div>

                @error('code')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-field">
                <label for="name">Nama Wilayah/Pasar *</label>
                <input id="name"
                       name="name"
                       type="text"
                       class="market-control"
                       maxlength="150"
                       required
                       value="{{ old('name', $market->name) }}"
                       placeholder="Nama wilayah atau pasar">

                @error('name')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-field">
                <label for="scope_type">Jenis Cakupan *</label>

                <select id="scope_type"
                        name="scope_type"
                        class="market-control"
                        required>
                    @foreach([
                        'market' => 'Pasar Fisik',
                        'city' => 'Agregasi Kota',
                        'province' => 'Agregasi Provinsi',
                        'national' => 'Agregasi Nasional'
                    ] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('scope_type', $market->scope_type ?? 'market') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @error('scope_type')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-field">
                <label for="city">Kota</label>

                <input id="city"
                       name="city"
                       type="text"
                       class="market-control"
                       maxlength="100"
                       value="{{ old('city', $market->city) }}"
                       placeholder="Opsional">

                @error('city')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-field">
                <label for="province">Provinsi</label>

                <input id="province"
                       name="province"
                       type="text"
                       class="market-control"
                       maxlength="100"
                       value="{{ old('province', $market->province) }}"
                       placeholder="Opsional">

                @error('province')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-field">
                <label for="is_active">Status *</label>

                <select id="is_active"
                        name="is_active"
                        class="market-control"
                        required>
                    <option value="1"
                        @selected((string) old('is_active', (int) ($market->is_active ?? true)) === '1')>
                        Aktif
                    </option>
                    <option value="0"
                        @selected((string) old('is_active', (int) ($market->is_active ?? true)) === '0')>
                        Nonaktif
                    </option>
                </select>

                @error('is_active')
                    <div class="market-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="market-form-actions">
                <a href="{{ route('admin.markets.index') }}"
                   class="market-form-button secondary">
                    Batal
                </a>

                <button type="submit" class="market-form-button">
                    {{ $editing ? 'Simpan Perubahan' : 'Tambah Pasar/Wilayah' }}
                </button>
            </div>
        </form>
    </div>
@endsection
