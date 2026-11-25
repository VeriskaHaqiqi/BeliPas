const settingsRoot = document.querySelector('[data-user-settings]');

if (settingsRoot) {
    const initialTrackedIds = JSON.parse(settingsRoot.dataset.initialTracked || '[]');
    let trackedIds = new Set(initialTrackedIds);
    let draftTrackedIds = new Set(trackedIds);
    const chips = [...settingsRoot.querySelectorAll('[data-watch-chip]')];
    const options = [...document.querySelectorAll('[data-watch-option]')];
    const countLabel = settingsRoot.querySelector('[data-watch-count]');
    const liveMessage = settingsRoot.querySelector('[data-settings-live]');
    const dialogLiveMessage = document.querySelector('[data-dialog-live]');
    const dialog = document.querySelector('[data-commodity-dialog]');

    const announce = (message, target = liveMessage) => {
        if (!target) return;

        target.textContent = message;
        target.hidden = false;
    };

    const syncOptions = (selectedIds) => {
        options.forEach((option) => {
            option.checked = selectedIds.has(option.value);
        });
    };

    const render = () => {
        chips.forEach((chip) => {
            chip.hidden = !trackedIds.has(chip.dataset.watchChip);
        });

        if (countLabel) countLabel.textContent = `${trackedIds.size} Dipilih`;
        syncOptions(trackedIds);
    };

    const closeDialog = () => {
        if (dialog?.open) dialog.close();
        draftTrackedIds = new Set(trackedIds);
        syncOptions(draftTrackedIds);
        if (dialogLiveMessage) dialogLiveMessage.hidden = true;
    };

    settingsRoot.querySelectorAll('[data-watch-chip]').forEach((chip) => {
        chip.addEventListener('click', () => {
            if (trackedIds.size <= 1) {
                announce('Pilih minimal satu komoditas pantauan.');
                return;
            }

            trackedIds.delete(chip.dataset.watchChip);
            render();
            announce(`${chip.querySelector('span')?.textContent ?? 'Komoditas'} dilepas dari pratinjau pantauan. Belum disimpan permanen.`);
        });
    });

    settingsRoot.querySelector('[data-open-commodity-dialog]')?.addEventListener('click', () => {
        if (!dialog) return;

        draftTrackedIds = new Set(trackedIds);
        syncOptions(draftTrackedIds);
        if (dialogLiveMessage) dialogLiveMessage.hidden = true;
        dialog.showModal();
    });

    options.forEach((option) => {
        option.addEventListener('change', () => {
            if (option.checked) draftTrackedIds.add(option.value);
            else draftTrackedIds.delete(option.value);
        });
    });

    document.querySelector('[data-apply-watch]')?.addEventListener('click', () => {
        if (draftTrackedIds.size < 1) {
            announce('Pilih minimal satu komoditas sebelum menerapkan pilihan.', dialogLiveMessage);
            return;
        }

        trackedIds = new Set(draftTrackedIds);
        render();
        closeDialog();
        announce('Pilihan demo diterapkan pada halaman ini; belum tersimpan permanen.');
    });

    document.querySelectorAll('[data-close-commodity-dialog]').forEach((button) => {
        button.addEventListener('click', closeDialog);
    });

    dialog?.addEventListener('click', (event) => {
        if (event.target === dialog) closeDialog();
    });

    settingsRoot.querySelector('[data-reset-tracked]')?.addEventListener('click', () => {
        trackedIds = new Set(initialTrackedIds);
        draftTrackedIds = new Set(trackedIds);
        render();
        announce('Pilihan komoditas dikembalikan ke standar demo. Belum ada data yang disimpan.');
    });

    settingsRoot.querySelector('[data-preview-save]')?.addEventListener('click', () => {
        announce('Pratinjau pilihan diperbarui di halaman ini. Penyimpanan ke database belum tersedia.');
    });

    settingsRoot.querySelector('[data-settings-support]')?.addEventListener('click', () => {
        announce('Kontak pendamping belum tersedia pada MVP v1.');
    });

    settingsRoot.querySelector('[data-settings-form]')?.addEventListener('submit', (event) => event.preventDefault());

    render();
}
