@extends('layouts.user')

@section('title', 'Pengaturan Akun & Preferensi')

@section('content')
    <main class="user-dashboard-main user-settings-main" data-user-settings data-initial-tracked='@json($initialTrackedIds)'>
        <div class="user-settings-container mx-auto flex w-full max-w-[1024px] flex-col gap-6 px-8 py-10">
            <section class="flex flex-col gap-2" aria-labelledby="settings-heading">
                <div class="flex items-center gap-2 text-sm leading-5 text-user-dashboard-secondary">
                    <a class="hover:text-user-dashboard-brand" href="{{ route('user.dashboard') }}">Beranda</a>
                    <img class="settings-asset" src="{{ asset('images/settings-breadcrumb-chevron.svg') }}" alt="" aria-hidden="true">
                    <span class="font-medium text-user-dashboard-text" aria-current="page">Pengaturan Akun &amp; Preferensi</span>
                </div>

                <div class="flex flex-col items-start justify-between gap-3 xl:flex-row xl:items-end">
                    <div class="min-w-0">
                        <h1 id="settings-heading" class="font-user-display text-[32px] font-bold leading-10 tracking-[-.025em] text-user-dashboard-text">Pengaturan Akun &amp; Preferensi</h1>
                        <p class="mt-1 text-base leading-6 text-user-dashboard-secondary">Kelola profil usaha kuliner, komoditas pantauan, ambang batas peringatan, dan notifikasi.</p>
                    </div>
                    <span class="user-settings-demo-pill"><i aria-hidden="true"></i>Pratinjau akun: <strong>{{ $profile['business_name'] }}</strong> · DATA DEMO</span>
                </div>
            </section>

            <div class="user-settings-notice" role="status" aria-live="polite">
                <span class="user-settings-notice-icon"><img class="settings-asset" src="{{ asset('images/settings-status-info.svg') }}" alt="" aria-hidden="true"></span>
                <div>
                    <strong>Penyimpanan preferensi belum tersedia</strong>
                    <p>Pilihan komoditas di halaman ini hanya berlaku sementara dan belum disimpan ke Supabase.</p>
                </div>
            </div>

            <form class="user-settings-form" data-settings-form aria-label="Pengaturan preferensi demo">
                <section class="user-settings-section user-settings-tracked" aria-labelledby="tracked-heading">
                    <div class="user-settings-section-heading">
                        <span class="user-settings-heading-icon"><img class="settings-asset" src="{{ asset('images/settings-section-commodities.svg') }}" alt="" aria-hidden="true"></span>
                        <h2 id="tracked-heading">Komoditas yang Dipantau</h2>
                        <span class="user-settings-selected-count" data-watch-count>{{ count($initialTrackedIds) }} Dipilih</span>
                    </div>
                    <p class="user-settings-section-description">Pilih bahan pokok yang ingin selalu diprioritaskan di ringkasan Beranda dan prakiraan belanja harian:</p>

                    <div class="user-settings-watch-list" data-watch-list aria-live="polite" aria-relevant="additions removals">
                        @foreach ($commodities as $commodity)
                            <button
                                class="user-settings-watch-chip is-selected"
                                type="button"
                                data-watch-chip="{{ $commodity['id'] }}"
                                aria-label="Hapus {{ $commodity['name'] }} dari daftar pantauan"
                                aria-pressed="true"
                            >
                                <img class="settings-asset" src="{{ asset('images/settings-chip-check.svg') }}" alt="" aria-hidden="true">
                                <span>{{ $commodity['name'] }}</span>
                            </button>
                        @endforeach
                        <button class="user-settings-add-button" type="button" data-open-commodity-dialog aria-haspopup="dialog" aria-controls="commodity-picker-dialog">
                            <img class="settings-asset" src="{{ asset('images/settings-add.svg') }}" alt="" aria-hidden="true">
                            <span>Tambah Komoditas Lain</span>
                        </button>
                    </div>

                    <p class="user-settings-helper"><img class="settings-asset" src="{{ asset('images/settings-info.svg') }}" alt="" aria-hidden="true">Pilih minimal satu komoditas. Daftar demo memakai komoditas yang sama dengan Beranda.</p>
                    <p class="user-settings-live-message" data-settings-live role="status" aria-live="polite" hidden></p>
                </section>

                <section class="user-settings-section user-settings-preview-section" aria-labelledby="sensitivity-heading">
                    <div class="user-settings-section-heading">
                        <span class="user-settings-heading-icon"><img class="settings-asset" src="{{ asset('images/settings-sliders.svg') }}" alt="" aria-hidden="true"></span>
                        <h2 id="sensitivity-heading">Sensitivitas Rekomendasi</h2>
                        <span class="user-settings-preview-label">Preview</span>
                    </div>
                    <p class="user-settings-section-description">Kontrol ini hanya menampilkan rancangan Figma. Aturan MVP tetap memakai threshold ±5% dan rerata forecast hari ke-1 sampai ke-7.</p>

                    <div class="user-settings-range-card" aria-describedby="threshold-preview-note">
                        <div class="user-settings-range-topline">
                            <span>Threshold rekomendasi saat ini</span>
                            <span class="user-settings-threshold-value"><strong>5%</strong><small>Standar MVP</small></span>
                        </div>
                        <input class="user-settings-range" type="range" min="3" max="10" value="5" disabled aria-label="Threshold rekomendasi preview, tetap 5 persen">
                        <div class="user-settings-range-markers" aria-hidden="true">
                            <span>3%<small>Sangat peka</small></span>
                            <span>5%<small>Standar MVP</small></span>
                            <span>10%<small>Lonjakan besar</small></span>
                        </div>
                    </div>

                    <p id="threshold-preview-note" class="user-settings-helper user-settings-preview-note">
                        <img class="settings-asset" src="{{ asset('images/settings-tip.svg') }}" alt="" aria-hidden="true">
                        Nilai threshold tidak dapat diubah dari halaman ini; preferensi ini belum disepakati untuk disimpan.
                    </p>
                </section>

                <section class="user-settings-section user-settings-horizon" aria-labelledby="horizon-heading">
                    <div class="user-settings-section-heading">
                        <span class="user-settings-heading-icon"><img class="settings-asset" src="{{ asset('images/settings-calendar.svg') }}" alt="" aria-hidden="true"></span>
                        <h2 id="horizon-heading">Jangka Waktu Perkiraan Utama</h2>
                        <span class="user-settings-preview-label">Preview</span>
                    </div>
                    <p class="user-settings-section-description">Rancangan pilihan horizon bawaan untuk ringkasan kebutuhan belanja.</p>
                    <div class="user-settings-horizon-control">
                        <select disabled aria-label="Pilihan horizon preview" aria-describedby="horizon-preview-note">
                            <option>3 Hari (Preview desain)</option>
                        </select>
                        <img class="settings-asset" src="{{ asset('images/settings-chevron.svg') }}" alt="" aria-hidden="true">
                    </div>
                    <p id="horizon-preview-note" class="user-settings-helper"><img class="settings-asset" src="{{ asset('images/settings-info-small.svg') }}" alt="" aria-hidden="true">Kontrol horizon belum aktif. Formula rekomendasi tetap menghitung forecast lengkap hari ke-1 sampai ke-7.</p>
                </section>

                <section class="user-settings-section user-settings-preview-section" aria-labelledby="reminders-heading">
                    <div class="user-settings-section-heading">
                        <span class="user-settings-heading-icon"><img class="settings-asset" src="{{ asset('images/settings-bell.svg') }}" alt="" aria-hidden="true"></span>
                        <h2 id="reminders-heading">Notifikasi Pengingat Pasar</h2>
                        <span class="user-settings-preview-label">Preview</span>
                    </div>
                    <p class="user-settings-section-description">Rancangan pengingat pasar. Pengiriman notifikasi belum tersedia pada MVP ini.</p>

                    <div class="user-settings-reminder-list">
                        <article class="user-settings-reminder-card">
                            <span class="user-settings-reminder-icon is-mint"><img class="settings-asset" src="{{ asset('images/settings-whatsapp.svg') }}" alt="" aria-hidden="true"></span>
                            <div class="user-settings-reminder-copy">
                                <h3>Ringkasan Belanja Pagi</h3>
                                <p>Preview pengingat komparasi harga sebelum waktu belanja. Saluran penerima belum dihubungkan.</p>
                                <span class="user-settings-reminder-tag"><img class="settings-asset" src="{{ asset('images/settings-phone.svg') }}" alt="" aria-hidden="true">Pengiriman nonaktif</span>
                            </div>
                            <button class="user-settings-switch" type="button" role="switch" aria-checked="false" aria-label="Notifikasi ringkasan belanja belum tersedia" disabled><span></span></button>
                        </article>

                        <article class="user-settings-reminder-card">
                            <span class="user-settings-reminder-icon is-sand"><img class="settings-asset" src="{{ asset('images/settings-alert.svg') }}" alt="" aria-hidden="true"></span>
                            <div class="user-settings-reminder-copy">
                                <h3>Peringatan Lonjakan Harga Mendadak</h3>
                                <p>Preview kategori peringatan. Sumber data dan aturan pemicunya belum disepakati.</p>
                                <span class="user-settings-reminder-tag is-warning"><img class="settings-asset" src="{{ asset('images/settings-warning.svg') }}" alt="" aria-hidden="true">Belum tersedia</span>
                            </div>
                            <button class="user-settings-switch" type="button" role="switch" aria-checked="false" aria-label="Peringatan lonjakan harga belum tersedia" disabled><span></span></button>
                        </article>
                    </div>
                </section>

                <div class="user-settings-actions">
                    <button class="user-settings-reset-button" type="button" data-reset-tracked>Batalkan / Reset ke Standar</button>
                    <button class="user-settings-save-button" type="button" data-preview-save>
                        <img class="settings-asset" src="{{ asset('images/settings-save.svg') }}" alt="" aria-hidden="true">
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>

            <aside class="user-settings-support-card" aria-label="Bantuan pengaturan">
                <span class="user-settings-support-icon"><img class="settings-asset" src="{{ asset('images/settings-support.svg') }}" alt="" aria-hidden="true"></span>
                <div>
                    <h2>Butuh Kalibrasi Khusus Menu Warung Anda?</h2>
                    <p>Informasi bantuan untuk penyesuaian komoditas dan kebutuhan usaha.</p>
                </div>
                <button class="user-settings-support-button" type="button" data-settings-support>
                    <span>Hubungi Pendamping</span>
                    <img class="settings-asset" src="{{ asset('images/settings-arrow.svg') }}" alt="" aria-hidden="true">
                </button>
            </aside>
        </div>
    </main>

    <dialog id="commodity-picker-dialog" class="user-settings-dialog" data-commodity-dialog aria-labelledby="commodity-dialog-title">
        <div class="user-settings-dialog-header">
            <div>
                <h2 id="commodity-dialog-title">Pilih Komoditas Pantauan</h2>
                <p>Pilihan dari katalog demo yang sama dengan Beranda.</p>
            </div>
            <button class="user-settings-dialog-close" type="button" data-close-commodity-dialog aria-label="Tutup dialog">
                <img class="settings-asset" src="{{ asset('images/settings-close.svg') }}" alt="" aria-hidden="true">
            </button>
        </div>
        <div class="user-settings-dialog-options">
            @foreach ($commodities as $commodity)
                <label class="user-settings-dialog-option" for="watch-option-{{ $commodity['id'] }}">
                    <input id="watch-option-{{ $commodity['id'] }}" type="checkbox" value="{{ $commodity['id'] }}" data-watch-option @checked(in_array($commodity['id'], $initialTrackedIds, true))>
                    <span><strong>{{ $commodity['name'] }}</strong><small>{{ $commodity['category'] }} · {{ $commodity['unit'] }}</small></span>
                </label>
            @endforeach
        </div>
        <p class="user-settings-dialog-note">Minimal satu komoditas harus dipilih. Perubahan hanya berlaku untuk pratinjau halaman ini.</p>
        <p class="user-settings-live-message" data-dialog-live role="status" aria-live="polite" hidden></p>
        <div class="user-settings-dialog-actions">
            <button class="user-settings-reset-button" type="button" data-close-commodity-dialog>Batal</button>
            <button class="user-settings-save-button" type="button" data-apply-watch>Gunakan Pilihan</button>
        </div>
    </dialog>
@endsection
