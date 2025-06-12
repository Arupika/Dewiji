<script setup>
import { onMounted, ref } from 'vue'
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
    gambar: "https://prambanan.injourneydestination.id/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-13-at-13.37.22_f4268807.jpg"
  },
  {
    nama: 'Pantai Parangtritis',
    deskripsi: 'Pantai mistis dengan ombak besar dan pemandangan matahari terbenam yang menakjubkan, erat dengan legenda Ratu Kidul.',
    gambar: "https://blog-images.reddoorz.com/uploads/ckeditor/pictures/3753/content_pantai_parangtritis.jpg"
  },
  {
    nama: 'Malioboro',
    deskripsi: 'Jalan ikonik di jantung kota Yogyakarta yang dipenuhi pedagang, kuliner khas, dan nuansa budaya Jawa yang kental.',
    gambar: "https://www.yogyes.com/id/yogyakarta-tourism-object/other/malioboro/1.jpg"
  },
  {
    nama: 'Bukit Breksi',
    deskripsi: 'Bekas tambang batu kapur yang disulap menjadi destinasi wisata dengan relief seni, panorama alam, dan spot foto unik.',
    gambar: "https://asset-2.tstatic.net/travel/foto/bank/images/pemandangan-sunset-dari-tebing-breksi.jpg"
  },
  {
    nama: 'Keraton Yogyakarta',
    deskripsi: 'Istana resmi Kesultanan Yogyakarta yang masih aktif, menyuguhkan arsitektur klasik dan nilai budaya tinggi.',
    gambar: "https://kadowisudaku.com/wp-content/uploads/2018/03/Info-Lengkap-Objek-Wisata-Sejarah-Kraton-Yogyakarta-Kraton_Yogyakarta_Pagelaran.jpg"
  },
  {
    nama: 'Gunung Merapi',
    deskripsi: 'Gunung berapi paling aktif di Indonesia yang menawarkan petualangan jeep lava tour dan panorama menakjubkan.',
    gambar: "https://cdn.rri.co.id/berita/Yogyakarta/o/1729504978290-mount-merapi-113620_1280/7gdeea17tmc4r0w.jpeg"
  },
  {
    nama: 'Tugu Jogja',
    deskripsi: 'Monumen ikonik sebagai simbol kota Yogyakarta yang sering dijadikan spot foto wisatawan.',
    gambar: "https://yogya.co/wp-content/uploads/tugu-jogja.webp"
  },
  {
    nama: 'Benteng Vredeburg',
    deskripsi: 'Benteng peninggalan Belanda yang kini menjadi museum sejarah perjuangan bangsa.',
    gambar: "https://asset.kompas.com/crops/S9CnIn7qLJSrgqt9jFPyPaClkCw=/0x0:597x398/1200x800/data/photo/2021/09/16/61433b6621325.jpg"
  },
  {
    nama: 'Monumen Jogja Kembali',
    deskripsi: 'Museum berbentuk kerucut yang menggambarkan perjuangan rakyat Yogyakarta saat kemerdekaan.',
    gambar: "https://cdn.rri.co.id/berita-foto/Yogyakarta/o/1730264707236-WhatsApp_Image_2024-10-24_at_21.55.50(1)/szvsiiu4sqgxhxp.jpeg"
  },
  {
    nama: 'Titik Nol KM',
    deskripsi: 'Pusat keramaian dan simbol awal jalanan utama kota Yogyakarta, sering dijadikan tempat nongkrong.',
    gambar: "https://asset.kompas.com/crops/tp7dCEi1zgzGJG-ZhoFOZwi2TGs=/0x0:972x648/1200x800/data/photo/2021/12/26/61c813b14760e.png"
  },
  {
    nama: 'Obelix Hills',
    deskripsi: 'Destinasi wisata hits di atas bukit dengan spot foto instagramable dan pemandangan sunset memukau.',
    gambar: "https://www.yogyes.com/id/yogyakarta-tourism-object/other/obelix-hills/1.jpg"
  },
  {
    nama: 'Gumuk Pasir',
    deskripsi: 'Hamparan pasir seperti gurun yang jadi tempat sandboarding favorit wisatawan.',
    gambar: "https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/ayojogjakarta/images/post/articles/2021/07/18/45251/gumuk-pasir.jpeg"
  },
  {
    nama: 'Goa Pindul',
    deskripsi: 'Goa bawah tanah yang bisa dijelajahi dengan tubing menyusuri sungai bawah tanah.',
    gambar: "https://visitingjogja.jogjaprov.go.id/wp-content/uploads/2021/04/106921857_2692730127668337_6628211008296078543_n-1024x681.jpg"
  },
  {
    nama: 'Air Terjun Sri Gethuk',
    deskripsi: 'Air terjun alami yang eksotis di Gunungkidul dengan aliran jernih di tengah tebing batu.',
    gambar: "https://labirutour.com/wp-content/uploads/2016/04/Keindahan-Alam-Air-Terjun-Sri-Gethuk-Yogyakarta-Bara-Purnomo.jpg"
  },
  {
    nama: 'Hutan Pinus Pengger',
    deskripsi: 'Hutan pinus sejuk dengan instalasi seni kayu unik yang cocok untuk hunting foto.',
    gambar: "https://asset.kompas.com/crops/x4CiCXv80iFcxxnE_Vm3TDS2S1M=/0x0:780x390/1200x800/data/photo/2018/12/27/776378636.jpg"
  },
  {
    nama: 'Kalibiru',
    deskripsi: 'Wisata alam di perbukitan dengan spot foto di atas pohon dan pemandangan Waduk Sermo.',
    gambar: "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit1440960gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg"
  },
  {
    nama: 'Pantai Indrayanti',
    deskripsi: 'Pantai pasir putih yang bersih dan tertata, cocok untuk wisata keluarga.',
    gambar: "https://nagantour.com/wp-content/uploads/2023/09/pantai-indrayanti.webp"
  },
  {
    nama: 'Taman Sari',
    deskripsi: 'Bekas taman kerajaan Kesultanan Yogyakarta dengan lorong bawah tanah dan kolam pemandian.',
    gambar: "https://asset.kompas.com/crops/nOQ3a7G-PrgyRoSVCR2vvlWiLFQ=/0x0:1000x667/750x500/data/photo/2022/03/13/622e12c85befb.jpg"
  }
]
const Rental = [
  {
    nama: 'Toyota Avanza',
    deskripsi: 'Mobil keluarga yang nyaman dan irit bahan bakar, cocok untuk perjalanan harian maupun liburan bersama keluarga.',
    gambar: "https://www.toyota.astra.co.id//sites/default/files/2023-09/1-avanza-purplish-silver.png"// contoh gambar Avanza
  },
  {
    nama: 'Toyota Innova',
    deskripsi: 'MPV andalan dengan kabin luas dan fitur lengkap, memberikan kenyamanan ekstra untuk perjalanan jauh.',
    gambar: "https://www.toyota.astra.co.id//sites/default/files/2020-10/1_innova-super-white-2_0.png"
  },
  {
    nama: 'Toyota Alphard',
    deskripsi: 'Mobil mewah dengan interior premium dan fitur lengkap, cocok untuk perjalanan bisnis atau acara istimewa.',
    gambar: "https://arinatoyota.co.id/wp-content/uploads/2018/11/vellfire-2021-colors-black-1-600x330.png"
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
  <!-- Hero Section dengan Background -->
<header class="position-relative text-white d-flex align-items-center justify-content-center" style="min-height: 100vh; background-image: url('/src/assets/merapi.png'); background-size: cover; background-position: center;">
  <!-- Overlay gelap -->
  <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

  <!-- Konten -->
  <div class="container text-center position-relative z-1 p-4">
    <h1 class="display-4 fw-bold" data-aos="fade-down">
      Selamat Datang di <span class="text-warning">Dewiji!</span>
    </h1>
    <p class="lead mt-3 text-white" data-aos="fade-up" data-aos-delay="100">
  Temukan pesona wisata Yogyakarta yang kaya akan budaya, alam, dan sejarah.  
  Dari pantai hingga candi, semua destinasi terbaik kami rangkum untuk Anda jelajahi!
</p>

    <a href="#destinasi"
   class="btn btn-warning text-white mt-4 px-4 py-2 shadow"
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
        <img :src="item.gambar" loading="lazy" class="img-fluid rounded" :alt="item.nama" />
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
        <img :src="item.gambar" loading="lazy" class="img-fluid rounded" :alt="item.nama" />
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
        <img :src="item.gambar" loading="lazy" class="img-fluid rounded" :alt="item.nama" />
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
      
    </div>
  </footer>
</template>
