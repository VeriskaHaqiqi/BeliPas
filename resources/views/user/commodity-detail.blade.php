@extends('layouts.user')

@section('title', 'Detail '.$commodity['name'])

@section('content')
    @php
        $recommendationCopy = match ($commodity['signal']) {
            'BUY NOW' => 'Sinyal demo menyarankan pembelian sekarang untuk kebutuhan operasional. Gunakan jumlah sesuai kebutuhan usaha dan pantau pembaruan harga.',
            'WAIT' => 'Sinyal demo menyarankan untuk menunggu sambil memantau perubahan harga sebelum membeli stok berikutnya.',
            default => 'Sinyal demo menyarankan pemantauan rutin. Pertimbangkan pembelian berdasarkan kebutuhan stok usaha.',
        };
        $relatedMarkets = collect($relatedCommodities)->take(3);
    @endphp

    <main class="user-dashboard-main user-detail-main" data-forecast-interaction data-initial-horizon="3">
        <div class="user-detail-container mx-auto flex w-full max-w-[1280px] flex-col gap-6 px-8 py-7">
            <div class="flex flex-wrap items-center justify-between gap-3 text-xs leading-4 text-user-dashboard-secondary">
                <div class="flex flex-wrap items-center gap-2">
                    <a class="user-detail-back-link" href="{{ route('user.dashboard') }}" aria-label="Kembali ke Beranda">
                        <span aria-hidden="true">←</span><span>Kembali ke Beranda</span>
                    </a>
                    <span class="text-user-dashboard-border" aria-hidden="true">/</span>
                    <a class="hover:text-user-dashboard-brand" href="{{ route('user.dashboard') }}">Komoditas</a>
                    <span class="text-user-dashboard-border" aria-hidden="true">/</span>
                    <span class="font-semibold text-user-dashboard-text">{{ $commodity['name'] }}</span>
                </div>
                <p class="flex items-center gap-1.5">
                    <img class="user-dashboard-icon" src="{{ asset('images/dashboard-update.svg') }}" alt="" aria-hidden="true">
                    <span><strong class="font-semibold text-user-dashboard-brand">DATA DEMO</strong> · {{ $commodity['updated_at_label'] }}</span>
                </p>
            </div>

            <section class="user-detail-heading grid items-start gap-5 lg:grid-cols-[minmax(0,1fr)_320px]" aria-labelledby="commodity-heading">
                <div class="flex min-w-0 items-start gap-4">
                    <span class="flex size-[58px] shrink-0 items-center justify-center rounded-2xl bg-user-dashboard-buy-bg">
                        <img class="user-detail-commodity-icon" src="{{ asset('images/'.$commodity['icon']) }}" alt="" aria-hidden="true">
                    </span>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[.08em] text-user-dashboard-brand">{{ $commodity['category'] }} · {{ $commodity['unit'] }}</p>
                        <h1 id="commodity-heading" class="mt-1 font-user-display text-[30px] font-bold leading-9 tracking-[-.025em] text-user-dashboard-text">Detail Komoditas - {{ $commodity['name'] }}</h1>
                        <p class="mt-1 max-w-3xl text-sm leading-5 text-user-dashboard-secondary">{{ $commodity['description'] }}</p>
                        <p class="mt-2 flex items-center gap-1.5 text-xs leading-4 text-user-dashboard-secondary">
                            <img class="user-dashboard-icon" src="{{ asset('images/dashboard-market.svg') }}" alt="" aria-hidden="true">
                            Pasar acuan demo: {{ $commodity['market'] }}
                        </p>
                    </div>
                </div>
                <div class="user-detail-current-price rounded-2xl border border-user-dashboard-border bg-white px-5 py-4 shadow-sm">
                    <p class="text-xs font-medium text-user-dashboard-secondary">Harga terkini <span class="text-[10px] font-bold uppercase tracking-wide text-user-dashboard-brand">· DATA DEMO</span></p>
                    <p class="mt-1 font-user-display text-[34px] font-bold leading-10 tracking-[-.025em] text-user-dashboard-text">Rp{{ $commodity['price'] }}<span class="ml-1 text-sm font-medium tracking-normal text-user-dashboard-secondary">/{{ $commodity['unit'] }}</span></p>
                    <p class="mt-1 flex items-center gap-1.5 text-xs font-semibold {{ $commodity['delta_tone'] === 'wait' ? 'text-user-dashboard-brand-light' : ($commodity['delta_tone'] === 'buy' ? 'text-user-dashboard-buy-dot' : 'text-user-dashboard-monitor-dot') }}">
                        <img class="user-dashboard-icon" src="{{ asset('images/'.$commodity['delta_icon']) }}" alt="" aria-hidden="true">{{ $commodity['delta'] }}
                    </p>
                </div>
            </section>

            <section class="user-detail-recommendation grid gap-4 rounded-2xl border border-user-dashboard-border border-t-4 bg-white p-5 shadow-sm {{ $commodity['signal'] === 'BUY NOW' ? 'border-t-user-dashboard-buy-dot' : ($commodity['signal'] === 'WAIT' ? 'border-t-user-dashboard-brand-light' : 'border-t-user-dashboard-monitor-dot') }} lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center" aria-label="Rekomendasi demo">
                <div class="flex min-w-0 items-start gap-4">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-2xl {{ $commodity['signal'] === 'BUY NOW' ? 'bg-user-dashboard-buy-bg' : ($commodity['signal'] === 'WAIT' ? 'bg-user-dashboard-wait-bg' : 'bg-user-dashboard-monitor-bg') }}">
                        <img class="user-dashboard-icon" src="{{ asset('images/'.$commodity['signal_icon']) }}" alt="" aria-hidden="true">
                    </span>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <x-user.signal-badge :signal="$commodity['signal']" />
                            <span class="text-sm font-semibold text-user-dashboard-text">{{ $commodity['signal_detail'] }}</span>
                            <span class="rounded-full bg-user-dashboard-surface px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO</span>
                        </div>
                        <p class="mt-2 text-sm leading-5 text-user-dashboard-secondary">{{ $recommendationCopy }}</p>
                    </div>
                </div>
                <a href="{{ route('user.commodities.forecast', ['code' => $commodity['id']]) }}" class="user-detail-outline-link inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-user-dashboard-brand px-4 text-sm font-semibold text-user-dashboard-brand transition hover:bg-user-dashboard-surface focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-dashboard-brand">Lihat prakiraan 7 hari <span aria-hidden="true">→</span></a>
            </section>

            <section class="user-detail-chart-card rounded-2xl border border-user-dashboard-border bg-white p-5 shadow-sm" aria-labelledby="chart-heading">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 id="chart-heading" class="font-user-display text-xl font-bold leading-7 text-user-dashboard-text">Tren Harga &amp; Proyeksi</h2>
                            <span class="rounded-full bg-user-dashboard-surface px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO</span>
                        </div>
                        <p class="mt-1 text-sm leading-5 text-user-dashboard-secondary">Riwayat dan ilustrasi proyeksi harga {{ strtolower($commodity['name']) }}.</p>
                    <a class="mt-2 inline-flex text-xs font-semibold text-user-dashboard-brand hover:underline" href="{{ route('user.prediction.explanation', ['code' => $commodity['id']]) }}">Bagaimana akurasi prediksi dijelaskan? <span class="ml-1" aria-hidden="true">→</span></a>
                    </div>
                    @if (count($commodity['forecast']))
                        <div class="inline-flex rounded-xl bg-user-dashboard-surface p-1" role="group" aria-label="Pilih horizon grafik">
                            <button class="user-detail-horizon" type="button" data-price-horizon="3" aria-pressed="false">3 Hari</button>
                            <button class="user-detail-horizon" type="button" data-price-horizon="7" aria-pressed="false">7 Hari</button>
                        </div>
                    @endif
                </div>

                @if (count($commodity['history']))
                    <x-user.price-forecast-chart :commodity="$commodity" />
                    <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-user-dashboard-secondary" aria-label="Legenda grafik">
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-line"></i>Harga historis (demo)</span>
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-line is-forecast"></i>Proyeksi (demo)</span>
                        <span class="inline-flex items-center gap-2"><i class="user-detail-legend-area"></i>Area ilustrasi</span>
                    </div>
                    <p class="mt-3 border-t border-user-dashboard-border pt-3 text-xs leading-5 text-user-dashboard-secondary">Seri dan proyeksi di atas adalah data demo untuk pratinjau antarmuka. Angka ini bukan data pasar aktual atau keluaran model XGBoost.</p>
                @else
                    <div class="mt-5 rounded-xl border border-dashed border-user-dashboard-border bg-[#fbfdfc] px-6 py-14 text-center">
                        <p class="font-semibold text-user-dashboard-text">Grafik belum tersedia</p>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Riwayat dan proyeksi demo untuk komoditas ini belum disediakan. Grafik akan tampil setelah sumber data disepakati tim.</p>
                    </div>
                @endif
            </section>

            <section id="proyeksi-harga" class="user-detail-forecast-card overflow-hidden rounded-2xl border border-user-dashboard-border bg-white shadow-sm" aria-labelledby="forecast-heading">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-user-dashboard-border px-5 py-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 id="forecast-heading" class="font-user-display text-lg font-bold leading-6 text-user-dashboard-text">Proyeksi Rinci Harga</h2>
                            <span class="rounded-full bg-user-dashboard-surface px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-user-dashboard-brand">DATA DEMO</span>
                        </div>
                        <p class="mt-1 text-xs leading-4 text-user-dashboard-secondary">Ilustrasi perubahan harga terhadap harga demo hari ini Rp{{ $commodity['price'] }}/{{ $commodity['unit'] }}.</p>
                    </div>
                    <p class="text-xs leading-4 text-user-dashboard-secondary">Diperbarui: {{ $commodity['updated_at_label'] }}</p>
                </div>
                @if (count($commodity['forecast']))
                    <div class="overflow-x-auto">
                        <table class="user-detail-table w-full min-w-[680px] text-left text-sm">
                            <thead><tr><th scope="col">Horizon</th><th scope="col">Perkiraan harga</th><th scope="col">Selisih vs harga hari ini</th><th scope="col">Sinyal demo</th></tr></thead>
                            <tbody>
                                @foreach (array_slice($commodity['forecast'], 1) as $index => $forecast)
                                    <tr data-forecast-row data-horizon-day="{{ $index + 1 }}" data-forecast-price="{{ $forecast['value'] }}">
                                        <td class="font-semibold text-user-dashboard-text">{{ $forecast['label'] }}</td>
                                        <td>Rp{{ number_format($forecast['value'], 0, ',', '.') }}/{{ $commodity['unit'] }}</td>
                                        <td class="{{ $forecast['change'] >= 0 ? 'text-user-dashboard-buy-dot' : 'text-user-dashboard-brand-light' }}">{{ $forecast['change'] >= 0 ? '+' : '' }}Rp{{ number_format($forecast['change'], 0, ',', '.') }}</td>
                                        <td><x-user.signal-badge :signal="$forecast['signal']" /></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="border-t border-user-dashboard-border px-5 py-3 text-xs leading-5 text-user-dashboard-secondary">Tabel memuat nilai ilustrasi untuk horizon yang dipilih. Seluruh nilai adalah data demo, bukan prediksi produksi.</p>
                @else
                    <div class="px-6 py-12 text-center">
                        <p class="font-semibold text-user-dashboard-text">Proyeksi belum tersedia</p>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Belum ada seri proyeksi demo untuk komoditas ini. Sinyal di atas hanya contoh tampilan dari data Beranda.</p>
                    </div>
                @endif
            </section>

            <section aria-labelledby="related-heading">
                <div class="mb-4 flex flex-wrap items-end justify-between gap-2">
                    <div>
                        <h2 id="related-heading" class="font-user-display text-lg font-bold leading-6 text-user-dashboard-text">Komoditas lain yang dipantau</h2>
                        <p class="mt-1 text-xs leading-4 text-user-dashboard-secondary">Nilai mengikuti fixture demo yang sama dengan Beranda.</p>
                    </div>
                    <a class="text-xs font-semibold text-user-dashboard-brand hover:underline" href="{{ route('user.dashboard') }}">Kembali ke Beranda →</a>
                </div>
                <div class="user-detail-related-grid">
                    @foreach ($relatedMarkets as $related)
                        <a class="user-detail-related-card" href="{{ route('user.commodities.show', ['code' => $related['id']]) }}">
                            <div class="flex items-start justify-between gap-2">
                                <span class="flex size-10 items-center justify-center rounded-xl {{ $related['icon_tone'] === 'buy' ? 'bg-user-dashboard-buy-bg' : ($related['icon_tone'] === 'onion' ? 'bg-[#eee9dd]' : ($related['icon_tone'] === 'oil' ? 'bg-[#f6efdc]' : 'bg-user-dashboard-surface')) }}"><img class="user-dashboard-icon" src="{{ asset('images/'.$related['icon']) }}" alt="" aria-hidden="true"></span>
                                <x-user.signal-badge :signal="$related['signal']" />
                            </div>
                            <p class="mt-4 font-user-display text-sm font-bold text-user-dashboard-text">{{ $related['name'] }}</p>
                            <p class="mt-1 text-xs text-user-dashboard-secondary">Rp{{ $related['price'] }}/{{ $related['unit'] }}</p>
                            <p class="mt-3 border-t border-user-dashboard-border pt-3 text-[11px] text-user-dashboard-secondary">{{ $related['delta'] }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        </div>
    </main>
@endsection
