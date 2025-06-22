<template>
  <link rel="preload" :href="daftarMobil[0]?.gambar" as="image">
  <div class="container py-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-8 text-center">
        <h1 class="fw-bold display-5">Rental Mobil Yogyakarta</h1>
        <p class="lead">
          Temukan mobil terbaik untuk kebutuhan perjalanan Anda di Jogja dan sekitarnya. 
          Kami menyediakan berbagai pilihan mobil dengan harga terjangkau dan pelayanan terbaik.
        </p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-4" v-for="mobil in daftarMobil" :key="mobil.id">
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
            <p class="card-text small">{{ mobil.deskripsi }}</p>

            <div class="mb-3">
              <span v-for="(fitur, i) in mobil.fitur" :key="i"
                class="badge bg-success bg-opacity-10 text-success me-2">
                {{ fitur }}
              </span>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Harga Sewa:</h6>
              <div class="d-flex justify-content-between mb-1">
                <span>Per Hari:</span>
                <span class="text-success fw-bold">Rp {{ Number(mobil.harga).toLocaleString() }}</span>
              </div>
              <div v-if="mobil.harga12jam" class="d-flex justify-content-between">
                <span>12 Jam:</span>
                <span class="text-success fw-bold">Rp {{ Number(mobil.harga12jam).toLocaleString() }}</span>
              </div>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Termasuk:</h6>
              <ul class="list-unstyled small">
                <li v-for="(item, i) in mobil.termasuk" :key="i" class="mb-1">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>
          </div>

          <div class="card-footer bg-white border-top-0 text-center pt-0">
            <button class="btn btn-success btn-sm w-100" @click="showDetails(mobil)">
              <i class="bi bi-car-front me-2"></i>Cek Detail
            </button>
          </div>
        </div>
      </div>

      <div v-if="!daftarMobil.length" class="col-12 text-center">
        <p class="text-muted">Belum ada mobil tersedia.</p>
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

const daftarMobil = ref([])

const fetchMobils = async () => {
  try {
    const res = await api.get('/api/mobils')
    daftarMobil.value = res.data.data.data
  } catch (err) {
    console.error('Gagal fetch mobil:', err)
  }
}

onMounted(fetchMobils)

const showDetails = (mobil) => {
  const fiturHtml = mobil.fitur?.length
    ? `<div class="mb-2"><strong>Fitur:</strong> ${mobil.fitur.join(', ')}</div>` : ''
  const termasukHtml = mobil.termasuk?.length
    ? `<div class="mb-2"><strong>Termasuk:</strong><ul>${mobil.termasuk.map(t => `<li>${t}</li>`).join('')}</ul></div>` : ''

  Swal.fire({
    title: mobil.nama,
    html: `
      <img src="${mobil.gambar}" style="width:100%; max-height:300px; object-fit:cover; border-radius:0.5rem; margin-bottom:1rem;" />
      <p>${mobil.deskripsi || 'Deskripsi belum tersedia'}</p>
      ${fiturHtml}
      ${termasukHtml}
      <div class="mt-3"><strong>Harga:</strong><br/>
        Per Hari: <span class="fw-bold text-success">Rp ${Number(mobil.harga).toLocaleString()}</span><br/>
        ${mobil.harga12jam ? `12 Jam: <span class="fw-bold text-success">Rp ${Number(mobil.harga12jam).toLocaleString()}</span>` : ''}
      </div>
    `,
    confirmButtonText: 'Tutup',
    confirmButtonColor: '#198754',
    customClass: {
      popup: 'rounded-3',
      htmlContainer: 'text-start'
    }
  })
}
</script>
