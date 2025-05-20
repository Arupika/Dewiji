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
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Home</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">destinasi</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Rental Mobil</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Paket Liburan</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Kritik & Saran</a></li>
          </ul>
        </div>
        
        <!-- Sosial Media -->
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
      
      <hr class="my-4 bg-secondary">
      
      <div class="text-center small text-muted">
        &copy; 2023 Dewiji Explore. All Rights Reserved.
      </div>
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
          gambar: "https://cdn.rri.co.id/berita/Yogyakarta/o/1729504978290-mount-merapi-113620_1280/7gdeea17tmc4r0w.jpeg",
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
          gambar: "https://kadowisudaku.com/wp-content/uploads/2018/03/Info-Lengkap-Objek-Wisata-Sejarah-Kraton-Yogyakarta-Kraton_Yogyakarta_Pagelaran.jpg",
          location: "Yogyakarta, DIY",
          kategori: ["Sejarah", "Budaya"],
          harga: {
            "Dewasa": "Rp 20.000",
            "Pelajar": "Rp 10.000"
          },
          jamOperasional: "Setiap hari 08:30 - 14:00 WIB (kecuali Jumat sampai 13:00)"
        },
        {
          id: 3,
          nama: "Candi Prambanan",
          deskripsi: "Candi Prambanan adalah kompleks candi Hindu terbesar dan termegah di Indonesia, bahkan di Asia Tenggara. Terletak di perbatasan Daerah Istimewa Yogyakarta dan Jawa Tengah, Candi Prambanan merupakan simbol kejayaan peradaban Hindu abad ke-9 dan menjadi salah satu Warisan Budaya Dunia UNESCO sejak tahun 1991.",
          gambar: "https://prambanan.injourneydestination.id/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-13-at-13.37.22_f4268807.jpg",
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
          gambar: "https://blog-images.reddoorz.com/uploads/ckeditor/pictures/3753/content_pantai_parangtritis.jpg",
          location: "Bantul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Parkir Motor": "Rp 5.000",
            "Parkir Mobil": "Rp 10.000"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 5,
          nama: "Jalan Malioboro",
          deskripsi: "Jalan Malioboro adalah ikon wisata paling terkenal di Yogyakarta. Terletak di jantung kota, Malioboro bukan sekadar jalan saja ia adalah denyut nadi kehidupan kota yang memadukan sejarah, belanja, seni, dan budaya Jawa dalam satu jalur yang hidup selama 24 jam.",
          gambar: "https://www.yogyes.com/id/yogyakarta-tourism-object/other/malioboro/1.jpg",
          location: "Yogyakarta, DIY",
          kategori: ["Belanja", "Kuliner"],
          jamOperasional: "24 Jam"
        },
        {
          id: 6,
          nama: "Tugu Jogja",
          deskripsi: "Tugu Jogja, atau juga dikenal sebagai Tugu Pal Putih, adalah salah satu landmark paling ikonik di Yogyakarta. Monumen bersejarah ini bukan hanya titik penanda geografis, tetapi juga memiliki makna filosofis mendalam bagi masyarakat Jogja dan para pengunjungnya.",
          gambar: "https://i0.wp.com/yogyacreative.com/wp-content/uploads/2022/08/Tugu-Pal-Putih-Jogjabike-sumber-jogjabike.id_.jpg?resize=750%2C500&ssl=1",
          location: "Yogyakarta, DIY",
          kategori: ["Landmark", "Sejarah"],
          jamOperasional: "24 Jam"
        },
        {
          id: 7,
          nama: "Benteng Vredeburg",
          deskripsi: "Benteng Vredeburg adalah salah satu situs sejarah paling penting di Yogyakarta, yang kini difungsikan sebagai museum perjuangan nasional. Terletak strategis di ujung Jalan Malioboro, benteng ini menjadi saksi bisu perjalanan panjang bangsa Indonesia dari masa penjajahan hingga kemerdekaan.",
          gambar: "https://asset.kompas.com/crops/S9CnIn7qLJSrgqt9jFPyPaClkCw=/0x0:597x398/1200x800/data/photo/2021/09/16/61433b6621325.jpg",
          location: "Yogyakarta, DIY",
          kategori: ["Sejarah", "Museum"],
          harga: {
            "Dewasa": "Rp 10.000",
            "Pelajar": "Rp 5.000"
          },
          jamOperasional: "08:00 - 16:00 WIB (Senin tutup)"
        },
        {
          id: 8,
          nama: "Tebing Breksi",
          deskripsi: "Tebing Breksi adalah destinasi wisata unik di Sleman, Yogyakarta, yang menyajikan keindahan tebing batu kapur berpadu dengan seni ukir dan panorama alam. Terletak di kawasan perbukitan Desa Sambirejo, dekat Candi Ijo dan Candi Ratu Boko, Tebing Breksi menjadi magnet baru bagi wisatawan pencinta foto, seni, dan alam terbuka.",
          gambar: "https://asset-2.tstatic.net/travel/foto/bank/images/pemandangan-sunset-dari-tebing-breksi.jpg",
          location: "Sleman, DIY",
          kategori: ["Alam", "Seni"],
          harga: {
            "Weekday": "Rp 20.000",
            "Weekend": "Rp 30.000"
          },
          jamOperasional: "08:00 - 17:00 WIB"
        },
        {
          id: 9,
          nama: "Monumen Jogja Kembali",
          deskripsi: "Monumen Jogja Kembali, atau yang lebih dikenal sebagai Monjali, adalah monumen sejarah yang dibangun untuk mengenang perjuangan rakyat Yogyakarta dalam mempertahankan kemerdekaan Indonesia. Terletak di Ngaglik, Sleman, sekitar 6 km dari pusat Kota Yogyakarta, Monjali menjadi simbol semangat perjuangan dan nasionalisme yang patut dikenang.",
          gambar: "https://cdn.rri.co.id/berita-foto/Yogyakarta/o/1730264707236-WhatsApp_Image_2024-10-24_at_21.55.50(1)/szvsiiu4sqgxhxp.jpeg",
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
          gambar: "https://atourin.obs.ap-southeast-3.myhuaweicloud.com/images/destination/yogyakarta/titik-nol-km-jogja-profile1646131657.png?x-image-process=image/resize,p_100,limit_1/imageslim",
          location: "Yogyakarta, DIY",
          kategori: ["Landmark", "Sejarah"],
          jamOperasional: "24 Jam"
        },
        {
          id: 11,
          nama: "Obelix Hills",
          deskripsi: "Obelix Hills adalah destinasi wisata dengan pemandangan alam yang indah di kawasan perbukitan Yogyakarta. Tempat ini menawarkan panorama kota Yogyakarta dari ketinggian yang memukau, terutama saat matahari terbit atau terbenam.",
          gambar: "https://www.yogyes.com/id/yogyakarta-tourism-object/other/obelix-hills/1.jpg",
          location: "Sleman, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Weekday": "Rp 25.000",
            "Weekend": "Rp 35.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 12,
          nama: "Gumuk Pasir",
          deskripsi: "Gumuk Pasir adalah fenomena alam unik berupa bukit pasir yang terbentuk secara alami di pesisir pantai Yogyakarta. Tempat ini merupakan salah satu dari sedikit gurun pasir yang ada di Indonesia dan menjadi daya tarik wisata yang unik.",
          gambar: "https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/ayojogjakarta/images/post/articles/2021/07/18/45251/gumuk-pasir.jpeg",
          location: "Bantul, DIY",
          kategori: ["Alam", "Unik"],
          harga: {
            "Dewasa": "Rp 10.000",
            "Anak-anak": "Rp 5.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 13,
          nama: "Goa Pindul",
          deskripsi: "Goa Pindul adalah destinasi wisata petualangan berupa gua vertikal dengan aktivitas cave tubing yang menantang. Pengunjung akan mengapung di atas ban dalam menyusuri sungai bawah tanah sambil menikmati keindahan stalaktit dan stalagmit.",
          gambar: "https://visitingjogja.jogjaprov.go.id/wp-content/uploads/2021/04/106921857_2692730127668337_6628211008296078543_n-1024x681.jpg",
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
          gambar: "https://reezkypradata.com/wp-content/uploads/2017/07/Sri-Gethuk-1024x640.jpg",
          location: "Gunungkidul, DIY",
          kategori: ["Alam", "Air Terjun"],
          harga: {
            "Tiket Masuk": "Rp 15.000",
            "Parkir Motor": "Rp 5.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 15,
          nama: "Hutan Pinus Pengger",
          deskripsi: "Hutan Pinus Pengger adalah destinasi wisata alam dengan pemandangan hutan pinus yang asri dan spot foto menarik. Terletak di kawasan perbukitan, tempat ini menawarkan panorama kota Yogyakarta dari ketinggian dengan udara yang sejuk.",
          gambar: "https://asset.kompas.com/crops/x4CiCXv80iFcxxnE_Vm3TDS2S1M=/0x0:780x390/1200x800/data/photo/2018/12/27/776378636.jpg",
          location: "Bantul, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Tiket Masuk": "Rp 10.000",
            "Parkir Motor": "Rp 5.000"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 16,
          nama: "Hutan Mangrove",
          deskripsi: "Hutan Mangrove di Kulon Progo adalah destinasi ekowisata yang menawarkan pengalaman menyusuri sungai di antara hutan bakau yang rimbun. Pengunjung bisa menikmati keindahan alam sambil belajar tentang pentingnya ekosistem mangrove.",
          gambar: "https://visitingjogja.jogjaprov.go.id/wp-content/uploads/2016/11/hutan-mangrove-pantai-congot-2.jpg",
          location: "Kulonprogo, DIY",
          kategori: ["Alam", "Ekowisata"],
          harga: {
            "Perahu": "Rp 25.000/orang",
            "Jembatan Gantung": "Rp 10.000"
          },
          jamOperasional: "08:00 - 17:00 WIB"
        },
        {
          id: 17,
          nama: "Kalibiru",
          deskripsi: "Kalibiru adalah destinasi wisata alam di Kulon Progo yang terkenal dengan spot foto di atas bukit dengan pemandangan Waduk Sermo dan perbukitan menakjubkan. Tempat ini juga menawarkan berbagai aktivitas outbound dan flying fox.",
          gambar: "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit1440960gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg",
          location: "Kulonprogo, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Weekday": "Rp 20.000",
            "Weekend": "Rp 30.000"
          },
          jamOperasional: "07:00 - 17:00 WIB"
        },
        {
          id: 18,
          nama: "Waduk Sermo",
          deskripsi: "Waduk Sermo adalah bendungan air yang terletak di Kulon Progo dengan pemandangan alam yang indah. Pengunjung bisa menikmati suasana tenang sambil berjalan-jalan di sekitar waduk atau menyewa perahu untuk berkeliling.",
          gambar: "https://assets.telkomsel.com/public/2025-02/Waduk-Sermo-Salah-Satu-Wisata-Favorit-di-Kulon-Progo.jpg?VersionId=ut_BpZ0vWMXYBRLPxswxopAQDPBufYrx",
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
          gambar: "https://nagantour.com/wp-content/uploads/2023/09/pantai-indrayanti.webp",
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Weekday": "Rp 15.000",
            "Weekend": "Rp 20.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 20,
          nama: "Pantai Pok Tunggal",
          deskripsi: "Pantai Pok Tunggal adalah pantai tersembunyi di Gunungkidul dengan tebing-tebing karang yang indah dan ombak yang tenang. Pantai ini cocok untuk mereka yang ingin menikmati suasana pantai yang lebih sepi dan alami.",
          gambar: "https://visitingjogja.jogjaprov.go.id/wp-content/uploads/2017/01/pantai-pok-tunggal-1068x522.jpg",
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Tiket Masuk": "Rp 10.000",
            "Parkir Motor": "Rp 5.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
        {
          id: 21,
          nama: "Bukit Bintang",
          deskripsi: "Bukit Bintang adalah destinasi wisata alam di Bantul yang menawarkan pemandangan kota Yogyakarta dari ketinggian, terutama indah saat malam hari dengan gemerlap lampu kota. Tempat ini juga populer untuk camping dan melihat bintang.",
          gambar: "https://nagantour.com/wp-content/uploads/2023/02/bukit-bintang.webp",
          location: "Bantul, DIY",
          kategori: ["Alam", "Pemandangan"],
          harga: {
            "Tiket Masuk": "Rp 15.000",
            "Camping": "Rp 50.000/tenda"
          },
          jamOperasional: "24 Jam"
        },
        {
          id: 22,
          nama: "Heha Sky View",
          deskripsi: "Heha Sky View adalah destinasi wisata dengan pemandangan spektakuler dari ketinggian. Terletak di Gunungkidul, tempat ini menawarkan berbagai spot foto instagramable dengan latar belakang perbukitan dan langit yang luas.",
          gambar: "https://asset.kompas.com/crops/nQ7Ba-rY_JtUG0kpZMpyFIwe4-k=/165x0:1156x661/1200x800/data/photo/2022/01/13/61dfb44b7bce2.png",
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
          gambar: "https://cdn.rri.co.id/berita/Jakarta/o/1728296083732-1000514118/7o0fb3a7boyiwbc.jpeg",
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
          gambar: "https://ruangbogor.com/assets/berita/original/73961442388-santorini-5960352_960_720.jpg",
          location: "Gunungkidul, DIY",
          kategori: ["Pantai", "Alam"],
          harga: {
            "Tiket Masuk": "Rp 15.000",
            "Parkir Motor": "Rp 5.000"
          },
          jamOperasional: "06:00 - 18:00 WIB"
        },
         {
          id: 25,
          nama: "Obelix Sea View",
          deskripsi: "Obelix Sea View adalah destinasi wisata yang menawarkan pengalaman unik menikmati panorama Laut Selatan dari ketinggian. Terletak di Hutan Giricahyo, Kecamatan Purwosari, Kabupaten Gunungkidul, tempat ini berada di timur Pantai Parangtritis dan dapat dijangkau dengan perjalanan sekitar 31 km dari pusat Kota Yogyakarta melalui Jalan Jogja-Parangtritis.",
          gambar: "https://obelixseaview.com/images/galeri/DJI_09882.jpg",
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
          gambar: "https://asset.kompas.com/crops/nOQ3a7G-PrgyRoSVCR2vvlWiLFQ=/0x0:1000x667/750x500/data/photo/2022/03/13/622e12c85befb.jpg",
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
          gambar: "https://idsejarah.net/wp-content/uploads/2016/07/ratu-boko.jpg",
          location: "Sleman, DIY",
          kategori: ["Budaya", "Sejarah"],
          harga: {
            "Wisatawan Lokal": "Rp 40.000",
            "Wisatawan Mancanegara": "Rp 100.000"
          },
          jamOperasional: "09:00 - 17:00 WIB"
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

<style scoped>
/* Custom Styles */
.hover-success:hover {
  color: #198754 !important;
  border-color: #198754 !important;
}
.card {
  border-radius: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
  border: none;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
}
.card-img-top {
  overflow: hidden;
}
.card-img-top img {
  transition: transform 0.5s ease;
  height: 200px;
  object-fit: cover;
  width: 100%;
}
.card:hover .card-img-top img {
  transform: scale(1.05);
}
.btn-success {
  transition: all 0.3s ease;
  padding: 0.5rem 1rem;
}
.btn-success:hover {
  background-color: #157347;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
}
 .border-success{
  border-color: #198754 !important;
}
.text-truncate {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
/* Responsive adjustments */
@media (max-width: 768px) {
  .display-5 {
    font-size: 2rem;
  }
  .lead {
    font-size: 1rem;
  }
}
.card-body {
  min-height: 150px;
}
</style>