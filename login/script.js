// Simulasi data user
const users = [
  {
    name: "Charisma Eka Pratiwi",
    email: "charismaekapratiwi@gmail.com",
    password: "Tiwi123",
  },
];

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

document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  const user = users.find((u) => u.email === email);

  if (!email && !password) {
    showNotif({
      type: "error",
      title: "Data Belum Diisi",
      message: "Silakan isi email dan password untuk login.",
    });
    return;
  }

  if (!user) {
    showNotif({
      type: "error",
      title: "Akun Tidak Ditemukan",
      message: "Akun belum terdaftar. Silakan daftar terlebih dahulu.",
    });
    return;
  }
  if (user.password !== password) {
    showNotif({
      type: "error",
      title: "Password Salah",
      message: "Password yang kamu masukkan salah.",
    });
    return;
  }
  localStorage.setItem("User", JSON.stringify({ email: user.email }));
  showNotif({
    type: "success",
    title: "Login Berhasil!",
    message: "Mengalihkan ke halaman utama...",
  });
  setTimeout(() => {
    window.location.href = "../index.html";
  }, 2000);
});

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
