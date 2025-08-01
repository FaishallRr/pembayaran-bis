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
  <title>Cara Pemesanan - AngkutIn</title>
  <!-- logo browser -->
  <link rel="website icon" type="png" href="../img/logoAngkutan.png" />

  <link rel="stylesheet" href="/global.css" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="relative w-full mt-[50px]">
    <div class="relative">
      <img src="../img/busTravel.png" alt="busTravel" class="mt-[-50px] w-full object-cover" />
      <div class="absolute inset-0 bg-black opacity-10"></div>
    </div>

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
          <span data-lang="promo">Promo</span>
        </a>
        <a href="#" class="text-sm font-medium hover:text-[var(--bg-primary)]" data-lang="carapesan">Cara Pesan
          Tiket</a>
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

  <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-[1440px] px-4" style="top: 250px; z-index: 10">
    <p class="text-center text-2xl font-semibold text-white mt-[75px]" data-lang="title1">
      Cara Pesan Tiket Bus & Shuttle di AngkutIn
    </p>
    <p class="text-center text-lg font-semibold text-white mt-[10px]" data-lang="title2">
      Booking e-tiket Anda hanya dalam 5 menit
    </p>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-200px]">
    <div class="relative w-full max-w-[1440px] px-4 mx-auto">
      <!-- Konten Langkah yang terpusat di tengah -->
      <div class="relative z-10 w-full flex justify-center items-center">
        <div class="flex items-center justify-center space-x-8">
          <!-- Gambar Kiri -->
          <div class="flex-shrink-0">
            <img src="../img/pilihTerminal.png" alt="Gambar Berita" class="w-[500px] h-auto rounded-md" />
          </div>

          <!-- Garis Horizontal -->
          <div class="h-[2px] bg-gray-200 w-12 mx-4 rounded-lg"></div>

          <!-- Konten Langkah -->
          <div class="max-w-4xl w-[350px] mx-2 mt-8 p-6 bg-white rounded-xl shadow-md">
            <div class="flex items-start space-x-4">
              <!-- Step Number -->
              <div class="flex items-center justify-center w-[55px] h-8 bg-blue-200 text-blue-800 rounded-full">
                <span class="text-xl font-semibold mt-[-4px] ml-[-1px]">1</span>
              </div>

              <!-- Step Content -->
              <div>
                <h3 class="text-lg font-bold text-gray-800" data-lang="step1">
                  Pilih terminal
                </h3>
                <p class="text-gray-600 mt-[10px] font-semibold" data-lang="step1Content">
                  Mulai pencarian Anda dengan memasukkan detail terminal.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-400px]">
    <div class="relative w-full max-w-[1440px] px-4 mx-auto">
      <!-- Konten Langkah yang terpusat di tengah -->
      <div class="relative z-10 w-full flex justify-center items-center">
        <div class="flex items-center justify-center space-x-8">
          <!-- Gambar Kiri -->
          <div class="flex-shrink-0">
            <img src="../img/pilihBus.png" alt="Gambar Berita" class="w-[500px] h-auto rounded-md" />
          </div>

          <!-- Garis Horizontal -->
          <div class="h-[2px] bg-gray-200 w-12 mx-4 rounded-lg"></div>

          <!-- Konten Langkah -->
          <div class="max-w-4xl w-[350px] mx-2 mt-8 p-6 bg-white rounded-xl shadow-md">
            <div class="flex items-start space-x-4">
              <!-- Step Number -->
              <div class="flex items-center justify-center w-[65px] h-8 bg-blue-200 text-blue-800 rounded-full">
                <span class="text-xl font-semibold mt-[-4px] ml-[1px]">2</span>
              </div>

              <!-- Step Content -->
              <div>
                <h3 class="text-lg font-bold text-gray-800" data-lang="step2">
                  Pilih bus yang tersedia
                </h3>
                <p class="text-gray-600 mt-[10px] font-semibold" data-lang="step2Content">
                  Detail bus (jadwal, harga, dan informasi lainnya) akan
                  ditampilkan di sini.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-400px]">
    <div class="relative w-full max-w-[1440px] px-4 mx-auto">
      <!-- Konten Langkah yang terpusat di tengah -->
      <div class="relative z-10 w-full flex justify-center items-center">
        <div class="flex items-center justify-center space-x-8">
          <!-- Gambar Kiri -->
          <div class="flex-shrink-0">
            <img src="../img/pilihKursi.png" alt="Gambar Berita" class="w-[500px] h-auto rounded-md" />
          </div>

          <!-- Garis Horizontal -->
          <div class="h-[2px] bg-gray-200 w-12 mx-4 rounded-lg"></div>

          <!-- Konten Langkah -->
          <div class="max-w-4xl w-[350px] mx-2 mt-8 p-6 bg-white rounded-xl shadow-md">
            <div class="flex items-start space-x-4">
              <!-- Step Number -->
              <div class="flex items-center justify-center w-[65px] h-8 bg-blue-200 text-blue-800 rounded-full">
                <span class="text-xl font-semibold mt-[-4px] ml-[1px]">3</span>
              </div>

              <!-- Step Content -->
              <div>
                <h3 class="text-lg font-bold text-gray-800" data-lang="step3">
                  Pilih kursi yang tersedia
                </h3>
                <p class="text-gray-600 mt-[10px] font-semibold" data-lang="step3Content">
                  Detail kursi (jadwal, harga, dan informasi lainnya) akan
                  ditampilkan di sini.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-400px]">
    <div class="relative w-full max-w-[1440px] px-4 mx-auto">
      <!-- Konten Langkah yang terpusat di tengah -->
      <div class="relative z-10 w-full flex justify-center items-center">
        <div class="flex items-center justify-center space-x-8">
          <!-- Gambar Kiri -->
          <div class="flex-shrink-0">
            <img src="../img/pilihPembayaran.png" alt="Gambar Berita" class="w-[500px] h-auto rounded-md" />
          </div>

          <!-- Garis Horizontal -->
          <div class="h-[2px] bg-gray-200 w-12 mx-4 rounded-lg"></div>

          <!-- Konten Langkah -->
          <div class="max-w-4xl w-[350px] mx-2 mt-8 p-6 bg-white rounded-xl shadow-md">
            <div class="flex items-start space-x-4">
              <!-- Step Number -->
              <div class="flex items-center justify-center w-[60px] h-8 bg-blue-200 text-blue-800 rounded-full">
                <span class="text-xl font-semibold mt-[-4px] ml-[-1px]">4</span>
              </div>

              <!-- Step Content -->
              <div>
                <h3 class="text-lg font-bold text-gray-800" data-lang="step4">
                  Pilih metode pembayaran
                </h3>
                <p class="text-gray-600 mt-[10px] font-semibold" data-lang="step4Content">
                  Detail pembayaran untuk bus dan shuttle untuk mendapatkan
                  tiket.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex justify-center items-center min-h-screen mt-[-400px] mb-[-150px]">
    <div class="relative w-full max-w-[1440px] px-4 mx-auto">
      <!-- Konten Langkah yang terpusat di tengah -->
      <div class="relative z-10 w-full flex justify-center items-center">
        <div class="flex items-center justify-center space-x-8">
          <!-- Gambar Kiri -->
          <div class="flex-shrink-0">
            <img src="../img/detailPesanan.png" alt="Gambar Berita" class="w-[500px] h-auto rounded-md" />
          </div>

          <!-- Garis Horizontal -->
          <div class="h-[2px] bg-gray-200 w-12 mx-4 rounded-lg"></div>

          <!-- Konten Langkah -->
          <div class="max-w-4xl w-[350px] mx-2 mt-8 p-6 bg-white rounded-xl shadow-md">
            <div class="flex items-start space-x-4">
              <!-- Step Number -->
              <div class="flex items-center justify-center w-[60px] h-8 bg-blue-200 text-blue-800 rounded-full">
                <span class="text-xl font-semibold mt-[-4px] ml-[-1px]">5</span>
              </div>

              <!-- Step Content -->
              <div>
                <h3 class="text-lg font-bold text-gray-800" data-lang="step5">
                  Detail pesanan
                </h3>
                <p class="text-gray-600 mt-[10px] font-semibold" data-lang="step5Content">
                  Detail pesanan untuk bus dan shuttle akan di tampilkan di
                  sini.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-[50px] bg-[#009cf7] h-[280px]">
    <div class="flex justify-between">
      <div class="w-[180px] ml-[70px] mt-[10px]">
        <img class="w-[180px] ml-0 mt-[30px]" src="/img/logoAngkutan.png" alt="" />
        <div class="mt-[65px]">
          <p class="text-[12px] text-white mb-[2px]" data-lang="© 2025 AngkutIn">
            © 2025 NIKE
          </p>
          <p class="text-[12px] text-white mb-[2px]" data-lang="All rights reserved">
            All rights reserved
          </p>
        </div>
      </div>

      <div class="text-footer">
        <p class="mt-[70px] text-[20px] font-bold text-white mb-[30px]" data-lang="resourcesTitle">
          Resources
        </p>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="findStore">Find A Store</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="becomeMember">Become A Member</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="educationDiscounts">Education Discounts</a>
      </div>

      <div class="text-footer">
        <p class="mt-[70px] text-[20px] font-bold text-white mb-[30px]" data-lang="helpTitle">
          Help
        </p>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="getHelp">Get Help</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="orderStatus">Order Status</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="returns">Returns</a>
      </div>

      <div class="text-footer">
        <p class="mt-[70px] text-[20px] font-bold text-white mb-[30px]" data-lang="companyTitle">
          Company
        </p>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="aboutNike">About Nike</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="news">News</a>
        <a href="#" class="text-[14px] text-white mb-[5px] block" data-lang="careers">Careers</a>
      </div>

      <div class="flex flex-col items-end mr-[70px] mt-[70px]">
        <div class="flex space-x-8 mb-4">
          <a href="#" aria-label="Twitter">
            <i class="fa-brands fa-twitter text-white text-[25px] hover:text-gray-200 transition"></i>
          </a>
          <a href="#" aria-label="Facebook">
            <i class="fa-brands fa-facebook-f text-white text-[25px] hover:text-gray-200 transition"></i>
          </a>
          <a href="#" aria-label="Instagram">
            <i class="fa-brands fa-instagram text-white text-[25px] hover:text-gray-200 transition"></i>
          </a>
          <a href="#" aria-label="YouTube">
            <i class="fa-brands fa-youtube text-white text-[25px] hover:text-gray-200 transition"></i>
          </a>
        </div>
        <p class="text-[12px] text-white mt-[110px]" data-lang="privacyPolicy">
          Privacy & Cookie Policy
        </p>
      </div>
    </div>
  </div>

  <script>

    const languageData = {
      en: {
        step1: "Select Terminal",
        step1Content: "Start your search by entering the terminal details.",
        step2: "Select Bus",
        step2Content:
          "Detail of the bus (schedule, price, and other information) will be displayed here.",
        step3: "Select Seat",
        step3Content:
          "Detail of the seat (schedule, price, and other information) will be displayed here.",
        step4: "Select Payment Method",
        step4Content:
          "Detail of the payment method for bus and shuttle tickets will be displayed here.",
        step5: "Detail of the Order",
        step5Content:
          "Detail of the order for bus and shuttle tickets will be displayed here.",
        title1: "How to Order Bus & Shuttle Tickets at AngkutIn",
        title2: "Booking e-tickets in 5 minutes",
        carapesan: "How to Order Tickets",
        pilihterminaltujuan: "Select Destination Terminal",
        pilihterminalkeberangkatan: "Select Departure Terminal",
        semuaKolomWajibDiisi: "All fields are required!",
        dari: "From",
        ke: "To",
        tanggal: "Date",
        penumpang: "Passengers",
        maksimal3Penumpang: "Maximum 3 passengers",
        termianalTidakBolehSama:
          "Terminals cannot be the same when boarding!",
        cariTiket: "SEARCH FOR INTERCITY TICKETS",
        antarTerminal: "Bus & Shuttle Tickets",
        promo: "Promo",
        pesanan: "Orders",
        latestNewsTitle: "Latest News",
        article1Title:
          "History of Public Transportation Modes and Regulations in Jakarta - Kompaspedia",
        article4Title:
          "Testing the Whoosh Train from Jakarta to Bandung - Terah Malioboro News",
        article2Title:
          "DKI Provincial Government to Make Public Transportation Free on April 24, 2025",
        article3Title:
          "Transjakarta Opens Opportunities for Cooperation with Electric Bus Agents",
        article5Title:
          "718,000 Passengers Ride the Whoosh High-Speed Train, KCIC: Comfort, Safety, and Efficiency Are Most Sought After",
        resourcesTitle: "Resources",
        findStore: "Find A Store",
        becomeMember: "Become A Member",
        educationDiscounts: "Education Discounts",
        helpTitle: "Help",
        getHelp: "Get Help",
        orderStatus: "Order Status",
        returns: "Returns",
        companyTitle: "Company",
        aboutNike: "About AngkutIn",
        news: "News",
        careers: "Careers",
        privacyPolicy: "Privacy & Cookie Policy",
      },
      id: {
        step1: "Pilih Terminal",
        step1Content:
          "Mulai pencarian Anda dengan memasukkan detail terminal.",
        step2: "Pilih Bus",
        step2Content:
          "Detail bus (jadwal, harga, dan informasi lainnya) akan ditampilkan di sini.",
        step3: "Pilih Tempat Duduk",
        step3Content:
          "Detail tempat duduk (jadwal, harga, dan informasi lainnya) akan ditampilkan di sini.",
        step4: "Pilih Metode Pembayaran",
        step4Content:
          "Detail metode pembayaran untuk tiket bus dan shuttle akan ditampilkan di sini.",
        step5: "Detail Pesanan",
        step5Content:
          "Detail pesanan untuk tiket bus dan shuttle akan ditampilkan di sini.",
        title1: "Cara Pesan Tiket Bus & Shuttle di AngkutIn",
        title2: "Pesanan e-tiket Anda dalam 5 menit",
        carapesan: "Cara Pesan Tiket",
        pilihterminaltujuan: "Pilih Terminal Tujuan",
        pilihterminalkeberangkatan: "Pilih Terminal Keberangkatan",
        semuaKolomWajibDiisi: "Semua kolom wajib diisi!",
        dari: "Dari",
        ke: "Ke",
        tanggal: "Tanggal",
        penumpang: "Penumpang",
        maksimal3Penumpang: "Maksimal 3 penumpang dewasa",
        termianalTidakBolehSama:
          "Terminal keberangkatan dan tujuan tidak boleh sama!",
        cariTiket: "CARI TIKET ANTAR KOTA",
        antarTerminal: "Tiket Bus & Antar Jemput",
        promo: "Promo",
        pesanan: "Pesanan",
        latestNewsTitle: "Berita Terbaru",
        article1Title:
          "Sejarah Mode dan Regulasi Transportasi Umum di Jakarta - Kompaspedia",
        article4Title:
          "Menjajal Kereta Api Whoosh dari Jakarta ke Bandung - Terah Malioboro News",
        article2Title:
          "Pemprov DKI Gratiskan Transportasi Umum pada 24 April 2025",
        article3Title:
          "Transjakarta Buka Peluang Kerja Sama dengan Agen Bus Listrik",
        article5Title:
          "718.000 Penumpang Naik Kereta Cepat Whoosh, KCIC: Kenyamanan, Keamanan dan Efisiensi Paling Dicari",
        resourcesTitle: "Sumber Daya",
        findStore: "Temukan Toko",
        becomeMember: "Jadi Anggota",
        educationDiscounts: "Diskon Pendidikan",
        helpTitle: "Bantuan",
        getHelp: "Dapatkan Bantuan",
        orderStatus: "Status Pesanan",
        returns: "Pengembalian",
        companyTitle: "Perusahaan",
        aboutNike: "Tentang AngkutIn",
        news: "Berita",
        careers: "Karir",
        privacyPolicy: "Kebijakan Privasi & Cookie",
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