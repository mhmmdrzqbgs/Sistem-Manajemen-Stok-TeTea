<?php
session_start();
include('../config.php');
include('header.php');
?>

<!-- Konten -->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Tambah Data Barang</h2>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <form action="tambah.php" method="post">
                    <div class="d-flex">
                        <div class="form-group p-1">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" required>
                        </div>
                        <div class="form-group p-1">
                            <label>Merek</label>
                            <input type="text" class="form-control" name="merek" placeholder="Merek" required>
                        </div>
                        <div class="form-group p-1">
                            <label>Kategori</label>
                            <input type="text" class="form-control" name="kategori" placeholder="Kategori" required>
                        </div>
                        <div class="form-group p-1">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" placeholder="Jumlah" required>
                        </div>
                        <div class="form-group p-1">
                            <label>Satuan</label>
                            <input type="text" class="form-control" name="satuan" placeholder="Satuan" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="Submit">Simpan</button>
                </form>
            </div>
        </div>
    </div><br>

    <?php
    if (isset($_POST['Submit'])) {
        $nama_barang = $_POST['nama_barang'];
        $merek = $_POST['merek'];
        $kategori = $_POST['kategori'];
        $jumlah = $_POST['jumlah'];
        $satuan = $_POST['satuan'];

        include("../config.php");
        $query = "INSERT INTO barang (nama_barang, merek, kategori, jumlah, satuan) 
                  VALUES ('$nama_barang', '$merek', '$kategori', '$jumlah', '$satuan')";
        $hasil = mysqli_query($conn, $query);

        if ($hasil) {
            echo "<script>alert('Data berhasil disimpan!');</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data!');</script>";
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h4>Daftar Barang</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Merek</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $result = mysqli_query($conn, "SELECT * FROM barang");
                    while ($data = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $data['nama_barang'] . "</td>";
                        echo "<td>" . $data['merek'] . "</td>";
                        echo "<td>" . $data['kategori'] . "</td>";
                        echo "<td>" . $data['jumlah'] . "</td>";
                        echo "<td>" . $data['satuan'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
