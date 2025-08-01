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
  <title>Home - AngkutIn</title>
  <!-- logo browser -->
  <link rel="website icon" type="png" href="./img/logoAngkutan.png" />
  <link rel="stylesheet" href="global.css" />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="relative w-full mt-[50px]">
    <div class="relative">
      <img src="img/busTravel.png" alt="busTravel" class="mt-[-50px] w-full object-cover" />
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
          <img id="lang-flag" src="https://flagcdn.com/id.svg" alt="ID" class="w-6 h-4 rounded-sm border" />
          <span id="lang-text" class="text-sm font-medium cursor-pointer" onclick="toggleLanguage()">ID | IDR</span>
        </div>
        <a href="./promo/promo.php"
          class="flex items-center space-x-1 text-sm font-medium hover:text-[var(--bg-primary)]">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" fill="#E6F7FF" />
            <text x="12" y="16" text-anchor="middle" font-size="14" fill="#4CAF50" font-family="Arial"
              font-weight="bold">%</text>
          </svg>
          <span data-lang="promo">Promo</span>
        </a>
        <a href="/caraPesan/index.php" class="text-sm font-medium hover:text-[var(--bg-primary)]"
          data-lang="carapesan">Cara Pesan Tiket</a>
        <a href="./pesanan/pesanan.php" class="text-sm font-medium hover:text-[var(--bg-primary)]"
          data-lang="pesanan">Pesanan</a>
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
    </header>
  </div>

  <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-[1440px] px-4 ml-[-275px] flex justify-center"
    style="top: 140px">
    <div class="flex items-center justify-between mt-10 space-y-4">
      <div>
        <div style="position: relative" class="ml-[140px]">
          <button class="px-6 py-1 rounded-2xl bg-[var(--bg-primary)] text-white font-bold flex items-center gap-2"
            data-lang="antarTerminal">
            <i class="fa-solid fa-bus"></i>
            Tiket Bus & Shuttle
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form di atas gambar -->
  <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-[1440px] px-4" style="top: 250px; z-index: 10">
    <div class="flex flex-row gap-14 justify-center w-full">
      <!-- Kolom Dari & Ke -->
      <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-2">
          <div class="font-bold text-lg w-[60px]" data-lang="dari">Dari</div>
          <div class="relative w-[350px]">
            <select id="terminal-dari"
              class="w-full px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-semibold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition appearance-none"
              onchange="cekTerminalSama()">
              <option value="" data-lang="pilihterminalkeberangkatan">
                Pilih Terminal Keberangkatan
              </option>
              <option value="terminal-pulo-gebang">
                Terminal Pulo Gebang
              </option>
              <option value="terminal-kampung-rambutan">
                Terminal Kampung Rambutan
              </option>
              <option value="terminal-lebak-bulus">
                Terminal Lebak Bulus
              </option>
              <option value="terminal-kalideres">Terminal Kalideres</option>
              <option value="terminal-giwangan">Terminal Giwangan</option>
              <option value="terminal-bungurasih">Terminal Bungurasih</option>
              <option value="terminal-arjosari">Terminal Arjosari</option>
              <option value="terminal-tirtonadi">Terminal Tirtonadi</option>
              <!-- Tambahkan terminal lain sesuai kebutuhan -->
            </select>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-bus" style="color: #009cf7"></i>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-chevron-down text-gray-400"></i>
            </div>
            <!-- Notifikasi custom -->
            <div id="notif-terminal"
              class="hidden absolute left-0 right-0 top-[110%] bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg text-sm shadow-lg z-20 flex items-center gap-2">
              <i class="fa-solid fa-circle-exclamation"></i>
              <span data-lang="termianalTidakBolehSama">Terminal keberangkatan dan tujuan tidak boleh sama!</span>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <div class="font-bold text-lg w-[60px]" data-lang="ke">Ke</div>
          <div class="relative w-[350px]">
            <select aria-label="Ke" id="terminal-ke"
              class="w-full px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-semibold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition appearance-none"
              onchange="cekTerminalSama()">
              <option value="" data-lang="pilihterminaltujuan">
                Pilih Terminal Tujuan
              </option>
              <option value="terminal-pulo-gebang">
                Terminal Pulo Gebang
              </option>
              <option value="terminal-kampung-rambutan">
                Terminal Kampung Rambutan
              </option>
              <option value="terminal-lebak-bulus">
                Terminal Lebak Bulus
              </option>
              <option value="terminal-kalideres">Terminal Kalideres</option>
              <option value="terminal-giwangan">Terminal Giwangan</option>
              <option value="terminal-bungurasih">Terminal Bungurasih</option>
              <option value="terminal-arjosari">Terminal Arjosari</option>
              <option value="terminal-tirtonadi">Terminal Tirtonadi</option>
              <!-- Tambahkan terminal lain sesuai kebutuhan -->
            </select>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-bus" style="color: #009cf7"></i>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-chevron-down text-gray-400"></i>
            </div>
          </div>
        </div>
      </div>
      <!-- Kolom Disampingnya -->
      <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-2">
          <label for="tanggal-berangkat" class="font-bold text-lg w-[60px]" data-lang="tanggal">Tanggal</label>
          <div class="relative w-[350px]">
            <input type="date" id="tanggal-berangkat" name="tanggal-berangkat"
              class="w-full px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-semibold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition appearance-none" />
            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-calendar-days" style="color: #009cf7"></i>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-chevron-down text-gray-400"></i>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <label class="font-bold text-lg w-[60px]" for="penumpang" data-lang="penumpang">
            Penumpang
          </label>
          <div class="relative w-[350px]">
            <select id="penumpang" name="penumpang"
              class="w-full px-12 py-3 rounded-2xl bg-[var(--bg-quaternary)] border border-[#C6E9FEFF] text-gray-500 font-semibold focus:outline-none hover:border-[#007acc] hover:bg-[#e6f7ff] hover:shadow-lg focus:border-[#007acc] focus:bg-[#e6f7ff] focus:shadow-lg transition appearance-none">
              <option value="1">1 Dewasa</option>
              <option value="2">2 Dewasa</option>
              <option value="3">3 Dewasa</option>
            </select>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-user-group" style="color: #009cf7"></i>
            </div>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
              <i class="fa-solid fa-chevron-down text-gray-400"></i>
            </div>
          </div>
          <span class="text-xs text-gray-600 ml-1" data-lang="maksimal3Penumpang">Maksimal 3 penumpang dewasa</span>
        </div>
      </div>
    </div>
  </div>
  <!-- Tombol Cari Tiket & Notifikasi -->
  <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-[1440px] px-4" style="top: 490px; z-index: 20">
    <div class="relative flex flex-col items-center">
      <!-- Notifikasi custom jika ada yang kosong -->
      <div id="notif-kosong"
        class="hidden mb-4 w-[500px] max-w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-base shadow-lg flex items-center gap-3 animate-fade-in"
        style="z-index: 30" role="alert">
        <i class="fa-solid fa-circle-exclamation text-xl"></i>
        <span data-lang="semuaKolomWajibDiisi">Semua kolom wajib diisi!</span>
      </div>
      <button id="cariTiketBtn"
        class="w-[500px] max-w-full px-6 py-3 rounded-2xl bg-[var(--bg-primary)] text-white font-bold flex items-center gap-3 z-20 text-lg justify-center shadow-lg hover:bg-[var(--bg-secondary)] transition"
        style="margin-top: 10px" data-lang="cariTiket">
        <i class="fa-solid fa-magnifying-glass"></i>
        CARI TIKET ANTAR KOTA
      </button>
    </div>
  </div>

  <!-- Artikel/berita dengan gambar kecil scroll horizontal -->
  <div class="w-full max-w-[1440px] mx-auto mt-7 px-4">
    <h2 class="text-xl font-bold mb-4" data-lang="latestNewsTitle">
      Berita Terbaru
    </h2>
    <div class="relative">
      <!-- Tombol scroll kiri -->
      <button id="scrollLeft"
        class="absolute left-[-20px] mt-[140px] -translate-y-1/2 z-10 bg-white/80 hover:bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center transition-all duration-200 border border-gray-200">
        <i class="fa fa-chevron-left text-2xl text-gray-700"></i>
      </button>
      <!-- Scrollable berita -->
      <div id="berita-scroll"
        class="flex gap-8 overflow-x-auto scroll-smooth py-4 px-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent"
        style="scrollbar-width: thin">
        <!-- Artikel 1 -->
        <a href="./detailBerita/detailBerita1.html"
          class="flex-shrink-0 w-[350px] bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-200 block">
          <img src="img/berita1.png" alt="Berita 1" class="object-cover rounded-t-2xl mx-auto" />
          <div class="mt-4 text-start text-sm font-bold px-4 pb-4" data-lang="article1Title">
            Sejarah Mode dan Regulasi Transportasi Umum di Jakarta -
            Kompaspedia
          </div>
        </a>
        <!-- Artikel 2 -->
        <a href="./detailBerita/detailBerita2.html"
          class="flex-shrink-0 w-[350px] bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-200 block">
          <img src="img/berita2.png" alt="Berita 2" class="object-cover rounded-t-2xl mx-auto" />
          <div class="mt-4 text-start text-sm font-bold px-4 pb-4" data-lang="article2Title">
            Pemprov DKI Gratiskan Transportasi Umum pada 24 April 2025
          </div>
        </a>
        <!-- Artikel 3 -->
        <a href="./detailBerita/detailBerita3.html"
          class="flex-shrink-0 w-[350px] bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-200 block">
          <img src="img/berita3.png" alt="Berita 3" class="object-cover rounded-t-2xl mx-auto" />
          <div class="mt-4 text-start text-sm font-bold px-4 pb-4" data-lang="article3Title">
            Transjakarta Buka Peluang Kerja Sama dengan Agen Bus Listrik
          </div>
        </a>
        <!-- Artikel 4 -->
        <a href="detail-berita4.html"
          class="flex-shrink-0 w-[350px] bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-200 block">
          <img src="img/berita4.png" alt="Berita 4" class="object-cover rounded-t-2xl mx-auto" />
          <div class="mt-4 text-start text-sm font-bold px-4 pb-4" data-lang="article4Title">
            Menjajal Kereta Api Whoosh dari Jakarta ke Bandung. - Terah
            Malioboro News
          </div>
        </a>
        <!-- Artikel 5 -->
        <a href="./detailBerita/detailBerita5.html"
          class="flex-shrink-0 w-[350px] bg-white rounded-2xl shadow-lg hover:scale-105 transition-transform duration-200 block">
          <img src="img/berita5.png" alt="Berita 5" class="object-cover rounded-t-2xl mx-auto" />
          <div class="mt-4 text-start text-sm font-bold px-4 pb-4" data-lang="article5Title">
            718.000 Penumpang Naik Kereta Cepat Whoosh, KCIC: Kenyamanan,
            Keamanan dan Efisiensi Paling Dicari
          </div>
        </a>
      </div>
      <!-- Tombol scroll kanan -->
      <button id="scrollRight"
        class="absolute right-[-28px] mt-[-150px] -translate-y-1/2 z-10 bg-white/80 hover:bg-white shadow-lg rounded-full w-12 h-12 flex items-center justify-center transition-all duration-200 border border-gray-200">
        <i class="fa fa-chevron-right text-2xl text-gray-700"></i>
      </button>
    </div>
  </div>

  <!-- Footer Section -->
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


  <script src="./script.js"></script>
</body>

</html>