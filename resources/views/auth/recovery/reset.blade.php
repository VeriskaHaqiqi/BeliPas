@extends('layouts.recovery')

@section('recovery-content')
    <header class="user-recovery-header">
        <p class="user-recovery-step">LANGKAH 3 DARI 4</p>
        <h2 id="recovery-heading" class="font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">Buat password baru</h2>
        <p class="mt-2 text-sm leading-6 text-user-text-secondary">Buat password yang kuat untuk menjaga keamanan akun Anda.</p>
    </header>

    <form class="mt-8 grid gap-5" data-recovery-form="password" novalidate>
        <x-user.input-field id="new-password" name="" label="Password baru" type="password" placeholder="Masukkan password baru" autocomplete="new-password" icon="password-lock.svg" required>
            <x-slot:trailing><button class="user-auth-password-toggle inline-flex items-center justify-center rounded-lg text-user-text-muted hover:text-user-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-accent" type="button" data-password-toggle aria-label="Tampilkan kata sandi" aria-controls="new-password" aria-pressed="false"><img src="{{ asset('images/password-eye.svg') }}" alt="Kata sandi tersembunyi" aria-hidden="true"></button></x-slot:trailing>
        </x-user.input-field>
        <div class="user-recovery-password-rules" aria-live="polite">
            <p class="text-xs font-semibold text-user-text">Persyaratan password</p>
            <div class="user-recovery-strength" aria-hidden="true"><span data-strength-bar></span><span data-strength-bar></span><span data-strength-bar></span></div>
            <ul class="mt-2 grid gap-1 text-[11px] text-user-text-secondary"><li data-password-rule="length">○ Minimal 8 karakter</li><li data-password-rule="letter">○ Mengandung huruf</li><li data-password-rule="number">○ Mengandung angka</li></ul>
        </div>
        <x-user.input-field id="new-password-confirmation" name="" label="Konfirmasi password baru" type="password" placeholder="Ulangi password baru" autocomplete="new-password" icon="password-lock.svg" required>
            <x-slot:trailing><button class="user-auth-password-toggle inline-flex items-center justify-center rounded-lg text-user-text-muted hover:text-user-brand focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-user-accent" type="button" data-password-toggle aria-label="Tampilkan kata sandi" aria-controls="new-password-confirmation" aria-pressed="false"><img src="{{ asset('images/password-eye.svg') }}" alt="Kata sandi tersembunyi" aria-hidden="true"></button></x-slot:trailing>
        </x-user.input-field>
        <p class="user-recovery-status" data-recovery-status role="status" aria-live="polite" hidden></p>
        <x-user.primary-button>Simpan Password <span aria-hidden="true">→</span></x-user.primary-button>
        <a class="user-auth-link justify-self-center text-sm" href="{{ route('password.verify') }}">Kembali</a>
        <a class="user-recovery-preview-link" href="{{ route('password.updated') }}" data-recovery-preview hidden>Lihat pratinjau konfirmasi <span aria-hidden="true">→</span></a>
    </form>
@endsection
