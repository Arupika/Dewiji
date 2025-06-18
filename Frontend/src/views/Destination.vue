<template>
  <link rel="preload" :href="destinations[0].gambar" as="image">
  <div class="container py-5">
    <!-- Hero Section -->
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1 class="mb-4 fw-bold display-5">Destinasi Wisata Jogja</h1>
          <p class="lead">Jelajahi berbagai destinasi wisata menarik di Yogyakarta dan sekitarnya. Temukan pengalaman liburan tak terlupakan!</p>
        </div>
      </div>
    </div>

    <!-- Destination Cards -->
    <div class="row g-4">
      <div class="col-md-4" v-for="(destination, index) in destinations" :key="index">
        <div class="card h-100 shadow-sm">
          <div class="card-img-top">
            <img :src="destination.gambar" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" :alt="destination.nama" loading="lazy" width="300" height="200"/>
          </div>
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ destination.nama }}</h5>
            <p class="text-muted mb-3">
              <i class="bi bi-geo-alt-fill text-success"></i> {{ destination.location }}
            </p>
            
            <div class="mb-3">
              <span class="badge bg-success bg-opacity-10 text-success me-2" v-for="(category, i) in destination.kategori" :key="i">
                {{ category }}
              </span>
            </div>
            
            <p class="card-text" :class="{ 'text-truncate': !destination.showFull }">
              {{ destination.deskripsi || 'Deskripsi belum tersedia' }}
            </p>
            
            <div v-if="destination.harga" class="mb-3">
              <h6 class="fw-bold mb-2">Harga Tiket:</h6>
              <div class="d-flex justify-content-between mb-1" v-for="(price, type) in destination.harga" :key="type">
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
            <button class="btn btn-success btn-sm w-100" @click="showDestinationDetails(destination)">
              <i class="bi bi-info-circle me-2"></i>Cek Selengkapnya
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer Section -->
  <<footer class="bg-dark text-light pt-5 pb-4">
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

