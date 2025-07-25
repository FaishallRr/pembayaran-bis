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
  <title>Pesanan - AngkutIn</title>

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
        <a href="#" class="text-sm font-medium hover:text-[var(--bg-primary)]" data-lang="pesanan">Pesanan</a>
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

    <div id="transaction-info" class="max-w-2xl mx-auto mt-[160px] mb-[100px]"></div>

    <script>
      // Ambil data pencarian tiket dan pesanan dari localStorage
      const pencarianTiketRaw = localStorage.getItem("pencarianTiket");
      const selectedBusRaw = localStorage.getItem("selectedBus");
      const selectedSeat = localStorage.getItem("selectedSeat");

      // Parsing data yang ada di localStorage
      const pencarianTiket = pencarianTiketRaw
        ? JSON.parse(pencarianTiketRaw)
        : null;
      const selectedBus = selectedBusRaw ? JSON.parse(selectedBusRaw) : null;

      // Validasi apakah data valid
      const isValid =
        pencarianTiket &&
        pencarianTiket.dari &&
        pencarianTiket.ke &&
        pencarianTiket.tanggal &&
        pencarianTiket.penumpang &&
        selectedBus &&
        selectedBus.nama &&
        selectedSeat;

      // Ambil elemen untuk menampilkan informasi
      const infoPencarianDiv = document.getElementById("info-pencarian");
      const transactionInfoDiv = document.getElementById("transaction-info");

      // Jika data tidak valid, tampilkan pesan "Belum ada pesanan"
      if (!isValid) {
        // Tampilkan pesan jika belum ada pesanan dan sembunyikan elemen lainnya
        infoPencarianDiv.innerHTML = `
    <div class="text-center text-lg font-semibold p-6 rounded-xl mt-[25px] mb-6" data-lang="belumAdaPesanan">
      Belum ada pesanan. Silakan pilih tiket terlebih dahulu.
    </div>
  `;
        transactionInfoDiv.innerHTML = ""; // Hapus informasi transaksi
      } else {
        // Menampilkan informasi pencarian tiket
        const div = document.createElement("div");
        div.className = "flex items-center justify-center";
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
        infoPencarianDiv.appendChild(div);

        // Menampilkan informasi transaksi
        const transactionDiv = document.createElement("div");
        transactionDiv.className =
          "flex items-center justify-center mt-[-130px]";
        transactionDiv.innerHTML = `
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
        transactionInfoDiv.appendChild(transactionDiv);
      }
    </script>
  </div>

  <div id="alertModal" class="hidden">
    <!-- Konten modal di sini -->
  </div>

  <script>
    const languageData = {
      en: {
        carapesan: "How to Order Tickets",
        belumAdaPesanan:
          "There are no orders yet. Please select a ticket first.",
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
        belumAdaPesanan:
          "Belum ada pesanan. Silakan pilih tiket terlebih dahulu.",
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