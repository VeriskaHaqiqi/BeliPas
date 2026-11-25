@extends('layouts.user')

@section('title', 'Pusat Rekomendasi Belanja')

@section('content')
    @php
        $totalItems = count($items);
        $filterDefinitions = [
            ['key' => 'all', 'label' => 'Semua Rekomendasi', 'count' => $totalItems],
            ['key' => 'buy-now', 'label' => 'BUY NOW', 'count' => $counts['BUY NOW']],
            ['key' => 'monitor', 'label' => 'MONITOR', 'count' => $counts['MONITOR']],
            ['key' => 'wait', 'label' => 'WAIT', 'count' => $counts['WAIT']],
        ];
    @endphp

    <main class="user-dashboard-main user-recommendations-main">
        <div class="user-recommendations-container mx-auto flex w-full max-w-[1280px] flex-col gap-5 px-8 py-7">
            <section class="flex flex-col gap-2" aria-labelledby="recommendations-heading">
                <div class="flex items-center gap-2 text-xs leading-4 text-user-dashboard-secondary">
                    <a class="hover:text-user-dashboard-brand" href="{{ route('user.dashboard') }}">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <span class="font-medium text-user-dashboard-text" aria-current="page">Pusat Rekomendasi Belanja</span>
                </div>

                <div class="flex flex-col justify-between gap-4 2xl:flex-row 2xl:items-end">
                    <div>
                        <h1 id="recommendations-heading" class="font-user-display text-[32px] font-bold leading-10 tracking-[-.02em] text-user-dashboard-text">Pusat Rekomendasi Belanja</h1>
                        <p class="mt-1 text-sm leading-6 text-user-dashboard-secondary sm:text-base">Daftar rekomendasi keputusan belanja komoditas berdasarkan analisis pergerakan harga.</p>
                    </div>
                    <p class="inline-flex w-fit items-center gap-2 rounded-full bg-user-dashboard-surface px-3 py-1.5 text-xs text-user-dashboard-secondary">
                        <img class="user-dashboard-icon" src="{{ asset('images/dashboard-update.svg') }}" alt="" aria-hidden="true">
                        <span>Diperbarui: <strong class="font-bold text-user-dashboard-text">{{ $updated_at_label }}</strong></span>
                    </p>
                </div>
                <p class="text-[11px] font-semibold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO · rekomendasi aktif hanya bila forecast 1–7 hari tersedia</p>
            </section>

            <section class="user-recommendations-summary flex flex-col justify-between gap-4 rounded-xl bg-user-dashboard-surface p-5 shadow-sm 2xl:flex-row 2xl:items-center" aria-label="Ringkasan rekomendasi demo">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-user-dashboard-wait-bg">
                        <img class="user-dashboard-icon" src="{{ asset('images/dashboard-insight.svg') }}" alt="" aria-hidden="true">
                    </span>
                    <span>
                        <span class="block font-user-display text-lg font-semibold leading-7 text-user-dashboard-text">Ringkasan Pasar Hari Ini</span>
                        <span class="block text-xs leading-4 text-user-dashboard-secondary">{{ $totalItems }} komoditas dipantau · {{ $totalItems - $unavailable_count }} memiliki forecast demo lengkap · {{ $unavailable_count }} belum tersedia</span>
                    </span>
                </div>
                <div class="flex flex-wrap gap-2.5" aria-label="Jumlah sinyal demo yang tersedia">
                    <span class="user-recommendations-count is-buy"><i aria-hidden="true"></i>{{ $counts['BUY NOW'] }} BELI SEKARANG</span>
                    <span class="user-recommendations-count is-monitor"><i aria-hidden="true"></i>{{ $counts['MONITOR'] }} PANTAU</span>
                    <span class="user-recommendations-count is-wait"><i aria-hidden="true"></i>{{ $counts['WAIT'] }} BISA TUNGGU</span>
                </div>
            </section>

            <section class="user-recommendations-filters flex gap-2 overflow-x-auto pb-1" role="group" aria-label="Filter status rekomendasi">
                @foreach ($filterDefinitions as $filter)
                    <button class="user-recommendations-filter {{ $loop->first ? 'is-active' : '' }} {{ $filter['key'] !== 'all' ? 'is-'.$filter['key'] : '' }}" type="button" data-recommendation-filter="{{ $filter['key'] }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                        <span>{{ $filter['label'] }}</span>
                        <span class="user-recommendations-filter-count">{{ $filter['count'] }}</span>
                    </button>
                @endforeach
            </section>

            <section class="user-recommendations-table-wrap overflow-hidden rounded-xl border border-user-dashboard-border bg-white shadow-sm" aria-label="Daftar rekomendasi komoditas demo">
                <div class="user-recommendations-table-scroll overflow-x-auto">
                    <table class="user-recommendations-table w-full min-w-[980px] text-left text-xs">
                        <thead>
                            <tr>
                                <th scope="col">Komoditas &amp; Jenis</th>
                                <th scope="col">Harga Hari Ini</th>
                                <th scope="col">Estimasi 3 Hari</th>
                                <th scope="col">Rekomendasi</th>
                                <th scope="col">Saran &amp; Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                @php
                                    $signalKey = match ($item['recommendation']) {
                                        'BUY NOW' => 'buy-now',
                                        'WAIT' => 'wait',
                                        'MONITOR' => 'monitor',
                                        default => 'unavailable',
                                    };
                                @endphp
                                <tr class="user-recommendations-row" data-recommendation-row data-recommendation-signal="{{ $signalKey }}">
                                    <td data-label="Komoditas &amp; Jenis">
                                        <div class="flex min-w-[210px] items-center gap-3">
                                            <span class="user-recommendations-commodity-icon is-{{ $item['icon_tone'] }}"><img src="{{ asset('images/'.$item['icon']) }}" alt="" aria-hidden="true"></span>
                                            <span class="min-w-0">
                                                <span class="block font-user-display text-sm font-bold text-user-dashboard-text">{{ $item['name'] }}</span>
                                                <span class="mt-0.5 block text-[10px] leading-4 text-user-dashboard-secondary">{{ $item['category'] }} · {{ $item['market'] }}</span>
                                                <span class="mt-1 block text-[9px] font-bold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td data-label="Harga Hari Ini">
                                        <span class="whitespace-nowrap font-user-display text-base font-bold text-user-dashboard-text">Rp{{ $item['price'] }}</span>
                                        <span class="ml-1 text-[10px] text-user-dashboard-secondary">/{{ $item['unit'] }}</span>
                                    </td>
                                    <td data-label="Estimasi 3 Hari">
                                        @if ($item['recommendation_available'])
                                            <span class="block whitespace-nowrap font-user-display text-sm font-bold text-user-dashboard-text">Rp{{ number_format($item['forecast_3d_value'], 0, ',', '.') }}</span>
                                            <span class="mt-0.5 inline-flex items-center gap-1 rounded bg-user-dashboard-buy-bg px-1.5 py-0.5 text-[9px] font-bold text-user-dashboard-buy-dot">↑ {{ $item['forecast_3d_change_percent'] }}</span>
                                            <span class="ml-1 text-[9px] text-user-dashboard-secondary">demo</span>
                                        @else
                                            <span class="block font-semibold text-user-dashboard-secondary">Belum tersedia</span>
                                            <span class="mt-1 block max-w-[150px] text-[9px] leading-3 text-user-dashboard-secondary">Forecast lengkap belum ada</span>
                                        @endif
                                    </td>
                                    <td data-label="Rekomendasi">
                                        @if ($item['recommendation_available'])
                                            <x-user.signal-badge :signal="$item['recommendation']" />
                                        @else
                                            <span class="user-recommendations-unavailable">Belum tersedia</span>
                                        @endif
                                    </td>
                                    <td data-label="Saran &amp; Aksi">
                                        <div class="flex min-w-[180px] items-center justify-between gap-3">
                                            <p class="user-recommendations-advice">{{ $item['recommendation_reason'] }}</p>
                                            <a class="user-recommendations-detail-link" href="{{ route('user.commodities.show', ['code' => $item['id']]) }}" aria-label="Lihat detail {{ $item['name'] }}">Detail <span aria-hidden="true">→</span></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><div class="user-recommendations-empty"><strong>Rekomendasi belum tersedia</strong><span>Belum ada komoditas yang dapat ditampilkan.</span></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="user-recommendations-filter-empty" data-recommendations-empty hidden role="status" aria-live="polite">
                    <strong>Belum ada rekomendasi untuk filter ini</strong>
                    <span>Sinyal ditampilkan setelah forecast 1–7 hari tersedia dan tervalidasi.</span>
                </div>
                <p class="border-t border-user-dashboard-border px-5 py-2.5 text-[10px] leading-4 text-user-dashboard-secondary">Nilai dan komoditas berasal dari fixture demo. Estimasi hanya ditampilkan jika data forecast 1–7 hari lengkap; sinyal demo bukan keluaran RecommendationService produksi.</p>
            </section>

            <section class="user-recommendations-guide rounded-xl bg-user-dashboard-surface p-5" aria-labelledby="recommendations-guide-heading">
                <h2 id="recommendations-guide-heading" class="flex items-center gap-2 font-user-display text-lg font-semibold text-user-dashboard-text">
                    <img class="user-dashboard-icon" src="{{ asset('images/dashboard-insight.svg') }}" alt="" aria-hidden="true">Cara Membaca Rekomendasi BeliPas
                </h2>
                <p class="mt-1 text-[10px] leading-4 text-user-dashboard-secondary">Panduan umum arti sinyal, bukan hasil prediksi untuk setiap komoditas.</p>
                <div class="user-recommendations-guide-grid mt-4">
                    <article class="user-recommendations-guide-card">
                        <h3><x-user.signal-badge signal="BUY NOW" /> <span>(Beli Sekarang)</span></h3>
                        <p>Beli segera atau tambah stok hari ini sebelum harga berpotensi naik dalam beberapa hari ke depan.</p>
                    </article>
                    <article class="user-recommendations-guide-card">
                        <h3><x-user.signal-badge signal="MONITOR" /> <span>(Pantau)</span></h3>
                        <p>Perubahan harga diperkirakan relatif kecil. Beli secukupnya sesuai kebutuhan dan pantau pembaruan.</p>
                    </article>
                    <article class="user-recommendations-guide-card">
                        <h3><x-user.signal-badge signal="WAIT" /> <span>(Bisa Tunggu)</span></h3>
                        <p>Jika stok masih cukup, pertimbangkan menunda pembelian besar sambil memantau pergerakan harga.</p>
                    </article>
                </div>
            </section>

            <section class="user-recommendations-impact-card flex flex-col items-start justify-between gap-5 rounded-xl p-6 shadow-sm sm:flex-row sm:items-center" aria-label="Efisiensi belanja demo">
                <div class="flex min-w-0 items-center gap-4">
                    <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-white/15"><img class="user-dashboard-icon" src="{{ asset('images/dashboard-savings.svg') }}" alt="" aria-hidden="true"></span>
                    <div>
                        <span class="inline-flex rounded-full bg-user-dashboard-wait-bg px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-user-dashboard-wait-text">DATA DEMO · estimasi ilustratif</span>
                        <h2 class="mt-2 font-user-display text-lg font-semibold text-white">Potensi Penghematan Mingguan: Hingga Rp{{ $demo_savings }}</h2>
                        <p class="mt-1 max-w-2xl text-xs leading-5 text-white/80">Contoh visual rancangan, bukan hasil kalkulasi aktual. Keputusan pembelian tetap berada pada pengguna.</p>
                    </div>
                </div>
                <button class="user-recommendations-schedule-button" type="button" data-dashboard-notice="Penjadwalan belanja belum tersedia pada MVP v1.">
                    <span aria-hidden="true">▦</span> Atur Jadwal Belanja
                </button>
            </section>
        </div>
    </main>
@endsection
