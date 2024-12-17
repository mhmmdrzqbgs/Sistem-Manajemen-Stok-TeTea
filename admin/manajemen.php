<?php
session_start();
include('../config.php');
include('header.php');
?>

<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h2>Manajemen Keluar Masuk Stok</h2>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <form action="manajemen.php" method="post" name="Submit" class="w-100">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="id_barang">Nama Barang</label>
                            <select class="form-control" name="id_barang" id="id_barang" required>
                                <option value="">Pilih Barang</option>
                                <?php
                                $result = mysqli_query($conn, "SELECT id_barang, nama_barang FROM barang");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='".$row['id_barang']."'>".$row['nama_barang']."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="tgl">Tanggal</label>
                            <input type="datetime-local" class="form-control" name="tgl" id="tgl" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="stok_masuk">Stok Masuk</label>
                            <input type="number" min="0" class="form-control" id="stok_masuk" name="stok_masuk" placeholder="Stok Masuk" onkeyup="myFunc()" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="stok_keluar">Stok Keluar</label>
                            <input type="number" min="0" class="form-control" id="stok_keluar" name="stok_keluar" placeholder="Stok Keluar" onkeyup="myFunc()" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="jenis_transaksi">Jenis Transaksi</label>
                            <select class="form-control" name="jenis_transaksi" id="jenis_transaksi" required>
                                <option value="Masuk">Masuk</option>
                                <option value="Keluar">Keluar</option>
                                <option value="Opname">Opname</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan Transaksi" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="stok_akhir">Stok Akhir</label>
                            <input type="text" class="form-control" id="stok_akhir" name="stok_akhir" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3" name="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div><br>

    <?php
    if (isset($_POST['Submit'])) {
        $id_barang = $_POST['id_barang'];
        $tgl = $_POST['tgl'];
        $stok_masuk = $_POST['stok_masuk'];
        $stok_keluar = $_POST['stok_keluar'];
        $jenis_transaksi = $_POST['jenis_transaksi'];
        $keterangan = $_POST['keterangan'];

        // Pastikan koneksi berhasil
        if ($conn) {
            // Ambil nama_barang dan jumlah dari tabel barang berdasarkan id_barang
            $result = mysqli_query($conn, "SELECT nama_barang, jumlah FROM barang WHERE id_barang = '$id_barang'");
            $data_barang = mysqli_fetch_assoc($result);
            $nama_barang = $data_barang['nama_barang'];
            $jumlah_barang = $data_barang['jumlah'];

            // Hitung stok_akhir berdasarkan transaksi
            $stok_akhir = $jumlah_barang + $stok_masuk - $stok_keluar;

            // Query untuk memasukkan data ke tabel stok
            $insert_query = "INSERT INTO stok (id_barang, nama_barang, tgl, stok_masuk, stok_keluar, jenis_transaksi, keterangan, stok_akhir) 
                            VALUES ('$id_barang', '$nama_barang', '$tgl', '$stok_masuk', '$stok_keluar', '$jenis_transaksi', '$keterangan', '$stok_akhir')";

            $hasil = mysqli_query($conn, $insert_query);

            if ($hasil) {
                // Jika transaksi Masuk, update jumlah barang
                if ($stok_masuk > 0) {
                    mysqli_query($conn, "UPDATE barang SET jumlah = jumlah + $stok_masuk WHERE id_barang = '$id_barang'");
                }

                // Jika transaksi Keluar, update jumlah barang
                if ($stok_keluar > 0) {
                    mysqli_query($conn, "UPDATE barang SET jumlah = jumlah - $stok_keluar WHERE id_barang = '$id_barang'");
                }

                echo "<script>alert('Berhasil Menambahkan!'); document.location='manajemen.php';</script>";
            } else {
                echo "<script>alert('Gagal Menambahkan!');</script>";
            }
        } else {
            echo "<script>alert('Gagal Koneksi ke Database!');</script>";
        }
    }
    ?>


    <div class="card">
        <div class="card-header">
            <a href="exportpdf.php" class="btn btn-warning">Ekspor Tabel ke PDF</a>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <table class="table table-bordered">
                    <tr class="card-header bg-dark text-white">
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Stok Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Jenis Transaksi</th>
                        <th>Keterangan</th>
                        <th>Stok Akhir</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    // Urutkan berdasarkan tanggal dari yang terdahulu
                    $hasil = mysqli_query($conn, "SELECT * FROM stok ORDER BY tgl ASC");
                    while ($data = mysqli_fetch_array($hasil)) {
                        echo "<tr>
                            <td>".$no++."</td>
                            <td>".$data['nama_barang']."</td>
                            <td>".$data['tgl']."</td>
                            <td>".$data['stok_masuk']."</td>
                            <td>".$data['stok_keluar']."</td>
                            <td>".$data['jenis_transaksi']."</td>
                            <td>".$data['keterangan']."</td>
                            <td>".$data['stok_akhir']."</td>
                            <td>
                                <div class='d-flex flex-column'> 
                                    <a href='manajemen_hapus.php?id=$data[id_stok]' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                </div>
                            </td>
                        </tr>";
                    };
                    ?>
                </table>
            </form>
        </div>
    </div>
</div>

<!-- Script menampilkan & menambahkan input secara realtime -->
<script>
function myFunc() {
  var x = document.getElementById("stok_masuk").value;
  var y = document.getElementById("stok_keluar").value;
  document.getElementById("stok_akhir").value = parseInt(x) - parseInt(y);
}
</script>

<?php
include('footer.php');
?>
