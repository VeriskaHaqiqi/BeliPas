@extends('layouts.auth')

@section('title', $recoveryTitle)

@section('content')
    <main class="user-auth-main user-recovery-main flex min-h-screen items-center justify-center px-4 py-6 lg:py-8">
        <div class="user-auth-shell user-recovery-shell relative grid min-h-[900px] w-full max-w-[1440px] grid-cols-2 overflow-hidden rounded-xl bg-white shadow-[0_20px_25px_-5px_rgba(0,0,0,.1),0_8px_10px_-6px_rgba(0,0,0,.1)]">
            <section class="user-auth-brand-panel user-recovery-brand relative isolate flex flex-col justify-between overflow-hidden bg-user-surface-soft p-8 lg:p-16" aria-labelledby="recovery-brand-heading">
                <div class="pointer-events-none absolute -left-24 -top-24 -z-10 size-96 rounded-full bg-user-mint/40 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-10 right-4 -z-10 size-80 rounded-full bg-user-sand/30 blur-2xl"></div>

                <div class="relative flex flex-col items-start gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-user.brand-logo />
                        <span class="rounded-full bg-[#dce4e1] px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[.05em] text-user-accent">Untuk UMKM Kuliner</span>
                    </div>
                    <div class="user-auth-brand-heading max-w-[512px] pt-2 lg:pt-4">
                        <h1 id="recovery-brand-heading" class="font-user-display text-3xl font-bold leading-tight tracking-[-.025em] text-user-text lg:text-4xl lg:leading-[44px]">Beli di waktu yang tepat.</h1>
                        <p class="mt-3 max-w-[448px] text-base leading-6 text-user-text-secondary">Pahami tren harga komoditas pangan untuk membantu merencanakan pembelian usaha kuliner Anda.</p>
                    </div>
                </div>

                <figure class="user-auth-preview user-recovery-chart relative mx-auto w-full max-w-[448px] rounded-2xl bg-white/80 p-6 shadow-sm backdrop-blur-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-xs font-semibold text-user-text"><span aria-hidden="true" class="size-2.5 rounded-full bg-user-brand"></span><span>Tren Belanja Pasar Induk</span></div>
                        <span class="rounded-full bg-user-mint px-2 py-0.5 text-[11px] font-semibold text-[#00201e]">Pratinjau</span>
                    </div>
                    <div class="overflow-hidden rounded-xl bg-[#e8f0ed] p-2">
                        <img class="user-recovery-market-chart" src="{{ asset('images/recovery-market-chart.svg') }}" width="432" height="144" alt="Ilustrasi tren harga, bukan data aktual BeliPas">
                    </div>
                    <figcaption class="mt-4 flex flex-wrap items-center justify-between gap-x-3 gap-y-2 text-[11px] font-semibold tracking-wide text-user-text-secondary"><span>Ilustrasi data</span><span>Bukan harga aktual</span><span class="text-user-accent">DATA DEMO</span></figcaption>
                </figure>

                <aside class="user-auth-testimonial user-recovery-notice relative flex w-full items-start gap-4 rounded-2xl bg-white p-5 shadow-sm" aria-label="Status pemulihan password">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-user-sand"><img src="{{ asset('images/password-lock.svg') }}" width="20" height="20" alt="" aria-hidden="true"></span>
                    <div><p class="text-sm leading-[1.65] text-user-text">Alur ini hanya pratinjau antarmuka. Pengiriman kode verifikasi dan pemulihan password belum terhubung.</p><p class="mt-2 text-xs font-semibold text-user-text-secondary">Tidak ada kode atau password yang dikirim maupun disimpan.</p></div>
                </aside>
            </section>

            <section class="user-auth-form-panel user-recovery-form-panel flex items-center justify-center bg-white px-5 py-10 sm:px-8 lg:px-[72px]" aria-labelledby="recovery-heading">
                <div class="user-auth-form-card user-recovery-form-card w-full max-w-[480px] rounded-2xl bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,.08),0_8px_16px_-8px_rgba(0,0,0,.16)] sm:p-8 lg:p-10">
                    @yield('recovery-content')
                </div>
            </section>
        </div>
    </main>
@endsection
