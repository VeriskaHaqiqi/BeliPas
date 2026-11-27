const recoveryForms = document.querySelectorAll('[data-recovery-form]');

const setRecoveryStatus = (form, message) => {
    const status = form.querySelector('[data-recovery-status]');
    if (!status) return;

    status.hidden = false;
    status.textContent = message;
};

recoveryForms.forEach((form) => {
    const preview = form.querySelector('[data-recovery-preview]');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (form.dataset.recoveryForm === 'identity') {
            const identity = form.querySelector('#recovery-identity');
            const value = identity.value.trim();
            const looksLikeEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            const phoneDigits = value.replace(/[\s()+.-]/g, '');
            const looksLikePhone = /^\+?\d{8,15}$/.test(phoneDigits);

            if (!looksLikeEmail && !looksLikePhone) {
                identity.setAttribute('aria-invalid', 'true');
                setRecoveryStatus(form, 'Masukkan format email atau nomor HP yang valid. Data ini hanya diperiksa di halaman dan tidak dikirim.');
                preview.hidden = true;
                return;
            }

            identity.removeAttribute('aria-invalid');
            setRecoveryStatus(form, 'Pratinjau saja: tidak ada kode yang dikirim. Layanan pemulihan belum terhubung.');
            preview.hidden = false;
            return;
        }

        if (form.dataset.recoveryForm === 'otp') {
            const digits = [...form.querySelectorAll('[data-otp-digit]')];
            const complete = digits.every((input) => /^\d$/.test(input.value));

            if (!complete) {
                setRecoveryStatus(form, 'Isi enam digit untuk melihat status pratinjau. Kode tidak diverifikasi.');
                digits.find((input) => !/^\d$/.test(input.value))?.focus();
                preview.hidden = true;
                return;
            }

            setRecoveryStatus(form, 'Kode tidak diverifikasi. Verifikasi OTP belum terhubung; tahap berikutnya hanya pratinjau UI.');
            preview.hidden = false;
            return;
        }

        if (form.dataset.recoveryForm === 'password') {
            const password = form.querySelector('#new-password');
            const confirmation = form.querySelector('#new-password-confirmation');
            const validPassword = password.value.length >= 8 && /[A-Za-z]/.test(password.value) && /\d/.test(password.value);
            const matching = password.value === confirmation.value;

            password.setAttribute('aria-invalid', String(!validPassword));
            confirmation.setAttribute('aria-invalid', String(!matching));

            if (!validPassword || !matching) {
                setRecoveryStatus(form, !validPassword
                    ? 'Password perlu berisi minimal 8 karakter, huruf, dan angka.'
                    : 'Konfirmasi password belum sama.');
                preview.hidden = true;
                return;
            }

            setRecoveryStatus(form, 'Password tidak disimpan atau diubah. Tahap ini hanya memeriksa format secara lokal untuk pratinjau UI.');
            preview.hidden = false;
        }
    });
});

const otpDigits = [...document.querySelectorAll('[data-otp-digit]')];

otpDigits.forEach((input, index) => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(-1);
        if (input.value && index < otpDigits.length - 1) otpDigits[index + 1].focus();
    });

    input.addEventListener('keydown', (event) => {
        if ((event.key === 'Backspace' || event.key === 'ArrowLeft') && !input.value && index > 0) {
            otpDigits[index - 1].focus();
        } else if (event.key === 'ArrowRight' && index < otpDigits.length - 1) {
            otpDigits[index + 1].focus();
        }
    });

    input.addEventListener('paste', (event) => {
        const pasted = event.clipboardData?.getData('text')?.replace(/\D/g, '').slice(0, 6);
        if (!pasted) return;

        event.preventDefault();
        [...pasted].forEach((digit, digitIndex) => {
            if (otpDigits[digitIndex]) otpDigits[digitIndex].value = digit;
        });
        otpDigits[Math.min(pasted.length, otpDigits.length) - 1]?.focus();
    });
});

const recoveryPassword = document.querySelector('#new-password');
const recoveryConfirmation = document.querySelector('#new-password-confirmation');
const strengthBars = [...document.querySelectorAll('[data-strength-bar]')];

const updateRecoveryPasswordState = () => {
    if (!recoveryPassword || !recoveryConfirmation) return;

    const value = recoveryPassword.value;
    const checks = {
        length: value.length >= 8,
        letter: /[A-Za-z]/.test(value),
        number: /\d/.test(value),
    };

    Object.entries(checks).forEach(([rule, valid]) => {
        const item = document.querySelector(`[data-password-rule="${rule}"]`);
        if (!item) return;
        item.classList.toggle('is-valid', valid);
        item.textContent = `${valid ? '✓' : '○'} ${rule === 'length' ? 'Minimal 8 karakter' : rule === 'letter' ? 'Mengandung huruf' : 'Mengandung angka'}`;
    });

    const score = Object.values(checks).filter(Boolean).length;
    strengthBars.forEach((bar, index) => bar.classList.toggle('is-active', index < score));

    if (recoveryConfirmation.value) {
        recoveryConfirmation.setAttribute('aria-invalid', String(recoveryConfirmation.value !== value));
    }
};

recoveryPassword?.addEventListener('input', updateRecoveryPasswordState);
recoveryConfirmation?.addEventListener('input', updateRecoveryPasswordState);

const countdown = document.querySelector('[data-otp-countdown]');
if (countdown) {
    let remaining = 44;
    window.setInterval(() => {
        remaining = Math.max(0, remaining - 1);
        countdown.textContent = `00:${String(remaining).padStart(2, '0')}`;
    }, 1000);
}

document.querySelector('[data-otp-resend]')?.addEventListener('click', () => {
    const form = document.querySelector('[data-recovery-form="otp"]');
    if (form) setRecoveryStatus(form, 'Kode tidak dikirim ulang. Fitur pengiriman OTP belum tersedia pada pratinjau ini.');
});
