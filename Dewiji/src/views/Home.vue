<script setup>
import { onMounted, ref } from 'vue'
import prambanan from '@/assets/Destinasi/prambanan.jpg'
import parangtritis from '@/assets/Destinasi/parangtritis.jpg'
import malioboro from '@/assets/Destinasi/malioboro.jpg'
import breksi from '@/assets/Destinasi/breksi.jpg'
import keraton from '@/assets/Destinasi/keraton.jpg'
import merapi from '@/assets/Destinasi/merapi.jpg'
import tugu from '@/assets/Destinasi/tugu.jpg'
import vredeburg from '@/assets/Destinasi/vredeburg.jpg'
import monjali from '@/assets/Destinasi/monjali.jpg'
import titikNol from '@/assets/Destinasi/titik-nol-km.jpg'
import obelix from '@/assets/Destinasi/obelix-hills.jpg'
import gumukPasir from '@/assets/Destinasi/gumuk-pasir.jpg'
import goaPindul from '@/assets/Destinasi/goa-pindul.jpg'
import sriGethuk from '@/assets/Destinasi/air-terjun-sri-gethuk.jpg'
import pinusPengger from '@/assets/Destinasi/hutan-pinus-pengger.jpg'
import kalibiru from '@/assets/Destinasi/kalibiru.jpg'
import indrayanti from '@/assets/Destinasi/pantai-indrayanti.jpg'
import tamansari from '@/assets/Destinasi/taman-sari.jpg'
import avanza from '@/assets/Mobil/avanza.png'
import innova from '@/assets/Mobil/innova.png'
import alphard from '@/assets/Mobil/alphard.png'

import { useRouter } from 'vue-router'

const router = useRouter()

function goToRentalPage() {
  router.push('/CarRent')  // Ganti sesuai path halaman rental mobil kamu
}
function goToDestinationPage() {
  router.push('/Destination')  // Ganti sesuai path halaman rental mobil kamu
}
function goToPackagePage() {
  router.push('/Package')  // Ganti sesuai path halaman rental mobil kamu
}


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
  },
  {
    nama: 'Gunung Merapi',
    deskripsi: 'Gunung berapi paling aktif di Indonesia yang menawarkan petualangan jeep lava tour dan panorama menakjubkan.',
    gambar: merapi
  },
  {
    nama: 'Tugu Jogja',
    deskripsi: 'Monumen ikonik sebagai simbol kota Yogyakarta yang sering dijadikan spot foto wisatawan.',
    gambar: tugu
  },
  {
    nama: 'Benteng Vredeburg',
    deskripsi: 'Benteng peninggalan Belanda yang kini menjadi museum sejarah perjuangan bangsa.',
    gambar: vredeburg
  },
  {
    nama: 'Monumen Jogja Kembali',
    deskripsi: 'Museum berbentuk kerucut yang menggambarkan perjuangan rakyat Yogyakarta saat kemerdekaan.',
    gambar: monjali
  },
  {
    nama: 'Titik Nol KM',
    deskripsi: 'Pusat keramaian dan simbol awal jalanan utama kota Yogyakarta, sering dijadikan tempat nongkrong.',
    gambar: titikNol
  },
  {
    nama: 'Obelix Hills',
    deskripsi: 'Destinasi wisata hits di atas bukit dengan spot foto instagramable dan pemandangan sunset memukau.',
    gambar: obelix
  },
  {
    nama: 'Gumuk Pasir',
    deskripsi: 'Hamparan pasir seperti gurun yang jadi tempat sandboarding favorit wisatawan.',
    gambar: gumukPasir
  },
  {
    nama: 'Goa Pindul',
    deskripsi: 'Goa bawah tanah yang bisa dijelajahi dengan tubing menyusuri sungai bawah tanah.',
    gambar: goaPindul
  },
  {
    nama: 'Air Terjun Sri Gethuk',
    deskripsi: 'Air terjun alami yang eksotis di Gunungkidul dengan aliran jernih di tengah tebing batu.',
    gambar: sriGethuk
  },
  {
    nama: 'Hutan Pinus Pengger',
    deskripsi: 'Hutan pinus sejuk dengan instalasi seni kayu unik yang cocok untuk hunting foto.',
    gambar: pinusPengger
  },
  {
    nama: 'Kalibiru',
    deskripsi: 'Wisata alam di perbukitan dengan spot foto di atas pohon dan pemandangan Waduk Sermo.',
    gambar: kalibiru
  },
  {
    nama: 'Pantai Indrayanti',
    deskripsi: 'Pantai pasir putih yang bersih dan tertata, cocok untuk wisata keluarga.',
    gambar: indrayanti
  },
  {
    nama: 'Taman Sari',
    deskripsi: 'Bekas taman kerajaan Kesultanan Yogyakarta dengan lorong bawah tanah dan kolam pemandian.',
    gambar: tamansari
  }
]
const Rental = [
  {
    nama: 'Toyota Avanza',
    deskripsi: 'Mobil keluarga yang nyaman dan irit bahan bakar, cocok untuk perjalanan harian maupun liburan bersama keluarga.',
    gambar: avanza// contoh gambar Avanza
  },
  {
    nama: 'Toyota Innova',
    deskripsi: 'MPV andalan dengan kabin luas dan fitur lengkap, memberikan kenyamanan ekstra untuk perjalanan jauh.',
    gambar: innova
  },
  {
    nama: 'Toyota Alphard',
    deskripsi: 'Mobil mewah dengan interior premium dan fitur lengkap, cocok untuk perjalanan bisnis atau acara istimewa.',
    gambar: alphard
  }
]

