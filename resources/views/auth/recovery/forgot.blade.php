@extends('layouts.recovery')

@section('recovery-content')
    <header class="user-recovery-header">
        <p class="user-recovery-step">LANGKAH 1 DARI 4</p>
        <h2 id="recovery-heading" class="font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">Lupa password?</h2>
        <p class="mt-2 text-sm leading-6 text-user-text-secondary">Masukkan email atau nomor HP yang terhubung dengan akun Anda untuk melihat pratinjau alur pemulihan. Kode verifikasi belum dikirim.</p>
    </header>

    <form class="mt-8 grid gap-5" data-recovery-form="identity" novalidate>
        <x-user.input-field id="recovery-identity" name="" label="Email atau Nomor HP" placeholder="nama@warung.com atau 08123456789" autocomplete="off" icon="identity-icon.svg" required />
        <p class="user-recovery-status" data-recovery-status role="status" aria-live="polite" hidden></p>
        <x-user.primary-button>Kirim Kode Verifikasi <span aria-hidden="true">→</span></x-user.primary-button>
        <a class="user-auth-link justify-self-center text-sm" href="{{ route('login') }}">Kembali ke Masuk</a>
        <a class="user-recovery-preview-link" href="{{ route('password.verify') }}" data-recovery-preview hidden>Lihat pratinjau tahap kode <span aria-hidden="true">→</span></a>
    </form>
@endsection
