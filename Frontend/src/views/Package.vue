<template>
  <div class="container py-5">
    <Transition name="fade" appear>
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1 class="mb-4 fw-bold display-5">Pilih Paket Liburan</h1>
          <p class="lead">Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan. Tentunya kamu masih bisa custom paket wisata!</p>
        </div>
      </div>
    </Transition>

    <Transition name="fade" appear>
      <div class="mb-4 container">
        <input
          type="text"
          class="form-control rounded-pill"
          placeholder="Cari paket liburan..."
          v-model="searchQuery"
        />
      </div>
    </Transition>

    <div v-if="loading" class="col-12 text-center py-5">
        <p class="lead">Memuat daftar paket...</p>
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div v-else-if="allTrips.length === 0 && searchQuery === ''" class="col-12 text-center py-5">
        <p class="lead">Tidak ada paket liburan yang tersedia saat ini.</p>
    </div>
    <div v-else-if="filteredAndPaginatedTrips.length === 0 && searchQuery !== ''" class="col-12 text-center py-5">
        <p class="lead">Tidak ada paket yang ditemukan sesuai dengan pencarian Anda.</p>
    </div>

    <TransitionGroup name="list" tag="div" class="row g-4 w-100">
      <div class="col-md-4" v-for="(trip, index) in filteredAndPaginatedTrips" :key="trip.id">
        <div class="card h-100 shadow-sm">
          <img :src="trip.gambar || 'https://via.placeholder.com/400x300?text=No+Image'" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" />
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ trip.nama || `Paket ${index + 1}` }}</h5>

            <div class="mb-3">
              <span class="badge bg-success bg-opacity-10 text-success me-2"
                v-for="(dest, i) in (trip.destinasi || []).slice(0, 2)" :key="i">
                {{ dest.split(',')[0] }}
              </span>
              <span v-if="(trip.destinasi || []).length > 2" class="badge bg-secondary bg-opacity-10 text-secondary">
                +{{ trip.destinasi.length - 2 }} lainnya
              </span>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Harga:</h6>
              <div v-for="(hargaItem, i) in (trip.harga || [])" :key="i" class="d-flex justify-content-between mb-1">
                <span>{{ hargaItem.tipe || 'Harga' }}:</span>
                <span>
                  <del v-if="hargaItem.lama" class="text-muted small me-2">{{ hargaItem.lama }}</del>
                  <strong class="text-success">{{ hargaItem.diskon || 'N/A' }}</strong>
                </span>
              </div>
            </div>

            <div class="mb-3" v-if="(trip.termasuk || []).length > 0">
              <h6 class="fw-bold mb-1">Termasuk:</h6>
              <ul class="list-unstyled mb-0 ms-3">
                <li v-for="(item, i) in (trip.termasuk || []).slice(0, 2)" :key="i" class="small">
                  <i class="bi bi-check-circle-fill text-success me-1"></i>{{ item }}
                </li>
                <li v-if="(trip.termasuk || []).length > 2" class="small text-muted">
                  +{{ trip.termasuk.length - 2 }} lainnya
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="(trip.tidak_termasuk || []).length > 0">
              <h6 class="fw-bold mb-1">Tidak Termasuk:</h6>
              <ul class="list-unstyled mb-0 ms-3">
                <li v-for="(item, i) in (trip.tidak_termasuk || []).slice(0, 2)" :key="i" class="small">
                  <i class="bi bi-x-circle-fill text-danger me-1"></i>{{ item }}
                </li>
                <li v-if="(trip.tidak_termasuk || []).length > 2" class="small text-muted">
                  +{{ trip.tidak_termasuk.length - 2 }} lainnya
                </li>
              </ul>
            </div>

            <div v-if="trip.deskripsi" class="mb-3">
              <h6 class="fw-bold mb-2">Deskripsi:</h6>
              <p class="card-text small description-clamp">{{ trip.deskripsi }}</p>
            </div>

            <button
              class="btn btn-success w-100 rounded-pill fw-bold"
              @click="showBookingModal(trip)">
              <i class="bi bi-whatsapp me-2"></i>Booking Sekarang
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

            <li
              class="page-item"
              v-for="page in pagination.last_page"
              :key="page"
              :class="{ active: page === pagination.current_page }"
            >
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
      v-if="showModal"
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
      @click.self="closeModal">

      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">{{ selectedPackage.nama || 'Detail Paket' }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <img
                :src="selectedPackage.gambar || 'https://via.placeholder.com/600x400?text=No+Image'"
                class="img-fluid rounded modal-image"
                alt="Foto paket"
              />
            </div>

            <div class="mb-3">
              <strong>Destinasi:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(dest, idx) in (selectedPackage.destinasi || [])" :key="idx">
                  <i class="bi bi-geo-alt-fill text-success me-2"></i>{{ dest }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.harga && selectedPackage.harga.length">
              <strong>Harga:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(hargaItem, idx) in selectedPackage.harga" :key="idx">
                  <span>{{ hargaItem.tipe }}: <del v-if="hargaItem.lama" class="text-muted small me-2">{{ hargaItem.lama }}</del><strong class="text-success">{{ hargaItem.diskon || 'N/A' }}</strong></span>
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.termasuk && selectedPackage.termasuk.length">
              <strong>Sudah Termasuk:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(item, idx) in selectedPackage.termasuk" :key="idx">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.tidak_termasuk && selectedPackage.tidak_termasuk.length">
              <strong>Tidak Termasuk:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(item, idx) in selectedPackage.tidak_termasuk" :key="idx">
                  <i class="bi bi-x-circle-fill text-danger me-2"></i>{{ item }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.deskripsi">
              <strong>Deskripsi:</strong>
              <p style="white-space: pre-line;">{{ selectedPackage.deskripsi || '-' }}</p>
            </div>

            <hr />
            <form @submit.prevent="submitBooking">
              <div class="mb-3" v-if="selectedPackage.harga && selectedPackage.harga.length > 0">
                <label class="form-label fw-bold">Pilih Jenis Harga</label>
                <select class="form-control" v-model="bookingData.tipeHarga" required>
                  <option disabled value="">Pilih salah satu harga</option>
                  <option v-for="(hargaItem, idx) in selectedPackage.harga" :key="idx" :value="hargaItem.tipe">
                    {{ hargaItem.tipe }} - {{ hargaItem.diskon }}
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Tour</label>
                <input type="date" class="form-control" v-model="bookingData.tanggal" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Jumlah Orang</label>
                <input type="number" class="form-control" v-model="bookingData.jumlahOrang" min="1" required />
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
                <label class="form-label fw-bold">Catatan Tambahan</label>
                <textarea class="form-control" v-model="bookingData.catatan" rows="2"></textarea>
              </div>

              <hr class="my-4">
              <h5 class="fw-bold text-center mb-3">Selesaikan Pembayaran Anda</h5>
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
                  <p class="text-info small fw-bold">
                      *Sertakan bukti transfer di kolom chat WhatsApp.
                  </p>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Total Harga Estimasi</label>
                <p class="form-control-plaintext fw-bold text-success display-6">
                  Rp {{ Number(calculatedPackagePrice).toLocaleString('id-ID') }}
                </p>
              </div>

              <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2">
                <i class="bi bi-whatsapp me-2"></i>Konfirmasi Pemesanan
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
// Mengimpor `ref`, `computed`, `onMounted`, dan `watch` dari Vue
// - `ref` digunakan untuk membuat state reaktif
// - `computed` digunakan untuk membuat properti turunan (derived) yang otomatis update saat dependensinya berubah
// - `onMounted` digunakan untuk mengeksekusi kode saat komponen sudah dirender ke DOM
// - `watch` digunakan untuk mengamati perubahan nilai dari suatu data reaktif
import { ref, computed, onMounted, watch } from 'vue'
// Mengimpor instance API yang sudah dikonfigurasi sebelumnya (biasanya Axios)
// Digunakan untuk melakukan request HTTP ke backend (misalnya fetch data destinasi, rental, atau paket)
import api from '@/api'
// Mengimpor SweetAlert2, pustaka popup/alert modern yang mendukung custom UI
// Digunakan untuk menampilkan notifikasi atau konfirmasi dengan tampilan menarik
import Swal from 'sweetalert2'
// Mengimpor komponen Vue untuk menampilkan QR Code
// Digunakan jika ingin menampilkan QR berdasarkan string/data tertentu
import QRCode from 'qrcode.vue'

// --- State (Data Reaktif) ---
const allTrips = ref([]) // // Menyimpan SEMUA data paket dari API.
const loading = ref(true) // // Status untuk menampilkan/menyembunyikan spinner loading.
const currentPage = ref(1) // // Menyimpan nomor halaman yang sedang aktif.
const itemsPerPage = 6; // // Menentukan berapa banyak paket yang ditampilkan per halaman.

const searchQuery = ref('') // // Menyimpan teks dari input pencarian.
const showModal = ref(false) // // Status untuk menampilkan/menyembunyikan modal.
const selectedPackage = ref(null) // // Menyimpan data paket yang sedang dipilih.

// // Objek untuk menampung semua data yang diisi pengguna di formulir pemesanan.
const bookingData = ref({
  tipeHarga: '',
  tanggal: '',
  jumlahOrang: 1, // // Menambahkan field jumlah orang.
  nama: '',
  whatsapp: '',
  catatan: ''
})

// ===============================================================
// Data untuk QR Pembayaran (QRIS dan BSI) - Sama seperti CarRent.vue
// PENTING: Ganti nilai ini dengan string QRIS ASLI Anda.
const qrPaymentText = ref('7213052386'); // // Ganti dengan string QRIS asli atau info rekening Anda.
const bsiBankDetails = {
  bankName: 'Bank Syariah Indonesia (BSI)',
  accountNumber: '7213052386', // // Ganti dengan nomor rekening Anda.
  accountName: 'irzha fahrizaldy' // // Ganti dengan nama pemilik rekening.
}

// Nomor WhatsApp untuk konfirmasi booking
const whatsappContactNumber = '6281348680937';
// ===============================================================

// --- Logika Utama (Computed Property) ---

// // Computed property yang secara otomatis menghitung total harga estimasi.
const calculatedPackagePrice = computed(() => {
  // // Jika paket atau tipe harga belum dipilih, kembalikan 0.
  if (!selectedPackage.value || !bookingData.value.tipeHarga) return 0;

  // // Cari objek harga yang cocok di dalam array harga paket.
  const selectedPriceObject = selectedPackage.value.harga.find(
    price => price.tipe === bookingData.value.tipeHarga
  );
  if (!selectedPriceObject || !selectedPriceObject.diskon) return 0;

  // // Ambil harga, bersihkan dari karakter non-numerik (spt "Rp", "."), lalu ubah menjadi angka.
  const price = parseFloat(String(selectedPriceObject.diskon).replace(/[^0-9,]+/g, "").replace(/,/g, ".")) || 0;

  // // Hitung total harga: harga per orang dikalikan jumlah orang.
  const total = price * (bookingData.value.jumlahOrang || 1);
  return total;
});

// --- Fungsi-Fungsi ---

// // Fungsi untuk mengambil SEMUA data paket dari API.
const fetchAllTrips = async () => {
  loading.value = true; // // Tampilkan loading spinner.
  try {
    // Panggil API dengan parameter `per_page=all` untuk mengambil semua data
    const res = await api.get('/api/pakets?per_page=all'); // URL disesuaikan dengan controller
    // Asumsi: respons API mengembalikan array data di `res.data.data`
    allTrips.value = res.data.data;
  } catch (err) {
    console.error('Gagal memuat semua paket:', err);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Memuat Paket',
      text: 'Terjadi kesalahan saat memuat daftar paket liburan.'
    });
    allTrips.value = [];
  } finally {
    loading.value = false; // // Sembunyikan loading spinner setelah selesai.
  }
}

