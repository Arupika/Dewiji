<template>
  <div class="container py-5">
    <Transition name="fade" appear>
      <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
          <h1 class="fw-bold display-5">Rental Mobil Yogyakarta</h1>
          <p class="lead">
            Temukan mobil terbaik untuk kebutuhan perjalanan Anda di Jogja dan sekitarnya. Kami menyediakan berbagai pilihan mobil dengan harga terjangkau dan pelayanan terbaik.
          </p>
        </div>
      </div>
    </Transition>

    <Transition name="fade" appear>
      <div class="mb-4 container">
        <input
          type="text"
          class="form-control rounded-pill"
          placeholder="Cari mobil..."
          v-model="searchQuery"
        />
      </div>
    </Transition>

    <div v-if="loading" class="col-12 text-center py-5">
        <p class="lead">Memuat daftar mobil...</p>
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-else-if="allMobils.length === 0 && searchQuery === ''" class="col-12 text-center py-5">
        <p class="lead">Tidak ada mobil yang tersedia saat ini.</p>
    </div>
    <div v-else-if="filteredAndPaginatedMobils.length === 0 && searchQuery !== ''" class="col-12 text-center py-5">
        <p class="lead">Tidak ada mobil yang ditemukan sesuai dengan pencarian Anda.</p>
    </div>

    <TransitionGroup name="list" tag="div" class="row g-4 w-100">
      <div class="col-md-4" v-for="mobil in filteredAndPaginatedMobils" :key="mobil.id">
        <div class="card h-100 shadow-sm">
          <img
            v-if="mobil.gambar"
            :src="mobil.gambar"
            class="w-100 rounded-top"
            style="height: 200px; object-fit: cover;"
            :alt="mobil.nama"
            loading="lazy"
          />
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ mobil.nama }}</h5>

            <p class="card-text text-muted mb-2">
              <i class="bi bi-people-fill text-success me-1"></i> Kapasitas: {{ mobil.kapasitas }} Orang
            </p>

            <p class="card-text text-truncate">{{ mobil.deskripsi }}</p>

            <div class="mb-2">
              <h6 class="fw-bold">Fitur Utama:</h6>
              <span v-for="(fitur, i) in mobil.fitur" :key="i" class="badge bg-success bg-opacity-10 text-success me-2">{{ fitur }}</span>
            </div>

            <div v-if="mobil.harga" class="mb-2">
              <h6 class="fw-bold">Harga Sewa:</h6>
              <div class="d-flex justify-content-between">
                <span>Per Hari</span>
                <span class="fw-bold text-success">Rp {{ Number(mobil.harga).toLocaleString() }}</span>
              </div>
              <div v-if="mobil.harga12jam" class="d-flex justify-content-between">
                <span>12 Jam</span>
                <span class="fw-bold text-success">Rp {{ Number(mobil.harga12jam).toLocaleString() }}</span>
              </div>
            </div>

            <div class="mb-2">
              <h6 class="fw-bold">Termasuk:</h6>
              <ul class="list-unstyled">
                <li v-for="(item, i) in mobil.termasuk" :key="i">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>
          </div>

          <div class="card-footer bg-white text-center border-0 pt-0">
            <button class="btn btn-success btn-sm w-100" @click="showDetails(mobil)">
              <i class="bi bi-car-front me-2"></i>Sewa Sekarang
            </button>
          </div>
        </div>
      </div>
    </TransitionGroup>


    <Transition name="fade" appear>
      <div class="col-12 mt-4 d-flex justify-content-center" v-if="pagination.last_page > 1">
        <nav>
          <ul class="pagination">
            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
              <button class="page-link" @click="changePage(pagination.current_page - 1)">Sebelumnya</button>
            </li>
            <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="{ active: page === pagination.current_page }">
              <button class="page-link" @click="changePage(page)">{{ page }}</button>
            </li>
            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
              <button class="page-link" @click="changePage(pagination.current_page + 1)">Berikutnya</button>
            </li>
          </ul>
        </nav>
      </div>
    </Transition>

    <div
      class="modal fade"
      :class="{ 'show d-block': showModal }"
      tabindex="-1"
      role="dialog"
      aria-modal="true"
      :style="{
        backgroundColor: showModal ? 'rgba(0,0,0,0.5)' : '',
        zIndex: showModal ? 1060 : 'auto',
        overflowY: 'auto'
      }"
      v-if="showModal"
      @click.self="closeModal">

      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">{{ selectedMobil.nama }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <img
              :src="selectedMobil.gambar"
              class="w-100 rounded mb-3 modal-image"
              alt="Foto mobil"
            />

            <h5 class="fw-bold mb-3">{{ selectedMobil.nama }}</h5>
            <p class="text-muted">{{ selectedMobil.deskripsi }}</p>

            <div class="mb-3">
              <strong>Kapasitas Penumpang:</strong>
              <p class="mb-0"><i class="bi bi-people-fill text-success me-2"></i> {{ selectedMobil.kapasitas }} Orang</p>
            </div>

            <div class="mb-3">
              <strong>Fitur:</strong>
              <div class="d-flex flex-wrap gap-2 mt-1">
                <span v-for="(fitur, i) in selectedMobil.fitur" :key="i"
                  class="badge bg-success bg-opacity-10 text-success">{{ fitur }}</span>
              </div>
            </div>

            <div class="mb-3">
              <strong>Harga Sewa:</strong>
              <ul class="list-unstyled mt-2">
                <li class="d-flex justify-content-between">
                  <span>Per Hari:</span>
                  <span class="fw-bold text-success">Rp {{ Number(selectedMobil.harga).toLocaleString() }}</span>
                </li>
                <li v-if="selectedMobil.harga12jam" class="d-flex justify-content-between">
                  <span>12 Jam:</span>
                  <span class="fw-bold text-success">Rp {{ Number(selectedMobil.harga12jam).toLocaleString() }}</span>
                </li>
              </ul>
            </div>

            <div class="mb-3">
              <strong>Sudah Termasuk:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(item, i) in selectedMobil.termasuk" :key="i">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>

            <hr />
            <form @submit.prevent="submitBooking">
              <div class="mb-3">
                <label class="form-label fw-bold">Paket Penyewaan</label>
                <select class="form-select" v-model="bookingData.rentalPackage" @change="resetDuration" required>
                  <option value="Sewa Harian (24 Jam)">Sewa Harian (24 Jam)</option>
                  <option value="Sewa 12 Jam" v-if="selectedMobil.harga12jam">Sewa 12 Jam</option>
                  <option value="Sewa Mingguan">Sewa Mingguan</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Pengambilan</label>
                <input type="date" class="form-control" v-model="bookingData.tanggal" required />
              </div>

              <div class="mb-3" v-if="bookingData.rentalPackage !== 'Sewa 12 Jam'">
                <label class="form-label fw-bold">Durasi ({{ unitDuration }})</label>
                <input type="number" class="form-control" v-model="bookingData.duration" min="1" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Lokasi Pengambilan</label>
                <select class="form-select" v-model="bookingData.pickupLocation" required>
                  <option value="Kantor Dewiji (Jl. Ngiringsi, Sleman)">Kantor Dewiji (Jl. Ngiringsi, Sleman)</option>
                  <option value="Bandara YIA">Bandara YIA</option>
                  <option value="Stasiun Tugu">Stasiun Tugu</option>
                  <option value="Stasiun Lempuyangan">Stasiun Lempuyangan</option>
                  <option value="Lainnya (Tulis di Catatan)">Lainnya (Tulis di Catatan)</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" v-model="bookingData.nama" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Nomor WhatsApp</label>
                <input type="tel" class="form-control" v-model="bookingData.whatsapp" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Catatan</label>
                <textarea class="form-control" rows="2" v-model="bookingData.catatan"></textarea>
              </div>

              <hr class="my-4"> <h5 class="fw-bold text-center mb-3">Selesaikan Pembayaran Anda</h5>
              <div class="text-center mb-3">
                <QRCode
                  :value="qrPaymentText"
                  :size="200"
                  level="H"
                  class="mx-auto border p-2 rounded"
                />
              </div>
              <p class="text-center text-muted small mb-3">Scan QRIS ini untuk melakukan pembayaran.</p>

              <div class="text-center mb-4">
                  <p class="fw-bold mb-1">Atau Transfer Manual:</p>
                  <p class="mb-0">Bank: {{ bsiBankDetails.bankName }}</p>
                  <p class="mb-0">No. Rekening: {{ bsiBankDetails.accountNumber }}</p>
                  <p class="mb-0">A.N.: {{ bsiBankDetails.accountName }}</p>
                  <p class="mt-2 text-danger small">Mohon lakukan pembayaran sesuai Total Harga Estimasi.</p>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Total Harga Estimasi</label>
                <p class="form-control-plaintext fw-bold text-success display-6">
                  Rp {{ Number(calculatedPrice).toLocaleString('id-ID') }}
                </p>
              </div>

              <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2">
                <i class="bi bi-whatsapp me-2"></i>Konfirmasi Pemesanan via WhatsApp
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="bg-dark text-light pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Tentang Kami</h5>
          <p class="small"><strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman dengan harga yang cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan sekitarnya.</p>
        </div>

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
              <router-link to="/Comment" class="text-light text-decoration-none hover-success">FAQ</router-link>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Sosial Media</h5>
          <p class="small">Ikuti kami di media sosial untuk mendapatkan penawaran terbaik!</p>
          <div class="d-flex gap-3">
            <a href="https://www.facebook.com/dewiji" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.tiktok.com/@segawo.n.lanang" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-tiktok"></i>
            </a>
            <a href="https://www.instagram.com/_irzha_" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="https://wa.me/6281348680937" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-whatsapp"></i>
            </a>
          </div>
        </div>
      </div>
      <hr class="my-4 bg-secondary">
    </div>
  </footer>
