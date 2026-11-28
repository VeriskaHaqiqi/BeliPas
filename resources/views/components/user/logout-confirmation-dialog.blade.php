<dialog class="user-logout-dialog" id="user-logout-dialog" data-logout-dialog aria-labelledby="user-logout-title" aria-describedby="user-logout-description">
    <div class="user-logout-dialog-card">
        <div class="user-logout-dialog-top-row">
            <button class="user-logout-dialog-close" type="button" data-close-logout-dialog aria-label="Tutup konfirmasi keluar">
                <img class="user-logout-icon" src="{{ asset('images/user-modal-close.svg') }}" alt="" aria-hidden="true">
            </button>
        </div>

        <div class="user-logout-dialog-content">
            <span class="user-logout-icon-tile" aria-hidden="true">
                <img class="user-logout-icon" src="{{ asset('images/user-modal-logout.svg') }}" alt="">
            </span>
            <h2 id="user-logout-title">Keluar dari BeliPas?</h2>
            <p id="user-logout-description">Anda akan keluar dari sesi akun saat ini dan diarahkan kembali ke halaman masuk.</p>
        </div>

        <div class="user-logout-dialog-actions">
            <button class="user-logout-cancel" type="button" data-close-logout-dialog>Batal</button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="user-logout-confirm" type="submit">Ya, Keluar</button>
            </form>
        </div>
    </div>
</dialog>
