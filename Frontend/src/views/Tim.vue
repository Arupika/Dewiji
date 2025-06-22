<template>
  
    <!-- Team Section Header -->
    <div class="container py-3 py-md-5">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h1 class="mb-3 fw-bold display-5 text-primary">Tim Kami</h1>
          <p class="lead text-muted">
            Tim Pengembang Website Ini.
          </p>
          <div class="divider mx-auto bg-success" style="width: 80px; height: 3px;"></div>
        </div>
      </div>
    </div>

    <!-- Team Members -->
    <div class="row g-4 justify-content-center">
      <div 
        class="col-sm-6 col-md-4 col-lg-3" 
        v-for="(member, index) in teamMembers" 
        :key="index"
      >
        <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
          <div class="member-photo">
            <img 
              :src="member.foto" 
              class="img-fluid w-100 h-100 object-fit-cover" 
              :alt="member.nama"
              loading="lazy"
            >
          </div>
          <div class="card-body text-center px-3 py-4">
            <h5 class="card-title fw-bold mb-1">{{ member.nama }}</h5>
            <p class="text-success small mb-2">{{ member.jabatan }}</p>
            <p class="card-text small text-muted mb-0">{{ member.deskripsi }}</p>
          </div>
          <div class="card-footer bg-transparent border-0 text-center pb-3">
          </div>
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

<script>
export default {
  setup() {
    const teamMembers = [
      {
        nama: " Irzha Fahrizaldy",
        jabatan: "isi job",
        deskripsi: "23.11.5385",
        foto: '/src/assets/team/Irzha.jpg'
      },
      {
        nama: "Rayyis Hammam Mukhayyar",
        jabatan: "Perancang Destinasi",
        deskripsi: "23.11.5405",
        foto: '/src/assets/team/Rei.jpeg'
      },
      {
        nama: "Samuel Jari Hartako ",
        jabatan: "isi job",
        deskripsi: "23.11.5389",
        foto: '/src/assets/team/Samuel.jpeg'
      },
      {
        nama: "Halimatussadiyah Lola Putri ",
        jabatan: "isi job",
        deskripsi: "23.11.5398",
        foto: '/src/assets/team/Putri.jpg'
      },
      {
        nama: "Chintya Sheila Masterina ",
        jabatan: "isi job",
        deskripsi: "23.11.5404",
        foto: '/src/assets/team/Shila.jpg'
      },
      {
        nama: "Ilham Bintang Saputra",
        jabatan: "isi job",
        deskripsi: "23.11.5432",
        foto: '/src/assets/team/Bintang.jpg'
      },
    ];

    return {
      teamMembers
    };
  }
};
</script>

<style scoped>
.card {
  transition: all 0.3s ease;
  border: 1px solid rgba(0,0,0,0.1);
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.member-photo {
  height: 250px;
  overflow: hidden;
}

.hover-primary:hover {
  color: #0d6efd !important;
}

.divider {
  opacity: 0.7;
}

.rounded-3 {
  border-radius: 0.7rem !important;
}

.object-fit-cover {
  object-fit: cover;
  object-position: center;
}
</style>