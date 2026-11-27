@extends('layouts.public')

@section('title', 'Beli di Waktu yang Tepat')

@section('content')
    <header class="public-landing-header" data-public-header>
        <div class="public-landing-header-inner">
            <a href="{{ route('landing') }}" class="public-landing-brand" aria-label="BeliPas, halaman utama"><x-user.brand-logo /></a>
            <button class="public-landing-menu-toggle" type="button" data-public-menu-toggle aria-controls="public-navigation" aria-expanded="false" aria-label="Buka menu navigasi"><span></span><span></span><span></span></button>
            <nav class="public-landing-nav" id="public-navigation" data-public-menu aria-label="Navigasi landing page">
                <div class="public-landing-nav-links">
                    <a href="#tantangan">Tantangan</a>
                    <a href="#cara-kerja">Cara Kerja</a>
                    <a href="#sinyal">Sinyal</a>
                    <a href="#komoditas">Komoditas</a>
                    <a href="#simulasi">Simulasi</a>
                </div>
                <div class="public-landing-nav-actions">
                    <a class="public-landing-login" href="{{ route('login') }}">Masuk</a>
                    <a class="public-landing-register" href="{{ route('register') }}">Daftar</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="public-landing-hero" aria-labelledby="landing-title">
            <div class="public-landing-hero-inner">
                <div class="public-landing-hero-copy">
                    <span class="public-landing-eyebrow"><i aria-hidden="true"></i> INFORMASI HARGA &amp; ESTIMASI KOMODITAS</span>
                    <h1 id="landing-title">Beli di waktu yang tepat,<br><span>rencana usaha lebih terarah</span></h1>
                    <p>BeliPas membantu UMKM kuliner memahami harga bahan baku dan estimasi pergerakannya 1–7 hari ke depan. Gunakan informasinya untuk mempertimbangkan waktu belanja dengan lebih tenang.</p>
                    <div class="public-landing-hero-actions">
                        <a class="public-landing-primary-button" href="{{ route('user.dashboard') }}">Lihat Pratinjau <span aria-hidden="true">→</span></a>
                        <a class="public-landing-secondary-button" href="#cara-kerja">Pelajari Cara Kerja</a>
                    </div>
                    <p class="public-landing-hero-footnote">Pratinjau memakai data demo. Prediksi adalah estimasi, bukan jaminan harga.</p>
                    <div class="public-landing-trust-strip" aria-label="Tentang BeliPas">
                        <span><i aria-hidden="true">✓</i> Dirancang untuk UMKM kuliner</span>
                        <span><i aria-hidden="true">✓</i> Horizon estimasi 1–7 hari</span>
                        <span><i aria-hidden="true">✓</i> Sinyal belanja yang ringkas</span>
                    </div>
                </div>

                <div class="public-landing-preview-wrap" aria-label="Pratinjau demo BeliPas">
                    <div class="public-landing-preview-glow" aria-hidden="true"></div>
                    <div class="public-landing-preview-window">
                        <div class="public-landing-preview-topbar">
                            <span class="public-landing-window-dots" aria-hidden="true"><i></i><i></i><i></i></span>
                            <span>Pratinjau ringkasan harga</span>
                            <span class="public-landing-demo-pill">DATA DEMO</span>
                        </div>
                        <div class="public-landing-preview-market"><img src="{{ asset('images/landing-hero-01.svg') }}" alt="" aria-hidden="true"><span>Pasar acuan contoh · Pembaruan demo</span><span class="public-landing-preview-time">DATA DEMO</span></div>
                        <div class="public-landing-preview-cards">
                            @foreach ($previewCommodities as $commodity)
                                <article class="public-landing-preview-card">
                                    <div class="public-landing-preview-card-heading">
                                        <div class="public-landing-preview-name"><img src="{{ asset('images/'.$commodity['icon']) }}" alt="" aria-hidden="true"><span><strong>{{ $commodity['name'] }}</strong><small>{{ $commodity['market'] }}</small></span></div>
                                        <x-user.signal-badge :signal="$commodity['signal']" />
                                    </div>
                                    <div class="public-landing-preview-price"><span><small>Harga demo</small><strong>Rp {{ $commodity['price'] }} <small>/ {{ $commodity['unit'] }}</small></strong></span><span class="public-landing-preview-movement">{{ $commodity['trend'] }}<img src="{{ asset('images/'.($commodity['signal'] === 'BUY NOW' ? 'landing-hero-02.svg' : ($commodity['signal'] === 'WAIT' ? 'landing-hero-05.svg' : 'landing-hero-06.svg'))) }}" alt="" aria-hidden="true"></span></div>
                                    @if ($loop->first)
                                        <div class="public-landing-sparkline" aria-hidden="true"><img src="{{ asset('images/landing-hero-03.svg') }}" alt=""><img src="{{ asset('images/landing-hero-04.svg') }}" alt=""></div>
                                    @else
                                        <div class="public-landing-preview-divider" aria-hidden="true"></div>
                                    @endif
                                    <p class="public-landing-preview-caption">Ilustrasi antarmuka · bukan harga pasar terkini</p>
                                </article>
                            @endforeach
                        </div>
                        <div class="public-landing-preview-footer"><img src="{{ asset('images/landing-hero-07.svg') }}" alt="" aria-hidden="true"><span>Gunakan perkiraan sebagai bahan pertimbangan belanja</span><a href="{{ route('user.dashboard') }}">Buka demo <img src="{{ asset('images/landing-hero-08.svg') }}" alt="" aria-hidden="true"></a></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="public-landing-section public-landing-problems" id="tantangan" aria-labelledby="landing-problems-title">
            <div class="public-landing-section-inner">
                <div class="public-landing-section-heading">
                    <span class="public-landing-section-kicker is-coral">TANTANGAN UMKM KULINER</span>
                    <h2 id="landing-problems-title">Mengapa belanja bahan baku sering<br>terasa sulit diperkirakan?</h2>
                    <p>Perubahan harga dan informasi yang tersebar dapat membuat perencanaan belanja harian menjadi tantangan.</p>
                </div>
                <div class="public-landing-problem-grid">
                    @foreach ($problems as $problem)
                        <article class="public-landing-problem-card">
                            <span class="public-landing-problem-icon"><img src="{{ asset('images/'.$problem['icon']) }}" alt="" aria-hidden="true"></span>
                            <h3>{{ $problem['title'] }}</h3>
                            <p>{{ $problem['copy'] }}</p>
                            <div class="public-landing-card-note"><strong>Dampak:</strong> {{ $problem['impact'] }}.</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="public-landing-section public-landing-how" id="cara-kerja" aria-labelledby="landing-how-title">
            <div class="public-landing-section-inner">
                <div class="public-landing-section-heading">
                    <span class="public-landing-section-kicker is-mint">METODOLOGI PRAKTIS</span>
                    <h2 id="landing-how-title">Cara Kerja BeliPas: Dari Informasi ke<br>Rencana Belanja</h2>
                    <p>Alur sederhana untuk membaca harga dan mempertimbangkan kebutuhan belanja usaha Anda.</p>
                </div>
                <div class="public-landing-step-grid">
                    @foreach ($steps as $index => $step)
                        <article class="public-landing-step-card">
                            <div class="public-landing-step-top"><span>{{ $index + 1 }}</span><i aria-hidden="true"></i></div>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['copy'] }}</p>
                            <div class="public-landing-step-foot"><span>{{ $step['detail'] }}</span><span aria-hidden="true">→</span></div>
                        </article>
                    @endforeach
                </div>
                <p class="public-landing-steps-note"><strong>Catatan:</strong> Ketersediaan harga dan estimasi bergantung pada data yang tersedia. Informasi pada pratinjau saat ini menggunakan data demo.</p>
            </div>
        </section>

        <section class="public-landing-section public-landing-signals" id="sinyal" aria-labelledby="landing-signals-title">
            <div class="public-landing-section-inner">
                <div class="public-landing-section-heading">
                    <span class="public-landing-section-kicker is-slate">KAMUS SINYAL BELIPAS</span>
                    <h2 id="landing-signals-title">Rekomendasi yang mudah dipahami<br>untuk membantu pertimbangan</h2>
                    <p>Tiga label membantu merangkum arah estimasi. Tetap sesuaikan keputusan dengan stok dan kebutuhan usaha.</p>
                </div>
                <div class="public-landing-signal-grid">
                    @foreach ($signals as $item)
                        <article class="public-landing-signal-card signal-{{ strtolower(str_replace(' ', '-', $item['signal'])) }}">
                            <div class="public-landing-signal-card-head"><img src="{{ asset('images/'.$item['icon']) }}" alt="" aria-hidden="true"><x-user.signal-badge :signal="$item['signal']" /></div>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['copy'] }}</p>
                            <div class="public-landing-signal-action"><strong>Arahan pertimbangan</strong><span>{{ $item['action'] }}</span></div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="public-landing-section public-landing-commodities" id="komoditas" aria-labelledby="landing-commodities-title">
            <div class="public-landing-section-inner">
                <div class="public-landing-section-heading public-landing-commodity-heading">
                    <div><span class="public-landing-section-kicker is-mint">CAKUPAN KOMODITAS</span><h2 id="landing-commodities-title">Komoditas yang menjadi<br>fokus pratinjau</h2><p>Daftar ini mengikuti contoh komoditas yang tersedia pada halaman demo BeliPas.</p></div>
                    <a href="{{ route('user.dashboard') }}">Lihat pratinjau komoditas <span aria-hidden="true">→</span></a>
                </div>
                <div class="public-landing-commodity-grid">
                    @foreach ($categories as $category)
                        <a class="public-landing-commodity-card" href="{{ route('user.commodities.show', ['code' => $category['id']]) }}">
                            <span class="public-landing-commodity-image"><img src="{{ asset('images/'.$category['icon']) }}" alt="" aria-hidden="true"></span>
                            <h3>{{ $category['title'] }}</h3>
                            <p>{{ $category['detail'] }}</p>
                            <span class="public-landing-commodity-status">{{ $category['status'] }}</span>
                        </a>
                    @endforeach
                </div>
                <p class="public-landing-commodity-note">Komoditas dan harga di halaman publik ini adalah contoh antarmuka; ketersediaan data produksi belum ditampilkan.</p>
            </div>
        </section>

        <section class="public-landing-section public-landing-savings" id="simulasi" aria-labelledby="landing-savings-title">
            <div class="public-landing-savings-card">
                <div class="public-landing-savings-copy">
                    <span class="public-landing-section-kicker is-mint">KALKULATOR SKENARIO</span>
                    <h2 id="landing-savings-title">Buat simulasi anggaran belanja</h2>
                    <p>Masukkan anggaran dan asumsi efisiensi Anda untuk melihat hitungan skenario sederhana. Angka ini bukan hasil pengukuran BeliPas.</p>
                    <label for="landing-budget">Anggaran bahan baku per bulan <span class="public-landing-demo-inline">DATA DEMO</span></label>
                    <div class="public-landing-budget-value">Rp <output data-budget-display>15.000.000</output></div>
                    <input id="landing-budget" type="range" min="3000000" max="60000000" step="1000000" value="15000000" data-budget-slider aria-describedby="landing-budget-help">
                    <div class="public-landing-budget-scale"><span>Rp3 juta</span><span>Rp30 juta</span><span>Rp60 juta</span></div>
                    <p id="landing-budget-help" class="public-landing-budget-help">Geser untuk mengubah anggaran contoh. Masukkan asumsi skenario untuk menghitung ilustrasi.</p>
                </div>
                <div class="public-landing-savings-results">
                    <div class="public-landing-assumption-box"><label for="landing-savings-rate">Asumsi efisiensi skenario</label><div><input id="landing-savings-rate" type="number" min="0" max="100" step="0.1" inputmode="decimal" placeholder="mis. 5" data-savings-rate><span>%</span></div><small>Masukan Anda sendiri; bukan angka akurasi model.</small></div>
                    <div class="public-landing-savings-result"><span>Hasil simulasi / bulan</span><strong data-savings-display>Masukkan asumsi</strong><small>Perhitungan anggaran × asumsi efisiensi</small></div>
                    <div class="public-landing-savings-result is-secondary"><span>Efisiensi model BeliPas</span><strong>Belum tersedia</strong><small>Menunggu hasil evaluasi yang tervalidasi.</small></div>
                    <p class="public-landing-savings-disclaimer">Simulasi ini tidak memprediksi penghematan aktual dan tidak menjamin hasil usaha.</p>
                </div>
            </div>
        </section>

        <section class="public-landing-cta" aria-labelledby="landing-cta-title">
            <div class="public-landing-cta-inner">
                <div><span class="public-landing-section-kicker is-mint">BELANJA DENGAN INFORMASI</span><h2 id="landing-cta-title">Rencanakan belanja bahan baku<br>dengan pertimbangan lebih jelas</h2><p>Masuk untuk melihat pratinjau fitur BeliPas. Estimasi harga tetap menjadi bahan pertimbangan, bukan kepastian.</p></div>
                <div class="public-landing-cta-actions"><a class="public-landing-primary-button" href="{{ route('login') }}">Masuk <span aria-hidden="true">→</span></a><a class="public-landing-secondary-button" href="{{ route('register') }}">Daftar</a></div>
            </div>
        </section>
    </main>

    <footer class="public-landing-footer">
        <a href="{{ route('landing') }}" class="public-landing-brand"><x-user.brand-logo /></a>
        <p>© {{ date('Y') }} BeliPas. Informasi harga dan estimasi untuk membantu pertimbangan UMKM kuliner.</p>
        <nav aria-label="Tautan footer"><a href="{{ route('user.prediction.explanation') }}">Pusat Bantuan</a><a href="#cara-kerja">Cara Kerja</a><a href="{{ route('login') }}">Masuk</a></nav>
    </footer>
@endsection
