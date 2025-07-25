<?php
session_start(); // Memulai session

// Cek apakah email ada di session
if (isset($_SESSION['user_email'])) {
  $user_email = $_SESSION['user_email']; // Mengambil email dari session
} else {
  $user_email = 'Login'; // Jika belum login, tampilkan 'Login'
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran - AngkutIn</title>

  <!-- logo browser -->
  <link rel="website icon" type="png" href="../img/logoAngkutan.png" />

  <link rel="stylesheet" href="global.css" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="w-full mt-[10px] mb-[]">
    <header
      class="flex items-center justify-between w-full max-w-[1440px] px-4 py-2 absolute top-0 left-1/2 -translate-x-1/2 ml-[-50px]">
      <div class="flex items-center">
        <a href="/index.html">
          <img src="../../img/logoAngkutan.png" alt="logo" class="w-[120px] ml-[60px]" />
        </a>
      </div>
      <div class="flex items-center space-x-6 mr-[-30px]">
        <div class="flex items-center space-x-2">
          <!-- Flag & Language Toggle -->
          <img id="lang-flag" src="https://flagcdn.com/id.svg" alt="ID" class="w-6 h-4 rounded-sm border" />
          <span id="lang-text" class="text-sm font-medium cursor-pointer" onclick="toggleLanguage()">ID | IDR</span>
        </div>
        <a href="#" class="flex items-center space-x-2 text-sm font-medium hover:text-[var(--bg-primary)]">
          <!-- Ikon SVG Promo -->
          <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="10" fill="#E6F7FF" />
            <text x="12" y="16" text-anchor="middle" font-size="14" fill="#4CAF50" font-family="Arial, sans-serif"
              font-weight="bold">
              %
            </text>
          </svg>
          <span>Promo</span>
        </a>
        <a href="/caraPesan/index.php" class="text-sm font-medium hover:text-[var(--bg-primary)]"
          data-lang="carapesan">Cara Pesan Tiket</a>
        <a href="../pesanan/pesanan.php" class="text-sm font-medium hover:text-[var(--bg-primary)]"
          data-lang="pesanan">Pesanan</a>
        <!-- Dropdown User/Login/Register/Logout -->
        <div class="relative" id="user-dropdown-container">
          <button id="user-dropdown-btn"
            class="flex items-center px-3.5 py-2 border border-[#009CF7] rounded-xl text-sm text-black font-medium hover:bg-[var(--bg-tertiary)] transition focus:outline-none"
            type="button">
            <i class="fa-solid fa-user mr-3" style="color: #009cf7"></i>
            <span id="user-dropdown-text"><?php echo $_SESSION['user_email'] ?? 'Log In'; ?></span>
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown menu -->
          <div id="user-dropdown-menu"
            class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg z-50 py-2 border border-gray-100">
            <!-- Jika pengguna belum login, tampilkan Login dan Daftar -->
            <button id="dropdown-login-btn"
              class="w-full text-left px-4 py-2 text-sm hover:bg-[var(--bg-quaternary)] transition flex items-center"
              onclick="window.location.href='/login/login.php'" type="button">
              <i class="fa-solid fa-right-to-bracket mr-2"></i> Log In
            </button>
            <button id="dropdown-register-btn"
              class="w-full text-left px-4 py-2 text-sm hover:bg-[var(--bg-quaternary)] transition flex items-center"
              onclick="window.location.href='./register/register.php'" type="button">
              <i class="fa-solid fa-user-plus mr-2"></i> Daftar
            </button>
            <!-- Jika sudah login, hanya tampilkan tombol Logout -->
            <button id="dropdown-logout-btn"
              class="w-full text-left px-4 py-2 text-sm hover:bg-red-100 text-red-600 transition flex items-center hidden"
              type="button" onclick="logout()">
              <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </button>
          </div>
        </div>
      </div>
    </header>
  </div>

  <div
    class="flex flex-col items-center justify-center text-center p-6 mt-[200px] mb-6 rounded-xl border-2 border-dashed border-[#fbbf24] bg-[#fffbea] mt-[300px] shadow-lg max-w-md mx-auto transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105">
    <!-- Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#f59e0b] mb-4 animate-bounce" fill="none"
      viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 13h6m-3-3v6m8 4H5a2 2 0 01-2-2V5a2 2 0 012-2h9l5 5v13a2 2 0 01-2 2z" />
    </svg>

    <!-- Text -->
    <h2 class="text-lg font-bold text-[#92400e] mb-1" data-lang="belumAdaKodePromo">
      Belum ada Kode Promo
    </h2>
    <p class="text-sm text-[#92400e]" data-lang="belumAdaKodePromoBerikut">
      Silakan kembali lagi nanti untuk penawaran menarik!
    </p>
  </div>

  <script>
    const languageData = {
      en: {
        carapesan: "How to Order Tickets",
        belumAdaKodePromo: "There is no Promo Code yet.",
        belumAdaKodePromoBerikut: "Please come back later to get a discount!",
        pesanan: "Orders",
        pencarianTiket: "Search Tickets",
        rincianTiket: "Ticket Details",
        rincianTiketBerikut:
          "Here are the details of the ticket you have selected:",
        rincianTransaksi: "Transaction Details",
        pembayaranViaBank: "Payment via BANK BCA",
        instruksiPembayaran1: "1. Open the BANK BCA app on your smartphone.",
        instruksiPembayaran2: "2. Select the 'Transfer' menu.",
        instruksiPembayaran3: "3. Enter the recipient's bank account number:",
        instruksiPembayaran4: "4. Enter the amount to be paid.",
        instruksiPembayaran5:
          "5. Follow the instructions until the transaction is successful.",
        nomerRekening: "12121221313154324524",
      },
      id: {
        carapesan: "Cara Pesan Tiket",
        belumAdaKodePromo: "Belum ada Kode Promo.",
        belumAdaKodePromoBerikut:
          "Silakan kembali lagi nanti untuk penawaran menarik!",
        pesanan: "Pesanan",
        pencarianTiket: "Cari Tiket",
        rincianTiket: "Rincian Tiket",
        rincianTiketBerikut:
          "Berikut adalah rincian tiket yang telah Anda pilih:",
        rincianTransaksi: "Rincian Transaksi",
        pembayaranViaBank: "Pembayaran via BANK BCA",
        instruksiPembayaran1: "1. Buka aplikasi BANK BCA di smartphone Anda.",
        instruksiPembayaran2: "2. Pilih menu 'Transfer'.",
        instruksiPembayaran3: "3. Masukkan nomor rekening BANK BCA tujuan:",
        instruksiPembayaran4:
          "4. Masukkan jumlah sesuai dengan total pembayaran.",
        instruksiPembayaran5: "5. Ikuti petunjuk hingga transaksi berhasil.",
        nomerRekening: "12121221313154324524",
      },
    };

    // Fungsi untuk mengubah bahasa
    function changeLanguage(language) {
      const elements = document.querySelectorAll("[data-lang]");

      elements.forEach((element) => {
        const key = element.getAttribute("data-lang");

        // Menentukan variabel 'text' berdasarkan bahasa yang dipilih
        let text = languageData[language][key] || key;

        // Cek jika key adalah 'articleText', tambahkan <b> untuk "TEMPO.CO, Jakarta"
        if (key === "articleText") {
          text = text.replace(
            "Jakarta, IDN Times",
            "<b>Jakarta, IDN Times</b>"
          ); // Membuat "TEMPO.CO, Jakarta" tebal
          element.innerHTML = text; // Gunakan innerHTML untuk merender tag <b>
        }
        // Cek jika key adalah 'by', tambahkan <b> untuk "Sulistyawan"
        else if (key === "by") {
          text = text.replace("Khusniani", "<b>Khusniani</b>"); // Membuat "Sulistyawan" tebal
          element.innerHTML = text; // Gunakan innerHTML untuk merender tag <b>
        } else {
          element.innerText = text; // Untuk selain key yang disebutkan, gunakan innerText
        }
      });

      // Mengubah flag dan teks bahasa di header
      const flag =
        language === "id"
          ? "https://flagcdn.com/id.svg"
          : "https://flagcdn.com/gb.svg"; // Mengubah bendera sesuai dengan bahasa yang dipilih

      const langText = language === "id" ? "ID | IDR" : "EN | IDR"; // Menggunakan "IDR" untuk kedua bahasa
      document.getElementById("lang-flag").src = flag;
      document.getElementById("lang-text").innerText = langText; // Mengubah teks bahasa di header
    }

    // Fungsi untuk toggle bahasa antara ID dan EN
    function toggleLanguage() {
      const currentLangText = document.getElementById("lang-text").innerText; // Mendapatkan teks saat ini
      let newLang;

      // Cek teks saat ini, apakah "ID | IDR" atau "EN | IDR"
      if (currentLangText === "ID | IDR") {
        newLang = "en"; // Jika "ID | IDR", ganti ke bahasa Inggris (EN)
      } else {
        newLang = "id"; // Jika "EN | IDR", ganti ke bahasa Indonesia (ID)
      }

      // Panggil fungsi untuk mengubah bahasa
      changeLanguage(newLang);
    }

    // Set default language (misalnya Bahasa Indonesia)
    changeLanguage("id");
  </script>

  <script>
    // Dropdown User/Login/Register/Logout
    const dropdownBtn = document.getElementById("user-dropdown-btn");
    const dropdownMenu = document.getElementById("user-dropdown-menu");

    // Menampilkan atau menyembunyikan dropdown
    dropdownBtn.addEventListener("click", function (e) {
      e.stopPropagation(); // Menghentikan event bubbling agar dropdown tidak menutup saat tombol dropdown diklik
      dropdownMenu.classList.toggle("hidden");
    });

    // Menyembunyikan dropdown saat klik di luar
    document.addEventListener("click", function () {
      dropdownMenu.classList.add("hidden");
    });


    document.addEventListener("DOMContentLoaded", function () {
      const email = localStorage.getItem("user_email"); // Cek apakah ada email di localStorage
      const dropdownText = document.getElementById("user-dropdown-text");
      const dropdownMenu = document.getElementById("user-dropdown-menu");
      const dropdownLoginBtn = document.getElementById("dropdown-login-btn");
      const dropdownRegisterBtn = document.getElementById("dropdown-register-btn");
      const dropdownLogoutBtn = document.getElementById("dropdown-logout-btn");

      if (email) {
        // Jika email ada di localStorage, berarti pengguna sudah login
        dropdownText.textContent = email; // Ganti teks dengan email pengguna

        // Sembunyikan tombol Login dan Daftar, tampilkan tombol Logout
        dropdownLoginBtn.classList.add("hidden");
        dropdownRegisterBtn.classList.add("hidden");
        dropdownLogoutBtn.classList.remove("hidden");
      } else {
        // Jika email tidak ada, berarti pengguna belum login
        dropdownText.textContent = "Log In"; // Tampilkan "Log In"

        // Sembunyikan tombol Logout, tampilkan tombol Login dan Daftar
        dropdownLoginBtn.classList.remove("hidden");
        dropdownRegisterBtn.classList.remove("hidden");
        dropdownLogoutBtn.classList.add("hidden");
      }
    });

    // Fungsi logout
    function logout() {
      // Hapus email pengguna dari localStorage
      localStorage.removeItem("user_email");
      localStorage.removeItem("pencarianTiket");
      localStorage.removeItem("selectedBus");
      localStorage.removeItem("selectedSeat");

      // Redirect ke halaman login setelah logout
      window.location.href = "/index.php"; // Ganti dengan URL halaman login Anda
    }
  </script>
</body>

</html>