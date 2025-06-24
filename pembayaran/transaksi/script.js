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

// Simulasi waktu habis transaksi (hitung mundur 5 menit)
let timeLeft = 5 * 60; // 5 menit dalam detik
const countdownElement = document.getElementById("countdown-timer");

function updateCountdown() {
  const minutes = Math.floor(timeLeft / 60);
  const seconds = timeLeft % 60;
  countdownElement.textContent = `Waktu: ${minutes}:${
    seconds < 10 ? "0" : ""
  }${seconds}`;

  if (timeLeft <= 0) {
    clearInterval(timerInterval); // Menghentikan timer
    showNotif({
      type: "error",
      title: "Transaksi Kadaluarsa",
      message: "Waktu Anda telah habis. Transaksi kadaluarsa.",
    });

    // Menampilkan modal dan mengarahkan ke halaman utama setelah 2 detik
    setTimeout(() => {
      console.log("Menampilkan modal...");
      // Menampilkan modal
      document.getElementById("alertModal").classList.remove("hidden");

      // Menghapus data dari localStorage (menghapus pencarianTiket, selectedSeat, selectedBus)
      localStorage.removeItem("pencarianTiket");
      localStorage.removeItem("selectedSeat");
      localStorage.removeItem("selectedBus");

      // Mengalihkan ke halaman utama setelah 6 detik
      setTimeout(() => {
        console.log("Redirecting to the homepage...");
        window.location.replace("../../index.html"); // Menggunakan replace() untuk pengalihan yang lebih kuat
      }, 6000); // 6 detik untuk pengalihan (setelah modal)
    }, 1000); // Menampilkan modal setelah 1 detik
  }
  timeLeft--;
}

const timerInterval = setInterval(updateCountdown, 1000);

// Memanggil fungsi updateCountdown segera untuk menampilkan waktu awal
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