// // Computed property untuk memfilter DAN memaginasi data di frontend.
const filteredAndPaginatedTrips = computed(() => {
  const query = searchQuery.value.toLowerCase().trim();

  // // 1. Filter: Saring semua data di `allTrips` berdasarkan `searchQuery`.
  const filtered = allTrips.value.filter(trip =>
    (trip.nama && trip.nama.toLowerCase().includes(query)) ||
    (trip.destinasi && Array.isArray(trip.destinasi) && trip.destinasi.join(' ').toLowerCase().includes(query)) ||
    (trip.deskripsi && trip.deskripsi.toLowerCase().includes(query)) ||
    (trip.harga && Array.isArray(trip.harga) && trip.harga.some(h =>
      (h.tipe && h.tipe.toLowerCase().includes(query)) ||
      (h.diskon && String(h.diskon).toLowerCase().includes(query))
    )) ||
    (trip.termasuk && Array.isArray(trip.termasuk) && trip.termasuk.some(t => t.toLowerCase().includes(query))) ||
    (trip.tidak_termasuk && Array.isArray(trip.tidak_termasuk) && trip.tidak_termasuk.some(nt => nt.toLowerCase().includes(query)))
  );

  // // 2. Paginasi: Ambil sebagian data dari hasil filter sesuai halaman saat ini.
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return filtered.slice(startIndex, endIndex); // // `slice` memotong array untuk paginasi.
});

