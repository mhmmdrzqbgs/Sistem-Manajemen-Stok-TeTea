<?php
// admin
include_once('../config.php');
include('header.php');
include('../auth.php'); // Cek login

$timeout_duration = 900; // 15 menit

// Periksa apakah sesi aktif
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: index.php?pesan=timeout");
    exit();
}

$_SESSION['last_activity'] = time();

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['id_user'])) {
    
    echo '<div class="alert alert-warning">Anda harus login terlebih dahulu!</div>';

    echo '<script>
        setTimeout(function() {
            window.location.href = "../index.php?pesan=belum_login"; // Arahkan ke halaman login
        }, 3000); // Tunggu selama 3 detik sebelum redirect
    </script>';

    exit();
}

if (!isset($_GET['pesan']) && !isset($_SESSION['toast_displayed'])) {
    $_SESSION['toast_displayed'] = true;
    header("Location: index.php?pesan=login_berhasil");
    exit();
}

// Sertakan file toast notification
include('../notif.php');
?>

<div class="container">
    <h1 class="text-center">Welcome, Admin!</h1>
    <div class="row p-2">
        <div class="col-md-6">
            <div class="card bg-success text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Data Stok</h5>
                    <p class="card-text">Tambahkan dan lihat daftar stok.</p>
                    <a href="tambah.php" class="btn btn-primary">Kelola Bahan Baku</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Manajemen Stok</h5>
                    <p class="card-text">Kelola stok masuk, keluar, dan stok akhir.</p>
                    <a href="manajemen.php" class="btn btn-success">Kelola Stok</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Manajemen User</h5>
                    <p class="card-text">Kelola user, tambah dan hapus user.</p>
                    <a href="manajemen_user.php" class="btn btn-warning">Kelola User</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Laporan Mutasi</h5>
                    <p class="card-text">Ekspor data stok untuk laporan mutasi.</p>
                    <a href="laporan.php" class="btn btn-dark">Ekspor Laporan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include('footer.php'); ?>
