@extends('layouts.user')

@section('title', 'Prakiraan Harga 7 Hari - '.$commodity['name'])

@section('content')
    @php
        $forecastRows = array_slice($commodity['forecast'], 1);
        $currentValue = (int) str_replace('.', '', $commodity['price']);
        $allValues = array_merge([$currentValue], array_column($forecastRows, 'value'));
        $lowestPrice = count($forecastRows) ? min($allValues) : null;
        $peakPrice = count($forecastRows) ? max(array_column($forecastRows, 'value')) : null;
        $peakRow = $peakPrice ? collect($forecastRows)->firstWhere('value', $peakPrice) : null;
        $hasForecast = count($forecastRows) > 0;
        $horizon = request()->integer('horizon') === 3 ? 3 : 7;
    @endphp

    <main class="user-dashboard-main user-forecast-main" data-forecast-interaction data-initial-horizon="{{ $horizon }}">
        <span class="sr-only" data-current-price-value="{{ $currentValue }}"></span>
        <div class="user-forecast-container mx-auto flex w-full max-w-[1280px] flex-col gap-5 px-8 py-7">
            <section class="user-forecast-page-header flex flex-col justify-between gap-5 border-b border-user-dashboard-border pb-4 lg:flex-row lg:items-end" aria-labelledby="forecast-page-heading">
                <div class="min-w-0 max-w-[768px]">
                    <div class="flex flex-wrap items-center gap-2 text-xs leading-4 text-user-dashboard-secondary">
                        <a class="hover:text-user-dashboard-brand" href="{{ route('user.dashboard') }}">Komoditas</a>
                        <span class="text-user-dashboard-border" aria-hidden="true">/</span>
                        <span class="font-medium text-user-dashboard-brand">Prakiraan 7 Hari</span>
                        <span class="text-user-dashboard-border" aria-hidden="true">•</span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#e3e9e7] px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-[.05em] text-user-dashboard-brand"><i class="size-1.5 rounded-full bg-user-dashboard-brand"></i>Pusat Analisis &amp; Pasokan</span>
                    </div>
                    <h1 id="forecast-page-heading" class="mt-2 font-user-display text-[32px] font-bold leading-10 tracking-[-.025em] text-user-dashboard-text">Prakiraan Harga 7 Hari</h1>
                    <p class="mt-1 text-sm leading-6 text-user-dashboard-secondary sm:text-base">Simulasi pergerakan harga komoditas pangan 7 hari ke depan untuk membantu perencanaan belanja dapur UMKM Anda secara efisien.</p>
                </div>
                <div class="inline-flex w-fit shrink-0 rounded-full border border-user-dashboard-border bg-[#e9efed] p-1" role="group" aria-label="Pilih horizon prediksi">
                    <button class="user-detail-horizon" type="button" data-price-horizon="3" aria-pressed="false">3 Hari</button>
                    <button class="user-detail-horizon" type="button" data-price-horizon="7" aria-pressed="false"><span aria-hidden="true">▦ </span>7 Hari</button>
                </div>
            </section>

            <nav class="user-forecast-filter-list flex gap-2.5 overflow-x-auto pb-1" aria-label="Pilih komoditas">
                @foreach ($commodities as $item)
                    <a href="{{ route('user.commodities.forecast', ['code' => $item['id']]) }}" class="user-forecast-filter {{ $item['id'] === $commodity['id'] ? 'is-active' : '' }}" @if ($item['id'] === $commodity['id']) aria-current="page" @endif>
                        <img src="{{ asset('images/'.$item['icon']) }}" alt="" aria-hidden="true">
                        <span>{{ $item['category'] === 'Cabai' ? 'Cabai' : ($item['category'] === 'Ayam' ? 'Ayam' : ($item['category'] === 'Telur' ? 'Telur' : ($item['category'] === 'Bawang' ? 'Bawang' : 'Minyak Goreng'))) }}</span>
                    </a>
                @endforeach
            </nav>

            <section class="user-forecast-summary-grid" aria-label="Ringkasan prakiraan {{ $commodity['name'] }}">
                <article class="user-forecast-summary-card">
                    <div>
                        <p class="user-forecast-summary-label">Harga terendah (<span data-horizon-label>{{ $horizon }} hari</span>)</p>
                        <p class="user-forecast-summary-value" data-horizon-stat="lowest">{{ $lowestPrice ? 'Rp'.number_format($lowestPrice, 0, ',', '.') : 'Belum tersedia' }}@if ($lowestPrice)<small>/{{ $commodity['unit'] }}</small>@endif</p>
                        <p class="user-forecast-summary-note">Hari ini · Rekomendasi: {{ $commodity['signal'] }}</p>
                    </div>
                    <span class="user-forecast-summary-icon is-low" aria-hidden="true">⌁</span>
                </article>
                <article class="user-forecast-summary-card">
                    <div>
                        <p class="user-forecast-summary-label">Puncak proyeksi</p>
                        <p class="user-forecast-summary-value" data-horizon-stat="peak">{{ $peakPrice ? 'Rp'.number_format($peakPrice, 0, ',', '.') : 'Belum tersedia' }}@if ($peakPrice)<small>/{{ $commodity['unit'] }}</small>@endif</p>
                <p class="user-forecast-summary-note is-peak" data-horizon-peak-note>{{ $peakRow ? '+'.$peakRow['change_percent'].' diperkirakan pada '.$peakRow['weekday'].', '.$peakRow['date'] : 'Belum ada forecast demo untuk komoditas ini.' }}</p>
                    </div>
                    <span class="user-forecast-summary-icon is-peak" aria-hidden="true">↗</span>
                </article>
                <article class="user-forecast-summary-card">
                    <div>
                        <p class="user-forecast-summary-label">Status data</p>
                        <p class="user-forecast-summary-value is-demo">DATA DEMO</p>
                        <p class="user-forecast-summary-note">{{ $hasForecast ? 'Bukan keluaran XGBoost produksi.' : 'Forecast belum tersedia untuk komoditas ini.' }}</p>
                    </div>
                    <span class="user-forecast-summary-icon is-status" aria-hidden="true">i</span>
                </article>
            </section>

            <section class="user-forecast-chart-card rounded-xl border border-user-dashboard-border bg-white p-4 shadow-sm sm:p-5" aria-labelledby="forecast-chart-heading">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-user-dashboard-border pb-3">
                    <div class="flex min-w-0 flex-wrap items-center gap-2.5">
                        <span class="size-2 shrink-0 rounded-full bg-user-dashboard-buy-dot" aria-hidden="true"></span>
                        <h2 id="forecast-chart-heading" class="font-user-display text-base font-bold text-user-dashboard-text">{{ $commodity['name'] }}</h2>
                        <span class="text-xs text-user-dashboard-secondary">· Hari ini: <strong class="text-user-dashboard-brand">Rp{{ $commodity['price'] }}/{{ $commodity['unit'] }}</strong></span>
                        <x-user.signal-badge :signal="$commodity['signal']" />
                        <span class="rounded-full bg-user-dashboard-surface px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO</span>
                    </div>
                    <a class="user-forecast-detail-link" href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}">Lihat detail komoditas <span aria-hidden="true">→</span></a>
                </div>

                @if ($hasForecast && count($commodity['history']))
                    <x-user.price-forecast-chart :commodity="$commodity" />
                    <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 border-t border-user-dashboard-border pt-3 text-[11px] text-user-dashboard-secondary" aria-label="Legenda grafik">
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-line"></i>Harga aktual · 14 hari terakhir (demo)</span>
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-line is-forecast"></i>Proyeksi 7 hari (demo)</span>
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-area"></i>Rentang ilustrasi</span>
                    </div>
                @else
                    <div class="mt-4 rounded-xl border border-dashed border-user-dashboard-border bg-[#fbfdfc] px-5 py-12 text-center">
                        <p class="font-semibold text-user-dashboard-text">Prakiraan belum tersedia</p>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Riwayat harga dan forecast demo untuk {{ $commodity['name'] }} belum disediakan. Nilai produksi akan ditampilkan setelah kontrak data dengan tim Supabase dan ML disepakati.</p>
                    </div>
                @endif
                <p class="mt-3 text-[11px] leading-5 text-user-dashboard-secondary">Harga historis ditampilkan dengan garis solid; proyeksi ditampilkan dengan garis putus-putus. Seluruh seri pada halaman ini merupakan fixture demo dan bukan data pasar aktual atau keluaran model produksi.</p>
            </section>

            <section class="user-forecast-table-card overflow-hidden rounded-xl border border-user-dashboard-border bg-white shadow-sm" aria-labelledby="forecast-table-heading">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-user-dashboard-border bg-[#f7faf9] px-5 py-3.5">
                    <div>
                        <h2 id="forecast-table-heading" class="font-user-display text-base font-bold text-user-dashboard-text">Rincian Proyeksi 7 Hari Mendatang</h2>
                        <p class="mt-0.5 text-[11px] leading-4 text-user-dashboard-secondary">Gunakan jadwal ilustratif ini untuk memahami perubahan harga harian.</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-user-dashboard-border bg-user-dashboard-surface px-3 py-1.5 text-[10px] font-semibold text-user-dashboard-secondary">
                        <img class="user-dashboard-icon" src="{{ asset('images/dashboard-market.svg') }}" alt="" aria-hidden="true">Pasar acuan: {{ $commodity['market'] }}
                    </span>
                </div>

                @if ($hasForecast)
                    <div class="overflow-x-auto">
                        <table class="user-forecast-table w-full min-w-[640px] text-left text-xs">
                            <thead><tr><th scope="col">Tanggal</th><th scope="col">Perkiraan harga</th><th scope="col">Selisih vs hari ini</th></tr></thead>
                            <tbody>
                                @foreach ($forecastRows as $index => $forecast)
                                    <tr data-forecast-row data-horizon-day="{{ $index + 1 }}" data-forecast-price="{{ $forecast['value'] }}" data-forecast-percent="{{ $forecast['change_percent'] }}" data-forecast-date="{{ $forecast['date'] }}" data-forecast-weekday="{{ $forecast['weekday'] }}" @if ($forecast['value'] === $peakPrice) class="is-peak" @endif>
                                        <td><strong>{{ $forecast['date'] }}</strong><span class="ml-2 text-[10px] text-user-dashboard-secondary">({{ $forecast['weekday'] }})</span>@if ($forecast['value'] === $peakPrice) <span class="user-forecast-peak-badge">Puncak</span>@endif</td>
                                        <td><strong class="{{ $forecast['value'] === $peakPrice ? 'text-user-dashboard-buy-dot' : 'text-user-dashboard-text' }}">Rp{{ number_format($forecast['value'], 0, ',', '.') }}</strong><span class="ml-1 text-[10px] text-user-dashboard-secondary">/{{ $commodity['unit'] }}</span></td>
                                        <td class="font-semibold text-user-dashboard-buy-dot">+Rp{{ number_format($forecast['change'], 0, ',', '.') }} (+{{ $forecast['change_percent'] }})</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="border-t border-user-dashboard-border px-5 py-2.5 text-[10px] leading-4 text-user-dashboard-secondary">Diperbarui: {{ $commodity['updated_at_label'] }} · Semua angka prakiraan adalah data demo.</p>
                @else
                    <div class="px-6 py-10 text-center">
                        <p class="font-semibold text-user-dashboard-text">Belum ada rincian prakiraan</p>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Data demo 7 hari belum tersedia untuk komoditas ini.</p>
                    </div>
                @endif

                <div class="user-forecast-action-banner flex flex-wrap items-center justify-between gap-4 border-t border-user-dashboard-border px-5 py-3.5">
                    <p class="max-w-3xl text-[11px] leading-5 text-user-dashboard-secondary">Ingin melihat konteks sinyal pembelian sebelum merencanakan stok? Buka detail komoditas untuk membaca ringkasan harga dan rekomendasi demonya.</p>
                    <a href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}" class="user-forecast-action-button">Lihat detail {{ $commodity['category'] }} <span aria-hidden="true">→</span></a>
                </div>
            </section>

            <aside class="user-forecast-disclaimer rounded-xl border border-user-dashboard-border bg-[#eff5f3] px-4 py-3" aria-label="Disclaimer dan metodologi">
                <h2 class="flex items-center gap-2 text-xs font-bold text-user-dashboard-text"><span class="flex size-4 items-center justify-center rounded-full border border-user-dashboard-brand text-[10px] text-user-dashboard-brand" aria-hidden="true">i</span>Disclaimer &amp; Metodologi BeliPas</h2>
                <p class="mt-1 text-[10px] leading-4 text-user-dashboard-secondary">Halaman ini menggunakan fixture DATA DEMO untuk pratinjau antarmuka, bukan data pasar aktual atau hasil XGBoost. Forecast merupakan estimasi, bukan kepastian; konfirmasi harga dan ketersediaan langsung ke pemasok sebelum transaksi.</p>
            </aside>
        </div>
    </main>
@endsection
