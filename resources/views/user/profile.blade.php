@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
    <main class="user-dashboard-main user-profile-main" data-user-profile data-profile-initial='@json($profile)'>
        <div class="user-profile-container">
            <section class="user-profile-page-heading" aria-labelledby="profile-page-title">
                <div class="user-profile-heading-copy">
                    <nav class="user-profile-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('user.dashboard') }}">Beranda</a>
                        <img class="user-profile-asset" src="{{ asset('images/profile-breadcrumb.svg') }}" alt="" aria-hidden="true">
                        <span aria-current="page">Profil Saya</span>
                    </nav>
                    <h1 id="profile-page-title">Profil Saya</h1>
                    <p>Kelola informasi akun dan keamanan akses Anda.</p>
                </div>
                <button class="user-profile-edit-trigger" type="button" data-profile-edit-toggle aria-controls="profile-editor" aria-expanded="false">
                    <img class="user-profile-asset" src="{{ asset('images/profile-edit.svg') }}" alt="" aria-hidden="true">
                    <span>Edit Profil</span>
                </button>
            </section>

            <div class="user-profile-demo-note" role="note">
                <span class="user-profile-demo-dot" aria-hidden="true"></span>
                <span><strong>DATA DEMO</strong> — informasi akun dan usaha pada halaman ini hanya contoh tampilan.</span>
            </div>

            <div class="user-profile-grid">
                <form class="user-profile-card user-profile-business-card" data-profile-edit-form aria-label="Informasi profil usaha" novalidate>
                    <div class="user-profile-business-heading">
                        <div class="user-profile-identity">
                            <span class="user-profile-avatar" aria-hidden="true">
                                <span data-profile-initials>{{ $profile['avatar_initials'] }}</span>
                                <span class="user-profile-avatar-badge"><img class="user-profile-asset" src="{{ asset('images/profile-avatar-camera.svg') }}" alt=""></span>
                            </span>
                            <div class="user-profile-identity-copy">
                                <div class="user-profile-name-line">
                                    <h2 data-profile-value="business_name">{{ $profile['business_name'] }}</h2>
                                    <span class="user-profile-demo-badge">DEMO</span>
                                </div>
                                <p>Pemilik: <span data-profile-value="owner_name">{{ $profile['owner_name'] }}</span></p>
                                <span class="user-profile-date">Contoh terdaftar sejak: {{ $profile['registered_at_label'] }}</span>
                            </div>
                        </div>
                        <div class="user-profile-business-type">
                            <span>Tipe Usaha</span>
                            <strong data-profile-value="business_type">{{ $profile['business_type'] }}</strong>
                        </div>
                    </div>

                    <dl class="user-profile-readonly" data-profile-readonly>
                        <div class="user-profile-readonly-item">
                            <dt>Nama Usaha</dt>
                            <dd data-profile-value="business_name">{{ $profile['business_name'] }}</dd>
                        </div>
                        <div class="user-profile-readonly-item">
                            <dt>Nama Pemilik</dt>
                            <dd data-profile-value="owner_name">{{ $profile['owner_name'] }}</dd>
                        </div>
                        <div class="user-profile-readonly-item user-profile-contact-item">
                            <dt>Email atau Nomor HP</dt>
                            <dd>
                                <span data-profile-value="contact">{{ $profile['contact'] }}</span>
                                <img class="user-profile-asset" src="{{ asset('images/profile-contact.svg') }}" alt="" aria-hidden="true">
                            </dd>
                        </div>
                    </dl>

                    <div class="user-profile-editor" id="profile-editor" data-profile-editor hidden>
                        <div class="user-profile-edit-field">
                            <label for="profile-business-name">Nama Usaha</label>
                            <input id="profile-business-name" name="business_name" value="{{ $profile['business_name'] }}" required maxlength="80" autocomplete="organization" data-profile-field="business_name" aria-describedby="profile-business-error">
                            <span class="user-profile-field-error" id="profile-business-error" data-profile-error="business_name" hidden></span>
                        </div>
                        <div class="user-profile-editor-row">
                            <div class="user-profile-edit-field">
                                <label for="profile-owner-name">Nama Pemilik</label>
                                <input id="profile-owner-name" name="owner_name" value="{{ $profile['owner_name'] }}" required maxlength="80" autocomplete="name" data-profile-field="owner_name" aria-describedby="profile-owner-error">
                                <span class="user-profile-field-error" id="profile-owner-error" data-profile-error="owner_name" hidden></span>
                            </div>
                            <div class="user-profile-edit-field">
                                <label for="profile-contact">Email atau Nomor HP</label>
                                <input id="profile-contact" name="contact" type="text" value="{{ $profile['contact'] }}" required maxlength="120" autocomplete="email" data-profile-field="contact" aria-describedby="profile-contact-error">
                                <span class="user-profile-field-error" id="profile-contact-error" data-profile-error="contact" hidden>Masukkan email atau nomor HP yang valid.</span>
                            </div>
                        </div>
                        <div class="user-profile-editor-actions">
                            <button class="user-profile-cancel-button" type="button" data-profile-cancel>Batal</button>
                            <button class="user-profile-save-button" type="submit">Simpan Perubahan</button>
                        </div>
                    </div>

                    <section class="user-profile-watchlist" aria-labelledby="profile-watchlist-title">
                        <div class="user-profile-watchlist-heading">
                            <h3 id="profile-watchlist-title">
                                <img class="user-profile-asset" src="{{ asset('images/profile-watchlist.svg') }}" alt="" aria-hidden="true">
                                <span>Komoditas yang Dipantau</span>
                            </h3>
                            <a href="{{ route('user.settings.index') }}">Ubah di Pengaturan <img class="user-profile-asset" src="{{ asset('images/profile-arrow.svg') }}" alt="" aria-hidden="true"></a>
                        </div>
                        <ul class="user-profile-commodity-chips">
                            @foreach ($commodities as $commodity)
                                <li><span aria-hidden="true"></span>{{ $commodity['name'] }}</li>
                            @endforeach
                        </ul>
                        <p>Komoditas ini muncul pada ringkasan harga harian dan daftar pantauan demo.</p>
                    </section>

                    <p class="user-profile-status" data-profile-status role="status" aria-live="polite" hidden></p>
                </form>

                <section class="user-profile-card user-profile-security-card" aria-labelledby="profile-security-title">
                    <div class="user-profile-security-heading">
                        <h2 id="profile-security-title"><img class="user-profile-asset" src="{{ asset('images/profile-security.svg') }}" alt="" aria-hidden="true">Keamanan Akun</h2>
                        <p>Gunakan password unik yang tidak digunakan di layanan lain.</p>
                    </div>

                    <form class="user-profile-password-form" data-profile-password-form novalidate>
                        <div class="user-profile-password-field">
                            <label for="profile-current-password">Password Lama</label>
                            <div class="user-profile-password-control">
                                <input id="profile-current-password" name="current_password" type="password" placeholder="••••••••" autocomplete="current-password" required data-profile-password>
                                <button class="user-profile-password-toggle" type="button" data-password-toggle aria-controls="profile-current-password" aria-label="Tampilkan password" aria-pressed="false">
                                    <img class="user-profile-asset" src="{{ asset('images/profile-password-eye.svg') }}" alt="" aria-hidden="true">
                                </button>
                            </div>
                            <span class="user-profile-field-error" data-password-error="current_password" hidden>Masukkan password lama.</span>
                        </div>
                        <div class="user-profile-password-field">
                            <label for="profile-new-password">Password Baru</label>
                            <div class="user-profile-password-control">
                                <input id="profile-new-password" name="new_password" type="password" placeholder="••••••••" autocomplete="new-password" required minlength="8" data-profile-password data-new-password>
                                <button class="user-profile-password-toggle" type="button" data-password-toggle aria-controls="profile-new-password" aria-label="Tampilkan password" aria-pressed="false">
                                    <img class="user-profile-asset" src="{{ asset('images/profile-password-eye.svg') }}" alt="" aria-hidden="true">
                                </button>
                            </div>
                            <span class="user-profile-password-hint">Minimal 8 karakter, kombinasi huruf dan angka</span>
                            <span class="user-profile-field-error" data-password-error="new_password" hidden>Gunakan minimal 8 karakter yang berisi huruf dan angka.</span>
                        </div>
                        <div class="user-profile-password-field">
                            <label for="profile-confirm-password">Konfirmasi Password Baru</label>
                            <div class="user-profile-password-control">
                                <input id="profile-confirm-password" name="new_password_confirmation" type="password" placeholder="••••••••" autocomplete="new-password" required data-profile-password data-confirm-password>
                                <button class="user-profile-password-toggle" type="button" data-password-toggle aria-controls="profile-confirm-password" aria-label="Tampilkan password" aria-pressed="false">
                                    <img class="user-profile-asset" src="{{ asset('images/profile-password-eye.svg') }}" alt="" aria-hidden="true">
                                </button>
                            </div>
                            <span class="user-profile-field-error" data-password-error="new_password_confirmation" hidden>Konfirmasi password belum sama.</span>
                        </div>
                        <button class="user-profile-password-submit" type="submit">
                            <img class="user-profile-asset" src="{{ asset('images/profile-password-key.svg') }}" alt="" aria-hidden="true">
                            <span>Ubah Password</span>
                        </button>
                        <p class="user-profile-password-status" data-password-status role="status" aria-live="polite" hidden></p>
                    </form>

                    <aside class="user-profile-security-note">
                        <img class="user-profile-asset" src="{{ asset('images/profile-security-tip.svg') }}" alt="" aria-hidden="true">
                        <div>
                            <strong>Perlindungan Akun Warung</strong>
                            <p>Form perubahan password belum terhubung ke autentikasi. Password tidak dikirim atau disimpan dari pratinjau ini.</p>
                        </div>
                    </aside>
                </section>
            </div>
        </div>

        <x-user.dashboard-footer />
    </main>
@endsection