</template>

<script setup>

 // --- Impor Modul ---
import { ref, onMounted, watch, computed } from 'vue' // Fungsi inti Vue.
import api from '@/api' // Konfigurasi Axios untuk request API.
import Swal from 'sweetalert2' // Import library untuk notifikasi pop-up
import QRCode from 'qrcode.vue' // Komponen untuk men-generate QR Code.

// --- State (Data Reaktif) ---
const allMobils = ref([]) // Menyimpan SEMUA data mobil dari API. Paginasi akan dilakukan di frontend.
const loading = ref(true) // Status untuk menampilkan/menyembunyikan spinner loading.
const currentPage = ref(1) // Menyimpan nomor halaman yang sedang aktif.
const itemsPerPage = 6; // Menentukan berapa banyak item yang ditampilkan per halaman.

const showModal = ref(false) // Status untuk menampilkan/menyembunyikan modal.
const selectedMobil = ref({}) // Menyimpan data mobil yang dipilih.
const searchQuery = ref('') // Menyimpan teks dari input pencarian.

// Objek untuk menampung data dari form booking.
const bookingData = ref({
  rentalPackage: 'Sewa Harian (24 Jam)',
  tanggal: '',
  duration: 1,
  pickupLocation: 'Kantor Dewiji (Jl. Ngiringsi, Sleman)',
  nama: '',
  whatsapp: '',
  catatan: ''
})

