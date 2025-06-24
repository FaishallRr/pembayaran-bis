// Ambil elemen dropdown
const dropdownButton = document.getElementById("user-dropdown-btn");
const dropdownMenu = document.getElementById("user-dropdown-menu");

// Tambahkan event listener untuk menampilkan/menyembunyikan dropdown saat tombol diklik
dropdownButton.addEventListener("click", () => {
  // Cek apakah dropdown sedang disembunyikan, jika ya, tampilkan
  if (dropdownMenu.classList.contains("hidden")) {
    dropdownMenu.classList.remove("hidden");
  } else {
    dropdownMenu.classList.add("hidden");
  }
});

// Menutup dropdown saat klik di luar elemen
document.addEventListener("click", (event) => {
  if (
    !dropdownButton.contains(event.target) &&
    !dropdownMenu.contains(event.target)
  ) {
    dropdownMenu.classList.add("hidden");
  }
});

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

// Data bus dummy
const buses = [
  {
    id: 1,
    nama: "Sinar Jaya",
    jam: "08:00",
    nomerBus: "120",
    harga: 120000,
  },
  {
    id: 2,
    nama: "Rosalia Indah",
    jam: "10:30",
    nomerBus: "110",
    harga: 150000,
  },
  {
    id: 3,
    nama: "PO Haryanto",
    jam: "13:00",
    nomerBus: "121",
    harga: 130000,
  },
];

// Generate daftar bus
const busList = document.getElementById("bus-list");
buses.forEach((bus) => {
  const div = document.createElement("div");
  div.className =
    "flex items-center justify-between bg-[#f8fafc] rounded-xl shadow p-6 border border-[#e0e7ef] hover:scale-[1.02] hover:shadow-lg transition-all duration-200";
  div.innerHTML = `
        <div>
        <div class="font-bold text-lg text-[#2563eb] mb-1 tracking-wide">${
          bus.nama
        }</div>
        <div class="text-gray-700 mb-1 flex items-center gap-2 text-sm">
          <i class="fa-solid fa-bus text-[#2563eb]"></i>
          <span>${bus.nomerBus}</span>
          <span class="mx-2">|</span>
          <i class="fa-solid fa-clock text-[#2563eb]"></i>
          <span>${bus.jam}</span>
        </div>
        <div class="text-gray-700 flex items-center gap-2 text-sm">
          <i class="fa-solid fa-money-bill-wave text-[#2563eb]"></i>
          <span class="font-semibold text-[#2563eb]">Rp${bus.harga.toLocaleString()}</span>
        </div>
        </div>
        <button class="pilih-bus-btn px-6 py-2 rounded-lg bg-[#2563eb] text-white font-semibold shadow hover:bg-[#1d4ed8] transition" data-id="${
          bus.id
        }">
        Pilih Bus
        </button>
      `;
  busList.appendChild(div);
});

// Pilih bus
let selectedBus = null;
let selectedSeat = null;
document.querySelectorAll(".pilih-bus-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    // Ambil data bus berdasarkan ID
    selectedBus = buses.find((b) => b.id == this.dataset.id);

    // Menyimpan data bus yang dipilih ke localStorage
    localStorage.setItem("selectedBus", JSON.stringify(selectedBus));

    // Menyimpan kursi yang dipilih ke localStorage setelah kursi dipilih
    if (selectedSeat) {
      localStorage.setItem("selectedSeat", selectedSeat);
    }

    // Debugging untuk memastikan data tersimpan dengan benar
    console.log("Selected Bus:", localStorage.getItem("selectedBus"));
    console.log("Selected Seat:", localStorage.getItem("selectedSeat"));

    // Menampilkan informasi bus yang dipilih
    document.getElementById("bus-info").innerHTML = `
      <span class="font-semibold text-[#2563eb]">${
        selectedBus.nama
      }</span> &bull; 
      <span>${selectedBus.nomerBus}</span> &bull; 
      <span>${selectedBus.jam}</span> &bull; 
      <span class="text-[#2563eb] font-semibold">Rp${selectedBus.harga.toLocaleString()}</span>
    `;

    // Tampilkan bagian kursi
    document.getElementById("seat-section").classList.remove("hidden");
    window.scrollTo({
      top: document.getElementById("seat-section").offsetTop - 40,
      behavior: "smooth",
    });

    generateSeats();
  });
});

// Generate kursi
// Generate kursi
function generateSeats() {
  const seatMap = document.getElementById("seat-map");
  seatMap.innerHTML = ""; // Menghapus kursi sebelumnya
  document.getElementById("lanjut-btn").disabled = true; // Pastikan tombol disabled saat pertama kali

  // 20 kursi, 4 per baris, 1 lorong
  for (let i = 1; i <= 20; i++) {
    const seatBtn = document.createElement("button");
    seatBtn.className =
      "w-12 h-12 rounded-xl border-2 border-[#2563eb] bg-white hover:bg-[#e0e7ef] font-bold text-[#2563eb] text-base transition shadow-lg flex items-center justify-center relative group";
    seatBtn.innerHTML = `
        <span class="z-10">${i}</span>
        <span class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition bg-[#2563eb]/10"></span>
        `;
    seatBtn.dataset.seat = i;
    seatBtn.addEventListener("click", function () {
      // Menghapus status yang dipilih dari semua kursi
      document.querySelectorAll("#seat-map button").forEach((b) => {
        b.classList.remove(
          "bg-[#2563eb]",
          "text-white",
          "ring-2",
          "ring-[#2563eb]",
          "scale-110"
        );
      });

      // Menandai kursi yang dipilih
      this.classList.add(
        "bg-[#2563eb]",
        "text-white",
        "ring-2",
        "ring-[#2563eb]",
        "scale-110"
      );
      selectedSeat = this.dataset.seat; // Menyimpan kursi yang dipilih

      // Menyimpan nomor kursi ke localStorage
      localStorage.setItem("selectedSeat", selectedSeat);

      // Mengaktifkan tombol lanjutkan setelah kursi dipilih
      document.getElementById("lanjut-btn").disabled = false;

      // Debugging untuk memastikan data tersimpan
      console.log("Selected Seat:", selectedSeat);
    });
    seatMap.appendChild(seatBtn);
  }
}

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
    window.location.href = `../pembayaran/pembayaran.html?${params.toString()}`;
  } else {
    console.log("Data bus atau kursi belum dipilih.");
  }
});
