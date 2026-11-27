/**
 * user-record-shopping.js
 * Logika interaksi untuk Modal Catat Belanja Pagi Ini.
 *
 * Scope: UI preview only — tidak ada request ke server.
 * Penyimpanan data akan diimplementasikan setelah autentikasi dan
 * tabel transaksi tersedia pada tahap integrasi backend.
 */

const dialog = document.querySelector('[data-record-shopping-dialog]');
const form = document.querySelector('[data-record-shopping-form]');
const commoditySelect = document.querySelector('[data-record-commodity-select]');
const priceInput = document.querySelector('[data-record-price-input]');
const unitLabel = document.querySelector('[data-record-unit-label]');
const qtyUnit = document.querySelector('[data-record-qty-unit]');
const dateInput = document.querySelector('[data-record-date-input]');
const submitBtn = document.querySelector('[data-record-submit-btn]');

/** Element yang membuka dialog — untuk mengembalikan fokus setelah ditutup. */
let returnFocusTarget = null;

/* ─── Helpers ─────────────────────────────────────────── */

/** Format angka ke format ribuan Indonesia, tanpa Rp prefix. */
const formatThousands = (raw) => {
    const digits = raw.replace(/\D/g, '');
    if (!digits) return '';
    return Number(digits).toLocaleString('id-ID');
};

/** Ambil satuan dari option yang dipilih. */
const getSelectedUnit = () => {
    const opt = commoditySelect?.options[commoditySelect.selectedIndex];
    return opt?.dataset.unit ?? 'kg';
};

/** Update label satuan pada harga dan jumlah. */
const syncUnitLabels = () => {
    const unit = getSelectedUnit();
    if (unitLabel) unitLabel.textContent = `/${unit}`;
    if (qtyUnit) qtyUnit.textContent = unit;
};

/** Set tanggal default ke hari ini. */
const setDefaultDate = () => {
    if (!dateInput) return;
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    dateInput.value = `${yyyy}-${mm}-${dd}`;
};

/* ─── Open / Close ────────────────────────────────────── */

const openDialog = (triggerEl = null) => {
    if (!dialog || typeof dialog.showModal !== 'function') return;
    returnFocusTarget = triggerEl;
    setDefaultDate();
    syncUnitLabels();
    dialog.showModal();
    // Fokus ke commodity select setelah animasi mount
    requestAnimationFrame(() => commoditySelect?.focus());
};

const closeDialog = () => {
    if (dialog?.open) dialog.close();
};

/* ─── Trigger: tombol "+ Catat Belanja Pagi Ini" ─────── */

document.querySelectorAll('[data-open-record-shopping-dialog]').forEach((btn) => {
    btn.addEventListener('click', () => openDialog(btn));
});

/* ─── Tutup via tombol X, Batal, klik backdrop ────────── */

dialog?.querySelectorAll('[data-close-record-shopping-dialog]').forEach((btn) => {
    btn.addEventListener('click', closeDialog);
});

// Klik di luar card (pada backdrop) menutup dialog
dialog?.addEventListener('click', (e) => {
    if (e.target === dialog) closeDialog();
});

// Kembalikan fokus ke trigger setelah dialog ditutup
dialog?.addEventListener('close', () => {
    form?.reset();
    if (priceInput) delete priceInput.dataset.autofilled;
    syncUnitLabels();
    if (returnFocusTarget?.isConnected) returnFocusTarget.focus();
    returnFocusTarget = null;
});

// Escape ditangani native oleh browser untuk <dialog>, tapi kita tetap
// menangani event untuk memastikan perilaku konsisten di semua browser
dialog?.addEventListener('cancel', () => {
    // Browser mengembalikan cancel event saat Escape ditekan pada <dialog>
    // Biarkan default close terjadi, cleanup dihandle oleh event 'close' di atas
});

/* ─── Commodity select — sinkronkan satuan ───────────── */

commoditySelect?.addEventListener('change', () => {
    syncUnitLabels();

    // Isi harga sugestif dari data komoditas (harga demo) selama belum diubah manual
    const opt = commoditySelect.options[commoditySelect.selectedIndex];
    if (opt?.dataset.price && priceInput && (!priceInput.value || priceInput.dataset.autofilled === 'true')) {
        priceInput.value = formatThousands(opt.dataset.price);
        priceInput.dataset.autofilled = 'true';
    }
});

/* ─── Input harga: format otomatis ribuan ─────────────── */

priceInput?.addEventListener('input', () => {
    delete priceInput.dataset.autofilled;
    const raw = priceInput.value;
    const cursorPos = priceInput.selectionStart ?? 0;
    const formatted = formatThousands(raw);

    // Hitung pergeseran posisi kursor akibat penambahan/penghapusan titik
    const prevLength = raw.length;
    priceInput.value = formatted;
    const newLength = formatted.length;
    const offset = newLength - prevLength;
    try {
        priceInput.setSelectionRange(cursorPos + offset, cursorPos + offset);
    } catch (_) {
        // Abaikan jika browser tidak mendukung
    }
});

/* ─── Submit: preview only, tidak ada POST ke server ─── */

form?.addEventListener('submit', (e) => {
    e.preventDefault();

    // Validasi sederhana sebelum memproses
    const commodity = commoditySelect?.value;
    const rawPrice = priceInput?.value.replace(/\./g, '').replace(',', '.');
    const price = parseFloat(rawPrice);
    const qty = parseFloat(document.querySelector('[data-record-qty-input]')?.value ?? '0');
    const date = dateInput?.value;

    if (!commodity) {
        commoditySelect?.focus();
        commoditySelect?.setCustomValidity('Pilih komoditas terlebih dahulu.');
        commoditySelect?.reportValidity();
        commoditySelect?.setCustomValidity('');
        return;
    }

    if (!price || price <= 0) {
        priceInput?.focus();
        priceInput?.setCustomValidity('Masukkan harga yang valid (lebih dari 0).');
        priceInput?.reportValidity();
        priceInput?.setCustomValidity('');
        return;
    }

    if (!qty || qty <= 0) {
        document.querySelector('[data-record-qty-input]')?.focus();
        document.querySelector('[data-record-qty-input]')?.setCustomValidity('Masukkan jumlah yang valid (lebih dari 0).');
        document.querySelector('[data-record-qty-input]')?.reportValidity();
        document.querySelector('[data-record-qty-input]')?.setCustomValidity('');
        return;
    }

    if (!date) {
        dateInput?.focus();
        dateInput?.setCustomValidity('Pilih tanggal belanja.');
        dateInput?.reportValidity();
        dateInput?.setCustomValidity('');
        return;
    }

    // ─── Preview only: ambil detail sebelum form di-reset, tampilkan toast dan tutup modal ───
    const name = commoditySelect.options[commoditySelect.selectedIndex]?.text ?? commodity;
    const unit = getSelectedUnit();
    closeDialog();

    // Tampilkan toast preview melalui mekanisme yang sudah ada di dashboard
    const toast = document.querySelector('[data-dashboard-toast]');
    if (toast) {
        toast.textContent = `Preview: catatan ${name} Rp${formatThousands(String(Math.round(price)))}/${unit} × ${qty} ${unit} tercatat (belum disimpan ke server).`;
        toast.hidden = false;
        clearTimeout(toast._toastTimer);
        toast._toastTimer = setTimeout(() => { toast.hidden = true; }, 4500);
    }
});
