const filters = [...document.querySelectorAll('[data-recommendation-filter]')];
const rows = [...document.querySelectorAll('[data-recommendation-row]')];
const emptyState = document.querySelector('[data-recommendations-empty]');

if (filters.length && rows.length) {
    const applyFilter = (selected) => {
        let visibleRows = 0;

        rows.forEach((row) => {
            const matches = selected === 'all' || row.dataset.recommendationSignal === selected;
            row.hidden = !matches;
            visibleRows += Number(matches);
        });

        filters.forEach((filter) => {
            const active = filter.dataset.recommendationFilter === selected;
            filter.classList.toggle('is-active', active);
            filter.setAttribute('aria-pressed', String(active));
        });

        if (emptyState) emptyState.hidden = visibleRows > 0;
    };

    filters.forEach((filter) => {
        filter.addEventListener('click', () => applyFilter(filter.dataset.recommendationFilter));
    });
}
