@props(['commodities' => []])

{{--
    Modal Catat Belanja Pagi Ini — UI preview only.
    Tidak ada penyimpanan ke server atau database pada tahap ini.
    Integrasi backend akan dilakukan setelah autentikasi dan tabel transaksi tersedia.
--}}
<dialog
    class="user-record-shopping-dialog"
    id="user-record-shopping-dialog"
    data-record-shopping-dialog
    aria-labelledby="record-shopping-title"
    aria-describedby="record-shopping-desc"
>
    <div class="user-record-shopping-card">

        {{-- Header --}}
        <div class="user-record-shopping-header">
            <div>
                <h2 id="record-shopping-title" class="user-record-shopping-title">Catat Belanja Pagi Ini</h2>
                <p id="record-shopping-desc" class="user-record-shopping-desc">
                    Catat harga yang Anda bayar agar akurasi prakiraan terus dievaluasi.
                </p>
            </div>
            <button
                class="user-record-shopping-close"
                type="button"
                data-close-record-shopping-dialog
                aria-label="Tutup modal catat belanja"
            >
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true" focusable="false">
                    <path d="M14 4L4 14M4 4L14 14" stroke="#3f4948" stroke-width="1.75" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form
            class="user-record-shopping-form"
            id="user-record-shopping-form"
            novalidate
            data-record-shopping-form
        >

            {{-- Komoditas --}}
            <div class="user-record-shopping-field">
                <label class="user-record-shopping-label" for="record-komoditas">Komoditas</label>
                <div class="user-record-shopping-select-wrap">
                    <select
                        class="user-record-shopping-select"
                        id="record-komoditas"
                        name="komoditas"
                        required
                        data-record-commodity-select
                        aria-required="true"
                    >
                        <option value="" disabled selected>Pilih komoditas…</option>
                        @foreach ($commodities as $commodity)
                            <option
                                value="{{ $commodity['id'] }}"
                                data-unit="{{ $commodity['unit'] }}"
                                data-price="{{ str_replace('.', '', $commodity['price']) }}"
                            >{{ $commodity['name'] }}</option>
                        @endforeach
                    </select>
                    <svg class="user-record-shopping-select-chevron" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false">
                        <path d="M4 6L8 10L12 6" stroke="#3f4948" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Harga dibayar --}}
            <div class="user-record-shopping-field">
                <label class="user-record-shopping-label" for="record-harga">Harga dibayar</label>
                <div class="user-record-shopping-price-wrap">
                    <span class="user-record-shopping-price-prefix" aria-hidden="true">Rp</span>
                    <input
                        class="user-record-shopping-price-input"
                        type="text"
                        id="record-harga"
                        name="harga"
                        inputmode="numeric"
                        pattern="[0-9.,]+"
                        placeholder="0"
                        required
                        aria-required="true"
                        data-record-price-input
                        autocomplete="off"
                    >
                    <span class="user-record-shopping-price-suffix" data-record-unit-label aria-live="polite">/kg</span>
                </div>
            </div>

            {{-- Jumlah + Tanggal (dua kolom) --}}
            <div class="user-record-shopping-row">
                <div class="user-record-shopping-field">
                    <label class="user-record-shopping-label" for="record-jumlah">Jumlah dibeli</label>
                    <div class="user-record-shopping-qty-wrap">
                        <input
                            class="user-record-shopping-qty-input"
                            type="number"
                            id="record-jumlah"
                            name="jumlah"
                            min="0.01"
                            step="0.01"
                            placeholder="0"
                            required
                            aria-required="true"
                            data-record-qty-input
                            autocomplete="off"
                        >
                        <span class="user-record-shopping-qty-suffix" data-record-qty-unit aria-live="polite">kg</span>
                    </div>
                </div>

                <div class="user-record-shopping-field">
                    <label class="user-record-shopping-label" for="record-tanggal">Tanggal</label>
                    <input
                        class="user-record-shopping-date-input"
                        type="date"
                        id="record-tanggal"
                        name="tanggal"
                        required
                        aria-required="true"
                        data-record-date-input
                    >
                </div>
            </div>

            {{-- Catatan --}}
            <div class="user-record-shopping-field">
                <label class="user-record-shopping-label" for="record-catatan">
                    Catatan
                    <span class="user-record-shopping-label-optional">(Opsional)</span>
                </label>
                <textarea
                    class="user-record-shopping-textarea"
                    id="record-catatan"
                    name="catatan"
                    rows="3"
                    placeholder="Contoh: Beli di lapak Pak Slamet, kualitas segar"
                    maxlength="400"
                    data-record-notes-input
                ></textarea>
            </div>

            {{-- Keterangan preview --}}
            <p class="user-record-shopping-preview-note" role="note">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" aria-hidden="true" focusable="false" style="flex:0 0 auto;margin-top:1px">
                    <circle cx="6.5" cy="6.5" r="6" stroke="#006a66" stroke-width="1"/>
                    <path d="M6.5 5.5V9M6.5 4V4.5" stroke="#006a66" stroke-width="1.25" stroke-linecap="round"/>
                </svg>
                <span>Fungsi penyimpanan belum aktif. Catatan ini bersifat <strong>preview UI</strong> dan tidak dikirim ke server.</span>
            </p>

            {{-- Divider --}}
            <hr class="user-record-shopping-divider" aria-hidden="true">

            {{-- Actions --}}
            <div class="user-record-shopping-actions">
                <button
                    class="user-record-shopping-btn-cancel"
                    type="button"
                    data-close-record-shopping-dialog
                >Batal</button>
                <button
                    class="user-record-shopping-btn-save"
                    type="submit"
                    data-record-submit-btn
                >
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" aria-hidden="true" focusable="false">
                        <path d="M2.5 7.5L6 11L12.5 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Simpan Catatan
                </button>
            </div>

        </form>
    </div>
</dialog>
