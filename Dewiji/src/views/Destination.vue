<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Destinasi Yogyakarta</h1>
    <div class="row g-4">
      <div class="col-md-4" v-for="(destinasi, index) in destinations" :key="index">
        <div class="card h-100 shadow-sm">
          <img :src="destinasi.gambar" class="card-img-top" :alt="destinasi.nama" />
          <div class="card-body">
            <h5 class="card-title">{{ destinasi.nama }}</h5>
            <p class="card-text" :class="{ 'text-truncate': !destinasi.showFull }">{{ destinasi.deskripsi }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <button class="btn btn-success btn-sm" @click="toggleDescription(index)">{{ destinasi.showFull ? 'Sembunyikan' : 'Cek Selengkapnya' }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      destinations: [
        {
          id: 1,
          nama: "Gunung Merapi",
          deskripsi: "Gunung Merapi merupakan salah satu destinasi wisata alam paling ikonik di Indonesia, terletak di perbatasan Daerah Istimewa Yogyakarta dan Jawa Tengah. Dikenal sebagai gunung berapi paling aktif di Indonesia, Merapi tidak hanya menawarkan pesona keindahan alam yang luar biasa, tetapi juga menyimpan kisah sejarah, budaya, dan kekuatan alam yang memukau. ",
          gambar: "https://media.suara.com/pictures/653x366/2025/03/19/91008-wisata-di-lereng-merapi.webp",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 2,
          nama: "Keraton Yogyakarta",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://kadowisudaku.com/wp-content/uploads/2018/03/Info-Lengkap-Objek-Wisata-Sejarah-Kraton-Yogyakarta-Kraton_Yogyakarta_Pagelaran.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 3,
          nama: "Candi Prambanan",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://prambanan.injourneydestination.id/wp-content/uploads/2024/11/WhatsApp-Image-2024-11-13-at-13.37.22_f4268807.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 4,
          nama: "Pantai Parangtritis",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://blog-images.reddoorz.com/uploads/ckeditor/pictures/3753/content_pantai_parangtritis.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
         {
          id: 5,
          nama: "Jalan Malioboro",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://perizinan.jogjakota.go.id/upload/kontent/bfbac156a5c5d001ef798a4f7f5e8a3b_gap-masyarakat-bawah-dan-atas-yogyakarta-paling-tinggi-kok-bisa-An6q9hn5OF.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 6,
          nama: "Tugu Jogja",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://i0.wp.com/yogyacreative.com/wp-content/uploads/2022/08/Tugu-Pal-Putih-Jogjabike-sumber-jogjabike.id_.jpg?resize=750%2C500&ssl=1",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 7,
          nama: "Benteng Vredeburg",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://asset.kompas.com/crops/S9CnIn7qLJSrgqt9jFPyPaClkCw=/0x0:597x398/1200x800/data/photo/2021/09/16/61433b6621325.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 8,
          nama: "Tebing Breksi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://asset-2.tstatic.net/travel/foto/bank/images/pemandangan-sunset-dari-tebing-breksi.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 9,
          nama: "Monumen Jogja Kembali",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://cdn.rri.co.id/berita-foto/Yogyakarta/o/1730264707236-WhatsApp_Image_2024-10-24_at_21.55.50(1)/szvsiiu4sqgxhxp.jpeg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 10,
          nama: "Titik Nol KM ",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://atourin.obs.ap-southeast-3.myhuaweicloud.com/images/destination/yogyakarta/titik-nol-km-jogja-profile1646131657.png?x-image-process=image/resize,p_100,limit_1/imageslim",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 11,
          nama: "Gunung Merapi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://perizinan.jogjakota.go.id/upload/kontent/bfbac156a5c5d001ef798a4f7f5e8a3b_gap-masyarakat-bawah-dan-atas-yogyakarta-paling-tinggi-kok-bisa-An6q9hn5OF.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        {
          id: 12,
          nama: "Gunung Merapi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://perizinan.jogjakota.go.id/upload/kontent/bfbac156a5c5d001ef798a4f7f5e8a3b_gap-masyarakat-bawah-dan-atas-yogyakarta-paling-tinggi-kok-bisa-An6q9hn5OF.jpg",
          location: "Daerah Istimewa Yogyakarta",
          rating: 4.8
        },
        
      ] .map(item => ({ ...item, showFull: false })) 
    };
  },
   methods: {
    toggleDescription(index) {
      this.destinations[index].showFull = !this.destinations[index].showFull;
    }
  }
};
</script>

<style scoped>
.card-img-top {
  height: 220px;       
  object-fit: cover;   
  width: 100%;         
}


.card {
  transition: transform 0.2s;
}
.card:hover {
  transform: scale(1.02);
}


.card-body {
  min-height: 150px;   
}

.text-truncate {
  display: -webkit-box;
 
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>