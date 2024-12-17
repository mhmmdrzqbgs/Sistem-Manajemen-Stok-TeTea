<?php
session_start();
include "../config.php";
include('header.php');
include '../auth.php'; // Cek login

$timeout_duration = 900; // 15 menit

// sesi aktif
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: index.php?pesan=timeout");
    exit();
}

$_SESSION['last_activity'] = time();


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

include('../notif.php');
?>

<div class="container">
    <h1 class="text-center">Welcome, Staff!</h1>
    <div class="row mx-auto p-2">
        <div class="col-md-6">
            <div class="card bg-success text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Stok Masuk</h5>
                    <p class="card-text">Catat barang yang masuk ke gudang.</p>
                    <a href="stok_masuk.php" class="btn btn-primary">Catat Stok Masuk</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Stok Keluar</h5>
                    <p class="card-text">Catat barang yang keluar dari gudang.</p>
                    <a href="stok_keluar.php" class="btn btn-success">Catat Stok Keluar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Data Stok</h5>
                    <p class="card-text">Lihat daftar bahan baku yang tersedia.</p>
                    <a href="lihat_barang.php" class="btn btn-warning">Lihat Bahan Baku</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white m-2">
                <div class="card-body">
                    <h5 class="card-title">Stok Keluar Masuk</h5>
                    <p class="card-text">Lihat keluar masuk stok.</p>
                    <a href="lihat_stok.php" class="btn btn-dark">Lihat Stok</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include('footer.php'); ?>
