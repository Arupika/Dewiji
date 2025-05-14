<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Destinasi Yogyakarta</h1>
    <div class="row g-4">
      <div class="col-md-4" v-for="(destinasi, index) in destinations" :key="index">
        <div class="card h-100 shadow-sm">
          <img :src="destinasi.gambar" class="card-img-top" :alt="destinasi.nama" />
          <div class="card-body">
            <h5 class="card-title">{{ destinasi.nama }}</h5>
            <p class="card-text">{{ destinasi.deskripsi }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <button class="btn btn-success btn-sm">Cek Selengkapnya</button>
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
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80",
          harga: 500000,
          location: "Bali",
          rating: 4.8
        },
        {
          id: 2,
          nama: "Gunung Merapi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80",
          harga: 500000,
          location: "Bali",
          rating: 4.8
        },
        {
          id: 3,
          nama: "Gunung Merapi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80",
          harga: 500000,
          location: "Bali",
          rating: 4.8
        },
        {
          id: 4,
          nama: "Gunung Merapi",
          deskripsi: "Pantai terkenal dengan ombak yang bagus untuk berselancar...",
          gambar: "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80",
          harga: 500000,
          location: "Bali",
          rating: 4.8
        },
        
      ]
    };
  }
};
</script>

<style scoped>
.hero-section {
  background: linear-gradient(135deg, #00c896, #00cfff);
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
}



</style>