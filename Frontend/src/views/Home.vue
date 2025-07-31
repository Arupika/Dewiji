<script setup>
// --- Impor Modul ---
import { ref, onMounted } from 'vue' 
// 'ref' digunakan untuk membuat data reaktif.
// 'onMounted' digunakan agar fungsi dijalankan saat komponen selesai dirender di DOM.

import { useRouter } from 'vue-router' 
// 'useRouter' digunakan untuk mendapatkan instance router Vue agar bisa navigasi halaman secara programatik (tanpa <router-link>).

import api from '@/api' 
// Mengimpor konfigurasi Axios dari file '@/api' untuk komunikasi ke backend API secara konsisten (misalnya GET, POST data).

// Mengimpor gambar dari folder assets untuk digunakan sebagai background di bagian tertentu halaman.
import destinasiBg from '@/assets/destinasi-bg.jpg' // Gambar latar untuk bagian destinasi wisata
import mobilBg from '@/assets/mobil-bg.jpg'         // Gambar latar untuk bagian rental mobil
import paketBg from '@/assets/paket-bg.jpg'         // Gambar latar untuk bagian paket wisata

// --- State (Data Reaktif) ---
const router = useRouter() 
// Mendapatkan objek router untuk melakukan navigasi ke halaman lain lewat kode JavaScript (misal: router.push('/detail')).

const destinasi = ref([]) // Menyimpan data destinasi wisata dari API
const rental = ref([])    // Menyimpan data rental mobil dari API
const packages = ref([])  // Menyimpan data paket wisata dari API

// --- Fungsi-Fungsi ---

// Fungsi untuk mengambil data dari beberapa endpoint API sekaligus.
const fetchData = async () => {
  try {
    // 'Promise.all' menjalankan semua request API secara bersamaan (paralel),
    // sehingga lebih cepat daripada menjalankannya satu per satu.
    const [resDestinasi, resRental, resPackage] = await Promise.all([
      api.get('/api/destinasis'),
      api.get('/api/mobils'),
      api.get('/api/pakets')
    ])
    // Setelah semua data diterima, simpan 5 item pertama dari setiap response ke state.
    // '.slice(0, 5)' digunakan untuk mengambil hanya 5 data pertama sebagai pratinjau di halaman utama.
    destinasi.value = resDestinasi.data.data.data.slice(0, 5)
    rental.value = resRental.data.data.data.slice(0, 5)
    packages.value = resPackage.data.data.data.slice(0, 5)
  } catch (error) {
    console.error('Gagal memuat data:', error)
  }
}

// --- Fungsi Navigasi ke Halaman Masing-Masing ---
// Fungsi-fungsi ini menggunakan router Vue untuk berpindah halaman secara programatik ketika dipanggil (misalnya saat tombol diklik).

const goToDestinationPage = () => router.push('/Destination') // Navigasi ke halaman destinasi wisata
const goToRentalPage = () => router.push('/CarRent')          // Navigasi ke halaman rental mobil
const goToPackagePage = () => router.push('/Package')         // Navigasi ke halaman paket liburan

// --- Lifecycle: Saat Komponen Dimuat (Mounted) ---
onMounted(() => {
  fetchData() // Memanggil fungsi untuk mengambil data dari API saat halaman selesai dimuat

  // --- IntersectionObserver untuk Efek Scroll ---
  // Membuat efek animasi (misalnya fade-in) ketika elemen tertentu muncul di viewport (area yang terlihat oleh user)
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) { // Jika elemen terlihat di layar
        entry.target.classList.add('is-visible') // Tambahkan kelas CSS untuk efek animasi
        observer.unobserve(entry.target)         // Hentikan pengamatan agar animasi tidak berulang
      }
    })
  }, { threshold: 0.1 }) // Elemen dianggap terlihat jika 10% dari tinggi elemen masuk viewport

  // Terapkan observer ke semua elemen yang memiliki kelas 'reveal-on-scroll'
  document.querySelectorAll('.reveal-on-scroll').forEach(section => {
    observer.observe(section)
  })
})

</script>

