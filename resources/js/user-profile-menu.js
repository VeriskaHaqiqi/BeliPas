const profileToggle = document.querySelector('[data-user-menu-toggle]');
const profileMenu = document.querySelector('[data-user-profile-menu]');
const logoutDialog = document.querySelector('[data-logout-dialog]');
let returnFocusTarget = null;

const closeProfileMenu = () => {
    if (!profileToggle || !profileMenu) return;

    profileMenu.hidden = true;
    profileToggle.setAttribute('aria-expanded', 'false');
};

const closeLogoutDialog = () => {
    if (logoutDialog?.open) logoutDialog.close();
};

profileToggle?.addEventListener('click', () => {
    if (!profileMenu) return;

    const willOpen = profileMenu.hidden;
    profileMenu.hidden = !willOpen;
    profileToggle.setAttribute('aria-expanded', String(willOpen));
});

document.addEventListener('click', (event) => {
    if (!profileToggle || !profileMenu || profileMenu.hidden) return;
    if (event.target instanceof Element && (profileMenu.contains(event.target) || profileToggle.contains(event.target))) return;

    closeProfileMenu();
});

document.querySelector('[data-profile-menu-link]')?.addEventListener('click', closeProfileMenu);

document.querySelector('[data-open-logout-dialog]')?.addEventListener('click', () => {
    if (!logoutDialog || typeof logoutDialog.showModal !== 'function') return;

    returnFocusTarget = profileToggle;
    closeProfileMenu();
    logoutDialog.showModal();
    requestAnimationFrame(() => logoutDialog.querySelector('[data-close-logout-dialog]')?.focus());
});

logoutDialog?.querySelectorAll('[data-close-logout-dialog]').forEach((button) => {
    button.addEventListener('click', closeLogoutDialog);
});

logoutDialog?.addEventListener('click', (event) => {
    if (event.target === logoutDialog) closeLogoutDialog();
});

logoutDialog?.addEventListener('close', () => {
    if (returnFocusTarget?.isConnected) returnFocusTarget.focus();
    returnFocusTarget = null;
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeProfileMenu();
});
