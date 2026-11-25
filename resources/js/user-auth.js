document.querySelectorAll('[data-password-toggle]').forEach((passwordToggle) => {
    passwordToggle.addEventListener('click', () => {
        const input = document.getElementById(passwordToggle.getAttribute('aria-controls'));
        const icon = passwordToggle.querySelector('img');

        if (!input || !icon) return;

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        passwordToggle.setAttribute('aria-pressed', String(isPassword));
        passwordToggle.setAttribute(
            'aria-label',
            isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi',
        );
        icon.alt = isPassword ? 'Kata sandi terlihat' : 'Kata sandi tersembunyi';
    });
});

const showStatus = (form, message) => {
    const status = form?.querySelector('[data-auth-status], [data-login-status]');

    if (!status) return;

    status.hidden = false;
    status.textContent = message;
};

const loginForm = document.querySelector('[data-login-form]');

loginForm?.addEventListener('submit', (event) => {
    event.preventDefault();
    showStatus(loginForm, 'Autentikasi belum dihubungkan. Form ini hanya pratinjau antarmuka.');
});

const registerForm = document.querySelector('[data-register-form]');
const registerPassword = document.querySelector('#register-password');
const registerPasswordConfirmation = document.querySelector('#register-password-confirmation');
const passwordStrength = document.querySelector('[data-password-strength]');

const updateRegistrationPasswordState = () => {
    if (!registerPassword || !registerPasswordConfirmation) return;

    const password = registerPassword.value;
    const meetsPasswordRules = password.length >= 8 && /[A-Za-z]/.test(password) && /\d/.test(password);
    registerPassword.setCustomValidity(
        password && !meetsPasswordRules ? 'Gunakan minimal 8 karakter yang berisi huruf dan angka.' : '',
    );

    if (passwordStrength) {
        passwordStrength.textContent = password
            ? meetsPasswordRules
                ? 'Kata sandi memenuhi ketentuan.'
                : 'Minimal 8 karakter, kombinasi huruf dan angka.'
            : 'Minimal 8 karakter, kombinasi huruf dan angka.';
        passwordStrength.dataset.valid = String(!password || meetsPasswordRules);
    }

    const confirmationMismatch = Boolean(registerPasswordConfirmation.value)
        && registerPasswordConfirmation.value !== password;
    registerPasswordConfirmation.setCustomValidity(
        confirmationMismatch ? 'Konfirmasi password belum sama.' : '',
    );
    registerPasswordConfirmation.setAttribute('aria-invalid', String(confirmationMismatch));
};

registerPassword?.addEventListener('input', updateRegistrationPasswordState);
registerPasswordConfirmation?.addEventListener('input', updateRegistrationPasswordState);

registerForm?.addEventListener('submit', (event) => {
    event.preventDefault();
    updateRegistrationPasswordState();

    if (!registerForm.reportValidity()) {
        showStatus(registerForm, 'Periksa kembali data yang wajib diisi dan ketentuan password.');
        return;
    }

    showStatus(registerForm, 'Pendaftaran belum disimpan. Form ini belum terhubung ke Supabase.');
});

document.querySelectorAll('[data-stage-placeholder]').forEach((control) => {
    control.addEventListener('click', () => {
        const form = control.closest('form');
        showStatus(form, `${control.dataset.stagePlaceholder} belum tersedia pada tahap ini.`);
    });
});
