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
        margin-bottom: 110px;
    }
</style>

<div class="container">
    <h2 class="text-center">Data Keluar Masuk Stok</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="card-header bg-dark text-white">
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Stok Akhir</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $hasil = mysqli_query($conn, "SELECT * FROM stok ORDER BY tgl ASC");
                while ($data = mysqli_fetch_array($hasil)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $data['nama_barang'] . "</td>";
                    echo "<td>" . $data['tgl'] . "</td>";
                    echo "<td>" . $data['stok_masuk'] . "</td>";
                    echo "<td>" . $data['stok_keluar'] . "</td>";
                    echo "<td>" . $data['stok_akhir'] . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
