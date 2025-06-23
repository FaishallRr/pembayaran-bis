//berita scroll kanan dan kiri
const beritaScroll = document.getElementById("berita-scroll");
document.getElementById("scrollLeft").onclick = () => {
  beritaScroll.scrollBy({ left: -350, behavior: "smooth" });
};
document.getElementById("scrollRight").onclick = () => {
  beritaScroll.scrollBy({ left: 350, behavior: "smooth" });
};

//alert atau notifikasi dari ke tujuan sama
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

//alert atau notifikasi semua belum diisi
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

// user sudah login
const user = JSON.parse(localStorage.getItem("User"));
const dropdownBtn = document.getElementById("user-dropdown-btn");
const dropdownMenu = document.getElementById("user-dropdown-menu");
const dropdownLoginBtn = document.getElementById("dropdown-login-btn");
const dropdownRegisterBtn = document.getElementById("dropdown-register-btn");
const dropdownLogoutBtn = document.getElementById("dropdown-logout-btn");
const dropdownText = document.getElementById("user-dropdown-text");

// Show/hide dropdown
dropdownBtn.addEventListener("click", function (e) {
  e.stopPropagation();
  dropdownMenu.classList.toggle("hidden");
});

// Hide dropdown when clicking outside
document.addEventListener("click", function () {
  dropdownMenu.classList.add("hidden");
});

// User state logic
if (user && user.email) {
  dropdownText.textContent = user.email;
  dropdownLoginBtn.style.display = "none";
  dropdownRegisterBtn.style.display = "none";
  dropdownLogoutBtn.classList.remove("hidden");
} else {
  dropdownText.textContent = "Log In";
  dropdownLoginBtn.style.display = "";
  dropdownRegisterBtn.style.display = "";
  dropdownLogoutBtn.classList.add("hidden");
}

// Logout
dropdownLogoutBtn &&
  dropdownLogoutBtn.addEventListener("click", function () {
    localStorage.removeItem("User");
    window.location.reload();
  });

// Event tombol cari tiket
document.getElementById("cariTiketBtn").addEventListener("click", function () {
  const dari = document.getElementById("terminal-dari").value;
  const ke = document.getElementById("terminal-ke").value;
  const tanggal = document.getElementById("tanggal-berangkat").value;
  const penumpang = document.getElementById("penumpang").value;

  // Cek apakah semua field sudah diisi
  if (!dari || !ke || !tanggal || !penumpang) {
    alert("Harap isi semua field!");
    return;
  }

  // Cek apakah user sudah login
  const user = JSON.parse(localStorage.getItem("User"));
  if (!user || !user.email) {
    // Jika user belum login, arahkan ke halaman login
    window.location.href = "./login/login.html";
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
  window.location.href = "./kursi/kursi.html";
});

//data dikirim ke excel
const simpanTanggal = document.getElementById("tanggal-berangkat");
simpanTanggal.addEventListener("change", function () {
  const tanggal = this.value;
  // Kirim data ke backend (misal pakai fetch ke endpoint API)
  fetch("/api/simpan-tanggal", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ kolom: "Pilih tanggal berangkat", tanggal }),
  });
});
