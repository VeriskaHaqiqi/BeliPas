const dashboardToast = document.querySelector('[data-dashboard-toast]');
let toastTimer;

const announceDashboardNotice = (message) => {
    if (!dashboardToast) return;

    dashboardToast.textContent = message;
    dashboardToast.hidden = false;
    window.clearTimeout(toastTimer);
    toastTimer = window.setTimeout(() => {
        dashboardToast.hidden = true;
    }, 3200);
};

document.querySelectorAll('[data-dashboard-notice]').forEach((control) => {
    control.addEventListener('click', () => {
        announceDashboardNotice(control.dataset.dashboardNotice);
    });
});

const categoryFilters = [...document.querySelectorAll('[data-category-filter]')];
const commodityCards = [...document.querySelectorAll('[data-commodity-card]')];
const commodityEmptyState = document.querySelector('[data-category-empty]');

categoryFilters.forEach((filter) => {
    filter.addEventListener('click', () => {
        const selectedCategory = filter.dataset.categoryFilter;
        let visibleCount = 0;

        categoryFilters.forEach((button) => {
            const isActive = button === filter;
            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-pressed', String(isActive));
        });

        commodityCards.forEach((card) => {
            const isVisible = selectedCategory === 'all' || card.dataset.category === selectedCategory;
            card.hidden = !isVisible;
            visibleCount += Number(isVisible);
        });

        if (commodityEmptyState) commodityEmptyState.hidden = visibleCount > 0;
    });
});

const mobileNavToggle = document.querySelector('[data-mobile-nav-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');

mobileNavToggle?.addEventListener('click', () => {
    if (!mobileNav) return;

    const willOpen = mobileNav.hidden;
    mobileNav.hidden = !willOpen;
    mobileNavToggle.setAttribute('aria-expanded', String(willOpen));
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;

    if (mobileNav && mobileNavToggle) {
        mobileNav.hidden = true;
        mobileNavToggle.setAttribute('aria-expanded', 'false');
    }
});
