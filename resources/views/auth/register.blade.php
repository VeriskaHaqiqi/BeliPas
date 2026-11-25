@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <main class="user-register user-register-main min-h-screen px-6 py-6">
        <div class="user-register-layout mx-auto grid min-h-[934px] max-w-[1232px] grid-cols-[minmax(0,1fr)_592px] items-center gap-12">
            <section class="user-register-brand flex min-h-[532px] flex-col justify-center" aria-labelledby="register-brand-heading">
                <div class="user-register-brand-content flex flex-col gap-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-user.brand-logo />
                        <span class="rounded-full bg-[#a2e9e3] px-3 py-1.5 text-[10px] font-bold uppercase tracking-[.08em] text-[#003a2f]">
                            Platform Pantau Harga UMKM
                        </span>
                        <span class="rounded-full bg-[#ebe5a9] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[.06em] text-[#444114]">
                            Data Demo
                        </span>
                    </div>

                    <header class="max-w-[576px]">
                        <h1 id="register-brand-heading" class="font-user-display text-3xl font-bold leading-[1.2] tracking-[-.03em] text-user-text lg:text-4xl">
                            Beli di waktu yang tepat.
                        </h1>
                        <p class="mt-2 max-w-[520px] text-sm leading-6 text-user-text-secondary lg:text-base">
                            Bantu warung makan, katering, dan kafe Anda merencanakan belanja bahan baku dengan prakiraan harga yang jelas.
                        </p>
                    </header>

                    <figure class="user-register-preview-wrap w-full max-w-[512px]">
                        <img
                            class="user-register-preview"
                            src="{{ asset('images/register-market-preview.png') }}"
                            width="512"
                            height="306"
                            alt="Pratinjau kartu harga dan grafik komoditas. Seluruh harga dan indikator pada gambar adalah data demo, bukan data aktual."
                        >
                        <figcaption class="mt-2 text-xs leading-5 text-user-text-muted">
                            Ilustrasi DATA DEMO — angka pada kartu ini bukan harga atau hasil model produksi.
                        </figcaption>
                    </figure>

                    <p class="flex items-center gap-2 text-xs leading-5 text-user-text-secondary">
                        <span aria-hidden="true" class="flex size-4 shrink-0 items-center justify-center rounded-full border border-user-accent text-[10px] font-bold text-user-accent">i</span>
                        Tampilan pendaftaran belum terhubung ke akun atau database.
                    </p>
                </div>
            </section>

            <section class="user-register-card w-full rounded-2xl bg-white p-9 shadow-[0_20px_30px_-18px_rgba(0,0,0,.24)]" aria-labelledby="register-heading">
                <header>
                    <h2 id="register-heading" class="font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">
                        Daftar Akun BeliPas
                    </h2>
                    <p class="mt-1 text-xs leading-5 text-user-text-secondary">
                        Isi data usaha Anda untuk mulai memantau harga.
                    </p>
                </header>

                <form class="mt-7 grid gap-4" data-register-form novalidate>
                    @csrf

                    <x-user.input-field
                        id="business-name"
                        name="business_name"
                        label="Nama usaha"
                        placeholder="contoh: Warung Bu Rina"
                        autocomplete="organization"
                        icon="business-icon.svg"
                        required
                    />

                    <x-user.input-field
                        id="owner-name"
                        name="owner_name"
                        label="Nama pemilik"
                        placeholder="contoh: Ibu Rina Suryani"
                        autocomplete="name"
                        icon="identity-icon.svg"
                        required
                    />

                    <div class="grid gap-1.5">
                        <x-user.input-field
                            id="register-identity"
                            name="identity"
                            label="Email atau Nomor HP"
                            placeholder="contoh: 08123456789 atau rina@warung.com"
                            autocomplete="username"
                            icon="contact-icon.svg"
                            required
                        />
                        <p class="flex items-center gap-1.5 pl-1 text-[11px] leading-4 text-user-accent">
                            <span aria-hidden="true" class="flex size-3 items-center justify-center rounded-full border border-current text-[8px] font-bold">✓</span>
                            Gunakan nomor WhatsApp aktif
                        </p>
                    </div>

                    <div class="user-register-password-row grid grid-cols-2 gap-3">
                        <x-user.input-field
                            id="register-password"
                            name="password"
                            label="Password"
                            type="password"
                            placeholder="Min. 8 karakter"
                            autocomplete="new-password"
                            icon="password-lock.svg"
                            required
                            aria-invalid="false"
                        >
                            <x-slot:trailing>
                                <button
                                    class="user-auth-password-toggle inline-flex items-center justify-center rounded-lg text-user-text-muted hover:text-user-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-accent"
                                    type="button"
                                    data-password-toggle
                                    aria-label="Tampilkan kata sandi"
                                    aria-controls="register-password"
                                    aria-pressed="false"
                                >
                                    <img src="{{ asset('images/password-eye.svg') }}" alt="" aria-hidden="true">
                                </button>
                            </x-slot:trailing>
                        </x-user.input-field>

                        <x-user.input-field
                            id="register-password-confirmation"
                            name="password_confirmation"
                            label="Konfirmasi password"
                            type="password"
                            placeholder="Ulangi sandi"
                            autocomplete="new-password"
                            icon="confirm-password-icon.svg"
                            required
                            aria-invalid="false"
                        >
                            <x-slot:trailing>
                                <button
                                    class="user-auth-password-toggle inline-flex items-center justify-center rounded-lg text-user-text-muted hover:text-user-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-accent"
                                    type="button"
                                    data-password-toggle
                                    aria-label="Tampilkan kata sandi"
                                    aria-controls="register-password-confirmation"
                                    aria-pressed="false"
                                >
                                    <img src="{{ asset('images/password-eye.svg') }}" alt="" aria-hidden="true">
                                </button>
                            </x-slot:trailing>
                        </x-user.input-field>
                    </div>

                    <p class="user-register-password-strength -mt-2 text-[11px] leading-4 text-user-text-muted" data-password-strength data-valid="true" aria-live="polite">
                        Minimal 8 karakter, kombinasi huruf dan angka.
                    </p>

                    <label for="terms" class="flex cursor-pointer items-start gap-2 text-[11px] leading-5 text-user-text-secondary">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            class="user-register-checkbox mt-1 size-4 shrink-0 rounded border-user-border focus:ring-user-accent"
                            required
                        >
                        <span>
                            Saya menyetujui
                            <button class="user-auth-link text-[11px]" type="button" data-stage-placeholder="Syarat & Ketentuan">Syarat &amp; Ketentuan</button>
                            dan
                            <button class="user-auth-link text-[11px]" type="button" data-stage-placeholder="Kebijakan Privasi">Kebijakan Privasi</button>
                            BeliPas.
                        </span>
                    </label>

                    <x-user.primary-button class="!bg-[#0b5345] hover:!bg-[#003a2f]">
                        Daftar Sekarang
                        <img src="{{ asset('images/primary-arrow.svg') }}" alt="" aria-hidden="true">
                    </x-user.primary-button>

                    <p class="rounded-xl bg-user-surface-soft px-4 py-3 text-center text-[11px] leading-4 text-user-text-secondary" data-auth-status role="status" aria-live="polite" hidden></p>
                </form>

                <p class="mt-5 text-center text-xs text-user-text-secondary">
                    Sudah punya akun?
                    <a class="user-auth-link ml-1 text-xs" href="{{ route('login') }}">Masuk</a>
                </p>

                <p class="mt-4 flex items-center justify-center gap-2 rounded-lg bg-user-surface-soft px-3 py-2.5 text-[11px] leading-4 text-user-text-secondary">
                    <span aria-hidden="true" class="flex size-3.5 items-center justify-center rounded-full border border-user-accent text-[9px] font-bold text-user-accent">i</span>
                    Pendaftaran belum terhubung dan tidak menyimpan data.
                </p>
            </section>
        </div>

        <footer class="user-register-footer mx-auto flex min-h-[50px] max-w-[1232px] flex-wrap items-center justify-between gap-3 text-[10px] leading-4 text-user-text-secondary">
            <p>© {{ date('Y') }} BeliPas. Solusi pemantauan harga bahan baku untuk UMKM kuliner.</p>
            <nav class="user-register-footer-links flex items-center gap-5" aria-label="Tautan informasi">
                <button class="user-auth-link text-[10px] font-medium" type="button" data-stage-placeholder="Privasi">Privasi</button>
                <button class="user-auth-link text-[10px] font-medium" type="button" data-stage-placeholder="Syarat & Ketentuan">Syarat &amp; Ketentuan</button>
                <button class="user-auth-link text-[10px] font-medium" type="button" data-stage-placeholder="Bantuan WhatsApp">Bantuan WhatsApp</button>
            </nav>
        </footer>
    </main>
@endsection
