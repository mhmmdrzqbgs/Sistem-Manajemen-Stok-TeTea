<?php
// notif.php
if (isset($_GET['pesan'])) {
    $message = '';
    $toastClass = '';

    switch ($_GET['pesan']) {
        case "gagal":
            $message = "Email atau Password salah!";
            $toastClass = "text-bg-danger";
            break;
        case "belum_login":
            $message = "Anda harus login terlebih dahulu untuk mengakses halaman ini.";
            $toastClass = "text-bg-danger";
            break;
        case "login_berhasil":
            $userName = isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : 'Pengguna';
            $message = "Login berhasil! Selamat datang, " . $userName . ".";
            $toastClass = "text-bg-success";
            break;
        case "logout_berhasil":
            $message = "Logout berhasil! Sampai jumpa.";
            $toastClass = "text-bg-success";
            break;
    }

    if ($message): ?>
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050;">
            <div class="toast align-items-center <?= $toastClass ?> border-0" id="toastNotification" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <?= $message ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const toast = new bootstrap.Toast(document.getElementById('toastNotification'));
                toast.show();

                setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('pesan');
                    url.searchParams.delete('nama');
                    window.history.replaceState({}, document.title, url);
                }, 3500);
            });
        </script>
    <?php endif;
}
?>
