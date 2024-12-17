<?php
// admin.php
include_once('../config.php');
include('header.php');
include('../auth.php'); // Cek login
?>

<div class="container mt-5">
        <h1 class="text-center">Cetak Laporan Bulanan</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Pilih Bulan dan Tahun</div>
                    <div class="card-body">
                        <form method="GET" action="exportpdf.php">
                            <div class="form-group mb-3">
                                <label for="bulan">Pilih Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php
                                    $bulan_indonesia = [
                                        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                                    ];
                                    
                                    foreach ($bulan_indonesia as $key => $nama_bulan) {
                                        echo '<option value="' . $key . '">' . $nama_bulan . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tahun">Pilih Tahun:</label>
                                <select name="tahun" id="tahun" class="form-control" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php
                                    $tahun_sekarang = date('Y');
                                    for ($i = $tahun_sekarang - 5; $i <= $tahun_sekarang; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Cetak Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sertakan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php include('footer.php'); ?>
