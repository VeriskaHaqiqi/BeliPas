@extends('layouts.user')

@section('title', 'Beranda UMKM')

@section('content')
    <main class="user-dashboard-main">
        <div class="user-dashboard-container mx-auto flex w-full max-w-[1280px] flex-col gap-6 px-8 py-8">
            <section class="flex flex-col justify-between gap-6 border-b border-user-dashboard-border pb-6 lg:flex-row lg:items-end" aria-labelledby="dashboard-heading">
                <div class="min-w-0">
                    <p class="flex flex-wrap items-center gap-2 text-xs leading-4 text-user-dashboard-secondary">
                        <span class="size-2 rounded-full bg-user-dashboard-brand" aria-hidden="true"></span>
                        <span class="font-bold uppercase tracking-[.05em] text-user-dashboard-brand">Pusat Intelijen Pasar F&amp;B</span>
                        <span class="text-user-dashboard-border" aria-hidden="true">·</span>
                        <span>Halo {{ $profile['owner_name'] }} ({{ $profile['business_name'] }})</span>
                    </p>
                    <h1 id="dashboard-heading" class="user-dashboard-heading-title mt-1.5 font-user-display text-[32px] font-bold leading-10 tracking-[-.025em] text-user-dashboard-text">
                        Beranda — Ringkasan Harga &amp; Rekomendasi Belanja
                    </h1>
                    <p class="mt-1 max-w-[672px] text-base leading-6 text-user-dashboard-secondary">
                        Pantau pergerakan harga komoditas pangan dan rekomendasi belanja cerdas untuk usaha Anda hari ini.
                    </p>
                    <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs leading-4 text-user-dashboard-secondary">
                        <img class="user-dashboard-icon" src="{{ asset('images/dashboard-update.svg') }}" alt="" aria-hidden="true">
                        <span><strong class="font-semibold text-user-dashboard-brand">DATA DEMO</strong> · waktu contoh {{ $updated_at_label }} dari {{ $updated_sources_label }}</span>
                    </p>
                </div>

                <aside class="flex shrink-0 items-center gap-3 rounded-xl bg-user-dashboard-surface px-4 py-2.5 shadow-sm" aria-label="Pasar acuan contoh">
                    <img class="user-dashboard-icon" src="{{ asset('images/dashboard-market.svg') }}" alt="" aria-hidden="true">
                    <span>
                        <span class="block text-xs leading-3 text-user-dashboard-secondary">Pasar Acuan Utama</span>
                        <span class="block text-sm font-bold leading-5 tracking-[.01em] text-user-dashboard-text">{{ $market }}</span>
                    </span>
                </aside>
            </section>

            <section class="flex flex-col gap-4 rounded-xl bg-user-dashboard-surface p-5 shadow-sm" aria-label="Ringkasan sinyal dan filter komoditas">
                <div class="user-dashboard-summary-indicators flex flex-wrap items-center gap-3">
                    @foreach ([['BUY NOW', 'bahan disarankan beli'], ['MONITOR', 'bahan perlu dipantau'], ['WAIT', 'bahan bisa ditunggu']] as [$signal, $description])
                        <div class="flex items-center gap-2.5 rounded-full bg-white px-3.5 py-2 shadow-sm">
                            <x-user.signal-badge :signal="$signal" />
                            <span class="text-sm font-semibold text-user-dashboard-text">{{ $signal_counts[$signal] ?? 0 }} {{ $description }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="user-dashboard-filter-list flex items-center gap-2 overflow-x-auto" role="group" aria-label="Filter kategori komoditas">
                    @foreach ([['all', 'Semua'], ['cabai', 'Cabai'], ['bawang', 'Bawang'], ['minyak-goreng', 'Minyak Goreng'], ['ayam', 'Ayam'], ['telur', 'Telur']] as [$key, $label])
                        <button
                            class="user-dashboard-filter {{ $loop->first ? 'is-active' : '' }}"
                            type="button"
                            data-category-filter="{{ $key }}"
                            aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            @if ($loop->first)
                                <img class="user-dashboard-icon mr-1" src="{{ asset('images/dashboard-filter-all.svg') }}" alt="" aria-hidden="true">
                            @endif
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </section>

            <section class="user-dashboard-grid" aria-label="Daftar ringkasan harga komoditas contoh">
                @forelse ($commodities as $commodity)
                    <x-user.commodity-card :commodity="$commodity" />
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-user-dashboard-border bg-white px-6 py-12 text-center" data-commodity-empty>
                        <h2 class="font-user-display text-lg font-semibold text-user-dashboard-text">Belum ada data komoditas</h2>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Daftar harga dan rekomendasi akan tampil setelah tersedia data yang sesuai.</p>
                    </div>
                @endforelse

                @if (count($commodities) > 0)
                    <div class="user-dashboard-quick-add flex min-h-[436px] flex-col justify-between rounded-xl bg-[linear-gradient(132deg,#eff5f3_0%,#e9efed_50%,#e3e9e7_100%)] p-5 shadow-sm">
                        <div>
                            <span class="flex size-12 items-center justify-center rounded-xl bg-user-dashboard-brand shadow-sm">
                                <img class="user-dashboard-icon" src="{{ asset('images/dashboard-expense.svg') }}" alt="" aria-hidden="true">
                            </span>
                            <h2 class="mt-4 font-user-display text-xl font-semibold leading-7 text-user-dashboard-text">Catat Pengeluaran Hari Ini?</h2>
                            <p class="mt-2 text-base leading-6 text-user-dashboard-secondary">
                                Contoh rancangan pencatatan belanja pagi untuk membantu tim memahami alur pembelian UMKM.
                            </p>
                            <div class="mt-3 flex items-center gap-3 rounded-xl bg-white p-3">
                                <img class="user-dashboard-icon" src="{{ asset('images/dashboard-demo-indicator.svg') }}" alt="" aria-hidden="true">
                                <span>
                                    <span class="block text-xs font-semibold leading-4 text-user-dashboard-text">Ilustrasi fitur, DATA DEMO</span>
                                    <span class="block text-xs leading-4 text-user-dashboard-secondary">Belum ada kalkulasi akurasi atau data transaksi.</span>
                                </span>
                            </div>
                        </div>
                        <button class="user-dashboard-card-button mt-6 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-user-dashboard-brand px-4 text-sm font-medium text-white shadow-sm transition hover:bg-[#003a37] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-user-dashboard-wait-bg focus-visible:ring-offset-2" type="button" data-dashboard-notice="Pencatatan belanja belum tersedia pada MVP v1.">
                            <img class="user-dashboard-icon" src="{{ asset('images/dashboard-add-cart.svg') }}" alt="" aria-hidden="true">
                            + Catat Belanja Pagi Ini
                        </button>
                    </div>
                    <div class="col-span-full rounded-xl border border-dashed border-user-dashboard-border bg-white px-6 py-10 text-center" data-category-empty hidden role="status" aria-live="polite">
                        <h2 class="font-user-display text-lg font-semibold text-user-dashboard-text">Belum ada komoditas pada kategori ini</h2>
                        <p class="mt-2 text-sm text-user-dashboard-secondary">Pilih kategori lain untuk melihat data contoh yang tersedia.</p>
                    </div>
                @endif
            </section>

            @if (count($commodities) > 0)
                <section class="user-dashboard-impact-card relative flex items-center justify-between gap-6 overflow-hidden rounded-xl bg-user-dashboard-monitor-bg p-6 shadow-sm" aria-labelledby="savings-heading">
                    <span class="pointer-events-none absolute -bottom-8 -right-8 size-44 rounded-full bg-[#ffb957] opacity-30" aria-hidden="true"></span>
                    <div class="user-dashboard-impact-copy relative flex min-w-0 items-center gap-4">
                        <span class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-white shadow-sm">
                            <img class="user-dashboard-icon" src="{{ asset('images/dashboard-savings.svg') }}" alt="" aria-hidden="true">
                        </span>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-white px-2.5 py-0.5 text-xs font-medium uppercase leading-4 text-[#664100]">DATA DEMO · Estimasi ilustratif</span>
                                <span class="text-xs text-[#643f00]">Pekan ini</span>
                            </div>
                            <h2 id="savings-heading" class="mt-1 font-user-display text-2xl font-semibold leading-8 tracking-[-.025em] text-user-dashboard-monitor-text">Potensi Penghematan Belanja Anda</h2>
                            <p class="mt-1 text-base leading-[26px] text-user-dashboard-monitor-text">
                                Contoh dari desain: berpotensi menghemat sekitar <strong class="font-bold underline decoration-[#865600] decoration-2 underline-offset-2">Rp{{ $demo_savings }}</strong> untuk 5 bahan utama. Nilai ini bukan hasil perhitungan aktual.
                            </p>
                        </div>
                    </div>
                    <a class="relative inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-user-dashboard-brand px-6 text-sm font-medium text-white shadow-sm transition hover:bg-[#003a37] focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-user-dashboard-wait-bg focus-visible:ring-offset-2" href="{{ route('user.recommendations.index') }}">
                        Lihat Semua Rekomendasi
                        <img class="user-dashboard-icon" src="{{ asset('images/dashboard-recommendation-arrow.svg') }}" alt="" aria-hidden="true">
                    </a>
                </section>
            @endif

        </div>
    </main>
@endsection
