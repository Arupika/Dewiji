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
          <div class="modal-header border-0 position-relative">
            <h5 class="modal-title fw-bold">{{ selectedMobil.nama }}</h5>
            <button 
              type="button" 
              class="btn-close position-absolute top-0 end-0 m-3" 
              @click="closeModal" 
              aria-label="Close"
              style="font-size: 1.5rem; opacity: 1;"
            >
              <i class="bi bi-x-lg"></i>
            </button>
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

              <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Nama Anda"
                  v-model="customerName"
                  required
                />
              </div>

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
  <footer class="bg-dark text-light pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <!-- Tentang Kami -->
        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Tentang Kami</h5>
          <p class="small"><strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman dengan harga yang cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan sekitarnya.</p>
        </div>
        
        <!-- Kontak Kami -->
        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Kontak Kami</h5>
          <ul class="list-unstyled small">
            <li class="mb-2">
              <i class="bi bi-geo-alt-fill text-success me-2"></i>
              Jl. Ngiringsi, Sleman, Yogyakarta 12345
            </li>
            <li class="mb-2">
              <i class="bi bi-telephone-fill text-success me-2"></i>
              081212344321
            </li>
            <li class="mb-2">
              <i class="bi bi-envelope-fill text-success me-2"></i>
              yogyakartaDewiji@gmail.com
            </li>
          </ul>
        </div>
        
        <!-- Navigasi -->
<div class="col-lg-3 col-md-6">
  <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Navigasi</h5>
  <ul class="list-unstyled small">
    <li class="mb-2">
      <router-link to="/" class="text-light text-decoration-none hover-success">Home</router-link>
    </li>
    <li class="mb-2">
      <router-link to="/Destination" class="text-light text-decoration-none hover-success">Destinasi</router-link>
    </li>
    <li class="mb-2">
      <router-link to="/CarRent" class="text-light text-decoration-none hover-success">Rental Mobil</router-link>
    </li>
    <li class="mb-2">
      <router-link to="/Package" class="text-light text-decoration-none hover-success">Paket Liburan</router-link>
    </li>
    <li class="mb-2">
      <router-link to="/Comment" class="text-light text-decoration-none hover-success">Kritik & Saran</router-link>
    </li>
  </ul>
</div>

        
       <!-- Sosial Media -->
<div class="col-lg-3 col-md-6">
  <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Sosial Media</h5>
  <p class="small">Ikuti kami di media sosial untuk mendapatkan penawaran terbaik!</p>
  <div class="d-flex gap-3">
    <!-- GANTI BAGIAN INI -->
    <a href="https://www.facebook.com/namapagekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
      <i class="bi bi-facebook"></i>
    </a>
    <!-- GANTI BAGIAN INI -->
    <a href="https://www.tiktok.com/@usernamekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
      <i class="bi bi-tiktok"></i>
    </a>
    <!-- GANTI BAGIAN INI -->
    <a href="https://www.instagram.com/usernamekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
      <i class="bi bi-instagram"></i>
    </a>
    <!-- GANTI BAGIAN INI -->
    <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
      <i class="bi bi-whatsapp"></i>
    </a>
  </div>
</div>

      </div>
      
      <hr class="my-4 bg-secondary">
      
    </div>
  </footer>
</template>

