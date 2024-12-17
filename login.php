<?php
include 'config.php';
session_start();

$timeout_duration = 900;

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

echo "Email yang dimasukkan: $email<br>";
echo "Password yang dimasukkan: $password<br>";

$query = "SELECT * FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    echo "Hash password yang disimpan di DB: " . $row['password'] . "<br>";

    if (password_verify($password, $row['password'])) {
        echo "Password cocok!<br>";

        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];

        $_SESSION['last_activity'] = time();

        if ($row['role'] == "Admin") {
            header("Location: ./admin/index.php?pesan=login_berhasil&nama=" . urlencode($row['nama']));
        } elseif ($row['role'] == "StaffGudang") {
            header("Location: ./staff/index.php?pesan=login_berhasil&nama=" . urlencode($row['nama']));
        }
    } else {
        echo "Password tidak cocok!<br>";
        header("Location: index.php?pesan=gagal");
        exit();
    }
} else {
    echo "Email tidak ditemukan!<br>";
    header("Location: index.php?pesan=gagal");
    exit();
}
?>
