@extends('layouts.recovery')

@section('recovery-content')
    <section class="user-recovery-success text-center" aria-labelledby="recovery-heading">
        <p class="user-recovery-step">LANGKAH 4 DARI 4 · PRATINJAU</p>
        <div class="user-recovery-success-icon mx-auto mt-6" aria-hidden="true"><span>✓</span></div>
        <h2 id="recovery-heading" class="mt-6 font-user-display text-2xl font-bold leading-8 tracking-[-.02em] text-user-text">Pratinjau konfirmasi</h2>
        <p class="mt-3 text-sm leading-6 text-user-text-secondary">Tampilan konfirmasi pemulihan password yang dirancang. Belum ada password yang diverifikasi atau diubah.</p>
        <p class="user-recovery-status mt-6" role="status">Password belum diubah. Fitur pemulihan belum terhubung ke autentikasi.</p>
        <a class="user-auth-primary-button mt-6" href="{{ route('login') }}">Kembali ke Masuk <span aria-hidden="true">→</span></a>
    </section>
@endsection
