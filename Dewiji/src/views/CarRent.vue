<template>
  <div class="container py-5">
    <!-- Hero Section -->
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1 class="mb-4 fw-bold display-5">Rental Mobil Yogyakarta</h1>
          <p class="lead">
            Temukan mobil terbaik untuk kebutuhan perjalanan Anda di Jogja dan sekitarnya.
            Kami menyediakan berbagai pilihan mobil dengan harga terjangkau dan pelayanan terbaik.
          </p>
        </div>
      </div>
    </div>

    <!-- Car Rental Cards -->
    <div class="row g-4">
      <div class="col-md-4" v-for="(mobil, index) in daftarMobil" :key="index">
        <div class="card h-100 shadow-sm">
          <div class="card-img-top">
            <img
              :src="mobil.gambar"
              class="w-100 rounded-top"
              style="height: 200px; object-fit: cover;"
              :alt="mobil.nama"
            />
          </div>
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ mobil.nama }}</h5>

            <div class="mb-3">
              <span
                class="badge bg-success bg-opacity-10 text-success me-2"
                v-for="(fitur, i) in mobil.fitur"
                :key="i"
              >
                {{ fitur }}
              </span>
            </div>

            <p class="card-text small">{{ mobil.deskripsi }}</p>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Harga Sewa:</h6>
              <div class="d-flex justify-content-between">
                <span>Per Hari:</span>
                <span class="text-success fw-bold">Rp {{ mobil.harga.toLocaleString() }}</span>
              </div>
              <div class="d-flex justify-content-between" v-if="mobil.harga12jam">
                <span>12 Jam:</span>
                <span class="text-success fw-bold">Rp {{ mobil.harga12jam.toLocaleString() }}</span>
              </div>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Termasuk:</h6>
              <ul class="list-unstyled small">
                <li v-for="item in mobil.termasuk" :key="item" class="mb-1">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>
          </div>
          <div class="card-footer bg-white border-top-0 text-center pt-0">
            <button
              class="btn btn-success w-100 rounded-pill fw-bold"
              @click="showDetails(mobil)"
            >
              <i class="bi bi-car-front me-2"></i>Sewa Sekarang
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Booking Modal -->
    <div
      v-if="selectedMobil"
      class="modal fade show"
      tabindex="-1"
      style="display: block; background: rgba(0,0,0,0.5)"
      aria-modal="true"
      role="dialog"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">{{ selectedMobil.nama }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <img
                :src="selectedMobil.gambar"
                class="img-fluid rounded"
                style="max-height: 200px"
                :alt="selectedMobil.nama"
              />
            </div>

            <div class="mb-4">
              <h6 class="fw-bold border-bottom pb-2">Detail Penyewaan</h6>
              <div class="row">
                <div class="col-6 mb-2">
                  <span class="text-muted small">Harga/hari</span>
                  <div class="fw-bold">Rp {{ selectedMobil.harga.toLocaleString() }}</div>
                </div>
                <div class="col-6 mb-2" v-if="selectedMobil.harga12jam">
                  <span class="text-muted small">Harga 12 jam</span>
                  <div class="fw-bold">Rp {{ selectedMobil.harga12jam.toLocaleString() }}</div>
                </div>
                <div class="col-12 mb-2">
                  <span class="text-muted small">Kapasitas</span>
                  <div class="fw-bold">{{ selectedMobil.kapasitas }} orang</div>
                </div>
              </div>
            </div>

            <form @submit.prevent="submitOrder">
              <div class="mb-3">
                <label class="form-label fw-bold">Paket Penyewaan</label>
                <select class="form-select" v-model="paketSewa" required>
                  <option value="harian">Sewa Harian (24 Jam)</option>
                  <option value="12jam" v-if="selectedMobil.harga12jam">Sewa 12 Jam</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Pengambilan</label>
                <input type="date" class="form-control" v-model="pickupDate" required />
              </div>

              <div class="mb-3" v-if="paketSewa === 'harian'">
                <label class="form-label fw-bold">Durasi (hari)</label>
                <input type="number" class="form-control" v-model="duration" min="1" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Lokasi Pengambilan</label>
                <select class="form-select" v-model="lokasiAmbil" required>
                  <option value="kantor">Kantor Dewiji (Jl. Ngiringsi, Sleman)</option>
                  <option value="bandara">Bandara Adisucipto</option>
                  <option value="stasiun">Stasiun Tugu</option>
                  <option value="hotel">Hotel (wilayah Jogja)</option>
                </select>
              </div>

              <!-- Input Nomor WhatsApp -->
              <div class="mb-3">
                <label class="form-label fw-bold">Nomor WhatsApp</label>
                <input
                  type="tel"
                  class="form-control"
                  placeholder="0812xxxxxxx"
                  v-model="customerPhone"
                  required
                />
              </div>

              <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold">
                <i class="bi bi-whatsapp me-2"></i>Konfirmasi Pemesanan
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Section -->
  <footer class="bg-dark text-light pt-5 pb-4 mt-5">
    <div class="container text-center">
      <small>&copy; 2025 Rental Mobil Yogyakarta. All rights reserved.</small>
    </div>
  </footer>
</template>

<script>
import { ref } from "vue";
import Swal from "sweetalert2";

// Contoh gambar (ganti dengan path yang sesuai di proyekmu)
import avanza from "@/assets/avanza.png";
import xenia from "@/assets/xenia.png";
import innova from "@/assets/innova.png";
import brio from "@/assets/brio.png";
import calya from "@/assets/calya.png";
import alphard from "@/assets/alphard.png";

