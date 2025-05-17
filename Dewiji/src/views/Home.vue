<template>
  <header class="hero-section text-white d-flex align-items-center justify-content-center">
    <div class="overlay"></div>
    <div class="container text-center position-relative">
      <h1 class="display-4 fw-bold" data-aos="fade-down">
        Selamat Datang di <span class="text-warning">Dewiji!</span>
      </h1>
      <p class="lead mt-3" data-aos="fade-up" data-aos-delay="100">
        Temukan pesona wisata Yogyakarta yang kaya akan budaya, alam, dan sejarah.
        Dari pantai hingga candi, semua destinasi terbaik kami rangkum untuk Anda jelajahi!
      </p>

      <a
        href="#destinasi"
        class="btn btn-warning mt-4 px-4 py-2 shadow grow-on-hover"
        data-aos="zoom-in"
        data-aos-delay="200"
      >
        Lihat Destinasi
      </a>
    </div>
  </header>

  <section id="destinasi" class="py-5 bg-light">
    <div class="container-fluid text-center"> <h2 class="fw-bold mb-4" data-aos="fade-up">Destinasi Terkenal di Yogyakarta</h2>

      <div class="destinasi-scroll-wrapper" ref="scrollContainer">
        <div class="destinasi-card" v-for="(item, i) in destinasi" :key="i">
          <img :src="item.gambar" class="img-fluid rounded mx-auto d-block" :alt="item.nama" /> <h5 class="mt-3 fw-bold">{{ item.nama }}</h5>
          <p class="text-muted">{{ item.deskripsi }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-4" data-aos="fade-up">Artikel Blog</h2>
      <p class="text-center mb-5 text-muted">Baca juga informasi menarik, tips dan trik seputar traveling berikut ini!</p>

      <div class="row g-4">
        <div
          class="col-md-4"
          v-for="(artikel, idx) in artikelList"
          :key="idx"
          data-aos="fade-up"
          :data-aos-delay="idx * 100"
        >
          <div class="card h-100 shadow-sm">
            <img :src="artikel.gambar" class="card-img-top" :alt="artikel.judul" />
            <div class="card-body">
              <h5 class="card-title text-primary fw-bold">{{ artikel.judul }}</h5>
              <small class="text-muted">
                <i class="bi bi-calendar-event"></i> {{ artikel.tanggal }} &nbsp;|&nbsp;
                <i class="bi bi-eye"></i> {{ artikel.views }}x &nbsp;|&nbsp;
                <span class="badge bg-secondary">{{ artikel.kategori }}</span>
              </small>
              <p class="card-text mt-2">{{ artikel.deskripsi }} <a :href="artikel.link">selengkapnya</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-light pt-5 pb-4">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Tentang Kami</h5>
          <p class="small">
            <strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman dengan harga yang
            cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan sekitarnya.
          </p>
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
            <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Home</a></li>
            <li class="mb-2"><a href="#destinasi" class="text-light text-decoration-none hover-success">Destinasi</a></li>
            <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Rental Mobil</a></li>
            <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Paket Liburan</a></li>
            <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Kritik & Saran</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Sosial Media</h5>
          <p class="small">Ikuti kami di media sosial untuk mendapatkan penawaran terbaik!</p>
          <div class="d-flex gap-3">
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-tiktok"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-instagram"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-whatsapp"></i>
            </a>
          </div>
        </div>
      </div>

      <hr class="my-4 bg-secondary" />

      <div class="text-center small text-muted">
        &copy; 2023 Dewiji Explore. All Rights Reserved.
      </div>
    </div>
  </footer>
</template>

<script setup>
import { onMounted, ref } from 'vue'

import prambanan from '@/assets/prambanan.jpg'
import parangtritis from '@/assets/parangtritis.jpg'
import malioboro from '@/assets/malioboro.jpg'
import breksi from '@/assets/breksi.jpg'
import keraton from '@/assets/keraton.jpg'

const scrollContainer = ref(null)

const destinasi = [
  {
    nama: 'Candi Prambanan',
    deskripsi: 'Kompleks candi Hindu terbesar di Indonesia, terkenal akan relief epik Ramayana dan arsitektur megah abad ke-9.',
    gambar: prambanan
  },
  {
    nama: 'Pantai Parangtritis',
    deskripsi: 'Pantai mistis dengan ombak besar dan pemandangan matahari terbenam yang menakjubkan, erat dengan legenda Ratu Kidul.',
    gambar: parangtritis
  },
  {
    nama: 'Malioboro',
    deskripsi: 'Jalan ikonik di jantung kota Yogyakarta yang dipenuhi pedagang, kuliner khas, dan nuansa budaya Jawa yang kental.',
    gambar: malioboro
  },
  {
    nama: 'Bukit Breksi',
    deskripsi: 'Bekas tambang batu kapur yang disulap menjadi destinasi wisata dengan relief seni, panorama alam, dan spot foto unik.',
    gambar: breksi
  },
  {
    nama: 'Keraton Yogyakarta',
    deskripsi: 'Istana resmi Kesultanan Yogyakarta yang masih aktif, menyuguhkan arsitektur klasik dan nilai budaya tinggi.',
    gambar: keraton
  }
]

const artikelList = [
  {
    judul: "Manfaat Sewa Bus 35 Seat Di Yogyakarta",
    tanggal: "17 December 2024",
    views: 63,
    kategori: "Rental Mobil",
    deskripsi: "Saat merencanakan perjalanan bersama rombongan, baik untuk acara perusahaan, wisata keliling, pernikahan, atau reuni keluarga...",
    link: "#",
    gambar: "https://alkawakibitrans.com/wp-content/uploads/2024/03/sewa-bus-jogja-medium-bus-min.jpg" // bus image
  },
  {
    judul: "Borobudur Sunrise: Must-Visit Destinations In Yogyakarta",
    tanggal: "17 October 2024",
    views: 83,
    kategori: "Wisata Jogja, Wisata Magelang",
    deskripsi: "Sunrise at Borobudur Temple is a must-see sight when you are in Yogyakarta. This temple is the largest Buddhist temple in the world...",
    link: "#",
    gambar: "https://media.tacdn.com/media/attractions-splice-spp-674x446/09/92/28/83.jpg" // borobudur sunrise
  },
  {
    judul: "Tour Kota Jogja Satu Hari Dengan Bus Mewah",
    tanggal: "2 October 2024",
    views: 90,
    kategori: "Travel Tips",
    deskripsi: "Jika kamu ingin menjelajahi tempat-tempat terbaik di Jogja dalam satu hari, tanpa repot berkendara atau menggunakan transportasi umum...",
    link: "#",
    gambar: "https://xplorejogja.com/wp-content/uploads/2023/08/Gambar-Foto-Bus-Trans-Jogja-1.jpg" // jogja city with tugu
  }
]

onMounted(() => {
  setInterval(() => {
    const el = scrollContainer.value
    if (el) {
      // Jika sudah mendekati akhir scroll, kembalikan ke awal
      if (el.scrollLeft + el.clientWidth >= el.scrollWidth - 10) {
        el.scrollTo({ left: 0, behavior: 'smooth' })
      } else {
        el.scrollBy({ left: 300, behavior: 'smooth' })
      }
    }
  }, 5000)
})
</script>

<style scoped>
.hero-section {
  position: relative;
  min-height: 100vh;
  background: url('@/assets/merapi.png') center center / cover no-repeat;
}

.overlay {
  position: absolute;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(2px);
  z-index: 1;
}

.container {
  z-index: 2;
}

.container-fluid { /* Membuat bagian destinasi mengisi lebar layar */
  padding-left: 0;
  padding-right: 0;
}

.destinasi-scroll-wrapper {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  gap: 1rem;
  padding: 1rem; /* Tambahkan padding agar konten tidak terlalu mepet tepi layar */
  scrollbar-width: thin;
  justify-content: center; /* Membuat item berada di tengah wrapper */
}

.destinasi-scroll-wrapper::-webkit-scrollbar {
  height: 8px;
}

.destinasi-scroll-wrapper::-webkit-scrollbar-thumb {
  background-color: #888;
  border-radius: 4px;
}

.destinasi-card {
  flex: 0 0 auto;
  width: 300px;
  background: white;
  border-radius: 1rem;
  padding: 1rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Efek hover */
  text-align: center; /* Rata tengah teks di dalam card */
}

.destinasi-card:hover {
  transform: scale(1.05); /* Sedikit membesar saat hover */
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2); /* Shadow lebih terlihat saat hover */
}

.destinasi-card img {
  max-width: 100%; /* Pastikan gambar tidak melebihi lebar card */
  height: auto;
  margin-bottom: 1rem; /* Beri jarak antara gambar dan teks */
}

.card-title {
  font-size: 1.25rem;
}

.card-text a {
  text-decoration: none;
  font-weight: 600;
  color: #f0ad4e; /* matching btn-warning */
}

.card-text a:hover {
  text-decoration: underline;
}

section.py-5 {
  padding-top: 3rem !important;
  padding-bottom: 3rem !important;
}
</style>