// ===============================================================
// Data untuk QR Pembayaran (QRIS dan BSI)
// PENTING: Ganti nilai ini dengan string QRIS ASLI Anda.
// Jika Anda tidak memiliki string QRIS, Anda bisa menggunakan nomor rekening bank.
const qrPaymentText = ref('7213052386'); // <--- GANTI DENGAN STRING QRIS ASLI ATAU INFO REKENING BSI ANDA

const bsiBankDetails = {
  bankName: 'Bank Syariah Indonesia (BSI)',
  accountNumber: '7213052386', // Ganti dengan nomor rekening BSI Anda
  accountName: 'irzha fahrizaldy' // Ganti dengan nama rekening BSI Anda
}
// ===============================================================

// --- Logika Utama (Computed Property) ---
// // Computed property untuk menentukan satuan durasi (hari/minggu).
const unitDuration = computed(() => {
  return bookingData.value.rentalPackage === 'Sewa Mingguan' ? 'minggu' : 'hari';
});

// Computed property untuk menghitung total harga secara otomatis.
const calculatedPrice = computed(() => {
  let total = 0;

  if (!selectedMobil.value || (!selectedMobil.value.harga && !selectedMobil.value.harga12jam)) {
    return 0;
  }

  // Mengubah string harga menjadi angka, menghapus pemisah ribuan
  const hargaPerHari = parseFloat(String(selectedMobil.value.harga).replace(/\./g, '')) || 0;
  const harga12Jam = parseFloat(String(selectedMobil.value.harga12jam).replace(/\./g, '')) || 0;

  const duration = bookingData.value.duration || 1;

  switch (bookingData.value.rentalPackage) {
    case 'Sewa Harian (24 Jam)':
      total = duration * hargaPerHari;
      break;
    case 'Sewa 12 Jam':
      total = harga12Jam;
      break;
    case 'Sewa Mingguan':
      total = duration * 7 * hargaPerHari; // Durasi dalam minggu * 7 hari/minggu * harga_harian
      break;
    default:
      total = 0;
      break;
  }

  return Math.max(0, total);
});