// // Computed property untuk menghitung informasi paginasi di frontend.
const pagination = computed(() => {
  // // Filter lagi untuk mendapatkan jumlah total item yang cocok dengan pencarian.
  const query = searchQuery.value.toLowerCase().trim();
  const filtered = allTrips.value.filter(trip =>
    (trip.nama && trip.nama.toLowerCase().includes(query)) ||
    (trip.destinasi && Array.isArray(trip.destinasi) && trip.destinasi.join(' ').toLowerCase().includes(query)) ||
    (trip.deskripsi && trip.deskripsi.toLowerCase().includes(query)) ||
    (trip.harga && Array.isArray(trip.harga) && trip.harga.some(h =>
      (h.tipe && h.tipe.toLowerCase().includes(query)) ||
      (h.diskon && String(h.diskon).toLowerCase().includes(query))
    )) ||
    (trip.termasuk && Array.isArray(trip.termasuk) && trip.termasuk.some(t => t.toLowerCase().includes(query))) ||
    (trip.tidak_termasuk && Array.isArray(trip.tidak_termasuk) && trip.tidak_termasuk.some(nt => nt.toLowerCase().includes(query)))
  );
  const totalItems = filtered.length;
  // // Hitung total halaman berdasarkan jumlah item dan item per halaman.
  const lastPage = Math.ceil(totalItems / itemsPerPage);

  return {
    current_page: currentPage.value,
    last_page: lastPage,
    total: totalItems
  };
});

