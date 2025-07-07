// Fungsi notifikasi kustom (seperti register)
function showNotif({ type = "success", title = "", message = "" }) {
  let notif = document.createElement("div");
  notif.innerHTML = `
          <div class="flex flex-col items-center">
            <div class="bg-white rounded-full p-4 shadow-lg mb-2">
            <i class="fa ${
              type === "success"
                ? "fa-check-circle text-green-500"
                : "fa-exclamation-circle text-red-500"
            } text-4xl animate-bounce"></i>
            </div>
            <span class="font-bold text-xl mb-1">${title}</span>
            <span class="text-base">${message}</span>
          </div>
          `;
  notif.className =
    "fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white/90 text-gray-800 px-10 py-7 rounded-2xl shadow-2xl text-center z-50 flex items-center justify-center transition-all opacity-100 border border-gray-200";
  notif.style.minWidth = "320px";
  notif.style.maxWidth = "90vw";
  notif.style.backdropFilter = "blur(2px)";
  notif.style.boxShadow = "0 8px 32px 0 rgba(31, 38, 135, 0.17)";
  document.body.appendChild(notif);

  // Membuat notifikasi memudar setelah 2 detik dan kemudian menghapusnya
  setTimeout(() => {
    notif.classList.add("opacity-0", "transition-opacity", "duration-500");
    setTimeout(() => notif.remove(), 500); // Menghapus notifikasi setelah fade-out
  }, 6000); // Menampilkan notifikasi selama 6 detik
}

let timeLeft = 5 * 60; // 5 menit dalam detik
const countdownElement = document.getElementById("countdown-timer");

function updateCountdown() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  countdownElement.textContent = `Waktu: ${minutes}:${
    seconds < 10 ? "0" : ""
  }${seconds}`;

  if (timeLeft <= 0) {
    clearInterval(timerInterval); // Menghentikan timer saat waktu habis
    showNotif({
      type: "error",
      title: "Transaksi Kadaluarsa",
      message: "Waktu Anda telah habis. Transaksi kadaluarsa.",
    });

    // Menampilkan modal dan mengarahkan ke halaman utama setelah 2 detik
    setTimeout(() => {
      console.log("Menampilkan modal...");
      document.getElementById("alertModal").classList.remove("hidden");
      localStorage.removeItem("pencarianTiket");
      localStorage.removeItem("selectedSeat");
      localStorage.removeItem("selectedBus");
      setTimeout(() => {
        window.location.replace("../../index.html"); // Redirect ke halaman utama
      }, 6000); // Mengalihkan setelah 6 detik
    }, 1000); // Menampilkan modal setelah 1 detik
  }
  timeLeft--; // Mengurangi detik
}

const timerInterval = setInterval(updateCountdown, 1000); // Memulai interval untuk countdown

// Menampilkan waktu segera setelah halaman dimuat
updateCountdown();

//
//

// Fungsi untuk menyalin teks ke clipboard
function copyText() {
  // Mendapatkan teks dari elemen span dengan id 'textToCopy'
  const textToCopy = document.getElementById("textToCopy");

  // Membuat elemen input (textarea) untuk menyalin teks
  const textField = document.createElement("textarea");
  textField.innerText = textToCopy.innerText; // Menyalin teks dari span
  document.body.appendChild(textField);

  // Memilih teks di dalam textarea
  textField.select();
  textField.setSelectionRange(0, 99999); // Untuk perangkat mobile

  // Salin teks ke clipboard
  document.execCommand("copy");

  // Menghapus textarea setelah teks disalin
  document.body.removeChild(textField);
}

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
  const email = document
    .getElementById("user-dropdown-text")
    .textContent.trim();
  const dropdownText = document.getElementById("user-dropdown-text");
  const dropdownLoginBtn = document.getElementById("dropdown-login-btn");
  const dropdownRegisterBtn = document.getElementById("dropdown-register-btn");
  const dropdownLogoutBtn = document.getElementById("dropdown-logout-btn");

  if (email !== "Login") {
    dropdownText.textContent = email; // Mengganti teks menjadi email
    dropdownLoginBtn.style.display = "none"; // Menyembunyikan tombol Login
    dropdownRegisterBtn.style.display = "none"; // Menyembunyikan tombol Daftar
    dropdownLogoutBtn.classList.remove("hidden"); // Menampilkan tombol Logout
  } else {
    dropdownText.textContent = "Log In"; // Menampilkan teks "Log In"
    dropdownLoginBtn.style.display = ""; // Menampilkan tombol Login
    dropdownRegisterBtn.style.display = ""; // Menampilkan tombol Daftar
    dropdownLogoutBtn.classList.add("hidden"); // Menyembunyikan tombol Logout
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
