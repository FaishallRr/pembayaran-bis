// Simulasi data user
const users = [{ email: "Tiwi@gmail.com", password: "Tiwi123" }];

// Custom notification function (same style as register)
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
  }, 2000);
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
document
  .getElementById("toggleConfirmPassword")
  .addEventListener("click", function () {
    const pwd = document.getElementById("confirmPassword");
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

// Register button logic
document.getElementById("registerBtn").addEventListener("click", function () {
  const nama = document.getElementById("nama").value.trim();
  const email = document.getElementById("email").value.trim();
  const pwd = document.getElementById("password").value;
  const conf = document.getElementById("confirmPassword").value;
  const notif = document.getElementById("notif");

  // Validasi field kosong
  if (!nama || !email || !pwd || !conf) {
    showNotif({
      type: "error",
      title: "Data Belum Diisi",
      message: "Silahkan isi semua data untuk membuat akun.",
    });
    return;
  }

  // Validasi email sudah terdaftar
  const user = users.find((u) => u.email.toLowerCase() === email.toLowerCase());
  if (user) {
    showNotif({
      type: "error",
      title: "Email Sudah Terdaftar",
      message: "Gunakan email lain untuk mendaftar.",
    });
    return;
  }

  // Validasi password dan konfirmasi
  if (pwd !== conf) {
    notif.classList.remove("hidden");
    showNotif({
      type: "error",
      title: "Konfirmasi Password Salah",
      message: "Konfirmasi password tidak sama.",
    });
    return;
  } else {
    notif.classList.add("hidden");
  }

  // Simulasi register sukses
  showNotif({
    type: "success",
    title: "Berhasil!",
    message: "Akun berhasil dibuat.",
  });

  // Simulasi menambah user baru ke array users
  users.push({ email, password: pwd });

  setTimeout(() => {
    window.location.href = "../login/login.html";
  }, 2000);
});
