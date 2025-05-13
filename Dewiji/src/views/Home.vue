<script setup>
import { onMounted } from 'vue'
import lottie from 'lottie-web'

onMounted(() => {
  lottie.loadAnimation({
    container: document.getElementById('lottie'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'https://lottie.host/7996208b-a64d-409d-87a7-6720fad13f67/ZzAwJgKRhn.json'
  })
})
</script>

<template>
  <header class="hero-section py-5 text-white">
    <div class="container">
      <div class="row align-items-center g-5">
        <!-- kolom teks -->
        <div class="col-lg-6 text-center text-lg-start">
          <h1 class="display-4 fw-bold" data-aos="fade-down">
            Selamat Datang di <span class="text-warning">Dewiji!</span>
          </h1>
          <p class="lead mt-3" data-aos="fade-up" data-aos-delay="100">
  Temukan pesona wisata Yogyakarta yang kaya akan budaya, alam, dan sejarah.  
  Dari pantai hingga candi, semua destinasi terbaik kami rangkum untuk Anda jelajahi!
</p>

         <RouterLink
  to="/destination"
  class="btn btn-warning mt-4 px-4 py-2 shadow grow-on-hover"
  data-aos="zoom-in"
  data-aos-delay="200">
  Lihat Destinasi
</RouterLink>


        </div>

        <!-- kolom animasi -->
        <div class="col-lg-6 text-center">
          <div class="p-3 rounded-4 bg-white bg-opacity-10 shadow" style="backdrop-filter: blur(8px);" data-aos="fade-left" data-aos-delay="300">
            <div id="lottie" style="max-width: 300px; margin: auto;"></div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<style scoped>
.hero-section {
  background: linear-gradient(135deg, #00c896, #00cfff);
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
}



</style>