<template>
  <!-- Hero Section -->
  <header class="position-relative text-white d-flex align-items-center justify-content-center hero-section-animated"
    style="min-height: 100vh; background-image: url('/src/assets/merapi.png'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 overlay-animated"></div>
    <div class="container text-center position-relative z-1 p-4 content-animated">
      <h1 class="display-4 fw-bold">Selamat Datang di <span class="text-warning">Dewiji!</span></h1>
      <p class="lead mt-3 text-white">
        Temukan pesona wisata Yogyakarta yang kaya akan budaya, alam, dan sejarah.
      </p>
      <a href="#destinasi" class="btn btn-warning text-white mt-4 px-4 py-2 shadow">Lihat Destinasi</a>
    </div>
  </header>

  <!-- Section Dinamis: Destinasi, Rental, Paket -->
  <section
    v-for="(section, index) in [
      { title: 'Destinasi Wisata', data: destinasi, action: goToDestinationPage, bgImage: destinasiBg },
      { title: 'Rental Mobil', data: rental, action: goToRentalPage, bgImage: mobilBg },
      { title: 'Paket Liburan', data: packages, action: goToPackagePage, bgImage: paketBg }
    ]"
    :key="index"
    :id="index === 0 ? 'destinasi' : null"
    class="py-5 position-relative reveal-on-scroll"
    :style="`transition-delay: ${index * 0.1}s; background-image: url(${section.bgImage}); background-size: cover; background-position: center; background-attachment: fixed;`"
  >
    <!-- Blur Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-overlay-blur"></div>

    <!-- Content -->
    <div class="container position-relative z-2">
      <h2 class="text-center fw-bold mb-4 text-white">{{ section.title }}</h2>

      <div class="scrolling-wrapper d-flex flex-nowrap overflow-auto">
        <div
          v-for="(item, i) in section.data"
          :key="i"
          class="card mx-2"
          style="min-width: 200px; flex: 0 0 auto;"
        >
          <img :src="item.gambar" class="card-img-top" :alt="item.nama" />
          <div class="card-body">
            <h6 class="card-title text-truncate">{{ item.nama || '-' }}</h6>
            <p class="card-text small text-muted text-truncate">{{ item.deskripsi || '-' }}</p>
          </div>
        </div>
      </div>

      <div class="text-center mt-3">
        <button @click="section.action" class="btn btn-warning btn-lg">
          Lihat Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
        </button>
      </div>
    </div>

    <!-- Gradient separator antar section -->
    <div class="separator-gradient"></div>
  </section>

   <!-- Footer -->
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
              <router-link to="/Comment" class="text-light text-decoration-none hover-success">FAQ</router-link>
            </li>
          </ul>
        </div>

        <!-- Sosial Media-->
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

<style scoped>
.bg-overlay-blur {
  backdrop-filter: blur(6px);
  background-color: rgba(0, 0, 0, 0.4);
  z-index: 1;
}

/* Gradient separator */
.separator-gradient {
  background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), transparent);
  margin-top: -30px;
  z-index: 2;
  position: relative;
}

/* Section container over overlay */
section > .container {
  position: relative;
  z-index: 2;
}

/* Scrollable card wrapper */
.scrolling-wrapper {
  scrollbar-width: thin;
  scrollbar-color: #ccc transparent;
  padding-bottom: 4px;
}
.scrolling-wrapper::-webkit-scrollbar {
  height: 8px;
}
.scrolling-wrapper::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 4px;
}

.card {
  width: 250px;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
}
.card-img-top {
  height: 180px;
  object-fit: cover;
}

.reveal-on-scroll {
  opacity: 0;
  transform: translateY(50px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}
.reveal-on-scroll.is-visible {
  opacity: 1;
  transform: translateY(0);
}

.content-animated {
  animation: slideInUp 1s ease-out forwards;
  opacity: 0;
  animation-delay: 0.3s;
}
.overlay-animated {
  animation: fadeIn 1s ease-out forwards;
  opacity: 0;
}
@keyframes slideInUp {
  from { transform: translateY(50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
