<template>
  <div class="container py-5">
    <Transition name="fade" appear>
      <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
          <h1 class="fw-bold display-5">Destinasi Wisata Jogja</h1>
          <p class="lead">Jelajahi berbagai destinasi wisata menarik di Yogyakarta dan sekitarnya. Temukan pengalaman liburan tak terlupakan!</p>
        </div>
      </div>
    </Transition>

    <Transition name="fade" appear>
      <div class="mb-4 container">
        <input
          type="text"
          class="form-control rounded-pill"
          placeholder="Cari destinasi..."
          v-model="searchQuery"
        />
      </div>
    </Transition>

    <div v-if="loading" class="col-12 text-center py-5">
      <p class="lead">Memuat destinasi...</p>
      <div class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
    <div v-else-if="allDestinations.length === 0 && searchQuery === ''" class="col-12 text-center py-5">
      <p class="lead">Tidak ada destinasi yang tersedia saat ini.</p>
    </div>
    <div v-else-if="filteredAndPaginatedDestinations.length === 0 && searchQuery !== ''" class="col-12 text-center py-5">
      <p class="lead">Tidak ada destinasi yang ditemukan sesuai dengan pencarian Anda.</p>
    </div>


    <TransitionGroup name="list" tag="div" class="row g-4 w-100">
      <div class="col-md-4" v-for="destination in filteredAndPaginatedDestinations" :key="destination.id">
        <div class="card h-100 shadow-sm">
          <img
            v-if="destination.gambar"
            :src="destination.gambar"
            class="w-100 rounded-top"
            style="height: 200px; object-fit: cover;"
            :alt="destination.nama"
          />
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ destination.nama }}</h5>
            <p class="text-muted mb-2">
              <i class="bi bi-geo-alt-fill text-success"></i> {{ destination.location }}
            </p>
            <div class="mb-2">
              <span v-for="(kategori, i) in destination.kategori" :key="i" class="badge bg-success bg-opacity-10 text-success me-1">
                {{ kategori }}
              </span>
            </div>
            <p class="card-text text-truncate">
              {{ destination.deskripsi || 'Deskripsi belum tersedia' }}
            </p>

            <div v-if="destination.harga && destination.harga.length > 0" class="mb-2">
              <h6 class="fw-bold">Harga Tiket:</h6>
              <div class="d-flex justify-content-between">
                <span class="fw-bold text-success">{{ destination.harga[destination.harga.length - 1] }}</span>
              </div>
            </div>

            <div v-if="destination.jamOperasional">
              <h6 class="fw-bold">Jam Operasional:</h6>
              <p class="small">{{ destination.jamOperasional }}</p>
            </div>
          </div>

          <div class="card-footer text-center bg-white border-0 pt-0">
            <button class="btn btn-success btn-sm w-100" @click="showDetails(destination)">
              <i class="bi bi-info-circle me-2"></i>Cek Selengkapnya
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
            <h5 class="modal-title">{{ selectedDestinasi.nama }}</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <img :src="selectedDestinasi.gambar" class="w-100 rounded mb-3 modal-image" alt="Foto destinasi" />

            <p class="text-muted">
              <i class="bi bi-geo-alt-fill text-success"></i> {{ selectedDestinasi.location }}
            </p>

            <div class="mb-2">
              <strong>Kategori:</strong>
              <div class="d-flex flex-wrap gap-2 mt-1">
                <span v-for="(k, i) in selectedDestinasi.kategori" :key="i"
                  class="badge bg-success bg-opacity-10 text-success">{{ k }}</span>
              </div>
            </div>

            <div class="mb-3">
              <strong>Deskripsi:</strong>
              <p style="white-space: pre-line;">{{ selectedDestinasi.deskripsi || '-' }}</p>
            </div>

            <div class="mb-3" v-if="selectedDestinasi.harga && selectedDestinasi.harga.length > 0">
              <strong>Harga Tiket:</strong>
              <ul class="list-unstyled mt-2">
                <li class="d-flex justify-content-between align-items-center">
                  <span class="fw-bold text-success">{{ selectedDestinasi.harga[selectedDestinasi.harga.length - 1] }}</span>
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedDestinasi.jamOperasional">
              <strong>Jam Operasional:</strong>
              <p>{{ selectedDestinasi.jamOperasional }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" @click="closeModal">Tutup</button>
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
import { ref, onMounted, watch, computed } from 'vue' // Fungsi inti Vue.
import api from '@/api' // Konfigurasi Axios untuk request API.

const allDestinations = ref([]) // Menyimpan SEMUA data destinasi dari API. Paginasi akan dilakukan di frontend.
const loading = ref(true) // Status untuk menampilkan/menyembunyikan spinner loading.
const currentPage = ref(1) // Menyimpan nomor halaman yang sedang aktif.
const itemsPerPage = 6; // Menentukan berapa banyak item yang ditampilkan per halaman.

const showModal = ref(false) // Status untuk menampilkan/menyembunyikan modal.
const selectedDestinasi = ref({}) // Menyimpan data destinasi yang dipilih.
const searchQuery = ref('') // Menyimpan teks dari input pencarian.

// --- Fungsi-Fungsi ---

// Fungsi untuk mengambil SEMUA data destinasi dari API.
const fetchAllDestinasi = async () => {
  loading.value = true; // Set loading true saat memulai fetch
  try {
    // Panggil API untuk mengambil semua data (contoh: dengan parameter `per_page=all`).
    const res = await api.get('/api/destinasis?per_page=all');

    // Asumsi: respons API mengembalikan array data di `res.data.data`
    // Sesuaikan ini jika struktur respons DestinasiResource Anda berbeda
    // Contoh: jika langsung array, pakai `res.data`
    // Contoh: jika ada objek { message, data: { data: [...] } }, pakai `res.data.data.data`
    allDestinations.value = res.data.data; // Simpan semua data ke state 'allDestinations'.
  } catch (err) {
    console.error('Fetch all destinations error:', err);
    // Tampilkan pesan error kepada pengguna jika fetch gagal
    // Misalnya dengan SweetAlert2
    // Swal.fire({
    //   icon: 'error',
    //   title: 'Gagal Memuat Destinasi',
    //   text: 'Terjadi kesalahan saat mengambil data destinasi. Mohon coba lagi.'
    // });
    allDestinations.value = []; // Kosongkan data jika ada error
  } finally {
    // Blok ini akan selalu berjalan, baik berhasil maupun gagal.
    loading.value = false; // Set loading false setelah fetch selesai (baik berhasil/gagal)
  }
}

// --- Logika Utama (Computed Property) ---

// Computed property untuk memfilter DAN memaginasi data di frontend.
const filteredAndPaginatedDestinations = computed(() => {
  const query = searchQuery.value.toLowerCase().trim();

  // 1. Filter: Saring semua data di `allDestinations` berdasarkan `searchQuery`.
  const filtered = allDestinations.value.filter(destination =>
    destination.nama.toLowerCase().includes(query) ||
    (destination.location && destination.location.toLowerCase().includes(query)) ||
    (destination.deskripsi && destination.deskripsi.toLowerCase().includes(query)) ||
    // Pastikan `kategori` adalah array di data Anda agar `.some()` berfungsi
    (destination.kategori && Array.isArray(destination.kategori) && destination.kategori.some(kategori => kategori.toLowerCase().includes(query)))
  );

  // 2. Paginasi: Ambil sebagian data dari hasil filter sesuai halaman saat ini.
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return filtered.slice(startIndex, endIndex); // `slice` memotong array untuk paginasi.
});

// Computed property untuk menghitung informasi paginasi di frontend.
const pagination = computed(() => {
  // Filter lagi untuk mendapatkan jumlah total item yang cocok dengan pencarian.
  const query = searchQuery.value.toLowerCase().trim();
  const filtered = allDestinations.value.filter(destination =>
    destination.nama.toLowerCase().includes(query) ||
    (destination.location && destination.location.toLowerCase().includes(query)) ||
    (destination.deskripsi && destination.deskripsi.toLowerCase().includes(query)) ||
    (destination.kategori && Array.isArray(destination.kategori) && destination.kategori.some(kategori => kategori.toLowerCase().includes(query)))
  );
  const totalItems = filtered.length;
  // Hitung total halaman berdasarkan jumlah item dan item per halaman.
  const lastPage = Math.ceil(totalItems / itemsPerPage);

  return {
    current_page: currentPage.value,
    last_page: lastPage,
    total: totalItems
  };
});
// Fungsi untuk menampilkan detail destinasi di modal.
const showDetails = (d) => {
  selectedDestinasi.value = d // Simpan data destinasi yang diklik.
  showModal.value = true // Tampilkan modal.
  document.body.classList.add('modal-open'); // Cegah scroll halaman di latar belakang.
  document.body.style.overflow = 'hidden'; // Fallback style
}
// Fungsi untuk menutup modal.
const closeModal = () => {
  showModal.value = false;
  document.body.classList.remove('modal-open');
  document.body.style.overflow = ''; // Reset body scroll
}
// Fungsi untuk berpindah halaman (paginasi).
const changePage = (page) => {
  // Hanya ubah halaman jika halaman baru valid dan berbeda dari halaman saat ini
  if (page !== currentPage.value && page > 0 && page <= pagination.value.last_page) {
    currentPage.value = page
    // Tidak perlu memanggil fetch lagi karena data sudah ada di `allDestinations`
  }
}

// --- Lifecycle dan Watcher ---

// Panggil fungsi untuk mengambil semua data saat komponen dimuat
onMounted(() => {
  fetchAllDestinasi();
});

// Watcher untuk mereset halaman ke 1 setiap kali query pencarian berubah
watch(searchQuery, () => {
  currentPage.value = 1;
});

// Watcher untuk mengelola overflow body saat modal berubah status
// `immediate: true` agar fungsi ini berjalan saat inisialisasi awal
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

/* // Aturan untuk animasi daftar kartu destinasi. */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px);
}

/* // Aturan khusus untuk item yang keluar dari daftar agar animasi mulus. */
.list-leave-active {
  position: absolute;
}

.list-move {
  transition: transform 0.5s ease;
}

/* Kustomisasi Modal */
/* Bootstrap 5.1+ sudah menangani modal-open, tapi ini sebagai fallback/penyesuaian */
body.modal-open {
  overflow: hidden !important;
  /* padding-right: var(--bs-modal-padding) !important;  Aktifkan jika ada isu scrollbar */
}

/* Penyesuaian gambar di dalam modal */
.modal-image {
  width: 100%;
  height: 250px; /* Tingkatkan sedikit tingginya agar lebih jelas di modal */
  object-fit: contain; /* Mempertahankan rasio aspek dan tidak gepeng */
  background-color: #f0f0f0; /* Opsional: latar belakang jika ada ruang kosong */
}

/* // Memberi efek hover pada link di footer. */
.hover-success:hover {
  color: #198754 !important; /* Warna hijau success Bootstrap */
}
</style>