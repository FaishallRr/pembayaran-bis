// Berita scroll kanan dan kiri
const beritaScroll = document.getElementById("berita-scroll");
document.getElementById("scrollLeft").onclick = () => {
  beritaScroll.scrollBy({ left: -350, behavior: "smooth" });
};
document.getElementById("scrollRight").onclick = () => {
  beritaScroll.scrollBy({ left: 350, behavior: "smooth" });
};

// Alert atau notifikasi jika terminal dari dan ke sama
function cekTerminalSama() {
  const dari = document.getElementById("terminal-dari").value;
  const keSelect = document.querySelector('select[aria-label="Ke"]');
  const ke = keSelect
    ? keSelect.value
    : document.querySelectorAll("select")[1].value;
  const notif = document.getElementById("notif-terminal");

  if (dari && ke && dari === ke) {
    notif.classList.remove("hidden");
    setTimeout(() => {
      notif.classList.add("hidden");
    }, 2500);
    document.getElementById("terminal-dari").selectedIndex = 0;
  } else {
    notif.classList.add("hidden");
  }
}

// Alert atau notifikasi jika kolom tidak diisi
const notifKosong = document.getElementById("notif-kosong");
document.getElementById("cariTiketBtn").addEventListener("click", function (e) {
  const dari = document.getElementById("terminal-dari").value;
  const ke = document.getElementById("terminal-ke").value;
  const tanggal = document.getElementById("tanggal-berangkat").value;
  const penumpang = document.getElementById("penumpang").value;

  if (!dari || !ke || !tanggal || !penumpang) {
    e.preventDefault();
    notifKosong.classList.remove("hidden");
    notifKosong.classList.add("flex");
    setTimeout(() => {
      notifKosong.classList.add("hidden");
      notifKosong.classList.remove("flex");
    }, 2500);
  }
});

// Dropdown User/Login/Register/Logout
const dropdownBtn = document.getElementById("user-dropdown-btn");
const dropdownMenu = document.getElementById("user-dropdown-menu");

// Menampilkan atau menyembunyikan dropdown
dropdownBtn.addEventListener("click", function (e) {
  e.stopPropagation();
  dropdownMenu.classList.toggle("hidden");
});

// Menyembunyikan dropdown saat klik di luar
document.addEventListener("click", function () {
  dropdownMenu.classList.add("hidden");
});

// Event tombol cari tiket
document.getElementById("cariTiketBtn").addEventListener("click", function () {
  const dari = document.getElementById("terminal-dari").value;
  const ke = document.getElementById("terminal-ke").value;
  const tanggal = document.getElementById("tanggal-berangkat").value;
  const penumpang = document.getElementById("penumpang").value;

  // Cek apakah semua field sudah diisi
  if (!dari || !ke || !tanggal || !penumpang) {
    return;
  }

  // Cek apakah user sudah login
  const email = localStorage.getItem("user_email"); // Ambil email langsung dari localStorage
  if (!email) {
    // Jika user belum login, arahkan ke halaman login
    window.location.href = "./login/login.php";
    return;
  }

  // Simpan data pencarian tiket ke localStorage
  localStorage.setItem(
    "pencarianTiket",
    JSON.stringify({
      dari: dari,
      ke: ke,
      tanggal: tanggal,
      penumpang: penumpang,
    })
  );

  // Lanjut ke halaman pemilihan bus
  window.location.href = "./kursi/kursi.php";
});

// Fungsi untuk mengecek apakah pengguna sudah login
function checkLogin() {
  const email = localStorage.getItem("user_email"); // Ambil email langsung dari localStorage

  if (!email) {
    // Jika belum login, arahkan ke halaman login
    window.location.href = "./login/login.php";
  }
}

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
