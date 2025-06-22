<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()

const destinasi = ref([])
const rental = ref([])
const packages = ref([])

const fetchData = async () => {
  try {
    const [resDestinasi, resRental, resPackage] = await Promise.all([
      api.get('/api/destinasi'),
      api.get('/api/mobils'),
      api.get('/api/pakets')
    ])

    destinasi.value = (resDestinasi.data.data?.data || resDestinasi.data.data || []).slice(0, 7)
    rental.value = (resRental.data.data?.data || resRental.data.data || []).slice(0, 7)
    packages.value = (resPackage.data.data?.data || resPackage.data.data || []).slice(0, 7)
  } catch (error) {
    console.error('Gagal memuat data:', error)
  }
}

const goToDestinationPage = () => router.push('/Destination')
const goToRentalPage = () => router.push('/CarRent')
const goToPackagePage = () => router.push('/Package')

onMounted(fetchData)
</script>

<template>
  <!-- Hero Section -->
  <header class="position-relative text-white d-flex align-items-center justify-content-center" style="min-height: 100vh; background-image: url('/src/assets/merapi.png'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div class="container text-center position-relative z-1 p-4">
      <h1 class="display-4 fw-bold">Selamat Datang di <span class="text-warning">Dewiji!</span></h1>
      <p class="lead mt-3 text-white">
        Temukan pesona wisata Yogyakarta yang kaya akan budaya, alam, dan sejarah.
        Dari pantai hingga candi, semua destinasi terbaik kami rangkum untuk Anda jelajahi!
      </p>
      <a href="#destinasi" class="btn btn-warning text-white mt-4 px-4 py-2 shadow">Lihat Destinasi</a>
    </div>
  </header>

  <!-- Section: Destinasi -->
  <section id="destinasi" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Destinasi Wisata</h2>
      <div class="row">
        <div v-for="(item, i) in destinasi" :key="i" class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img :src="item.gambar" class="card-img-top" :alt="item.nama" />
            <div class="card-body">
              <p class="card-text">{{ item.deskripsi }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <button @click="goToDestinationPage" class="btn btn-warning btn-lg">
          Lihat Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- Section: Rental Mobil -->
  <section id="CarRent" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Rental Mobil</h2>
      <div class="row">
        <div v-for="(item, i) in mobil" :key="i" class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img :src="item.gambar" class="card-img-top" :alt="item.nama" />
            <div class="card-body">
              <p class="card-text">{{ item.deskripsi }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <button @click="goToRentalPage" class="btn btn-warning btn-lg">
          Lihat Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
        </button>
      </div>
    </div>
  </section>

  <!-- Section: Paket Liburan -->
  <section id="Package" class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Paket Liburan</h2>
      <div class="row">
        <div v-for="(item, i) in paket" :key="i" class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img :src="item.gambar" class="card-img-top" :alt="item.nama" />
            <div class="card-body">
              <p class="card-text">{{ item.deskripsi }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
        <button @click="goToPackagePage" class="btn btn-warning btn-lg">
          Lihat Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
        </button>
      </div>
    </div>
  </section>
</template>

<style scoped>
.card img {
  object-fit: cover;
  height: 220px;
}
</style>
