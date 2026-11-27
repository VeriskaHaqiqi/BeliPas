@extends('layouts.user')

@section('title', 'Evaluasi & Akurasi Prediksi')

@section('content')
    <main class="user-dashboard-main user-prediction-page" data-forecast-interaction data-initial-horizon="7">
        <div class="user-prediction-container mx-auto flex w-full max-w-[1280px] flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            <section class="user-prediction-heading" aria-labelledby="prediction-page-title">
                <div class="user-prediction-topline">
                    <div class="user-prediction-breadcrumbs">
                        <a href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}" class="user-prediction-back-link"><span aria-hidden="true">←</span> Kembali ke Detail Komoditas</a>
                        <span class="user-prediction-crumb-separator" aria-hidden="true">•</span>
                        <nav aria-label="Breadcrumb">
                            <a href="{{ route('user.dashboard') }}">Beranda</a><span aria-hidden="true">›</span>
                            <a href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}">{{ $commodity['name'] }}</a><span aria-hidden="true">›</span>
                            <span aria-current="page">Akurasi Prediksi</span>
                        </nav>
                    </div>

                    <label class="user-prediction-commodity-picker">
                        <img src="{{ asset('images/dashboard-nav-commodities.svg') }}" alt="" aria-hidden="true">
                        <span><small>Pilihan Komoditas &amp; Pasar</small>
                            <select aria-label="Pilih komoditas" data-prediction-commodity-select>
                                @foreach ($commodities as $item)
                                    <option value="{{ route('user.prediction.explanation', ['code' => $item['id']]) }}" @selected($item['id'] === $commodity['id'])>{{ $item['name'] }} · {{ $item['market'] }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="user-prediction-select-chevron" aria-hidden="true">⌄</span>
                    </label>
                </div>

                <div class="user-prediction-title-row">
                    <div class="user-prediction-title-copy">
                        <span class="user-prediction-eyebrow"><i aria-hidden="true"></i> TRANSPARANSI PREDIKSI</span>
                        <h1 id="prediction-page-title">Evaluasi &amp; Akurasi Prediksi</h1>
                        <p>Pelajari cara kerja perkiraan harga BeliPas, arti hasilnya, dan hal yang perlu dipertimbangkan sebelum mengambil keputusan belanja.</p>
                    </div>
                    <div class="user-prediction-evaluation-status"><span aria-hidden="true">ⓘ</span><span>Evaluasi model: <strong>Belum tersedia</strong></span></div>
                </div>
            </section>

            <aside class="user-prediction-data-notice" role="note">
                <span class="user-prediction-notice-icon" aria-hidden="true">i</span>
                <p><strong>Hasil evaluasi model belum tersedia.</strong> Nilai akurasi dan metrik pada rancangan Figma merupakan contoh desain. Kami tidak menampilkan angka evaluasi sebelum hasil pengujian model disediakan dan disepakati tim.</p>
            </aside>

            <section class="user-prediction-metrics" aria-label="Ringkasan evaluasi model">
                @foreach ($evaluationMetrics as $metric)
                    <article class="user-prediction-metric-card">
                        <div class="user-prediction-metric-top">
                            <span class="user-prediction-metric-icon"><img src="{{ asset('images/'.$metric['icon']) }}" alt="" aria-hidden="true"></span>
                            <span class="user-prediction-metric-tag">{{ $metric['tag'] }}</span>
                        </div>
                        <h2>{{ $metric['title'] }}</h2>
                        <p class="user-prediction-metric-value">{{ $metric['value'] ?? 'Belum tersedia' }}@if ($metric['value'] !== null)<small>{{ $metric['suffix'] }}</small>@endif</p>
                        <p class="user-prediction-metric-description">{{ $metric['description'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="user-prediction-comparison-grid" aria-label="Perbandingan metode dan contoh grafik">
                <article class="user-prediction-panel user-prediction-method-panel" aria-labelledby="prediction-method-title">
                    <div class="user-prediction-panel-heading">
                        <div><h2 id="prediction-method-title">Perbandingan Evaluasi</h2><p>Perbandingan baru ditampilkan setelah hasil uji tersedia.</p></div>
                        <span class="user-prediction-panel-note">Data belum tersedia</span>
                    </div>
                    <div class="user-prediction-method-list">
                        @foreach ($comparisonMethods as $index => $method)
                            <div class="user-prediction-method-row {{ $index === 2 ? 'is-belipas' : '' }}">
                                <div class="user-prediction-method-label"><strong>{{ $method['name'] }}</strong><span>{{ $method['description'] }}</span></div>
                                <span class="user-prediction-empty-value">Belum tersedia</span>
                                <div class="user-prediction-empty-track" aria-hidden="true"><span></span></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="user-prediction-period"><span>Jumlah sampel</span><strong>Belum tersedia</strong><span>Periode evaluasi</span><strong>Belum ditetapkan</strong></div>
                </article>

                <article class="user-prediction-panel user-prediction-chart-panel" aria-labelledby="prediction-chart-title">
                    <div class="user-prediction-panel-heading user-prediction-chart-heading">
                        <div><h2 id="prediction-chart-title">Harga Historis &amp; Ilustrasi Proyeksi</h2><p>{{ $commodity['name'] }} · {{ $commodity['market'] }} ({{ $commodity['unit'] }})</p></div>
                        <span class="user-prediction-demo-badge">DATA DEMO</span>
                    </div>

                    @if (count($commodity['history']) > 1 && count($commodity['forecast']) > 1)
                        <x-user.price-forecast-chart :commodity="$commodity" />
                        <div class="user-prediction-legend" aria-label="Legenda grafik">
                            <span><i class="user-prediction-legend-line"></i>Harga historis demo</span>
                            <span><i class="user-prediction-legend-line is-projection"></i>Ilustrasi proyeksi</span>
                        </div>
                        <p class="user-prediction-chart-note">Grafik memakai fixture yang sama dengan halaman komoditas. Ini bukan rekaman transaksi pasar atau hasil evaluasi XGBoost.</p>
                    @else
                        <div class="user-prediction-chart-empty"><strong>Grafik belum tersedia</strong><span>Seri historis atau contoh proyeksi belum disediakan untuk {{ $commodity['name'] }}.</span></div>
                    @endif
                </article>
            </section>

            <section class="user-prediction-methodology" aria-labelledby="prediction-methodology-title">
                <span class="user-prediction-methodology-icon"><img src="{{ asset('images/prediction-methodology.svg') }}" alt="" aria-hidden="true"></span>
                <div>
                    <div class="user-prediction-methodology-title"><h2 id="prediction-methodology-title">Bagaimana BeliPas Bekerja?</h2><span>Penjelasan sederhana</span></div>
                    <p>Model XGBoost dirancang untuk mempelajari pola dari data historis yang disiapkan tim, lalu menyusun perkiraan harga untuk horizon <strong>1–7 hari</strong>. Hasil perkiraan menjadi salah satu masukan bagi sinyal belanja BeliPas. Rincian input, formula, dan hasil evaluasi akan ditampilkan setelah kontrak data dan evaluasinya disepakati.</p>
                </div>
            </section>

            <aside class="user-prediction-disclaimer" aria-label="Batasan prediksi">
                <img src="{{ asset('images/settings-info.svg') }}" alt="" aria-hidden="true">
                <p><strong>Prediksi adalah estimasi, bukan jaminan harga di masa depan.</strong> Harga dapat berubah karena kondisi pasar dan ketersediaan data. Gunakan informasi ini sebagai bahan pertimbangan, lalu sesuaikan pembelian dengan stok, kebutuhan, dan harga pemasok Anda.</p>
            </aside>

            <div class="user-prediction-page-actions">
                <a href="{{ route('user.commodities.show', ['code' => $commodity['id']]) }}" class="user-prediction-primary-link">Kembali ke Detail Komoditas <span aria-hidden="true">→</span></a>
                <a href="{{ route('user.dashboard') }}" class="user-prediction-secondary-link">Kembali ke Beranda</a>
            </div>
        </div>
        <x-user.dashboard-footer />
    </main>
@endsection
