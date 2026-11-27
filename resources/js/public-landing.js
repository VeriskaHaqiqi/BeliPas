const landingMenuToggle = document.querySelector('[data-public-menu-toggle]');
const landingMenu = document.querySelector('[data-public-menu]');
const landingDesktopMedia = window.matchMedia('(min-width: 761px)');

if (landingMenu) landingMenu.hidden = !landingDesktopMedia.matches;

const closeLandingMenu = () => {
    if (!landingMenuToggle || !landingMenu) return;

    landingMenu.hidden = !landingDesktopMedia.matches;
    landingMenuToggle.setAttribute('aria-expanded', 'false');
    landingMenuToggle.setAttribute('aria-label', 'Buka menu navigasi');
};

landingMenuToggle?.addEventListener('click', () => {
    if (!landingMenu) return;

    const willOpen = landingMenu.hidden;
    landingMenu.hidden = !willOpen;
    landingMenuToggle.setAttribute('aria-expanded', String(willOpen));
    landingMenuToggle.setAttribute('aria-label', willOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
});

landingMenu?.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', () => closeLandingMenu());
});

document.addEventListener('click', (event) => {
    if (!landingMenu || landingMenu.hidden) return;
    if (event.target instanceof Element && (landingMenu.contains(event.target) || landingMenuToggle?.contains(event.target))) return;

    closeLandingMenu();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeLandingMenu();
});

const budgetSlider = document.querySelector('[data-budget-slider]');
const budgetDisplay = document.querySelector('[data-budget-display]');
const savingsRate = document.querySelector('[data-savings-rate]');
const savingsDisplay = document.querySelector('[data-savings-display]');
const formatRupiah = (value) => new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(value);

const updateSavingsScenario = () => {
    if (!budgetSlider || !budgetDisplay || !savingsRate || !savingsDisplay) return;

    const budget = Number(budgetSlider.value);
    budgetDisplay.textContent = formatRupiah(budget);
    const minimum = Number(budgetSlider.min);
    const maximum = Number(budgetSlider.max);
    const filled = ((budget - minimum) / Math.max(1, maximum - minimum)) * 100;
    budgetSlider.style.background = `linear-gradient(90deg, #006a66 0 ${filled}%, #e0e8e5 ${filled}%)`;

    const rateText = savingsRate.value.trim().replace(',', '.');
    const rate = Number(rateText);

    if (rateText === '' || !Number.isFinite(rate) || rate < 0 || rate > 100) {
        savingsDisplay.textContent = rateText === '' ? 'Masukkan asumsi' : 'Periksa asumsi';
        return;
    }

    savingsDisplay.textContent = `Rp ${formatRupiah((budget * rate) / 100)}`;
};

budgetSlider?.addEventListener('input', updateSavingsScenario);
savingsRate?.addEventListener('input', updateSavingsScenario);
updateSavingsScenario();

landingDesktopMedia.addEventListener('change', closeLandingMenu);