// Fungsi untuk mereset durasi menjadi 1 saat paket sewa diganti.
const resetDuration = () => {
  bookingData.value.duration = 1;
};

// Fungsi untuk mengambil SEMUA data mobil dari API.
const fetchAllMobils = async () => {
  loading.value = true; // Tampilkan loading spinner
  try {
    // Panggil API untuk mengambil semua data (contoh: dengan parameter `per_page=all`).
    const res = await api.get('/api/mobils?per_page=all');
    // Asumsi: respons API mengembalikan array data di `res.data.data`
    allMobils.value = res.data.data; // Simpan semua data ke state 'allMobils'.
  } catch (err) {
    // Tangani error jika gagal.
    console.error('Gagal fetch semua mobil:', err);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Memuat Mobil',
      text: 'Terjadi kesalahan saat mengambil data mobil. Mohon coba lagi.'
    });
    allMobils.value = [];
  } finally {
    // Blok ini akan selalu berjalan, baik berhasil maupun gagal.
    loading.value = false; // Sembunyikan loading spinner.
  }
}

// Computed property untuk memfilter DAN memaginasi data di frontend.
const filteredAndPaginatedMobils = computed(() => {
  const query = searchQuery.value.toLowerCase().trim();

  // 1. Filter: Saring semua data di `allMobils` berdasarkan `searchQuery`.
  const filtered = allMobils.value.filter(mobil =>
    mobil.nama.toLowerCase().includes(query) ||
    (mobil.deskripsi && mobil.deskripsi.toLowerCase().includes(query)) ||
    // Pastikan `fitur` adalah array di data Anda agar `.some()` berfungsi
    (mobil.fitur && Array.isArray(mobil.fitur) && mobil.fitur.some(fitur => fitur.toLowerCase().includes(query)))
  );

  // 2. Paginasi: Ambil sebagian data dari hasil filter sesuai halaman saat ini.
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return filtered.slice(startIndex, endIndex);
});

// NEW: Computed property untuk informasi paginasi di frontend
const pagination = computed(() => {
  const query = searchQuery.value.toLowerCase().trim();
  const filtered = allMobils.value.filter(mobil =>
    mobil.nama.toLowerCase().includes(query) ||
    (mobil.deskripsi && mobil.deskripsi.toLowerCase().includes(query)) ||
    (mobil.fitur && Array.isArray(mobil.fitur) && mobil.fitur.some(fitur => fitur.toLowerCase().includes(query)))
  );
  const totalItems = filtered.length;
  const lastPage = Math.ceil(totalItems / itemsPerPage);

  return {
    current_page: currentPage.value,
    last_page: lastPage,
    total: totalItems
  };
});

// Fungsi untuk membuka modal dan mereset form ke nilai default.
const showDetails = (mobil) => {
  selectedMobil.value = mobil
  showModal.value = true

  // Set default date to tomorrow
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  bookingData.value.tanggal = tomorrow.toISOString().split('T')[0];

  // Set default values for new fields (reset saat modal dibuka)
  bookingData.value.rentalPackage = 'Sewa Harian (24 Jam)';
  bookingData.value.duration = 1;
  bookingData.value.pickupLocation = 'Kantor Dewiji (Jl. Ngiringsi, Sleman)';
  bookingData.value.nama = '';
  bookingData.value.whatsapp = '';
  bookingData.value.catatan = '';


  document.body.classList.add('modal-open');
  document.body.style.overflow = 'hidden';
}

// Fungsi untuk menutup modal.
const closeModal = () => {
  showModal.value = false;
  document.body.classList.remove('modal-open');
  document.body.style.overflow = '';
}

