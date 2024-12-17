<?php
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
    }

    .table {
        margin-bottom: 50px;
    }
</style>

<div class="container content">
    <h1 class="text-center">Data Stok Bahan Baku</h1>
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <table class="table table-bordered">
                    <thead class="card-header bg-dark text-white">
                        <tr>
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
                        $hasil = mysqli_query($conn, "SELECT * FROM barang");
                        while ($data = mysqli_fetch_array($hasil)) {
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
            </form>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
