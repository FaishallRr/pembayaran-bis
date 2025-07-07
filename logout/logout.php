<?php
session_start();  // Memulai session
session_unset(); // Menghapus session yang ada
session_destroy(); // Menghancurkan session
header("Location: /login/login.php"); // Mengarahkan ke halaman login
exit();
?>