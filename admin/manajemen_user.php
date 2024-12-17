<?php
session_start();
include('../config.php');
include('header.php');

if ($_SESSION['role'] !== 'Admin') {
    echo "<script>alert('Akses ditolak!'); document.location='admin.php';</script>";
    exit();
}

if (isset($_POST['add_user'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "INSERT INTO user (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil ditambahkan!'); document.location='manajemen_user.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pengguna: " . mysqli_error($conn) . "');</script>";
    }
}

if (isset($_POST['delete_user'])) {
    $id_user = intval($_POST['delete_user']);

    $check_user = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id_user");
    if (mysqli_num_rows($check_user) > 0) {
        if ($_SESSION['id_user'] == $id_user) {
            echo "<script>alert('Anda tidak dapat menghapus akun Anda sendiri!'); document.location='manajemen_user.php';</script>";
        } else {
            $query = "DELETE FROM user WHERE id_user = $id_user";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Pengguna berhasil dihapus!'); document.location='manajemen_user.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus pengguna: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Pengguna tidak ditemukan!'); document.location='manajemen_user.php';</script>";
    }
}
?>

<div class="container">
    <h1 class="text-center">Manajemen Pengguna</h1>

    <!-- Form Tambah Pengguna -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Pengguna</div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="Admin">Admin</option>
                        <option value="StaffGudang">Staff</option>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success mt-3">Tambah Pengguna</button>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna -->
    <div class="card">
        <div class="card-header bg-dark text-white">Daftar Pengguna</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM user");
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>";
                        if ($_SESSION['id_user'] != $row['id_user']) { // Mencegah admin menghapus dirinya sendiri
                            echo '<form method="post" style="display:inline-block;">
                                    <input type="hidden" name="delete_user" value="' . $row['id_user'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus pengguna ini?\')">Hapus</button>
                                </form>';
                        }
                        echo "</td>";
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
