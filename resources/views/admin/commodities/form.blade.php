
@extends('layouts.admin')

@php
    $editing = $commodity->exists;
@endphp

@section('title', $editing ? 'Edit Komoditas' : 'Tambah Komoditas')

@push('styles')
<style>
    .commodity-form {
        max-width: 700px;
    }

    .form-field {
        margin-bottom: 20px;
    }

    .form-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #BFCFCC;
        border-radius: 9px;
        font: inherit;
        background: #fff;
    }

    .form-hint {
        color: #657370;
        margin-top: 7px;
        font-size: 12px;
    }

    .field-error {
        margin-top: 6px;
        color: #B42318;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
    }

    .form-button {
        display: inline-block;
        padding: 12px 20px;
        border: 1px solid #1F6B67;
        border-radius: 9px;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        background: #1F6B67;
        color: white;
        text-decoration: none;
    }

    .form-button.secondary {
        background: white;
        color: #1F6B67;
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        BeliPas Admin / Manajemen Komoditas & Pasar
    </div>

    <h1>{{ $editing ? 'Edit Komoditas' : 'Tambah Komoditas' }}</h1>

    <p class="subtitle">
        Isi data master komoditas yang akan digunakan BeliPas.
    </p>

    <div class="card commodity-form">
        <form
            method="POST"
            action="{{ $editing
                ? route('admin.commodities.update', $commodity)
                : route('admin.commodities.store') }}"
        >
            @csrf

            @if($editing)
                @method('PUT')
            @endif

            <div class="form-field">
                <label for="code">Kode Komoditas *</label>

                <input
                    id="code"
                    name="code"
                    class="form-control"
                    type="text"
                    required
                    maxlength="50"
                    pattern="[A-Z0-9_]+"
                    value="{{ old('code', $commodity->code) }}"
                    placeholder="Contoh: CABAI_RAWIT_MERAH"
                >

                <div class="form-hint">
                    Gunakan huruf kapital, angka, atau underscore.
                </div>

                @error('code')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-field">
                <label for="name">Nama Komoditas *</label>

                <input
                    id="name"
                    name="name"
                    class="form-control"
                    type="text"
                    required
                    maxlength="150"
                    value="{{ old('name', $commodity->name) }}"
                    placeholder="Nama komoditas"
                >

                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-field">
                <label for="unit">Satuan Harga *</label>

                <select id="unit"
                        name="unit"
                        class="form-control"
                        required>
                    <option value="">Pilih satuan</option>

                    @foreach(['kg', 'liter', 'butir', 'gram', 'kemasan'] as $unit)
                        <option
                            value="{{ $unit }}"
                            @selected(old('unit', $commodity->unit) === $unit)
                        >
                            Rp/{{ $unit }}
                        </option>
                    @endforeach
                </select>

                @error('unit')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-field">
                <label for="is_active">Status Komoditas *</label>

                <select id="is_active"
                        name="is_active"
                        class="form-control"
                        required>
                    <option value="1"
                        @selected((string) old('is_active', (int) ($commodity->is_active ?? true)) === '1')>
                        Aktif
                    </option>

                    <option value="0"
                        @selected((string) old('is_active', (int) ($commodity->is_active ?? true)) === '0')>
                        Nonaktif
                    </option>
                </select>

                @error('is_active')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.commodities.index') }}"
                   class="form-button secondary">
                    Batal
                </a>

                <button type="submit" class="form-button">
                    {{ $editing ? 'Simpan Perubahan' : 'Tambah Komoditas' }}
                </button>
            </div>
        </form>
    </div>
@endsection