// Fungsi untuk berpindah halaman (paginasi).
const changePage = (page) => {
  if (page !== currentPage.value && page > 0 && page <= pagination.value.last_page) {
    currentPage.value = page // Cukup ubah nomor halaman saat ini, tidak perlu panggil API lagi.
  }
}

// Fungsi yang dijalankan saat form booking di-submit.
const submitBooking = () => {
  const durationText = bookingData.value.rentalPackage !== 'Sewa 12 Jam'
    ? `Durasi: ${bookingData.value.duration} ${unitDuration.value}\n`
    : '';

  const message = `Halo Dewiji Explore, saya telah melakukan pemesanan sewa mobil:

🚗 Mobil: ${selectedMobil.value.nama}
📦 Paket Penyewaan: ${bookingData.value.rentalPackage}
📅 Tanggal Pengambilan: ${bookingData.value.tanggal}
${durationText}
💰 Total Harga Estimasi: Rp ${Number(calculatedPrice.value).toLocaleString('id-ID')}
📍 Lokasi Pengambilan: ${bookingData.value.pickupLocation}
👤 Nama: ${bookingData.value.nama}
📱 WhatsApp: ${bookingData.value.whatsapp}
${selectedMobil.value.termasuk && selectedMobil.value.termasuk.length ? `✅ Termasuk: ${selectedMobil.value.termasuk.join(', ')}\n` : ''}
${selectedMobil.value.deskripsi ? `📝 Deskripsi Mobil: ${selectedMobil.value.deskripsi}\n` : ''}
${selectedMobil.value.fitur && selectedMobil.value.fitur.length ? `✨ Fitur: ${selectedMobil.value.fitur.join(', ')}\n` : ''}
${bookingData.value.catatan ? `✏️ Catatan: ${bookingData.value.catatan}` : ''}

Saya sudah melakukan pembayaran melalui ${bsiBankDetails.bankName} (${bsiBankDetails.accountNumber} A.N. ${bsiBankDetails.accountName}) atau QRIS. Mohon konfirmasi pemesanan saya. Terima kasih.
`;

  const encoded = encodeURIComponent(message)
  window.open(`https://wa.me/6281348680937?text=${encoded}`, '_blank')

  // Tampilkan notifikasi bahwa pesanan berhasil dan user harus konfirmasi via WA.
  Swal.fire({
    title: 'Pemesanan Berhasil!',
    text: 'Mohon lanjutkan konfirmasi pemesanan Anda via WhatsApp.',
    icon: 'success',
    confirmButtonText: 'Oke',
    allowOutsideClick: false
  }).then(() => {
    closeModal(); // Tutup modal setelah user menekan 'Oke'.
  });
}

// OLD: onMounted(() => fetchMobils())
// NEW: Panggil fetchAllMobils()
onMounted(() => fetchAllMobils())

// NEW: Watcher untuk mereset halaman ke 1 setiap kali query pencarian berubah
watch(searchQuery, () => {
  currentPage.value = 1; // Jika user mulai mengetik, reset ke halaman 1.
});

// Mengawasi perubahan pada 'showModal'.
watch(showModal, (newValue) => {
  if (!newValue) {
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
  }
}, { immediate: true });
</script>

<style scoped>
/* Aturan untuk animasi fade saat elemen muncul/hilang. */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Aturan untuk animasi daftar kartu mobil. */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px); /* // Efek muncul dari bawah. */
}

 /* // Aturan khusus untuk item yang keluar dari daftar agar animasi mulus. */
.list-leave-active {
  position: absolute;
}

.list-move {
  transition: transform 0.5s ease;
}

/* // Aturan untuk mencegah body bisa di-scroll saat modal terbuka. */
body.modal-open {
  overflow: hidden !important;
  /* padding-right: var(--bs-modal-padding) !important;  Aktifkan jika ada isu scrollbar */
}

/* // Mengatur gaya gambar di dalam modal. */
.modal-image {
  width: 100%;
  height: 200px;
  object-fit: contain;
  background-color: #f0f0f0;
}

/* // Memberi efek hover pada link di footer. */
.hover-success:hover {
  color: #198754 !important; /* Warna hijau success Bootstrap */
}
</style>