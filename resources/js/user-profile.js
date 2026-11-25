const profileRoot = document.querySelector('[data-user-profile]');

if (profileRoot) {
    const initialProfile = JSON.parse(profileRoot.dataset.profileInitial || '{}');
    const profileForm = profileRoot.querySelector('[data-profile-edit-form]');
    const readonlyPanel = profileRoot.querySelector('[data-profile-readonly]');
    const editor = profileRoot.querySelector('[data-profile-editor]');
    const editToggle = profileRoot.querySelector('[data-profile-edit-toggle]');
    const profileStatus = profileRoot.querySelector('[data-profile-status]');
    const profileFields = [...profileRoot.querySelectorAll('[data-profile-field]')];
    let currentProfile = { ...initialProfile };

    const announce = (element, message) => {
        if (!element) return;
        element.textContent = message;
        element.hidden = false;
    };

    const setProfileMode = (isEditing) => {
        if (!editor || !readonlyPanel || !editToggle) return;

        editor.hidden = !isEditing;
        readonlyPanel.hidden = isEditing;
        editToggle.setAttribute('aria-expanded', String(isEditing));
        editToggle.querySelector('span').textContent = isEditing ? 'Tutup Edit' : 'Edit Profil';

        if (isEditing) profileFields[0]?.focus();
    };

    const restoreProfileFields = () => {
        profileFields.forEach((field) => {
            field.value = currentProfile[field.dataset.profileField] ?? '';
            field.setCustomValidity('');
            field.setAttribute('aria-invalid', 'false');
        });

        profileRoot.querySelectorAll('[data-profile-error]').forEach((error) => {
            error.hidden = true;
        });
    };

    editToggle?.addEventListener('click', () => {
        const isEditing = editor?.hidden ?? true;
        if (isEditing) restoreProfileFields();
        setProfileMode(isEditing);
    });

    profileRoot.querySelector('[data-profile-cancel]')?.addEventListener('click', () => {
        restoreProfileFields();
        setProfileMode(false);
        announce(profileStatus, 'Pengeditan dibatalkan. Tidak ada perubahan yang disimpan.');
    });

    profileFields.forEach((field) => {
        field.addEventListener('input', () => {
            field.setCustomValidity('');
            field.setAttribute('aria-invalid', 'false');
            const error = profileRoot.querySelector(`[data-profile-error="${field.dataset.profileField}"]`);
            if (error) error.hidden = true;
        });
    });

    profileForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        let valid = true;

        profileFields.forEach((field) => {
            let isValid = field.checkValidity();
            if (field.dataset.profileField === 'contact' && field.value.trim()) {
                const contact = field.value.trim();
                const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(contact);
                const validPhone = /^\+?[0-9][0-9\s().-]*$/.test(contact)
                    && (contact.match(/\d/g)?.length ?? 0) >= 8
                    && (contact.match(/\d/g)?.length ?? 0) <= 15;
                isValid = validEmail || validPhone;
                field.setCustomValidity(isValid ? '' : 'Masukkan email atau nomor HP yang valid.');
            }
            field.setAttribute('aria-invalid', String(!isValid));
            const error = profileRoot.querySelector(`[data-profile-error="${field.dataset.profileField}"]`);
            if (error) error.hidden = isValid;
            valid &&= isValid;
        });

        if (!valid) {
            profileForm.reportValidity();
            announce(profileStatus, 'Periksa kembali nama usaha, nama pemilik, dan email atau nomor HP.');
            return;
        }

        profileFields.forEach((field) => {
            currentProfile[field.dataset.profileField] = field.value.trim();
        });
        document.querySelectorAll('[data-profile-value]').forEach((value) => {
            value.textContent = currentProfile[value.dataset.profileValue] ?? '';
        });

        setProfileMode(false);
        announce(profileStatus, 'Pratinjau profil diperbarui di halaman ini. Perubahan belum tersimpan permanen.');
    });

    const passwordForm = profileRoot.querySelector('[data-profile-password-form]');
    const currentPassword = passwordForm?.querySelector('[name="current_password"]');
    const newPassword = passwordForm?.querySelector('[data-new-password]');
    const confirmation = passwordForm?.querySelector('[data-confirm-password]');
    const passwordStatus = passwordForm?.querySelector('[data-password-status]');
    let passwordSubmitted = false;

    const validatePasswords = () => {
        if (!passwordForm || !currentPassword || !newPassword || !confirmation) return false;

        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
        const checks = [
            [currentPassword, currentPassword.value.length > 0, 'current_password', 'Masukkan password lama.'],
            [newPassword, passwordPattern.test(newPassword.value), 'new_password', 'Gunakan minimal 8 karakter yang berisi huruf dan angka.'],
            [confirmation, confirmation.value === newPassword.value && confirmation.value.length > 0, 'new_password_confirmation', 'Konfirmasi password belum sama.'],
        ];

        let valid = true;
        checks.forEach(([field, isValid, key, message]) => {
            field.setCustomValidity(isValid ? '' : message);
            field.setAttribute('aria-invalid', String(!isValid));
            const error = passwordForm.querySelector(`[data-password-error="${key}"]`);
            if (error) error.hidden = isValid;
            valid &&= isValid;
        });

        return valid;
    };

    const clearPasswordValidation = () => {
        [currentPassword, newPassword, confirmation].forEach((field) => {
            if (!field) return;
            field.setCustomValidity('');
            field.setAttribute('aria-invalid', 'false');
        });
        passwordForm?.querySelectorAll('[data-password-error]').forEach((error) => {
            error.hidden = true;
        });
        passwordForm?.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
            const field = document.getElementById(toggle.getAttribute('aria-controls'));
            if (field) field.type = 'password';
            toggle.setAttribute('aria-pressed', 'false');
            toggle.setAttribute('aria-label', 'Tampilkan password');
        });
    };

    [currentPassword, newPassword, confirmation].forEach((field) => {
        field?.addEventListener('input', () => {
            if (passwordSubmitted) {
                validatePasswords();
            } else if (field === newPassword && field.value) {
                const valid = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/.test(field.value);
                field.setCustomValidity(valid ? '' : 'Gunakan minimal 8 karakter yang berisi huruf dan angka.');
                field.setAttribute('aria-invalid', String(!valid));
                const error = passwordForm.querySelector('[data-password-error="new_password"]');
                if (error) error.hidden = valid;
            } else if (field === confirmation && field.value) {
                const valid = field.value === newPassword?.value;
                field.setCustomValidity(valid ? '' : 'Konfirmasi password belum sama.');
                field.setAttribute('aria-invalid', String(!valid));
                const error = passwordForm.querySelector('[data-password-error="new_password_confirmation"]');
                if (error) error.hidden = valid;
            }
            if (passwordStatus) passwordStatus.hidden = true;
        });
    });

    passwordForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        passwordSubmitted = true;
        if (!validatePasswords()) {
            passwordForm.reportValidity();
            announce(passwordStatus, 'Periksa password lama, ketentuan password baru, dan konfirmasinya.');
            return;
        }

        passwordForm.reset();
        clearPasswordValidation();
        announce(passwordStatus, 'Password tidak diubah. Autentikasi backend belum tersedia, sehingga data tidak dikirim atau disimpan.');
    });
}
