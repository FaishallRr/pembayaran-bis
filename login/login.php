<?php
session_start(); // Mulai session

// Koneksi ke database
$host = 'localhost';
$dbname = 'pembayaranbis';
$username = 'root';
$password = 'password';
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Jika metode yang digunakan adalah POST dan email ada di request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
  $email = $conn->real_escape_string(trim($_POST['email']));
  $password = $conn->real_escape_string(trim($_POST['password']));

  // Validasi input
  if (empty($email) || empty($password)) {
    // Kirimkan respons error ke frontend untuk ditampilkan dengan notifikasi
    echo json_encode(['status' => 'error', 'message' => 'Email dan Password harus diisi!']);
    exit();
  }

  // Cek apakah email terdaftar
  $email_check = $conn->query("SELECT * FROM users WHERE email = '$email'");

  if ($email_check->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Akun belum terdaftar. Silakan daftar terlebih dahulu.']);
    exit();
  }

  // Ambil data pengguna
  $user = $email_check->fetch_assoc();

  // Verifikasi password
  if (!password_verify($password, $user['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Password salah.']);
    exit();
  }

  // Set session login (opsional, jika diperlukan untuk pengelolaan session)
  $_SESSION['user_email'] = $user['email'];

  // Kirim respons sukses ke frontend untuk ditampilkan dengan notifikasi
  echo json_encode(['status' => 'success', 'message' => 'Login berhasil!', 'email' => $user['email']]);
  exit();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - AngkutIn</title>
  <link rel="website icon" type="png" href="../img/logoAngkutan.png" />
  <link rel="stylesheet" href="../global.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="flex items-center justify-center min-h-screen">
    <div
      class="bg-white border-4 border-[#E3E3E3FF] rounded-3xl px-6 py-3 flex w-[600px] h-[600px] flex-col justify-center items-center">
      <div class="w-full flex flex-col justify-start mt-0">
        <div class="flex flex-col items-center w-full">
          <img src="../img/logoAngkutan.png" alt="logo" class="w-[120px] mt-[-40px]" />
        </div>
        <p class="mb-4 text-2xl font-bold text-gray-700 text-center mt-[20px]">Log in</p>

        <form id="loginForm" onsubmit="event.preventDefault(); login();" class="w-full flex flex-col items-center"
          method="POST" action="login.php">
          <div class="w-full flex justify-center mt-4 relative">
            <input id="email" name="email" type="email" placeholder="Emailkamu@gmail.com"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition" />
          </div>
          <div class="w-full flex justify-center mt-4 relative">
            <input type="password" placeholder="Password"
              class="w-[430px] px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-bold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition"
              style="height: auto" id="password" name="password" />
            <span class="absolute right-6 top-1/2 -translate-y-1/2 cursor-pointer" id="togglePassword">
              <i class="far fa-eye text-gray-400"></i>
            </span>
          </div>
          <div class="w-full flex justify-center mt-[20px] relative">
            <button type="submit"
              class="text-white w-[430px] px-12 py-3 rounded-2xl bg-[#009cf7] text-gray-500 font-bold focus:outline-none hover:bg-[#007acc] hover:border-[#007acc] hover:shadow-lg focus:border-[#007acc] focus:shadow-lg transition">Log
              In</button>
          </div>
        </form>
      </div>
      <div class="w-full flex justify-center mt-5">
        <p class="text-gray-600 text-sm">Belum punya akun? <a href="../register/register.php"
            class="text-blue-600 hover:underline"><b>Daftar, yuk!</b></a></p>
      </div>
    </div>
  </div>
  <script src="../login/script.js"></script> <!-- File JS untuk notifikasi -->
</body>

</html>