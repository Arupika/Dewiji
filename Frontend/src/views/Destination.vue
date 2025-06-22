<template>
  <link rel="preload" :href="destinations[0]?.gambar" as="image">
  <div class="container py-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-8 text-center">
        <h1 class="fw-bold display-5">Destinasi Wisata Jogja</h1>
        <p class="lead">Jelajahi berbagai destinasi wisata menarik di Yogyakarta dan sekitarnya. Temukan pengalaman liburan tak terlupakan!</p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-4" v-for="(destination, index) in destinations" :key="destination.id">
        <div class="card h-100 shadow-sm">
          <img
            v-if="destination.gambar"
            :src="destination.gambar"
            class="w-100 rounded-top"
            style="height: 200px; object-fit: cover;"
            :alt="destination.nama"
            loading="lazy"
            width="300"
            height="200"
          />
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ destination.nama }}</h5>
            <p class="text-muted mb-3">
              <i class="bi bi-geo-alt-fill text-success"></i> {{ destination.location }}
            </p>

            <div class="mb-3">
              <span
                v-for="(category, i) in destination.kategori"
                :key="i"
                class="badge bg-success bg-opacity-10 text-success me-2"
              >
                {{ category }}
              </span>
            </div>

            <p class="card-text" :class="{ 'text-truncate': !destination.showFull }">
              {{ destination.deskripsi || 'Deskripsi belum tersedia' }}
            </p>

            <div v-if="destination.harga" class="mb-3">
              <h6 class="fw-bold mb-2">Harga Tiket:</h6>
              <div
                class="d-flex justify-content-between mb-1"
                v-for="(price, type) in destination.harga"
                :key="type"
              >
                <span>{{ type }}:</span>
                <span class="text-success fw-bold">{{ price }}</span>
              </div>
            </div>

            <div v-if="destination.jamOperasional" class="mb-3">
              <h6 class="fw-bold mb-2">Jam Operasional:</h6>
              <p class="small">{{ destination.jamOperasional }}</p>
            </div>
          </div>

          <div class="card-footer bg-white border-top-0 text-center pt-0">
            <button class="btn btn-success btn-sm w-100" @click="showDetails(destination)">
              <i class="bi bi-info-circle me-2"></i>Cek Selengkapnya
            </button>
          </div>
        </div>
      </div>

      <div v-if="!destinations.length" class="col-12 text-center">
        <p class="text-muted">Belum ada destinasi tersedia.</p>
      </div>
    </div>
  </div>
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
import { ref, onMounted } from 'vue'
import api from '@/api'
import Swal from 'sweetalert2'

const destinations = ref([])

const fetchDestinasi = async () => {
  try {
    const res = await api.get('/api/destinasis')
    destinations.value = res.data.data.data.map(item => ({
      ...item,
      showFull: false
    }))
  } catch (err) {
    console.error('Fetch error:', err)
  }
}

onMounted(fetchDestinasi)

const showDetails = (d) => {
  const hargaHtml = d.harga
    ? `<div class="mt-3"><h6>Harga Tiket:</h6><ul class="list-unstyled">${
        Object.entries(d.harga).map(([t, p]) =>
          `<li class="d-flex justify-content-between"><span>${t}:</span><span class="fw-bold text-success">${p}</span></li>`
        ).join('')
      }</ul></div>`
    : ''

  const jamHtml = d.jamOperasional
    ? `<div class="mt-3"><h6>Jam Operasional:</h6><p>${d.jamOperasional}</p></div>`
    : ''

  const kategoriHtml = d.kategori?.length
    ? `<div class="d-flex flex-wrap gap-2 mb-3">${
        d.kategori.map(k => `<span class="badge bg-success bg-opacity-10 text-success">${k}</span>`).join('')
      }</div>`
    : ''

  Swal.fire({
    title: d.nama,
    html: `
      <img src="${d.gambar}" style="width:100%; max-height:300px; object-fit:cover; border-radius:0.5rem; margin-bottom:1rem;" alt="${d.nama}" />
      <p class="text-muted"><i class="bi bi-geo-alt-fill text-success"></i> ${d.location}</p>
      ${kategoriHtml}
      <p>${d.deskripsi || 'Deskripsi belum tersedia'}</p>
      ${hargaHtml}
      ${jamHtml}
    `,
    showCloseButton: true,
    confirmButtonText: 'Tutup',
    confirmButtonColor: '#198754',
    width: '500px',
    customClass: { popup: 'rounded-3', htmlContainer: 'text-start' },
  })
}
</script>
