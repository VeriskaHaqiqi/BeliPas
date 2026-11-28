@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <main class="user-auth-main flex min-h-screen items-center justify-center px-4 py-6 lg:py-[max(24px,calc((100vh-900px)/2))]">
        <div class="user-auth-shell relative grid min-h-[900px] w-full max-w-[1440px] grid-cols-2 overflow-hidden rounded-xl bg-white shadow-[0_20px_25px_-5px_rgba(0,0,0,.1),0_8px_10px_-6px_rgba(0,0,0,.1)]">
            <section class="user-auth-brand-panel relative isolate flex flex-col justify-between overflow-hidden bg-user-surface-soft p-10 lg:p-16" aria-labelledby="brand-heading">
                <div class="pointer-events-none absolute -left-24 -top-24 -z-10 size-96 rounded-full bg-user-mint/40 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-10 right-4 -z-10 size-80 rounded-full bg-user-sand/30 blur-2xl"></div>

                <div class="relative flex flex-col items-start gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-user.brand-logo />
                        <span class="rounded-full bg-[#dce4e1] px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[.05em] text-user-accent">Untuk UMKM Kuliner</span>
                    </div>

                    <div class="user-auth-brand-heading max-w-[512px] pt-2 lg:pt-4">
                        <h1 id="brand-heading" class="font-user-display text-3xl font-bold leading-tight tracking-[-.025em] text-user-text lg:text-4xl lg:leading-[44px]">
                            Beli di waktu yang tepat.
                        </h1>
                        <p class="mt-3 max-w-[448px] text-base leading-6 text-user-text-secondary">
                            Masuk untuk memantau prakiraan harga komoditas pangan harian dan menjaga margin usaha kuliner Anda tetap sehat.
                        </p>
                    </div>
                </div>

                <figure class="user-auth-preview relative mx-auto w-full max-w-[448px] rounded-2xl bg-white/80 p-6 shadow-sm backdrop-blur-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-xs font-semibold text-user-text">
                            <span aria-hidden="true" class="size-2.5 rounded-full bg-user-brand"></span>
                            <span>Tren Belanja Pasar Induk</span>
                        </div>
                        <span class="rounded-full bg-user-mint px-2 py-0.5 text-[11px] font-semibold text-[#00201e]">Pratinjau</span>
                    </div>

                    <div class="overflow-hidden rounded-xl bg-[#e8f0ed]">
                        <img
                            class="user-auth-illustration"
                            src="{{ asset('images/login-market-preview.png') }}"
                            width="400"
                            height="192"
                            alt="Ilustrasi grafik contoh perubahan harga cabai; nilai pada ilustrasi bukan data aktual BeliPas."
                        >
                    </div>

                    <figcaption class="mt-4 flex flex-wrap items-center justify-between gap-x-3 gap-y-2 text-[11px] font-semibold tracking-wide text-user-text-secondary">
                        <span class="flex items-center gap-1.5"><span aria-hidden="true" class="size-2 rounded-full bg-user-brand"></span>Ilustrasi data</span>
                        <span class="flex items-center gap-1.5"><span aria-hidden="true" class="size-2 rounded-full bg-user-accent"></span>Bukan harga aktual</span>
                        <span class="text-user-accent">DATA DEMO</span>
                    </figcaption>
                </figure>

                <aside class="user-auth-testimonial relative flex w-full items-start gap-4 rounded-2xl bg-white p-6 shadow-sm" aria-label="Informasi tentang rekomendasi BeliPas">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-user-sand">
                        <img src="{{ asset('images/quote-mark.svg') }}" alt="" aria-hidden="true">
                    </span>
                    <div>
                        <p class="text-sm leading-[1.65] text-user-text">
                            BeliPas menyajikan perkiraan harga sebagai bahan pertimbangan. Keputusan pembelian tetap berada di tangan Anda.
                        </p>
                        <p class="mt-2 text-xs font-semibold text-user-text-secondary">Informasi untuk pengguna</p>
                    </div>
                </aside>
            </section>

            <section class="user-auth-form-panel flex items-center justify-center bg-white px-8 py-12 lg:px-[72px]" aria-labelledby="login-heading">
                <div class="user-auth-form-card w-full max-w-[480px] rounded-2xl bg-white p-8 shadow-[0_1px_3px_rgba(0,0,0,.08),0_8px_16px_-8px_rgba(0,0,0,.16)] lg:p-10">
                    <header>
                        <h2 id="login-heading" class="font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">Selamat Datang</h2>
                        <p class="mt-1.5 text-sm leading-5 text-user-text-secondary">Masukkan email atau nomor HP yang terdaftar</p>
                    </header>

                    <form class="mt-8" method="POST" action="{{ route('login.store') }}" data-login-form novalidate>
                        @csrf
                        <div class="grid gap-4">
                            <x-user.input-field
                                id="identity"
                                name="identity"
                                type="email"
                                label="Email"
                                placeholder="contoh: nama@warung.com"
                                autocomplete="username"
                                icon="identity-icon.svg"
                                :value="old('identity')"
                                required
                            />

                            <p class="-mt-2 flex items-center gap-1.5 text-[11px] leading-4 text-user-text-muted">
                                <span aria-hidden="true" class="flex size-3 items-center justify-center rounded-full border border-user-accent text-[8px] font-bold text-user-accent">i</span>
                                Masuk menggunakan alamat email akun terdaftar
                            </p>

                            <x-user.input-field
                                id="password"
                                name="password"
                                label="Password"
                                type="password"
                                placeholder="Masukkan kata sandi akun"
                                autocomplete="current-password"
                                icon="password-lock.svg"
                                hint="Minimal 8 karakter kombinasi huruf dan angka"
                                required
                            >
                                <x-slot:labelAction>
                                    @if (app()->environment('local'))
                                        <a class="user-auth-link text-xs" href="{{ route('password.forgot') }}">Lupa password?</a>
                                    @else
                                        <span class="text-xs text-user-text-muted">Lupa password?</span>
                                    @endif
                                </x-slot:labelAction>
                                <x-slot:trailing>
                                    <button
                                        class="user-auth-password-toggle inline-flex items-center justify-center rounded-lg text-user-text-muted hover:text-user-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-accent"
                                        type="button"
                                        data-password-toggle
                                        aria-label="Tampilkan kata sandi"
                                        aria-controls="password"
                                        aria-pressed="false"
                                    >
                                        <img src="{{ asset('images/password-eye.svg') }}" alt="Kata sandi tersembunyi" aria-hidden="true">
                                    </button>
                                </x-slot:trailing>
                            </x-user.input-field>
                        </div>

                        <label for="remember" class="mt-5 flex min-h-6 cursor-pointer items-center gap-3 text-sm text-user-text">
                            <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember')) class="user-auth-checkbox size-4 rounded border-user-border focus:ring-user-accent">
                            <span>Ingat saya di perangkat ini</span>
                        </label>

                        <div class="mt-6">
                            <x-user.primary-button>
                                Masuk
                                <img src="{{ asset('images/primary-arrow.svg') }}" alt="" aria-hidden="true">
                            </x-user.primary-button>
                        </div>

                        @if ($errors->any())
                            <p class="mt-4 rounded-xl border border-[#f5c2c7] bg-[#fff5f5] px-4 py-3 text-sm leading-5 text-[#9f1239]" data-login-status role="alert">
                                {{ $errors->first() }}
                            </p>
                        @elseif (session('status'))
                            <p class="mt-4 rounded-xl border border-user-border bg-user-surface-soft px-4 py-3 text-sm leading-5 text-user-text-secondary" data-login-status role="status" aria-live="polite">
                                {{ session('status') }}
                            </p>
                        @else
                            <p class="mt-4 rounded-xl border border-user-border bg-user-surface-soft px-4 py-3 text-sm leading-5 text-user-text-secondary" data-login-status role="status" aria-live="polite" hidden></p>
                        @endif
                    </form>

                    <div class="mt-6 border-t border-user-border pt-6 text-center text-sm text-user-text-secondary">
                        Belum punya akun?
                        <a class="user-auth-link ml-1 text-sm" href="{{ route('register') }}">Daftar</a>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