export default {
  setup() {
    const daftarMobil = [
      {
        nama: "Toyota Avanza",
        deskripsi: "Mobil keluarga yang nyaman dan irit bahan bakar.",
        harga: 350000,
        harga12jam: 200000,
        kapasitas: 7,
        fitur: ["AC", "MP3 Player", "Driver"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: avanza,
      },
      {
        nama: "Daihatsu Xenia",
        deskripsi: "Cocok untuk perjalanan jarak jauh dan keluarga kecil.",
        harga: 330000,
        harga12jam: 190000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: xenia,
      },
      {
        nama: "Toyota Innova",
        deskripsi: "Lebih luas dan nyaman untuk perjalanan bisnis atau keluarga.",
        harga: 550000,
        harga12jam: 300000,
        kapasitas: 8,
        fitur: ["AC", "Audio", "Driver", "GPS"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: innova,
      },
      {
        nama: "Honda Brio",
        deskripsi: "Mobil kecil, lincah, dan irit untuk dalam kota.",
        harga: 280000,
        kapasitas: 5,
        fitur: ["AC", "Audio"],
        termasuk: ["Bensin", "Asuransi"],
        gambar: brio,
      },
      {
        nama: "Toyota Calya",
        deskripsi: "Ekonomis dengan kapasitas 7 orang, cocok untuk keluarga.",
        harga: 320000,
        harga12jam: 180000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: calya,
      },
      {
        nama: "Toyota Alphard",
        deskripsi: "Mobil mewah untuk perjalanan eksklusif dan VIP.",
        harga: 1500000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver", "TV"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: alphard,
      },
    ];

    const selectedMobil = ref(null);
    const duration = ref(1);
    const pickupDate = ref("");
    const paketSewa = ref("harian");
    const lokasiAmbil = ref("kantor");
    const customerPhone = ref("");

    const showDetails = (mobil) => {
      selectedMobil.value = mobil;
      // Set tanggal pengambilan default besok hari
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      pickupDate.value = tomorrow.toISOString().split("T")[0];
      // Reset form lain
      duration.value = 1;
      paketSewa.value = "harian";
      lokasiAmbil.value = "kantor";
      customerPhone.value = "";
    };

    const closeModal = () => {
      selectedMobil.value = null;
      duration.value = 1;
      pickupDate.value = "";
      paketSewa.value = "harian";
      lokasiAmbil.value = "kantor";
      customerPhone.value = "";
    };

    // Fungsi untuk mengubah nomor HP ke format 62...
    const formatPhoneNumber = (phone) => {
      let cleaned = phone.replace(/\D/g, "");
      if (cleaned.startsWith("0")) {
        cleaned = "62" + cleaned.substring(1);
      }
      if (!cleaned.startsWith("62")) {
        cleaned = "62" + cleaned;
      }
      return cleaned;
    };

    // Fungsi untuk mengubah kode lokasi jadi text deskriptif
    const getLokasiText = (value) => {
      switch (value) {
        case "bandara":
          return "Bandara Adisucipto";
        case "stasiun":
          return "Stasiun Tugu";
        case "hotel":
          return "Kantor Dewiji Hotel (wilayah Jogja)";
        default:
          return "Kantor Dewiji (Jl. Ngiringsi, Sleman)";
      }
    };

    const submitOrder = () => {
      if (!customerPhone.value) {
        Swal.fire("Error", "Nomor WhatsApp harus diisi!", "error");
        return;
      }
      const phone = formatPhoneNumber(customerPhone.value);

      const mobil = selectedMobil.value.nama;
      const paket = paketSewa.value === "harian" ? "Sewa Harian (24 Jam)" : "Sewa 12 Jam";
      const tanggal = pickupDate.value;
      const durasiText = paketSewa.value === "harian" ? `${duration.value} hari` : "12 jam";
      const lokasi = getLokasiText(lokasiAmbil.value);

      const pesan =
        `Halo, saya ingin memesan mobil:\n` +
        `Mobil: *${mobil}*\n` +
        `Paket: *${paket}*\n` +
        `Tanggal Pengambilan: *${tanggal}*\n` +
        `Durasi: *${durasiText}*\n` +
        `Lokasi Pengambilan: *${lokasi}*\n` +
        `Nomor WA: +${phone}\n` +

        `Mohon info lebih lanjut untuk proses penyewaan Terima kasih!`;
      const encodedPesan = encodeURIComponent(pesan);
      const waUrl = `https://wa.me/${phone}?text=${encodedPesan}`;

      window.open(waUrl, "_blank");
      closeModal();
    };

    return {
      daftarMobil,
      selectedMobil,
      duration,
      pickupDate,
      paketSewa,
      lokasiAmbil,
      customerPhone,
      showDetails,
      closeModal,
      submitOrder,
    };
  },
};
</script>

<style scoped>
/* Tambahan opsional styling agar modal dan card lebih rapih */

.modal-content {
  border-radius: 1rem;
}

.btn-close {
  background: none;
  border: none;
  font-size: 1.2rem;
}

.card-title {
  font-size: 1.25rem;
}

.card-footer .btn {
  font-size: 1.1rem;
}

/* Scroll modal body jika konten terlalu panjang */
.modal-body {
  max-height: 70vh;
  overflow-y: auto;
}
</style>
