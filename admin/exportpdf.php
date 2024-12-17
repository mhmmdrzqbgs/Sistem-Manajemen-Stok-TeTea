<?php
// Include library TCPDF
require_once('../libs/tcpdf/tcpdf.php');

// Koneksi ke database
include('../config.php');

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : null;
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : null;

// Jika bulan dan tahun tidak dipilih, tampilkan pesan error
if (!$bulan || !$tahun) {
    die("Bulan dan tahun harus dipilih.");
}

// Nama bulan dalam bahasa Indonesia
$bulan_indonesia = [
    1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

// Ambil data stok dari database berdasarkan bulan dan tahun, dengan pengelompokan
$query = "
    SELECT nama_barang, 
        SUM(stok_masuk) AS total_masuk, 
        SUM(stok_keluar) AS total_keluar, 
        SUM(stok_akhir) AS total_akhir 
    FROM stok 
    WHERE MONTH(tgl) = '$bulan' AND YEAR(tgl) = '$tahun' 
    GROUP BY nama_barang
";
$result = mysqli_query($conn, $query);

// Cek apakah ada data
if (!$result || mysqli_num_rows($result) == 0) {
    die("Tidak ada data stok untuk bulan $bulan dan tahun $tahun.");
}

$total_masuk = 0;
$total_keluar = 0;
$total_akhir = 0;

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Manajemen Stok');
$pdf->SetTitle('Laporan Stok');
$pdf->SetSubject('Laporan Mutasi Stok');
$pdf->SetKeywords('TCPDF, PDF, laporan, stok');

$pdf->SetMargins(10, 10, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 10);

$pdf->AddPage();

// Header tabel
$html = '<h3 style="text-align:center;">Laporan Stok Bulan ' . $bulan_indonesia[(int)$bulan] . ' Tahun ' . $tahun . '</h3>
        <table border="1" cellspacing="0" cellpadding="6" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background-color:#f2f2f2; text-align:center;">
                <th style="width:8%; font-weight:bold;">No</th>
                <th style="width:42%; font-weight:bold;">Nama Barang</th>
                <th style="width:15%; font-weight:bold;">Stok Masuk</th>
                <th style="width:15%; font-weight:bold;">Stok Keluar</th>
                <th style="width:20%; font-weight:bold;">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>';

// Isi tabel
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr style="text-align:center;">
                <td style="width:8%;">' . $no++ . '</td>
                <td style="width:42%; text-align:left; padding-left:4px;">' . htmlspecialchars($row['nama_barang']) . '</td>
                <td style="width:15%;">' . intval($row['total_masuk']) . '</td>
                <td style="width:15%;">' . intval($row['total_keluar']) . '</td>
                <td style="width:20%;">' . intval($row['total_akhir']) . '</td>
            </tr>';

    // Tambahkan ke total keseluruhan
    $total_masuk += intval($row['total_masuk']);
    $total_keluar += intval($row['total_keluar']);
    $total_akhir += intval($row['total_akhir']);
}

$html .= '<tr style="background-color:#e6e6e6; text-align:center; font-weight:bold;">
            <td colspan="2" style="text-align:right; padding-right:4px;">Total Keseluruhan</td>
            <td>' . $total_masuk . '</td>
            <td>' . $total_keluar . '</td>
            <td>' . $total_akhir . '</td>
        </tr>';

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');

$nama_file = 'Laporan_Stok_' . $bulan_indonesia[(int)$bulan] . '_' . $tahun . '.pdf';

$pdf->Output($nama_file, 'I'); // 'I' untuk membuka di browser

?>
