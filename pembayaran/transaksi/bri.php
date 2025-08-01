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
  <link rel="website icon" type="png" href="../../img/logoAngkutan.png" />

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

  <div class="max-w-2xl mx-auto mt-[160px] mb-[100px]">
    <!-- Informasi Pencarian Tiket -->
    <div id="info-pencarian"
      class="text-center text-xl font-semibold text-[#2563eb] mb-6 p-6 bg-gradient-to-r from-[#E6F7FF] to-[#A0C4FF] rounded-lg shadow-xl border-2 border-[#2563eb]">
      <!-- Informasi pencarian tiket akan ditampilkan di sini -->
    </div>
  </div>

  <div class="max-w-2xl mx-auto mt-[-50px] mb-16">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-semibold text-[#2563eb]" data-lang="rincianTiket">
        Rincian Tiket
      </h2>
      <p class="text-lg text-gray-600" data-lang="rincianTiketBerikut">
        Berikut adalah rincian tiket yang telah Anda pilih:
      </p>
    </div>

    <!-- Halaman Pembayaran -->
    <div id="transaction-info" class="max-w-2xl mx-auto mt-[160px] mb-[100px]"></div>

    <script>
      // Ambil data pencarian tiket dari localStorage
      const pencarianTiket = JSON.parse(
        localStorage.getItem("pencarianTiket")
      );

      if (pencarianTiket) {
        // Menampilkan informasi pencarian tiket dengan format yang lebih menarik dan dipusatkan
        const div = document.createElement("div");
        div.className = "flex items-center justify-center"; // Memastikan div ini terpusat di layar
        div.innerHTML = `
<div class="flex flex-col items-center justify-center bg-[#ffffff] rounded-xl shadow p-6 border border-[#e0e7ef] hover:scale-[1.02] hover:shadow-lg transition-all duration-200">
<div class="font-bold text-XL text-[#2563eb] mb-3 tracking-wide" data-lang="pencarianTiket">Pencarian Tiket</div>
<div class="text-gray-700 mb-2 flex items-center gap-2 text-sm mt-[10px]">
  <i class="fa-solid fa-location-arrow text-[#2563eb]"></i>
  <span>Dari: ${pencarianTiket.dari}</span>
  <span class="mx-2">|</span>
  <i class="fa-solid fa-location-dot text-[#2563eb]"></i>
  <span>Tujuan: ${pencarianTiket.ke}</span>
</div>
<div class="text-gray-700 mb-2 flex items-center gap-2 text-sm mt-[10px]">
  <i class="fa-solid fa-calendar-days text-[#2563eb]"></i>
  <span>${pencarianTiket.tanggal}</span>
</div>
<div class="text-gray-700 flex items-center gap-2 text-sm">
  <i class="fa-solid fa-users text-[#2563eb]"></i>
  <span>Jumlah Penumpang: ${pencarianTiket.penumpang}</span>
</div>
</div>
`;
        document.getElementById("info-pencarian").appendChild(div);
      } else {
        // Jika tidak ada data pencarian tiket, redirect kembali ke halaman utama
        window.location.href = "./index.html";
      }

      // Mengambil data bus dan kursi dari localStorage
      const selectedBus = JSON.parse(localStorage.getItem("selectedBus"));
      const selectedSeat = localStorage.getItem("selectedSeat");

      // Menampilkan informasi transaksi
      if (selectedBus && selectedSeat) {
        const div = document.createElement("div");
        div.className = "flex items-center justify-center mt-[-130px]";
        div.innerHTML = `
    <div class="flex flex-col items-center justify-center bg-[#ffffff] rounded-xl shadow p-6 border border-[#e0e7ef]">
      <div class="font-bold text-XL text-[#2563eb] mb-3 tracking-wide" data-lang="rincianTransaksi">Rincian Transaksi</div>
      <div class="text-gray-700 mb-2 flex items-center gap-2 text-sm mt-[20px]">
        <i class="fa-solid fa-bus text-[#2563eb]"></i>
        <b><span>PO Bus: ${selectedBus.nama}</span></b>
        <span class="mx-2">|</span>
        <b><span>No. Bus: ${selectedBus.nomerBus}</span></b>
      </div>
      <div class="text-gray-700 flex items-center gap-2 text-sm mt-0">
        <i class="fa fa-clock text-[#2563eb]"></i>
        <b><span>Berangkat: ${selectedBus.jam}</span></b>
      </div>
      <div class="text-gray-700 flex items-center gap-2 text-sm mt-2">
        <span>Tempat Duduk: ${selectedSeat}</span>
      </div>
      <div class="text-gray-700 text-sm mt-2">
        <span>Harga: </span>
        <span class="font-semibold text-[#2563eb]">Rp${parseInt(
          selectedBus.harga
        ).toLocaleString()}</span>
      </div>
    </div>
  `;
        document.getElementById("transaction-info").appendChild(div);
      } else {
        document.getElementById("transaction-info").innerHTML =
          "Data tidak ditemukan";
      }
    </script>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-180px]">
    <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-8">
      <div class="flex items-center justify-between mb-6">
        <img src="../../img/bri.png" alt="DANA Logo" class="w-20 h-15" />
        <h2 class="text-2xl font-bold text-[#2563eb]" data-lang="pembayaranViaBank">
          Pembayaran via BANK BRI
        </h2>
      </div>
      <!-- Countdown Timer -->
      <div id="countdown-timer" class="text-lg font-bold text-[#2563eb] mt-4 mb-4">
        Waktu: 05:00
      </div>
      <div>
        <!-- Display countdown timer -->
        <p id="countdown" class="text-lg text-[#2563eb] font-bold mb-2"></p>
      </div>
      <!-- Instruksi Pembayaran -->
      <div class="bg-[#f0f8ff] p-6 rounded-lg shadow-md mb-6">
        <div class="text-lg font-semibold text-[#2563eb] mb-4">
          Instruksi Pembayaran
        </div>
        <p class="text-gray-700 mb-2" data-lang="instruksiPembayaran1">
          1. Buka aplikasi BANK BRI di smartphone Anda.
        </p>
        <p class="text-gray-700 mb-2" data-lang="instruksiPembayaran2">
          2. Pilih menu "Transfer".
        </p>
        <p class="text-gray-700 mb-2" data-lang="instruksiPembayaran3">
          3. Masukkan nomor rekening BANK BRI tujuan:
        </p>
        <span id="textToCopy" class="font-semibold text-[#2563eb]" data-lang="nomerRekening">
          12121221313154324524
        </span>
        <!-- Tombol Salin -->
        <button class="copy-btn text-[#2563eb]" id="copyBtn" onclick="copyText()">
          <i class="fa-regular fa-copy"></i>
        </button>
        <p class="text-gray-700 mb-2" data-lang="instruksiPembayaran4">
          4. Masukkan jumlah sesuai dengan total pembayaran.
        </p>
        <p class="text-gray-700 mb-4" data-lang="instruksiPembayaran5">
          5. Ikuti petunjuk hingga transaksi berhasil.
        </p>
      </div>
    </div>
  </div>

  <div id="alertModal" class="hidden">
    <!-- Konten modal di sini -->
  </div>

  <script>
    const languageData = {
      en: {
        carapesan: "How to Order Tickets",
        pesanan: "Orders",
        pencarianTiket: "Search Tickets",
        rincianTiket: "Ticket Details",
        rincianTiketBerikut:
          "Here are the details of the ticket you have selected:",
        rincianTransaksi: "Transaction Details",
        pembayaranViaBank: "Payment via BANK BRI",
        instruksiPembayaran1: "1. Open the BANK BRI app on your smartphone.",
        instruksiPembayaran2: "2. Select the 'Transfer' menu.",
        instruksiPembayaran3: "3. Enter the recipient's bank account number:",
        instruksiPembayaran4: "4. Enter the amount to be paid.",
        instruksiPembayaran5:
          "5. Follow the instructions until the transaction is successful.",
        nomerRekening: "12121221313154324524",
      },
      id: {
        carapesan: "Cara Pesan Tiket",
        pesanan: "Pesanan",
        pencarianTiket: "Cari Tiket",
        rincianTiket: "Rincian Tiket",
        rincianTiketBerikut:
          "Berikut adalah rincian tiket yang telah Anda pilih:",
        rincianTransaksi: "Rincian Transaksi",
        pembayaranViaBank: "Pembayaran via BANK BRI",
        instruksiPembayaran1: "1. Buka aplikasi BANK BRI di smartphone Anda.",
        instruksiPembayaran2: "2. Pilih menu 'Transfer'.",
        instruksiPembayaran3: "3. Masukkan nomor rekening BANK BRI tujuan:",
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


  <script src="../transaksi/script.js"></script>
</body>

</html>