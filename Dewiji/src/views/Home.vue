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
      <h2 class="text-center fw-bold mb-4" data-aos="fade-up">Destinasi Terkenal di Yogyakarta</h2>

      <div class="destinasi-scroll-wrapper" ref="scrollContainer">
        <div class="destinasi-card" v-for="(item, i) in destinasi" :key="i">
          <img :src="item.gambar" class="img-fluid rounded" :alt="item.nama" />
          <h5 class="mt-3 fw-bold">{{ item.nama }}</h5>
          <p class="text-muted">{{ item.deskripsi }}</p>
        </div>
      </div>
    </div>
  </section>
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

.destinasi-scroll-wrapper {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  gap: 1rem;
  padding-bottom: 1rem;
  scrollbar-width: thin;
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
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>