// // Fungsi untuk membuka modal dan mereset form ke nilai default.
const showBookingModal = (trip) => {
  selectedPackage.value = trip
  showModal.value = true

  // // Atur tanggal default di form ke hari esok.
  const tomorrow = new Date()
  tomorrow.setDate(tomorrow.getDate() + 1)
  bookingData.value.tanggal = tomorrow.toISOString().split('T')[0]

  // // Reset semua data di form untuk sesi booking yang baru.
  bookingData.value.tipeHarga = '';
  bookingData.value.jumlahOrang = 1;
  bookingData.value.nama = '';
  bookingData.value.whatsapp = '';
  bookingData.value.catatan = '';

  // Set default selected price if available
  if (selectedPackage.value.harga && selectedPackage.value.harga.length > 0) {
    bookingData.value.tipeHarga = selectedPackage.value.harga[0].tipe;
  } else {
    bookingData.value.tipeHarga = '';
  }
  // // Cegah scroll halaman di latar belakang.
  document.body.classList.add('modal-open');
  document.body.style.overflow = 'hidden';
}

// // Fungsi untuk menutup modal dan membersihkan semua data.
const closeModal = () => {
  showModal.value = false
  selectedPackage.value = null // // Hapus data paket yang dipilih.

  // // Reset kembali semua data form ke kondisi awal.
  bookingData.value = {
    tipeHarga: '',
    tanggal: '',
    jumlahOrang: 1,
    nama: '',
    whatsapp: '',
    catatan: ''
  }

  document.body.classList.remove('modal-open');
  document.body.style.overflow = '';
}

// // Fungsi untuk berpindah halaman (paginasi).
const changePage = (page) => {
  // // Cek apakah halaman yang dituju valid.
  if (page !== currentPage.value && page > 0 && page <= pagination.value.last_page) {
    currentPage.value = page; // // Cukup ubah nomor halaman, tidak perlu panggil API lagi.
    // Tidak perlu memanggil fetch lagi karena data sudah ada di `allTrips`
  }
}

