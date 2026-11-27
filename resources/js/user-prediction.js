document.querySelectorAll('[data-prediction-commodity-select]').forEach((select) => {
    select.addEventListener('change', () => {
        const target = select.value;

        if (target) window.location.assign(target);
    });
});
