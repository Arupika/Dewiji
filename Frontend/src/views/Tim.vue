<template>
  <div class="container py-4 py-md-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h1 class="mb-3 fw-bold display-5 text-primary">Tim Kami</h1>
        <p class="lead text-muted">
          Kenalan dengan para pengembang di balik website ini.
        </p>
        <div
          class="divider mx-auto bg-success"
          style="width: 80px; height: 3px"
        ></div>
      </div>
    </div>
  </div>

  <div class="container pb-5">
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
            />
          </div>
          <div class="card-body text-center px-3 py-4">
            <h5 class="card-title fw-bold mb-1">{{ member.nama }}</h5>
            <p class="text-success small mb-2">{{ member.jabatan }}</p>
            <p class="card-text small text-muted mb-0">
              {{ member.deskripsi }}
            </p>
          </div>
          <div class="card-footer bg-transparent border-0 text-center pb-3">
            </div>
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
      <router-link to="/Comment" class="text-light text-decoration-none hover-success">FAQ</router-link>
    </li>
  </ul>
</div>

        
        <!-- Sosial Media-->
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
// // Mengekspor objek konfigurasi komponen Vue.
export default {
  // // Fungsi setup() adalah bagian dari Composition API di Vue.
  // // Semua yang di-'return' dari sini akan bisa diakses di dalam <template>.
  setup() {
    // // Mendefinisikan data anggota tim secara langsung dalam sebuah array objek.
    // // Data ini bersifat statis (hardcoded), tidak diambil dari database atau API.
    const teamMembers = [
      {
        nama: "Irzha Fahrizaldy",
        jabatan: "Frontend & Backend Developer",
        deskripsi: "NIM: 23.11.5385",
        foto: "/src/assets/team/Irzha.jpg",
      },
      {
        nama: "Rayyis Hammam Mukhayyar",
        jabatan: "Frontend Developer",
        deskripsi: "NIM: 23.11.5405",
        foto: "/src/assets/team/Rei.jpeg",
      },
      {
        nama: "Samuel Jari Hartako",
        jabatan: "Frontend Developer",
        deskripsi: "NIM: 23.11.5389",
        foto: "/src/assets/team/Samuel.jpeg",
      },
      {
        nama: "Halimatussadiyah Lola Putri",
        jabatan: "Frontend Developer",
        deskripsi: "NIM: 23.11.5398",
        foto: "/src/assets/team/Putri.jpg",
      },
      {
        nama: "Chintya Sheila Masterina",
        jabatan: "Frontend Developer",
        deskripsi: "NIM: 23.11.5404",
        foto: "/src/assets/team/Shila.jpg",
      },
      {
        nama: "Ilham Bintang Saputra",
        jabatan: "Frontend Developer",
        deskripsi: "NIM: 23.11.5432",
        foto: "/src/assets/team/Bintang.jpg",
      },
    ];

    // // Variabel ini menghitung tahun saat ini, meskipun tidak digunakan di template saat ini.
    const currentYear = new Date().getFullYear();

    // // Mengembalikan data agar bisa digunakan di dalam <template>.
    return {
      teamMembers, // // Array ini akan digunakan oleh v-for di template.
      currentYear,
    };
  },
};
</script>

<style scoped>
/* // 'scoped' berarti gaya CSS ini hanya berlaku untuk komponen ini saja, tidak akan "bocor" ke komponen lain. */

/* // Memberi efek transisi yang mulus pada kartu. */
.card {
  transition: all 0.3s ease;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

/* // Efek saat kursor mouse berada di atas kartu. */
.card:hover {
  transform: translateY(-8px); /* // Mengangkat kartu sedikit ke atas. */
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important; /* // Menambahkan bayangan yang lebih jelas. */
}

/* // Mengatur ukuran kontainer foto agar seragam. */
.member-photo {
  height: 250px;
  overflow: hidden; /* // Menyembunyikan bagian gambar yang melebihi kontainer. */
}

/* // Efek hover untuk ikon sosial media (jika ditambahkan di masa depan). */
.social-icon:hover {
  background-color: var(--bs-success) !important;
  border-color: var(--bs-success) !important;
  color: #fff !important;
}

/* // CSS untuk elemen pembatas di bawah judul. */
.divider {
  opacity: 0.7;
}

/* // Kustomisasi radius sudut. */
.rounded-3 {
  border-radius: 0.7rem !important;
}

/* // Memastikan gambar mengisi area foto tanpa merusak rasio aspek (tidak gepeng atau terdistorsi). */
.object-fit-cover {
  object-fit: cover; /* // Gambar akan dipotong (jika perlu) agar pas mengisi kontainer. */
  object-position: center; /* // Fokus pemotongan di tengah gambar. */
}
</style>