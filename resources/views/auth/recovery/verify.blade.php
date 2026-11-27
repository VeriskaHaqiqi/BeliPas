@extends('layouts.recovery')

@section('recovery-content')
    <header class="user-recovery-header">
        <p class="user-recovery-step">LANGKAH 2 DARI 4</p>
        <h2 id="recovery-heading" class="font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">Masukkan kode verifikasi</h2>
        <p class="mt-2 text-sm leading-6 text-user-text-secondary">Masukkan enam digit untuk melihat interaksi pratinjau. Kode OTP belum dikirim dan tidak akan diverifikasi.</p>
    </header>

    <form class="mt-8 grid gap-5" data-recovery-form="otp" novalidate>
        <div class="grid gap-1.5">
            <label class="text-xs font-semibold text-user-text" for="otp-1">Kode verifikasi</label>
            <div class="user-recovery-otp" role="group" aria-label="Enam digit kode verifikasi">
                @for ($digit = 1; $digit <= 6; $digit++)
                    <input id="otp-{{ $digit }}" class="user-recovery-otp-digit" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="{{ $digit === 1 ? 'one-time-code' : 'off' }}" aria-label="Digit {{ $digit }}" data-otp-digit>
                @endfor
            </div>
            <p class="text-[11px] leading-4 text-user-text-muted">Untuk pratinjau, isi enam digit apa saja. Kode tidak dikirim atau diverifikasi.</p>
        </div>
        <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-user-text-secondary">
            <span>Timer tampilan (demo): <strong class="font-semibold text-user-text" data-otp-countdown>00:44</strong></span>
            <button class="user-auth-link text-xs" type="button" data-otp-resend>Kirim ulang kode</button>
        </div>
        <p class="user-recovery-status" data-recovery-status role="status" aria-live="polite" hidden></p>
        <x-user.primary-button>Verifikasi <span aria-hidden="true">→</span></x-user.primary-button>
        <div class="flex items-center justify-between gap-3 text-sm"><a class="user-auth-link" href="{{ route('password.forgot') }}">Kembali</a><a class="user-auth-link" href="{{ route('login') }}">Kembali ke Masuk</a></div>
        <a class="user-recovery-preview-link" href="{{ route('password.reset') }}" data-recovery-preview hidden>Lihat pratinjau tahap password baru <span aria-hidden="true">→</span></a>
    </form>
@endsection
