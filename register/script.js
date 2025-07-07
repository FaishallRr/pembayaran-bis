// Function to show notification
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

  setTimeout(() => {
    notif.classList.add("opacity-0", "transition-opacity", "duration-500");
    setTimeout(() => notif.remove(), 500);
  }, 5000); // Notifikasi hilang setelah 2 detik

  // Redirect to login page if the status is success
  if (type === "success") {
    setTimeout(() => {
      window.location.href = "../login/login.php"; // Redirect ke halaman login setelah 2 detik
    }, 5000); // Waktu delay sama dengan notifikasi
  }
}

// Read query string parameters from URL
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get("status"); // 'success' or 'error'
const message = urlParams.get("message"); // The message sent from PHP

// Check if both status and message are present in the URL
if (status && message) {
  showNotif({
    type: status, // success or error
    title: status === "success" ? "Berhasil" : "Gagal", // Title based on status
    message: message, // Message from PHP
  });
}

// Toggle password visibility
document
  .getElementById("togglePassword")
  .addEventListener("click", function () {
    const pwd = document.getElementById("password");
    const icon = this.querySelector("i");
    if (pwd.type === "password") {
      pwd.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      pwd.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  });

// toogle confirm password visibility
document
  .getElementById("toggleConfirmPassword")
  .addEventListener("click", function () {
    const pwd = document.getElementById("konfirmasi_password");
    const icon = this.querySelector("i");
    if (pwd.type === "password") {
      pwd.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      pwd.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  });
