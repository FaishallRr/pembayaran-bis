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

  <link rel="stylesheet" href="../global.css" />

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
            <span id="user-dropdown-text"><?php echo $user_email; ?></span>
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
    <div id="payment-info" class="max-w-2xl mx-auto mt-[160px] mb-[100px]"></div>

    <script>
      // Ambil data dari query string (URL)
      const params = new URLSearchParams(window.location.search);
      const bus = params.get("bus");
      const tanggal = params.get("tanggal");
      const jam = params.get("jam");
      const harga = params.get("harga");
      const seat = params.get("seat");
      const nomerBus = params.get("nomerBus");

      // Menampilkan informasi yang dipilih pengguna
      const div = document.createElement("div");
      div.className = "flex items-center justify-center mt-[-130px]"; // Memastikan div ini terpusat di layar
      div.innerHTML = `
    <div class="flex flex-col items-center justify-center bg-[#ffffff] rounded-xl shadow p-6 border border-[#e0e7ef] hover:scale-[1.02] hover:shadow-lg transition-all duration-200">
      <div class="font-bold text-XL text-[#2563eb] mb-3 tracking-wide" data-lang="rincianData" >Rincian Bus & Tempat Duduk</div>
      <div class="text-gray-700 mb-2 flex items-center gap-2 text-sm mt-[20px]">
        <i class="fa-solid fa-bus text-[#2563eb]"></i>
        <b><span>PO Bus : ${bus}</span></b>
        <span class="mx-2">|</span>
        <b><span>No. Bus : ${nomerBus}</span></b>
      </div>
      <div class="text-gray-700 flex items-center gap-2 text-sm mt-0">
        <i class="fa fa-clock text-[#2563eb]"></i>
        <b><span>Berangkat : ${jam}</span></b>
      </div>
      <div class="text-gray-700 flex items-center gap-2 text-sm mt-2">
        <span>tempat duduk : ${seat}</span>
      </div>
      <div class="text-gray-700 text-sm mt-2">
        <span>Harga: </span>
        <span class="font-semibold text-[#2563eb]">Rp${parseInt(
        harga
      ).toLocaleString()}</span>
      </div>
    </div>
  `;
      document.getElementById("payment-info").appendChild(div);
    </script>
  </div>

  <!-- Metode Pembayaran -->
  <div class="max-w-xl mx-auto mt-[30px] mb-[100px]" id="payment-method">
    <div class="text-lg font-bold" data-lang="transferAntarBank">
      Transfer Antar Bank
    </div>

    <!-- Button Layouts -->
    <button id="btn-bni"
      class="mt-[10px] w-full flex items-center space-x-10 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/bni.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">BANK BNI</span>
    </button>
    <button id="btn-bri"
      class="mt-[10px] w-full flex items-center space-x-11 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/bri.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">BANK BRI</span>
    </button>
    <button id="btn-jateng"
      class="mt-[10px] w-full flex items-center space-x-5 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/jateng.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">BANK JATENG</span>
    </button>
    <button id="btn-bca"
      class="mt-[10px] w-full flex items-center space-x-8 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/bca.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">BANK BCA</span>
    </button>

    <!-- QRIS -->
    <div class="text-lg font-bold mt-[20px]">Qris</div>
    <button id="btn-qris"
      class="mt-[10px] w-full flex items-center space-x-8 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/qris.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">QRIS</span>
    </button>

    <!-- E-Wallet -->
    <div class="text-lg font-bold mt-[20px]">E-Wallet</div>
    <button id="btn-dana"
      class="mt-[10px] w-full flex items-center space-x-6 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/dana.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">DANA</span>
    </button>
    <button id="btn-gopay"
      class="mt-[10px] w-full flex items-center space-x-7 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/gopay.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">GOPAY</span>
    </button>
    <button id="btn-shopeepay"
      class="mt-[10px] w-full flex items-center space-x-9 p-2 bg-transparent border-2 border-blue-200 text-black rounded-xl focus:outline-none hover:border-blue-600 transition"
      onclick="setActiveButton(this)">
      <img src="../img/shopee.png" alt="bank-icon" class="w-19 h-19" />
      <span class="text-lg font-bold">SHOPEEPAY</span>
    </button>

    <!-- Next Button -->
    <div class="mt-6 text-center">
      <button id="continueBtn"
        class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
        onclick="goToNextPage()" disabled>
        SELANJUTNYA
      </button>
    </div>
  </div>

  <script>
    // Function to set active state for buttons
    function setActiveButton(button) {
      // Remove selected state from all buttons
      const allButtons = document.querySelectorAll("#payment-method button");
      allButtons.forEach((btn) => {
        btn.classList.remove("ring-4", "ring-blue-500", "bg-blue-100");
      });

      // Add selected style to clicked button
      button.classList.add("ring-4", "ring-blue-400", "bg-blue-100");

      // Enable the next button
      const continueBtn = document.getElementById("continueBtn");
      continueBtn.disabled = false;
      continueBtn.classList.remove("opacity-50", "cursor-not-allowed");
    }

    // Function to handle the "SELANJUTNYA" button click and navigate to the next page
    function goToNextPage() {
      // You can check the selected button and redirect accordingly
      const selectedButton = document.querySelector(
        "#payment-method button.ring-blue-400"
      );

      if (selectedButton) {
        // Check which button is selected and redirect to the corresponding page
        if (selectedButton.id === "btn-bni") {
          window.location.href = "../pembayaran/transaksi/bni.php"; // Change this URL to your destination
        } else if (selectedButton.id === "btn-bri") {
          window.location.href = "../pembayaran/transaksi/bri.php";
        } else if (selectedButton.id === "btn-jateng") {
          window.location.href = "../pembayaran/transaksi/jateng.php";
        } else if (selectedButton.id === "btn-bca") {
          window.location.href = "../pembayaran/transaksi/bca.php";
        } else if (selectedButton.id === "btn-qris") {
          window.location.href = "../pembayaran/transaksi/qris.php";
        } else if (selectedButton.id === "btn-dana") {
          window.location.href = "../pembayaran/transaksi/dana.php";
        } else if (selectedButton.id === "btn-gopay") {
          window.location.href = "../pembayaran/transaksi/gopay.php";
        } else if (selectedButton.id === "btn-shopeepay") {
          window.location.href = "../pembayaran/transaksi/shopeepay.php";
        }
      }
    }

    // Function to detect clicks outside the buttons and reset
    document.addEventListener("click", function (event) {
      const paymentMethodDiv = document.getElementById("payment-method");
      const isClickInside = paymentMethodDiv.contains(event.target);

      // If click is outside, remove selected state
      if (!isClickInside) {
        const allButtons = document.querySelectorAll(
          "#payment-method button"
        );
        allButtons.forEach((btn) => {
          btn.classList.remove("ring-4", "ring-blue-500", "bg-blue-100");
        });
        const continueBtn = document.getElementById("continueBtn");
        continueBtn.disabled = true;
        continueBtn.classList.add("opacity-50", "cursor-not-allowed");
      }
    });
  </script>

  <script>
    const languageData = {
      en: {
        carapesan: "How to Order Tickets",
        pencarianTiket: "Search Tickets",
        rincianTiket: "Ticket Details",
        rincianTiketBerikut:
          "Here are the details of the ticket you have selected:",
        transferAntarBank: "Transfer to Bank Account",
        pesanan: "Orders",
        rincianData: "Bus & Seat Details",
      },
      id: {
        carapesan: "Cara Pesan Tiket",
        pencarianTiket: "Cari Tiket",
        rincianTiket: "Rincian Tiket",
        rincianTiketBerikut:
          "Berikut adalah rincian tiket yang telah Anda pilih:",
        transferAntarBank: "Transfer ke Rekening Bank",
        pesanan: "Pesanan",
        rincianData: "Rincian Bus & Tempat Duduk",
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
    // Ambil data pencarian tiket dari localStorage
    const pencarianTiket = JSON.parse(localStorage.getItem("pencarianTiket"));

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
  </script>

  <script>
    // Menyimpan nomor kursi yang dipilih ke localStorage
    localStorage.setItem("selectedSeat", selectedSeat);

    console.log("Selected Seat:", selectedSeat); // Verifikasi nilai kursi yang dipilih

    // Setelah memilih bus dan kursi
    document.getElementById("lanjut-btn").addEventListener("click", function () {
      // Pastikan data dipilih dan dikirim melalui query string
      if (selectedBus && selectedSeat) {
        // Simpan data bus dan kursi ke localStorage
        localStorage.setItem("selectedBus", JSON.stringify(selectedBus));
        localStorage.setItem("selectedSeat", selectedSeat);

        // Menyusun parameter untuk query string
        const params = new URLSearchParams({
          bus: selectedBus.nama, // Nama bus
          nomerBus: selectedBus.nomerBus, // Nomor bus
          jam: selectedBus.jam, // Jam keberangkatan
          harga: selectedBus.harga, // Harga tiket
          seat: selectedSeat, // Tempat duduk yang dipilih
        });

        // Redirect ke halaman pembayaran dengan query string yang lengkap
        window.location.href = `../pembayaran/pembayaran.php?${params.toString()}`;
      } else {
        console.log("Data bus atau kursi belum dipilih.");
      }
    });
  </script>

  <script>
    // Dropdown User/Login/Register/Logout
    const dropdownBtn = document.getElementById("user-dropdown-btn");
    const dropdownMenu = document.getElementById("user-dropdown-menu");

    // Menampilkan atau menyembunyikan dropdown
    dropdownBtn.addEventListener("click", function (e) {
      e.stopPropagation();  // Menghentikan event bubbling agar dropdown tidak menutup saat tombol dropdown diklik
      dropdownMenu.classList.toggle("hidden");
    });

    // Menyembunyikan dropdown saat klik di luar
    document.addEventListener("click", function () {
      dropdownMenu.classList.add("hidden");
    });



    document.addEventListener("DOMContentLoaded", function () {
      // Ambil email dari span yang sudah di-set oleh PHP
      const email = document.getElementById("user-dropdown-text").textContent.trim();

      const dropdownText = document.getElementById("user-dropdown-text");
      const dropdownLoginBtn = document.getElementById("dropdown-login-btn");
      const dropdownRegisterBtn = document.getElementById("dropdown-register-btn");
      const dropdownLogoutBtn = document.getElementById("dropdown-logout-btn");

      if (email !== 'Login') {
        // Jika email tidak "Login", berarti pengguna sudah login
        dropdownText.textContent = email; // Ganti teks dengan email pengguna

        // Sembunyikan tombol Login dan Daftar, tampilkan tombol Logout
        dropdownLoginBtn.classList.add("hidden");
        dropdownRegisterBtn.classList.add("hidden");
        dropdownLogoutBtn.classList.remove("hidden");
      } else {
        // Jika email masih "Login", berarti pengguna belum login
        dropdownText.textContent = "Log In"; // Tampilkan "Log In"

        // Sembunyikan tombol Logout, tampilkan tombol Login dan Daftar
        dropdownLoginBtn.classList.remove("hidden");
        dropdownRegisterBtn.classList.remove("hidden");
        dropdownLogoutBtn.classList.add("hidden");
      }
    });


    function logout() {
      // Hapus data dari session dan localStorage
      localStorage.removeItem("user_email");
      localStorage.removeItem("pencarianTiket");
      localStorage.removeItem("selectedBus");
      localStorage.removeItem("selectedSeat");

      // Redirect ke halaman utama setelah logout
      window.location.href = "/index.php"; // Ganti dengan URL halaman login Anda
    }

  </script>

  <script src="../kursi/script.js"></script>
</body>

</html>