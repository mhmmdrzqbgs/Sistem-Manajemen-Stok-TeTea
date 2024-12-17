<?php
include("../config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data stok untuk menghitung perubahan jumlah barang
    $result = mysqli_query($conn, "SELECT * FROM stok WHERE id_stok = $id");
    $data = mysqli_fetch_assoc($result);
    $nama_barang = $data['nama_barang'];
    $stok_masuk = $data['stok_masuk'];
    $stok_keluar = $data['stok_keluar'];

    // Update jumlah barang di tabel barang (kurangi stok sesuai transaksi)
    if ($stok_masuk > 0) {
        mysqli_query($conn, "UPDATE barang SET jumlah = jumlah - $stok_masuk WHERE nama_barang = '$nama_barang'");
    }

    if ($stok_keluar > 0) {
        mysqli_query($conn, "UPDATE barang SET jumlah = jumlah + $stok_keluar WHERE nama_barang = '$nama_barang'");
    }

    // Hapus data dari tabel stok
    $delete_query = "DELETE FROM stok WHERE id_stok = $id";
    $hasil = mysqli_query($conn, $delete_query);

    if ($hasil) {
        echo "<script>alert('Data berhasil dihapus!'); document.location='manajemen.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}
?>
