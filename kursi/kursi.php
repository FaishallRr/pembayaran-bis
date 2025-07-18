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
  <title>Kursi - AngkutIn</title>

  <!-- logo browser -->
  <link rel="website icon" type="png" href="../img/logoAngkutan.png" />

  <link rel="stylesheet" href="global.css" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body class="bg-gray-50">
  <div class="w-full mt-[10px] mb-[]">
    <header
      class="flex items-center justify-between w-full max-w-[1440px] px-4 py-2 absolute top-0 left-1/2 -translate-x-1/2 ml-[-50px]">
      <div class="flex items-center">
        <a href="/index.html">
          <img src="../img/logoAngkutan.png" alt="logo" class="w-[120px] ml-[60px]" />
        </a>
      </div>
      <div class="flex items-center space-x-6 mr-[-30px]">
        <div class="flex items-center space-x-2">
          <!-- Flag & Language Toggle -->
          <img id="lang-flag" src="https://flagcdn.com/id.svg" alt="ID" class="w-6 h-4 rounded-sm border" />
          <span id="lang-text" class="text-sm font-medium cursor-pointer" onclick="toggleLanguage()">ID | IDR</span>
        </div>
        <a href="../promo/promo.php"
          class="flex items-center space-x-1 text-sm font-medium hover:text-[var(--bg-primary)]">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" fill="#E6F7FF" />
            <text x="12" y="16" text-anchor="middle" font-size="14" fill="#4CAF50" font-family="Arial"
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
            <span id="user-dropdown-text">Log In</span> <!-- Teks ini akan diganti dengan email setelah login -->
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

  <!-- Daftar Bus -->
  <div class="max-w-2xl mx-auto mt-[160px] mb-[100px]">
    <!-- Informasi Pencarian Tiket -->
    <div id="info-pencarian"
      class="text-center text-xl font-semibold text-[#2563eb] mb-6 p-6 bg-gradient-to-r from-[#E6F7FF] to-[#A0C4FF] rounded-lg shadow-xl border-2 border-[#2563eb]">
      <!-- Informasi pencarian tiket akan ditampilkan di sini -->
    </div>

    <h2 class="text-3xl font-bold mb-8 text-[#2563eb] text-center tracking-wide drop-shadow-lg mt-[100px]"
      data-lang="pilihBusTersedia">
      Pilih Bus Tersedia
    </h2>
    <div id="bus-list" class="space-y-6">
      <!-- Bus akan di-generate oleh JS -->
    </div>
  </div>

  <!-- Pilih Kursi -->
  <div id="seat-section" class="max-w-3xl mx-auto mt-14 hidden mb-[100px]">
    <h2 class="text-2xl font-semibold mb-6 text-[#2563eb] text-center tracking-wide" data-lang="pilihKursi">
      Pilih Kursi
    </h2>
    <div class="bg-gradient-to-br from-[#f0f6ff] to-[#e0e7ef] rounded-2xl shadow-xl p-10 border border-[#e0e7ef]">
      <div class="flex flex-col items-center">
        <div class="mb-6 text-gray-700 text-base font-medium" id="bus-info"></div>
        <!-- Layout kursi -->
        <div class="relative w-full flex flex-col items-center">
          <div class="absolute -top-7 left-1/2 -translate-x-1/2 flex items-center gap-2">
            <span class="w-8 h-2 bg-gray-200 rounded-t-full"></span>
            <span class="w-8 h-2 bg-gray-200 rounded-t-full"></span>
          </div>
          <div id="seat-map" class="grid grid-cols-5 gap-6 mb-8 mt-6">
            <!-- Kursi akan di-generate oleh JS -->
          </div>
          <div class="flex gap-6 mt-2 text-sm">
            <div class="flex items-center gap-2">
              <span class="inline-block w-5 h-5 rounded bg-[#2563eb] border-2 border-[#2563eb] shadow-md"></span>
              <span class="text-gray-700" data-lang="dipilih">Dipilih</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="inline-block w-5 h-5 rounded bg-white border-2 border-[#2563eb] shadow-md"></span>
              <span class="text-gray-700" data-lang="tersedia">Tersedia</span>
            </div>
          </div>
        </div>
        <button id="lanjut-btn"
          class="mt-8 px-8 py-2.5 rounded-xl bg-[#2563eb] text-white font-semibold text-lg shadow hover:bg-[#1d4ed8] transition disabled:opacity-50"
          disabled data-lang="lanjut">
          Lanjutkan
        </button>
      </div>
    </div>
  </div>

  <script>
    const languageData = {
      en: {
        carapesan: "How to Order Tickets",
        pencarianTiket: "Search Tickets",
        pilihKursi: "Select Seat",
        pesanan: "Orders",
        pilihBusTersedia: "Select Bus",
        dipilih: "Selected",
        tersedia: "Available",
        lanjut: "Continue",
      },
      id: {
        carapesan: "Cara Pesan Tiket",
        pencarianTiket: "Cari Tiket",
        pilihKursi: "Pilih Kursi",
        pesanan: "Pesanan",
        pilihBusTersedia: "Pilih Bus Tersedia",
        dipilih: "Dipilih",
        tersedia: "Tersedia",
        lanjut: "Lanjutkan",
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

  <script src="../kursi/script.js"></script>
</body>

</html>