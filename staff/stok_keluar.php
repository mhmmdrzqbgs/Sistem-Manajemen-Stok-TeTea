<?php
// stok_keluar.php
session_start();
include('../config.php');
include('header.php');
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    .content {
        flex: 1;
        margin-bottom: 50px;
    }

    footer {
        padding-top: 50px;
    }
</style>

<div class="container content">
    <h2 class="text-center">Stok Keluar Barang</h2>

    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="id_barang">Nama Barang</label>
                    <select name="id_barang" id="id_barang" class="form-control" required>
                        <option value="">-- Pilih Nama Barang --</option>
                        <?php
                        $query = "SELECT id_barang, nama_barang FROM barang";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id_barang'] . "'>" . $row['nama_barang'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stok_keluar">Stok Keluar</label>
                    <input type="number" name="stok_keluar" id="stok_keluar" class="form-control" required>
                </div>

                <input type="hidden" name="jenis_transaksi" value="Keluar">

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <button type="submit" name="submit" class="btn btn-danger mt-3">Tambah Stok Keluar</button>
            </form>
        </div>
    </div>

    <?php

if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $stok_keluar = $_POST['stok_keluar'];
    $jenis_transaksi = $_POST['jenis_transaksi'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    $query_barang = "SELECT nama_barang, stok_akhir FROM stok WHERE id_barang = '$id_barang' ORDER BY tgl DESC LIMIT 1";
    $result_barang = mysqli_query($conn, $query_barang);
    $data_barang = mysqli_fetch_assoc($result_barang);
    $stok_akhir = $data_barang ? $data_barang['stok_akhir'] : 0;
    $nama_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_barang FROM barang WHERE id_barang = '$id_barang'"))['nama_barang'];

    if ($stok_keluar > $stok_akhir) {
        echo '<div class="alert alert-danger mt-3">Stok yang keluar melebihi stok yang tersedia!</div>';
    } else {
        $stok_akhir -= $stok_keluar;

        $query = "INSERT INTO stok (id_barang, nama_barang, stok_masuk, stok_keluar, tgl, jenis_transaksi, keterangan, stok_akhir) 
                VALUES ('$id_barang', '$nama_barang', 0, '$stok_keluar', '$tanggal', '$jenis_transaksi', '$keterangan', '$stok_akhir')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $update_barang = "UPDATE barang SET jumlah = jumlah - $stok_keluar WHERE id_barang = '$id_barang'";
            mysqli_query($conn, $update_barang);

            echo '<div class="alert alert-success mt-3">Stok keluar berhasil ditambahkan!</div>';
        } else {
            echo '<div class="alert alert-danger mt-3">Gagal menambahkan stok keluar!</div>';
        }
    }
}
?>

</div>

<?php
include('footer.php');
?>
