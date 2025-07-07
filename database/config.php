<?php
// Fungsi untuk memuat konfigurasi dari file .env
function loadEnv()
{
    $env = [];
    $file = '.env'; // Nama file .env

    if (file_exists($file)) {
        // Membaca file .env dan mengabaikan baris kosong atau komentar
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) {
                continue; // Skip baris komentar
            }

            // Memisahkan key dan value pada setiap baris
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value); // Menyimpan dalam array
        }
    }

    return $env;
}

// Menggunakan fungsi loadEnv untuk membaca konfigurasi dari file .env
$env = loadEnv();

// Mengambil konfigurasi database dari .env
$dbHost = $env['DB_HOST'] ?? 'localhost'; // Default ke 'localhost' jika tidak ditemukan
$dbName = $env['DB_NAME'] ?? 'pembayaranbis';
$dbUser = $env['DB_USER'] ?? 'root';
$dbPass = $env['DB_PASS'] ?? 'password';

// Menghubungkan ke database menggunakan PDO
try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8"; // DSN untuk koneksi MySQL
    $pdo = new PDO($dsn, $dbUser, $dbPass); // Membuat koneksi PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Menangani error
    // echo "Koneksi ke database berhasil!";  // Uncomment untuk memastikan koneksi berhasil
} catch (PDOException $e) {
    echo json_encode(['type' => 'error', 'title' => 'Koneksi Gagal', 'message' => $e->getMessage()]);
    exit();
}
?>