// // Fungsi yang dieksekusi saat form booking di-submit.
const submitBooking = () => {
  const selectedPriceObject = selectedPackage.value.harga.find(
    price => price.tipe === bookingData.value.tipeHarga
  );
  const priceDisplay = selectedPriceObject ? selectedPriceObject.diskon : 'Harga tidak tersedia';
  const oldPriceDisplay = selectedPriceObject && selectedPriceObject.lama ? ` (Harga normal: ${selectedPriceObject.lama})` : '';

  const message = `Halo Dewiji Explore, saya ingin memesan:

📌 *Paket ${selectedPackage.value.nama}*
📍 Destinasi: ${(selectedPackage.value.destinasi || []).join(', ')}

👥 Jumlah Orang: ${bookingData.value.jumlahOrang}
💰 Harga Per Orang (${bookingData.value.tipeHarga}): ${priceDisplay}${oldPriceDisplay}
💲 Total Harga Estimasi: Rp ${Number(calculatedPackagePrice.value).toLocaleString('id-ID')}
📅 Tanggal Tour: ${bookingData.value.tanggal}
👤 Nama: ${bookingData.value.nama}
📱 WhatsApp: ${bookingData.value.whatsapp}
${(selectedPackage.value.termasuk && selectedPackage.value.termasuk.length) ? `✅ Termasuk: ${selectedPackage.value.termasuk.join(', ')}\n` : ''}
${(selectedPackage.value.tidak_termasuk && selectedPackage.value.tidak_termasuk.length) ? `❌ Tidak Termasuk: ${selectedPackage.value.tidak_termasuk.join(', ')}\n` : ''}
${selectedPackage.value.deskripsi ? `📝 Deskripsi Paket: ${selectedPackage.value.deskripsi}\n` : ''}
${bookingData.value.catatan ? `✏️ Catatan Pribadi: ${bookingData.value.catatan}` : ''}

Saya sudah melakukan pembayaran melalui ${bsiBankDetails.bankName} (${bsiBankDetails.accountNumber} A.N. ${bsiBankDetails.accountName}) atau QRIS. Mohon konfirmasi pemesanan saya. Terima kasih.`;

  const encoded = encodeURIComponent(message)
  // // Buka tab baru ke WhatsApp.
  window.open(`https://wa.me/${whatsappContactNumber}?text=${encoded}`, '_blank')

  // // Tampilkan notifikasi bahwa pesanan berhasil dan user harus konfirmasi via WA.
  Swal.fire({
    title: 'Pemesanan Berhasil!',
    text: 'Mohon tunggu konfirmasi dari kami melalui WhatsApp.',
    icon: 'success',
    confirmButtonText: 'Oke',
    allowOutsideClick: false
  }).then(() => {
    closeModal(); // // Tutup modal setelah user menekan 'Oke'.
  });
}

// OLD: onMounted(fetchTrips)
// NEW: Panggil fetchAllTrips()
onMounted(() => fetchAllTrips())

// NEW: Watcher untuk mereset halaman ke 1 setiap kali query pencarian berubah
watch(searchQuery, () => {
  currentPage.value = 1;
});

watch(showModal, (newValue) => {
  if (!newValue) {
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
  }
}, { immediate: true });
</script>

<style scoped>
/* // Aturan untuk animasi fade saat elemen muncul/hilang. */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* // Aturan untuk animasi daftar kartu paket. */
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
  padding-right: var(--bs-modal-padding) !important;
}

/* // Mengatur gaya gambar di dalam modal. */
.modal-image {
  width: 100%;
  height: 200px; /* Disesuaikan agar tidak terlalu besar di modal */
  object-fit: contain; /* // Gambar akan diskalakan agar pas tanpa terpotong atau gepeng. */
  background-color: #f0f0f0;
}

/* Custom CSS untuk deskripsi multi-baris dengan elipsis */
.description-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Tampilkan hingga 3 baris */
  line-clamp: 3; /* Standard property for compatibility */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  min-height: 3.8em; /* Sesuaikan dengan line-height * jumlah baris (misal 1.2em * 3 = 3.6em) */
  line-height: 1.2em; /* Sesuaikan line-height agar konsisten */
}
/* // Memberi efek hover pada link di footer. */
.hover-success:hover {
  color: #198754 !important; /* Warna hijau success Bootstrap */
}
</style>