<script>
export default {
  data() {
    return {
      destinations: [
        {
          id: 1,
          nama: "Gunung Merapi",
          deskripsi: "Gunung Merapi merupakan salah satu destinasi wisata alam paling ikonik di Indonesia, terletak di perbatasan Daerah Istimewa Yogyakarta dan Jawa Tengah. Dikenal sebagai gunung berapi paling aktif di Indonesia, Merapi tidak hanya menawarkan pesona keindahan alam yang luar biasa, tetapi juga menyimpan kisah sejarah, budaya, dan kekuatan alam yang memukau.",
          gambar: '/src/assets/destination/merapi.jpg',
          location: "Sleman, DIY",
          kategori: ["Alam", "Petualangan"],
          harga: {
            "Dewasa": "Rp 50.000",
            "Anak-anak": "Rp 25.000"
          },
          jamOperasional: "Setiap hari 08:00 - 17:00 WIB"
        },
        {
          id: 2,
          nama: "Keraton Yogyakarta",
          deskripsi: "Keraton Yogyakarta, atau secara resmi disebut Keraton Ngayogyakarta Hadiningrat, adalah istana resmi Sultan Yogyakarta sekaligus pusat kebudayaan Jawa yang masih hidup hingga kini. Terletak di pusat Kota Yogyakarta, keraton ini bukan sekadar bangunan bersejarah, melainkan simbol hidup dari warisan budaya, tradisi, dan filosofi Jawa.",
          gambar: '/src/assets/destination/keraton.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Sejarah", "Budaya"],
          harga: {
            "Dewasa": "Rp 20.000",
            "Pelajar": "Rp 10.000"
          },
          jamOperasional: "Setiap hari 08:30 - 14:00 WIB (kecuali hari Senin)"
        },
        {
          id: 3,
          nama: "Candi Prambanan",
          deskripsi: "Candi Prambanan adalah kompleks candi Hindu terbesar dan termegah di Indonesia, bahkan di Asia Tenggara. Terletak di perbatasan Daerah Istimewa Yogyakarta dan Jawa Tengah, Candi Prambanan merupakan simbol kejayaan peradaban Hindu abad ke-9 dan menjadi salah satu Warisan Budaya Dunia UNESCO sejak tahun 1991.",
          gambar: '/src/assets/destination/prambanan.jpg',
          location: "Sleman, DIY",
          kategori: ["Sejarah", "UNESCO"],
          harga: {
            "Turis Domestik": "Rp 50.000",
            "Turis Asing": "Rp 250.000"
          },
          jamOperasional: "Setiap hari 06:00 - 17:00 WIB"
        },
        {
          id: 4,
          nama: "Pantai Parangtritis",
          deskripsi: "Pantai Parangtritis adalah salah satu destinasi wisata paling terkenal di Yogyakarta, terletak sekitar 27 km ke arah selatan dari pusat kota. Pantai ini tidak hanya menawarkan panorama alam yang indah, tetapi juga menyimpan nilai historis, budaya, dan spiritual yang kuat.",
          gambar: '/src/assets/destination/parangtritis.jpg',
          location: "Bantul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Parkir Motor": "Rp 2.000",
            "Parkir Mobil": "Rp 5.000"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 5,
          nama: "Jalan Malioboro",
          deskripsi: "Jalan Malioboro adalah ikon wisata paling terkenal di Yogyakarta. Terletak di jantung kota, Malioboro bukan sekadar jalan saja ia adalah denyut nadi kehidupan kota yang memadukan sejarah, belanja, seni, dan budaya Jawa dalam satu jalur yang hidup selama 24 jam.",
          gambar: '/src/assets/destination/malioboro.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Belanja", "Kuliner"],
          jamOperasional: "24 Jam"
        },
        {
          id: 6,
          nama: "Tugu Jogja",
          deskripsi: "Tugu Jogja, atau juga dikenal sebagai Tugu Pal Putih, adalah salah satu landmark paling ikonik di Yogyakarta. Monumen bersejarah ini bukan hanya titik penanda geografis, tetapi juga memiliki makna filosofis mendalam bagi masyarakat Jogja dan para pengunjungnya.",
          gambar: '/src/assets/destination/tugu.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Landmark", "Sejarah"],
          jamOperasional: "24 Jam"
        },
        {
          id: 7,
          nama: "Benteng Vredeburg",
          deskripsi: "Benteng Vredeburg adalah salah satu situs sejarah paling penting di Yogyakarta, yang kini difungsikan sebagai museum perjuangan nasional. Terletak strategis di ujung Jalan Malioboro, benteng ini menjadi saksi bisu perjalanan panjang bangsa Indonesia dari masa penjajahan hingga kemerdekaan.",
          gambar: '/src/assets/destination/vredeburg.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Sejarah", "Museum"],
          harga: {
            "Dewasa": "Rp 3.000",
            "Anak Anak": "Rp 2.000"
          },
          jamOperasional: "08:00 - 16:00 WIB (Senin tutup)"
        },
        {
          id: 8,
          nama: "Tebing Breksi",
          deskripsi: "Tebing Breksi adalah destinasi wisata unik di Sleman, Yogyakarta, yang menyajikan keindahan tebing batu kapur berpadu dengan seni ukir dan panorama alam. Terletak di kawasan perbukitan Desa Sambirejo, dekat Candi Ijo dan Candi Ratu Boko, Tebing Breksi menjadi magnet baru bagi wisatawan pencinta foto, seni, dan alam terbuka.",
          gambar: '/src/assets/destination/breksi.jpg',
          location: "Sleman, DIY",
          kategori: ["Alam", "Seni"],
          harga: {
            "Weekday": "Rp 10.000",
            "Weekend": "Rp 15.000"
          },
          jamOperasional: "08:00 - 17:00 WIB"
        },
        {
          id: 9,
          nama: "Monumen Jogja Kembali",
          deskripsi: "Monumen Jogja Kembali, atau yang lebih dikenal sebagai Monjali, adalah monumen sejarah yang dibangun untuk mengenang perjuangan rakyat Yogyakarta dalam mempertahankan kemerdekaan Indonesia. Terletak di Ngaglik, Sleman, sekitar 6 km dari pusat Kota Yogyakarta, Monjali menjadi simbol semangat perjuangan dan nasionalisme yang patut dikenang.",
          gambar: '/src/assets/destination/monjali.jpg',
          location: "Sleman, DIY",
          kategori: ["Sejarah", "Monumen"],
          harga: {
            "Dewasa": "Rp 15.000",
            "Anak-anak": "Rp 10.000"
          },
          jamOperasional: "08:00 - 16:00 WIB"
        },
        {
          id: 10,
          nama: "Titik Nol KM",
          deskripsi: "Titik Nol Kilometer Yogyakarta adalah salah satu landmark paling ikonik dan ramai dikunjungi di jantung Kota Yogyakarta. Terletak di pertemuan jalan utama (Jalan Ahmad Yani, Jalan Trikora, dan Jalan Senopati), titik ini menandai pusat administratif dan simbolis Kota Jogja, tempat di mana sejarah, budaya, dan kehidupan urban bertemu.",
          gambar: '/src/assets/destination/titik-nol-km.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Landmark", "Sejarah"],
          jamOperasional: "24 Jam"
        },
        {
          id: 11,
          nama: "Obelix Hills",
          deskripsi: "Obelix Hills adalah destinasi wisata dengan pemandangan alam yang indah di kawasan perbukitan Yogyakarta. Tempat ini menawarkan panorama kota Yogyakarta dari ketinggian yang memukau, terutama saat matahari terbit atau terbenam.",
          gambar: '/src/assets/destination/obelix-hills.jpg',
          location: "Sleman, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Weekday": "Rp 20.000",
            "Weekend": "Rp 25.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 12,
          nama: "Gumuk Pasir",
          deskripsi: "Gumuk Pasir adalah fenomena alam unik berupa bukit pasir yang terbentuk secara alami di pesisir pantai Yogyakarta. Tempat ini merupakan salah satu dari sedikit gurun pasir yang ada di Indonesia dan menjadi daya tarik wisata yang unik.",
          gambar: '/src/assets/destination/gumuk-pasir.jpg',
          location: "Bantul, DIY",
          kategori: ["Alam", "Unik"],
          harga: {
            "Wisatawan": "Rp 15.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 13,
          nama: "Goa Pindul",
          deskripsi: "Goa Pindul adalah destinasi wisata petualangan berupa gua vertikal dengan aktivitas cave tubing yang menantang. Pengunjung akan mengapung di atas ban dalam menyusuri sungai bawah tanah sambil menikmati keindahan stalaktit dan stalagmit.",
          gambar: '/src/assets/destination/goa-pindul.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Petualangan", "Alam"],
          harga: {
            "Paket Reguler": "Rp 75.000",
            "Paket VIP": "Rp 125.000"
          },
          jamOperasional: "08:00 - 16:00 WIB"
        },
        {
          id: 14,
          nama: "Air Terjun Sri Gethuk",
          deskripsi: "Air Terjun Sri Gethuk adalah salah satu air terjun paling indah di Yogyakarta yang terletak di Kabupaten Gunungkidul. Air terjun ini memiliki keunikan berupa susunan batu kapur yang membentuk undakan alami dengan air jernih yang mengalir deras.",
          gambar: '/src/assets/destination/air-terjun-sri-gethuk.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Alam", "Air Terjun"],
          harga: {
            "Tiket Masuk": "Rp 15.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 15,
          nama: "Hutan Pinus Pengger",
          deskripsi: "Hutan Pinus Pengger adalah destinasi wisata alam dengan pemandangan hutan pinus yang asri dan spot foto menarik. Terletak di kawasan perbukitan, tempat ini menawarkan panorama kota Yogyakarta dari ketinggian dengan udara yang sejuk.",
          gambar: '/src/assets/destination/hutan-pinus-pengger.jpg',
          location: "Bantul, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Tiket Masuk": "Rp 10.000"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 16,
          nama: "Hutan Mangrove",
          deskripsi: "Hutan Mangrove di Kulon Progo adalah destinasi ekowisata yang menawarkan pengalaman menyusuri sungai di antara hutan bakau yang rimbun. Pengunjung bisa menikmati keindahan alam sambil belajar tentang pentingnya ekosistem mangrove.",
          gambar: '/src/assets/destination/hutan-mangrove.jpg',
          location: "Kulonprogo, DIY",
          kategori: ["Alam", "Ekowisata"],
          harga: {
            "Harga Masuk": "Rp 5.000/orang"
          },
          jamOperasional: "08:00 - 17:00 WIB"
        },
        {
          id: 17,
          nama: "Kalibiru",
          deskripsi: "Kalibiru adalah destinasi wisata alam di Kulon Progo yang terkenal dengan spot foto di atas bukit dengan pemandangan Waduk Sermo dan perbukitan menakjubkan. Tempat ini juga menawarkan berbagai aktivitas outbound dan flying fox.",
          gambar: '/src/assets/destination/kalibiru.jpg',
          location: "Kulonprogo, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Harga Masuk": "Rp 20.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 18,
          nama: "Waduk Sermo",
          deskripsi: "Waduk Sermo adalah bendungan air yang terletak di Kulon Progo dengan pemandangan alam yang indah. Pengunjung bisa menikmati suasana tenang sambil berjalan-jalan di sekitar waduk atau menyewa perahu untuk berkeliling.",
          gambar: '/src/assets/destination/Waduk-Sermo.jpg',
          location: "Kulonprogo, DIY",
          kategori: ["Alam", "Waduk"],
          harga: {
            "Tiket Masuk": "Rp 5.000",
            "Sewa Perahu": "Rp 50.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 19,
          nama: "Pantai Indrayanti",
          deskripsi: "Pantai Indrayanti adalah salah satu pantai terindah di Gunungkidul dengan pasir putih dan air laut yang jernih. Pantai ini dilengkapi dengan berbagai fasilitas seperti gazebo, restoran, dan toilet yang nyaman.",
          gambar: '/src/assets/destination/pantai-indrayanti.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Weekday": "Rp 10.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 20,
          nama: "Pantai Pok Tunggal",
          deskripsi: "Pantai Pok Tunggal adalah pantai tersembunyi di Gunungkidul dengan tebing-tebing karang yang indah dan ombak yang tenang. Pantai ini cocok untuk mereka yang ingin menikmati suasana pantai yang lebih sepi dan alami.",
          gambar: '/src/assets/destination/pantai-pok-tunggal.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Tiket Masuk": "Rp 10.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 21,
          nama: "Bukit Bintang",
          deskripsi: "Bukit Bintang adalah destinasi wisata alam di Bantul yang menawarkan pemandangan kota Yogyakarta dari ketinggian, terutama indah saat malam hari dengan gemerlap lampu kota. Tempat ini juga populer untuk camping dan melihat bintang.",
          gambar: '/src/assets/destination/Bukit-Bintang.jpg',
          location: "Bantul, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Parkir Motor": "Rp 5.000",
            "Parkir Mobil": "Rp 10.000"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 22,
          nama: "Heha Sky View",
          deskripsi: "Heha Sky View adalah destinasi wisata dengan pemandangan spektakuler dari ketinggian. Terletak di Gunungkidul, tempat ini menawarkan berbagai spot foto instagramable dengan latar belakang perbukitan dan langit yang luas.",
          gambar: '/src/assets/destination/Heha-skyview.png',
          location: "Gunungkidul, DIY",
          kategori: ["Pemandangan", "Alam"],
          harga: {
            "Weekday": "Rp 30.000",
            "Weekend": "Rp 40.000"
          },
          jamOperasional: "08:00 - 22:00 WIB"
        },
        {
          id: 23,
          nama: "Heha Ocean View",
          deskripsi: "Heha Ocean View adalah destinasi wisata dengan pemandangan laut lepas dari ketinggian. Terletak di Gunungkidul, tempat ini menawarkan berbagai spot foto menarik dengan latar belakang Samudera Hindia yang biru.",
          gambar: '/src/assets/destination/Heha-Ocean.jpeg',
          location: "Gunungkidul, DIY",
          kategori: ["Pemandangan", "Alam"],
          harga: {
            "Weekday": "Rp 30.000",
            "Weekend": "Rp 40.000"
          },
          jamOperasional: "08:00 - 22:00 WIB"
        },
        {
          id: 24,
          nama: "Pantai Jungwok Blue Ocean",
          deskripsi: "Pantai Jungwok Blue Ocean adalah pantai eksotis di Gunungkidul dengan air laut berwarna biru kehijauan yang jernih. Pantai ini dikelilingi tebing-tebing karang yang indah dan cocok untuk snorkeling.",
          gambar: '/src/assets/destination/Pantai-Jungwok.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Weekday": "Rp 30.000",
            "Weekend": "Rp 35.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
         {
          id: 25,
          nama: "Obelix Sea View",
          deskripsi: "Obelix Sea View adalah destinasi wisata yang menawarkan pengalaman unik menikmati panorama Laut Selatan dari ketinggian. Terletak di Hutan Giricahyo, Kecamatan Purwosari, Kabupaten Gunungkidul, tempat ini berada di timur Pantai Parangtritis dan dapat dijangkau dengan perjalanan sekitar 31 km dari pusat Kota Yogyakarta melalui Jalan Jogja-Parangtritis.",
          gambar: '/src/assets/destination/obelix-sea-view.jpeg',
          location: "Gunungkidul, DIY",
          kategori: ["Pemandangan", "Alam"],
          harga: {
            "Weekday": "Rp 30.000",
            "Weekend": "Rp 40.000"
          },
          jamOperasional: "08:00 - 21:00 WIB"
        },
         {
          id: 26,
          nama: "Taman Sari",
          deskripsi: "Taman Sari, dikenal juga sebagai Istana Air, adalah kompleks bersejarah yang dulunya merupakan taman kerajaan Kesultanan Yogyakarta. Dibangun pada masa Sultan Hamengkubuwono I antara tahun 1758–1765, kompleks ini berfungsi sebagai tempat peristirahatan, meditasi, pertahanan, dan rekreasi bagi keluarga kerajaan. Terletak sekitar 750 meter dari Alun-Alun Kidul, Taman Sari kini menjadi destinasi wisata budaya yang memikat dengan perpaduan arsitektur Jawa dan Eropa. ",
          gambar: '/src/assets/destination/taman-sari.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Landmark", "Sejarah"],
          harga: {
            "Wisatawan Lokal": "Rp 7.500",
            "Wisatawan Mancanegara": "Rp 15.000"
          },
          jamOperasional: "09:00 - 15:00 WIB"
        },
         {
          id: 27,
          nama: "Keraton Ratu Boko",
          deskripsi: "Ratu Boko adalah situs purbakala yang berada di atas bukit, sekitar 3 km dari Candi Prambanan, tepatnya di Desa Bokoharjo, Sleman, Yogyakarta. Meski sering disebut sebagai candi, Ratu Boko bukanlah tempat ibadah, melainkan reruntuhan kompleks istana kuno yang diperkirakan dibangun pada abad ke-8 Masehi oleh Wangsa Syailendra atau Mataram Kuno. Terletak di ketinggian sekitar 196 meter di atas permukaan laut, kompleks ini menyuguhkan pemandangan alam spektakuler dan sunset terbaik di Yogyakarta.",
          gambar: '/src/assets/destination/ratu-boko.jpg',
          location: "Sleman, DIY",
          kategori: ["Budaya", "Sejarah"],
          harga: {
            "Wisatawan Lokal": "Rp 40.000",
            "Wisatawan Mancanegara": "Rp 100.000"
          },
          jamOperasional: "09:00 - 17:00 WIB"
        },
        {
          id: 28,
         nama: "Pantai Ngobaran",
          deskripsi: "Pantai Ngobaran menawarkan keunikan perpaduan budaya dan alam, dengan keberadaan pura, mushola, dan seni patung yang berdampingan di tepi laut. Terletak di Gunungkidul, pantai ini cocok bagi pengunjung yang ingin menikmati sunset dalam suasana sakral dan eksotis.",
          gambar: '/src/assets/destination/pantai-ngobaran.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Wisatawan Lokal": "Rp 10.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 29,
          nama: "Kebun Buah Mangunan",
          deskripsi: "Kebun Buah Mangunan merupakan destinasi alam yang menawarkan panorama perbukitan hijau dan kabut pagi yang memukau, sering disebut “Negeri di Atas Awan.” Lokasinya berada di Dlingo, Bantul, dan cocok untuk menikmati sunrise serta udara sejuk, sambil menikmati fasilitas kebun buah dan gardu pandang.",
          gambar: '/src/assets/destination/kebun-buah-mangunan.jpg',
          location: "Bantul, DIY",
          kategori: ["Wisata", "Alam"],
          harga: {
            "Weekday": "Rp 7.000",
            "Weekend": "Rp 8.000"
          },
          jamOperasional: "04:30 - 18:00 WIB"
        },
        {
          id: 30,
          nama: "Pantai Parangkusumo",
          deskripsi: "Pantai Parangkusumo terkenal dengan aura mistis dan spiritualnya, sering menjadi lokasi upacara adat seperti Labuhan. Terletak di Bantul, pantai ini menyuguhkan pemandangan laut selatan yang kuat dan sunset yang indah.",
          gambar: '/src/assets/destination/Parang-Kusumo.jpg',
          location: "Bantul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Wisatawan": "Rp 10.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 31,
          nama: "Puncak Becici",
          deskripsi: "Puncak Becici adalah kawasan hutan pinus alami di Bantul yang menawarkan suasana sejuk, pemandangan perbukitan hingga laut selatan, dan spot selfie kekinian. Tempat ini sangat cocok untuk bersantai, menikmati sunset, berkemah, atau sekadar berjalan di bawah rindangnya pepohonan.",
          gambar: '/src/assets/destination/puncak-becici.jpg',
          location: "bantul, DIY",
          kategori: ["Wisata", "Alam"],
          harga: {
            "Wisatawan": "Rp 5.000",
            "Parkir": "Rp 10.000"
          },
          jamOperasional: "08:00 - 22:00 WIB"
        },
        {
          id: 32,
          nama: "Pantai Sepanjang",
          deskripsi: "Pantai Sepanjang di Gunungkidul dikenal sebagai salah satu pantai berpasir putih terpanjang di kawasan selatan Yogyakarta. Suasananya masih alami, dengan ombak yang cukup besar, deretan warung kayu, dan cocok untuk keluarga yang ingin bersantai atau bermain air.",
          gambar: '/src/assets/destination/pantaisepanjang.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Wisatawan": "Rp 10.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 33,
          nama: "Candi Kalasan",
          deskripsi: "Candi Kalasan adalah salah satu peninggalan Buddha tertua di Yogyakarta yang dibangun pada abad ke-8. Terletak di Sleman, candi ini menampilkan relief halus, arsitektur unik, dan nuansa sejarah yang kuat, menjadikannya situs menarik untuk wisata budaya dan arkeologi.",
          gambar: '/src/assets/destination/candi-kalasan.jpeg',
          location: "Sleman, DIY",
          kategori: ["Budaya", "Sejarah"],
          harga: {
            "Wisatawan Lokal": "Rp 5.000",
            "Wisatawan Mancanegara": "Rp 10.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 34,
          nama: "Candi Ijo",
          deskripsi: "Candi Ijo berdiri di atas bukit tertinggi di Yogyakarta, menyuguhkan perpaduan arsitektur Hindu kuno dan panorama matahari terbenam yang luar biasa. Suasana tenang dan pemandangan dari ketinggian menjadikan tempat ini populer bagi wisatawan pencinta sejarah dan fotografi.",
          gambar: '/src/assets/destination/candi-ijo.jpeg',
          location: "Sleman, DIY",
          kategori: ["Budaya", "Sejarah"],
          harga: {
            "Wisatawan Lokal": "Rp 7.000",
            "Wisatawan Mancanegara": "Rp 15.000"
          },
          jamOperasional: "09:00 - 17:00 WIB"
        },
        {
          id: 35,
          nama: "Taman Pintar",
          deskripsi: "Taman Pintar merupakan pusat wisata edukasi interaktif di pusat Kota Yogyakarta, ideal untuk anak-anak dan keluarga. Dengan berbagai zona sains, teknologi, dan seni yang menarik, tempat ini memadukan pembelajaran dan hiburan dalam satu kunjungan yang menyenangkan.",
          gambar: '/src/assets/destination/taman-pintar.jpg',
          location: "Yogyakarta, DIY",
          kategori: ["Edukasi", "Keluarga"],
          harga: {
            "Wisatawan": "Rp 12.000"
          },
          jamOperasional: "08:30 - 16:00 WIB"
        },
        {
          id: 36,
          nama: "Goa Jomblang",
          deskripsi: "Goa Jomblang adalah goa vertikal purba di Gunungkidul yang terkenal dengan “cahaya surga” yang masuk dari atas lubang goa. Wisata ini menantang adrenalin karena pengunjung harus turun dengan tali, namun akan terbayar dengan keindahan lorong bawah tanah dan vegetasi purba.",
          gambar: '/src/assets/destination/Goa-Jomblang.jpg',
          location: "Gunungkidul, DIY",
          kategori: ["Petualangan", "Alam"],
          harga: {
            "Wisatawan": "Rp 450.000"
          },
          jamOperasional: "08:00 - 14:00 WIB"
        }
      ].map(item => ({ ...item, showFull: false }))
    };
  },
 methods: {
  showDestinationDetails(destination) {
    // Format harga untuk ditampilkan
    let hargaHtml = '';
    if (destination.harga) {
      hargaHtml += '<div class="text-start mt-3"><h6 class="fw-bold">Harga Tiket:</h6><ul class="list-unstyled">';
      for (const [type, price] of Object.entries(destination.harga)) {
        hargaHtml += `<li class="d-flex justify-content-between"><span>${type}:</span> <span class="fw-bold text-success">${price}</span></li>`;
      }
      hargaHtml += '</ul></div>';
    }

    // Format jam operasional
    let jamHtml = '';
    if (destination.jamOperasional) {
      jamHtml = `<div class="text-start mt-3"><h6 class="fw-bold">Jam Operasional:</h6><p>${destination.jamOperasional}</p></div>`;
    }

    // Format kategori
    let kategoriHtml = '';
    if (destination.kategori && destination.kategori.length > 0) {
      kategoriHtml = `<div class="d-flex flex-wrap gap-2 mb-3">${
        destination.kategori.map(k => `<span class="badge bg-success bg-opacity-10 text-success">${k}</span>`).join('')
      }</div>`;
    }

    Swal.fire({
      title: destination.nama,
      html: `
        <div class="text-start">
          <div class="mb-3">
            <div style="max-height: 300px; overflow: hidden; display: flex; justify-content: center; align-items: center; border-radius: 0.5rem; margin-bottom: 1rem;">
              <img src="${destination.gambar}" style="width: 100%; height: auto; object-fit: cover;" alt="${destination.nama}">
            </div>
            <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill text-success"></i> ${destination.location}</p>
            ${kategoriHtml}
            <p class="mb-0">${destination.deskripsi || 'Deskripsi belum tersedia'}</p>
          </div>
          ${hargaHtml}
          ${jamHtml}
        </div>
      `,
      showCloseButton: true,
      confirmButtonText: 'Tutup',
      confirmButtonColor: '#198754',
      width: '500px',
      customClass: {
        popup: 'rounded-3',
        htmlContainer: 'text-start'
      }
    });
  }
}
};
</script>