<?php
session_start();

session_unset();
session_destroy();

header("Location: index.php?pesan=logout_berhasil");
exit();
?>