<script>
import { ref } from "vue";
import Swal from "sweetalert2";

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
        gambar: "https://www.toyota.astra.co.id//sites/default/files/2023-09/1-avanza-purplish-silver.png",
      },
      {
        nama: "Daihatsu Xenia",
        deskripsi: "Cocok untuk perjalanan jarak jauh dan keluarga kecil.",
        harga: 330000,
        harga12jam: 190000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: "https://images.prod.seva.id/Daihatsu/All%20New%20Xenia/main_color/black.png",
      },
      {
        nama: "Toyota Innova",
        deskripsi: "Lebih luas dan nyaman untuk perjalanan bisnis atau keluarga.",
        harga: 550000,
        harga12jam: 300000,
        kapasitas: 8,
        fitur: ["AC", "Audio", "Driver", "GPS"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: "https://www.toyota.astra.co.id//sites/default/files/2020-10/1_innova-super-white-2_0.png",
      },
      {
        nama: "Honda Brio",
        deskripsi: "Mobil kecil, lincah, dan irit untuk dalam kota.",
        harga: 280000,
        kapasitas: 5,
        fitur: ["AC", "Audio"],
        termasuk: ["Bensin", "Asuransi"],
        gambar: "https://jwc.gotra-resources.my.id/web-upload/1676866724-20-02-2023-wHgIW1mLxjUFdlpQD79yK2JMVuCEofes.png",
      },
      {
        nama: "Toyota Calya",
        deskripsi: "Ekonomis dengan kapasitas 7 orang, cocok untuk keluarga.",
        harga: 320000,
        harga12jam: 180000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: "https://static.wixstatic.com/media/261cbb_71a664430e3e4c5ab31469fde51d82d6~mv2.png/v1/fill/w_688,h_408,al_c,q_85,enc_avif,quality_auto/261cbb_71a664430e3e4c5ab31469fde51d82d6~mv2.png",
      },
      {
        nama: "Toyota Alphard",
        deskripsi: "Mobil mewah untuk perjalanan eksklusif dan VIP.",
        harga: 1500000,
        kapasitas: 7,
        fitur: ["AC", "Audio", "Driver", "TV"],
        termasuk: ["Bensin", "Driver", "Asuransi"],
        gambar: "https://arinatoyota.co.id/wp-content/uploads/2018/11/vellfire-2021-colors-black-1-600x330.png",
      },
    ];

    const selectedMobil = ref(null);
    const duration = ref(1);
    const pickupDate = ref("");
    const paketSewa = ref("harian");
    const lokasiAmbil = ref("kantor");
    const customerName = ref("");
    const customerPhone = ref("");
    const adminPhone = "6281234567890"; // Ganti dengan nomor admin yang benar

    const showDetails = (mobil) => {
      selectedMobil.value = mobil;
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      pickupDate.value = tomorrow.toISOString().split("T")[0];
      duration.value = 1;
      paketSewa.value = "harian";
      lokasiAmbil.value = "kantor";
      customerName.value = "";
      customerPhone.value = "";
    };

    const closeModal = () => {
      selectedMobil.value = null;
      duration.value = 1;
      pickupDate.value = "";
      paketSewa.value = "harian";
      lokasiAmbil.value = "kantor";
      customerName.value = "";
      customerPhone.value = "";
    };

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

    const getLokasiText = (value) => {
      switch (value) {
        case "bandara":
          return "Bandara Adisucipto";
        case "stasiun":
          return "Stasiun Tugu";
        case "hotel":
          return "Hotel (wilayah Jogja)";
        default:
          return "Kantor Dewiji (Jl. Ngiringsi, Sleman)";
      }
    };

    const submitOrder = () => {
      if (!customerName.value || !customerPhone.value) {
        Swal.fire("Error", "Nama dan nomor WhatsApp harus diisi!", "error");
        return;
      }
      
      const phone = formatPhoneNumber(customerPhone.value);

      const mobil = selectedMobil.value.nama;
      const paket = paketSewa.value === "harian" ? "Sewa Harian (24 Jam)" : "Sewa 12 Jam";
      const tanggal = pickupDate.value;
      const durasiText = paketSewa.value === "harian" ? `${duration.value} hari` : "12 jam";
      const lokasi = getLokasiText(lokasiAmbil.value);

      const pesan =
        `Halo, saya *${customerName.value}* ingin memesan mobil:\n` +
        `• Mobil: *${mobil}*\n` +
        `• Paket: *${paket}*\n` +
        `• Tanggal Pengambilan: *${tanggal}*\n` +
        `• Durasi: *${durasiText}*\n` +
        `• Lokasi Pengambilan: *${lokasi}*\n` +
        `• Nama Pemesan: *${customerName.value}*\n` +
        `• Nomor WA: +${phone}\n\n` +
        `Mohon info lebih lanjut untuk proses penyewaan. Terima kasih!`;

      const encodedPesan = encodeURIComponent(pesan);
      const waUrl = `https://wa.me/${adminPhone}?text=${encodedPesan}`;

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
      customerName,
      customerPhone,
      showDetails,
      closeModal,
      submitOrder,
    };
  },
};
</script>

<style scoped>

.display-5 {
  font-size: 2.5rem; /* Slightly smaller display heading */
  color: #343a40; /* Dark grey text */
}

.lead {
  font-size: 1.1rem;
  color: #6c757d;
}

/* Car Rental Cards */
.row.g-4 {
  margin-top: 1rem;
}

.col-md-4 {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Added transition */
}

.col-md-4:hover {
  transform: translateY(-5px); /* Slight vertical lift on hover */
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Subtle shadow on hover */
}

.card {
  border: none;
}

.card-img-top {
  border-radius: 0.5rem 0.5rem 0 0;
  overflow: hidden; /* Ensure image doesn't overflow rounded corners */
}

.card-body {
  padding: 1.5rem;
}

.card-title {
  font-size: 1.1rem; /* Slightly smaller card title */
  color: #212529; /* Darker text */
  margin-bottom: 0.75rem;
}

.badge {
  font-size: 0.8rem;
  padding: 0.3rem 0.6rem;
  border-radius: 0.25rem;
  margin-right: 0.3rem;
}

.card-text {
  color: #495057;
  margin-bottom: 1rem;
}

.fw-bold.mb-2 {
  color: #343a40;
}

.text-success.fw-bold {
  color: #28a745 !important; /* Ensure success color overrides */
}

.list-unstyled i {
  margin-right: 0.5rem;
}

.card-footer {
  padding: 1rem 1.5rem;
  background-color: transparent;
}

.card-footer .btn {
  font-size: 1rem;
  padding: 0.75rem 1.5rem;
}

/* Booking Modal */
.modal-content {
  border-radius: 1rem;
  border: none;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
}

.modal-header {
  padding: 1.5rem 2rem;
  border-bottom: 1px solid #dee2e6;
}

.modal-title {
  font-size: 1.25rem;
  color: #343a40;
}

.btn-close {
  opacity: 0.7;
}

.btn-close:hover {
  opacity: 1;
}

.modal-body {
  padding: 2rem;
  max-height: 70vh;
  overflow-y: auto;
}

.border-bottom {
  border-bottom: 2px solid #007bff !important; /* Accent color for the detail section */
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
}

.text-muted.small {
  color: #6c757d !important;
}

.form-label.fw-bold {
  color: #343a40;
  margin-bottom: 0.5rem;
}

.form-select,
.form-control {
  margin-bottom: 1rem;
  border-radius: 0.3rem;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.btn-success:hover {
  background-color: #218838;
  border-color: #1e7e34;
}


.text-light {
  color: #f8f9fa !important;
}

.footer small {
  font-size: 0.9rem;
}
</style>