<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$dbname = 'pembayaranbis'; // Ganti dengan nama database kamu
$username = 'your_username'; // Ganti dengan username database kamu
$password = 'your_password'; // Ganti dengan password database kamu

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Cek jika form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama'])) {
  // Menangani input form
  $nama = $conn->real_escape_string(trim($_POST['nama']));
  $email = $conn->real_escape_string(trim($_POST['email']));
  $password = $conn->real_escape_string(trim($_POST['password']));
  $konfirmasi_password = $conn->real_escape_string(trim($_POST['konfirmasi_password']));

  // Validasi input
  if (empty($nama) || empty($email) || empty($password) || empty($konfirmasi_password)) {
    header("Location: register.php?status=error&message=Semua kolom harus diisi!&nama=$nama&email=$email");
    exit();
  }

  // Validasi email sudah terdaftar
  $email_check = $conn->query("SELECT * FROM users WHERE email = '$email'");

  if ($email_check->num_rows > 0) {
    header("Location: register.php?status=error&message=Email sudah digunakan!&nama=$nama&email=$email");
    exit();
  }

  // Validasi password
  if ($password !== $konfirmasi_password) {
    header("Location: register.php?status=error&message=Konfirmasi password tidak sama!&nama=$nama&email=$email");
    exit();
  }

  // Hash password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert data ke database
  $sql = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$hashed_password')";

  if ($conn->query($sql) === TRUE) {
    header("Location: register.php?status=success&message=Akun berhasil dibuat!");
    exit();
  } else {
    header("Location: register.php?status=error&message=Gagal mendaftar, coba lagi!&nama=$nama&email=$email");
    exit();
  }
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - AngkutIn</title>
  <link rel="website icon" type="png" href="./img/logoAngkutan.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="flex items-center justify-center min-h-screen">
    <div
      class="bg-white border-4 border-[#E3E3E3FF] rounded-3xl px-6 py-3 flex w-[600px] h-[600px] flex-col justify-center items-center">
      <div class="w-full flex flex-col justify-start mt-[20px]">
        <div class="flex flex-col items-center w-full">
          <img src="../img/logoAngkutan.png" alt="logo" class="w-[120px] mt-[-40px]" />
        </div>
        <p class="mb-4 text-2xl font-bold text-gray-700 text-center mt-[20px]">Register</p>
        <form id="registerForm" method="POST" action="register.php" novalidate>
          <div class="w-full flex justify-center mt-4 relative">
            <input type="text" placeholder="Nama Lengkap"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition"
              style="height: auto" id="nama" name="nama" required />
          </div>

          <div class="w-full flex justify-center mt-4 relative">
            <input type="email" placeholder="Email"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition"
              style="height: auto" id="email" name="email" required />
          </div>

          <div class="w-full flex justify-center mt-4 relative">
            <input type="password" placeholder="Password"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition"
              style="height: auto" id="password" name="password" required />
            <span class="absolute right-6 top-1/2 -translate-y-1/2 cursor-pointer" id="togglePassword">
              <i class="far fa-eye text-gray-400"></i>
            </span>
          </div>

          <div class="w-full flex justify-center mt-4 relative">
            <input type="password" placeholder="Konfirmasi Password"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition"
              style="height: auto" id="konfirmasi_password" name="konfirmasi_password" required />
            <span class="absolute right-6 top-1/2 -translate-y-1/2 cursor-pointer" id="toggleConfirmPassword">
              <i class="far fa-eye text-gray-400"></i>
            </span>
          </div>

          <div class="w-full flex justify-center mt-2">
            <span id="notif" class="text-red-500 font-bold text-sm hidden mb-[-20px]">Konfirmasi password tidak
              sama!</span>
          </div>

          <div class="w-full flex justify-center mt-[35px] relative">
            <button
              class="text-white w-[430px] px-12 py-3 rounded-2xl bg-[#009cf7] text-gray-500 font-bold focus:outline-none hover:bg-[#007acc] hover:border-[#007acc] hover:shadow-lg focus:border-[#007acc] focus:shadow-lg transition"
              type="submit">
              Buat Akun
            </button>
          </div>
        </form>
      </div>

      <div class="w-full flex justify-center mt-5">
        <p class="text-gray-600 text-sm">
          Sudah punya akun?
          <a href="../login/login.php" class="text-blue-600 hover:underline"><b>Login, yuk!</b></a>
        </p>
      </div>
    </div>
  </div>
  <script src="../register/script.js"></script>
</body>

</html>