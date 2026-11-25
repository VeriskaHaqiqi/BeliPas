const formatDemoPrice = (amount) => new Intl.NumberFormat('id-ID').format(amount);

document.querySelectorAll('[data-forecast-interaction]').forEach((page) => {
    const chart = page.querySelector('[data-price-chart]');
    const buttons = [...page.querySelectorAll('[data-price-horizon]')];
    const rows = [...page.querySelectorAll('[data-forecast-row]')];
    const currentPrice = Number(page.querySelector('[data-current-price-value]')?.dataset.currentPriceValue ?? 0);
    const lowestValue = page.querySelector('[data-horizon-stat="lowest"]');
    const peakValue = page.querySelector('[data-horizon-stat="peak"]');
    const forecastLine = chart?.querySelector('[data-forecast-line]');
    const forecastArea = chart?.querySelector('[data-forecast-area]');
    const historicPoints = chart ? [...chart.querySelectorAll('[data-chart-point]:not([data-forecast-point])')] : [];
    const forecastPoints = chart ? [...chart.querySelectorAll('[data-forecast-point]')] : [];
    const tooltip = chart?.querySelector('[data-chart-tooltip]');

    const updateHorizon = (horizon) => {
        page.dataset.activeHorizon = horizon;
        buttons.forEach((button) => {
            const active = button.dataset.priceHorizon === horizon;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', String(active));
        });

        rows.forEach((row) => {
            row.hidden = Number(row.dataset.horizonDay) > Number(horizon);
        });

        const visiblePoints = forecastPoints.filter((point) => Number(point.dataset.dayIndex) <= Number(horizon));
        const startPoint = historicPoints.at(-1);
        const coordinates = [startPoint, ...visiblePoints]
            .filter(Boolean)
            .map((point) => `${point.getAttribute('cx')},${point.getAttribute('cy')}`)
            .join(' ');

        if (forecastLine) forecastLine.setAttribute('points', coordinates);
        if (forecastArea && startPoint && visiblePoints.length) {
            const lastPoint = visiblePoints.at(-1);
            forecastArea.setAttribute('points', `${startPoint.getAttribute('cx')},286 ${coordinates} ${lastPoint.getAttribute('cx')},286`);
            forecastArea.hidden = false;
        } else if (forecastArea) {
            forecastArea.hidden = true;
        }

        forecastPoints.forEach((point) => {
            const outsideHorizon = Number(point.dataset.dayIndex) > Number(horizon);
            point.classList.toggle('is-outside-horizon', outsideHorizon);
            point.setAttribute('aria-hidden', String(outsideHorizon));
            point.setAttribute('tabindex', outsideHorizon ? '-1' : '0');
        });

        const visiblePrices = rows
            .filter((row) => !row.hidden)
            .map((row) => Number(row.dataset.forecastPrice))
            .filter(Number.isFinite);
        const allPrices = [currentPrice, ...visiblePrices].filter((value) => value > 0);
        if (allPrices.length && lowestValue) lowestValue.textContent = `Rp${formatDemoPrice(Math.min(...allPrices))}`;
        if (visiblePrices.length && peakValue) peakValue.textContent = `Rp${formatDemoPrice(Math.max(...visiblePrices))}`;
        const visibleRows = rows.filter((row) => !row.hidden);
        const peakRow = visibleRows.reduce((peak, row) => {
            if (!peak || Number(row.dataset.forecastPrice) > Number(peak.dataset.forecastPrice)) return row;
            return peak;
        }, null);
        const horizonLabel = page.querySelector('[data-horizon-label]');
        const peakNote = page.querySelector('[data-horizon-peak-note]');
        if (horizonLabel) horizonLabel.textContent = `${horizon} hari`;
        if (peakRow && peakNote) {
            peakNote.textContent = `+${peakRow.dataset.forecastPercent} diperkirakan pada ${peakRow.dataset.forecastWeekday}, ${peakRow.dataset.forecastDate}`;
        }
        if (tooltip) tooltip.hidden = true;
    };

    const showTooltip = (point) => {
        if (!chart || !tooltip) return;

        const chartBounds = chart.getBoundingClientRect();
        const pointBounds = point.getBoundingClientRect();
        const x = pointBounds.left - chartBounds.left + pointBounds.width / 2;
        const y = pointBounds.top - chartBounds.top;
        const isForecast = point.hasAttribute('data-forecast-point');
        tooltip.textContent = `${point.dataset.chartLabel} · Rp${point.dataset.chartValue}/${chart.dataset.chartUnit} · ${isForecast ? 'Proyeksi' : 'Historis'} · DATA DEMO`;
        tooltip.style.left = `${Math.max(8, Math.min(x - 50, chartBounds.width - 220))}px`;
        tooltip.style.top = `${Math.max(88, y - 62)}px`;
        tooltip.hidden = false;
    };

    buttons.forEach((button) => {
        button.addEventListener('click', () => updateHorizon(button.dataset.priceHorizon));
    });

    chart?.querySelectorAll('[data-chart-point]').forEach((point) => {
        point.addEventListener('pointerenter', () => showTooltip(point));
        point.addEventListener('pointerleave', () => { if (tooltip) tooltip.hidden = true; });
        point.addEventListener('focus', () => showTooltip(point));
        point.addEventListener('blur', () => { if (tooltip) tooltip.hidden = true; });
    });

    updateHorizon(page.dataset.initialHorizon ?? '7');
});