const Packages = [
   {
        nama: 'Paket Wisata Kota',
        deskripsi: 'Nikmati keindahan kota Yogyakarta dan belajar tentang budaya Yogyakarta dengan kunjungan ke Keraton Yogyakarta, Taman Sari, Malioboro',
        gambar: "https://assets-a1.kompasiana.com/items/album/2023/09/15/keraton-yogyakarta-650405b908a8b526932b67e2.jpg"
      },
      {
        nama: 'Paket Wisata Alam',
        deskripsi: 'Jelajahi alam Yogyakarta seperti Goa Pindul, Kalibiru, dan Pantai Parangtritis.',
        gambar: "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/original/events/2020/12/22/49a96f72-c387-4c50-bb85-02c381fc0195-1608638257347-9999a67ed9efb83861d0057a525f891c.jpg"
      },
      {
        nama: 'Paket Relax',
        deskripsi: 'Eksplore Yogyakarta sambil relax dengan destinasi populer dan guide berpengalaman.',
        gambar: "https://cdn.paradisotour.co.id/wp-content/uploads/2024/07/Gumuk-Pasir-Parangkusumo.jpg"
      },
      {
        nama: 'Paket Keluarga',
        deskripsi: 'Liburan seru untuk keluarga dengan itinerary ramah anak dan akomodasi nyaman.',
        gambar: "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg"
      }
]

const scrollContainer = ref(null)
onMounted(() => {
  setInterval(() => {
    const wrappers = document.querySelectorAll('.scroll-wrapper')
    wrappers.forEach(el => {
      if (el.scrollLeft + el.clientWidth >= el.scrollWidth - 10) {
        el.scrollTo({ left: 0, behavior: 'smooth' })
      } else {
        el.scrollBy({ left: 300, behavior: 'smooth' })
      }
    })
  }, 5000)
})

</script>

<template>
  <!-- Hero Section -->
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
        data-aos-delay="200">
        Lihat Destinasi
      </a>
    </div>
  </header>
  
