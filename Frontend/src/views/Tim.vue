<template>
  <div class="container py-5">
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
  </div>
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