<!-- Destinasi Terkenal Section -->
<section id="destinasi" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-4" data-aos="fade-up">
      Destinasi Terkenal di Yogyakarta
    </h2>
    <p class="lead text-center">
      Jelajahi berbagai destinasi wisata menarik di Yogyakarta dan sekitarnya. Temukan pengalaman liburan tak terlupakan!
    </p>
    <!-- Konten Card + Tombol di Samping -->
    <div class="d-flex justify-content-center gap-4 flex-wrap">
      <!-- Kartu Rental Mobil -->
      <div class="scroll-wrapper mb-4">
      <div class="destinasi-element-card" v-for="(item, i) in destinasi" :key="i">
        <img :src="item.gambar" class="img-fluid rounded" :alt="item.nama" />
        <h5 class="mt-3 fw-bold">{{ item.nama }}</h5>
        <p class="text-muted">{{ item.deskripsi }}</p>
      </div>
        <!-- Tombol di Samping -->
      <div class="d-flex align-items-center">
        <button @click="goToDestinationPage" class="btn btn-warning btn-lg d-flex align-items-center gap-2 shadow">
          Lihat Selengkapnya
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
      </div>
    </div>

    
  </div>
</section>
<!-- Rental mobil Section -->
  <section id="CarRent" class="py-5 bg-light">
  <div class="container">
    <!-- Judul Tetap di Atas -->
    <h3 class="text-center fw-bold mb-4" data-aos="fade-up">
      Rental Mobil</h3>
      <p class="lead text-center">
      Temukan mobil terbaik untuk kebutuhan perjalanan Anda di Jogja dan sekitarnya. Kami menyediakan berbagai pilihan mobil dengan harga terjangkau dan pelayanan terbaik.
    </p>
<!-- Konten Card + Tombol di Samping -->
    <div class="d-flex justify-content-center gap-4 flex-wrap">
      <!-- Kartu Rental Mobil -->
      <div class="scroll-wrapper mb-4">
      <div class="element-card" v-for="(item, i) in Rental" :key="i">
        <img :src="item.gambar" class="img-fluid rounded" :alt="item.nama" />
        <h5 class="mt-3 fw-bold">{{ item.nama }}</h5>
        <p class="text-muted">{{ item.deskripsi }}</p>
      </div>
        <!-- Tombol di Samping -->
      <div class="d-flex align-items-center">
        <button @click="goToRentalPage" class="btn btn-warning btn-lg d-flex align-items-center gap-2 shadow">
          Lihat Selengkapnya
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
      </div>
    </div>
  </div>
</section>
<!-- Paket Liburan Section -->
<section id="Package" class="py-5 bg-light">
  <div class="container">
    <!-- Judul Tetap di Atas -->
  <h4 class="text-center fw-bold mb-4" data-aos="fade-up">
    Paket Liburan
  </h4>
  <p class="lead text-center">
      Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan. Tentunya kamu masih bisa custom paket wisata!
    </p>
    <!-- Konten Card + Tombol di Samping -->
    <div class="d-flex justify-content-center gap-4 flex-wrap">
      <!-- Kartu Rental Mobil -->
      <div class="scroll-wrapper mb-4">
      <div class="element-card" v-for="(item, i) in Packages" :key="i">
        <img :src="item.gambar" class="img-fluid rounded" :alt="item.nama" />
        <h5 class="mt-3 fw-bold">{{ item.nama }}</h5>
        <p class="text-muted">{{ item.deskripsi }}</p>
      </div>
        <!-- Tombol di Samping -->
      <div class="d-flex align-items-center">
        <button @click="goToPackagePage" class="btn btn-warning btn-lg d-flex align-items-center gap-2 shadow">
          Lihat Selengkapnya
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
      </div>
    </div>
  </div>
</section>

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
      
      <div class="text-center small text-muted">
        &copy; 2023 Dewiji Explore. All Rights Reserved.
      </div>
    </div>
  </footer>
</template>

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

.scroll-wrapper {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  gap: 1rem;
  padding-bottom: 1rem;
  scrollbar-width: thin;
}

.scroll-wrapper::-webkit-scrollbar {
  height: 8px;
}

.scroll-wrapper::-webkit-scrollbar-thumb {
  background-color: #888;
  border-radius: 4px;
}
.border-success{
  border-color: #198754 !important;
}
.destinasi-element-card {
  flex: 0 0 auto;
  width: 400px;
  background: white;
  border-radius: 1rem;
  padding: 1rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.element-card {
  flex: 0 0 auto;
  width: 350px;
  background: white;
  border-radius: 1rem;
  padding: 1rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
