<template>
  <div class="container py-5">
    <Transition name="fade" appear>
      <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
          <h1 class="fw-bold display-5">FAQ</h1>
          <p class="lead">Temukan jawaban dari pertanyaan Anda di sini</p>
        </div>
      </div>
    </Transition>

    <Transition name="fade" appear>
      <div class="input-group mb-5 shadow-sm rounded-pill overflow-hidden">
        <input
          type="text"
          class="form-control border-0 py-3 ps-4"
          placeholder="Type your topic here (e.g. rental mobil, refund)"
          v-model="searchQuery"
        />
        <button class="btn btn-primary px-4 py-3 border-0" type="button">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </Transition>

    <section class="mb-5">
      <h4 class="fw-semibold mb-3">Popular Topics</h4>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <div class="col" v-for="faq in filteredFaqs" :key="faq.id">
          <button
            class="card card-hover h-100 p-3 d-flex flex-row justify-content-between align-items-center"
            @click="showTopicDetail(faq)"
          >
            <span>{{ faq.title }}</span>
            <i class="bi bi-chevron-right ms-2"></i>
          </button>
        </div>
        <div v-if="!filteredFaqs.length" class="col-12 text-muted text-center py-3">Tidak ada hasil ditemukan.</div>
      </div>
    </section>

    <section class="mb-5">
      <h4 class="fw-semibold mb-3">Explore by Service</h4>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <button
          class="btn btn-outline-dark btn-square"
          v-for="cat in allCategories"
          :key="cat.slug"
          @click="filterByCategory(cat.slug)"
          :class="{ 'active-category': searchQuery === cat.slug }"
        >
          {{ cat.name }}
        </button>
        <button
          v-if="searchQuery"
          class="btn btn-outline-secondary btn-square"
          @click="clearFilter"
        >
          Tampilkan Semua
        </button>
      </div>
    </section>

    <nav v-if="pagination.last_page > 1" class="mt-4">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
          <button class="page-link" @click="changePage(pagination.current_page - 1)">
            &laquo;
          </button>
        </li>
        <li
          class="page-item"
          v-for="page in pagination.last_page"
          :key="page"
          :class="{ active: page === pagination.current_page }"
        >
          <button class="page-link" @click="changePage(page)">{{ page }}</button>
        </li>
        <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
          <button class="page-link" @click="changePage(pagination.current_page + 1)">
            &raquo;
          </button>
        </li>
      </ul>
    </nav>
  </div>

  <div v-if="selectedTopic" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3">
        <div class="modal-header">
          <h5 class="modal-title">{{ selectedTopic.title }}</h5>
          <button type="button" class="btn-close" @click="selectedTopic = null"></button>
        </div>
        <div class="modal-body">
          <p>{{ selectedTopic.answer }}</p>
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

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/api'

const faqs = ref([]) // Untuk FAQ yang dipaginasi (Popular Topics)
const allFaqsForCategories = ref([]) // NEW: Untuk mendapatkan semua kategori tanpa pagination
const searchQuery = ref('')
const selectedTopic = ref(null)
const pagination = ref({ current_page: 1, last_page: 1 })

// Fungsi untuk mengambil FAQ yang dipaginasi
const fetchFaqs = async (page = 1) => {
  try {
    const res = await api.get(`/api/faqs?page=${page}`)
    faqs.value = res.data.data.data || res.data.data // Sesuaikan jika API hanya mengembalikan array langsung
    pagination.value = {
      current_page: res.data.data.current_page,
      last_page: res.data.data.last_page,
    }
  } catch (err) {
    console.error('Gagal memuat FAQ paginated:', err)
  }
}

// NEW: Fungsi untuk mengambil SEMUA FAQ (hanya untuk kategori)
const fetchAllFaqsForCategories = async () => {
  try {
    // Asumsi: endpoint /api/faqs tanpa 'page' parameter mengembalikan SEMUA FAQ
    // Atau, jika ada endpoint khusus untuk kategori, gunakan itu.
    const res = await api.get('/api/faqs'); 
    allFaqsForCategories.value = res.data.data.data || res.data.data;
  } catch (err) {
    console.error('Gagal memuat semua FAQ untuk kategori:', err);
  }
}

const changePage = (page) => {
  pagination.value.current_page = page
  fetchFaqs(page)
}

const filteredFaqs = computed(() => {
  const query = searchQuery.value.toLowerCase().trim();
  if (!query) {
    // Tampilkan 6 FAQ teratas dari data yang dipaginasi jika tidak ada query
    // Atau, jika Anda ingin 6 "popular" dari SEMUA FAQ, gunakan allFaqsForCategories.value.slice(0,6)
    return faqs.value.slice(0, 6); 
  }
  // Filter dari data yang dipaginasi atau data yang diambil dengan `fetchFaqs`
  return faqs.value.filter(faq => // Perhatikan: ini masih memfilter dari FAQ yang dipaginasi
    faq.title.toLowerCase().includes(query) ||
    faq.answer.toLowerCase().includes(query) ||
    (Array.isArray(faq.category) ? faq.category.some(cat => cat.toLowerCase().includes(query)) : faq.category?.toLowerCase().includes(query))
  );
})

// NEW: Computed property untuk semua kategori, diambil dari `allFaqsForCategories`
const allCategories = computed(() => {
  const unique = {};
  allFaqsForCategories.value.forEach(faq => { // Menggunakan data lengkap
    const cat = faq.category;
    if (Array.isArray(cat)) {
      cat.forEach(c => unique[c] = true);
    } else if (cat) {
      unique[cat] = true;
    }
  });
  return Object.keys(unique).map(slug => ({
    slug,
    name: slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
  })).sort((a,b) => a.name.localeCompare(b.name));
});

const filterByCategory = (slug) => {
  searchQuery.value = slug;
  // Saat filter kategori diklik, kita perlu mengambil FAQ yang sesuai dari API
  // Jika API Anda mendukung filter berdasarkan kategori:
  // fetchFaqs(1, { category: slug }); // Anda mungkin perlu memodifikasi fetchFaqs agar menerima parameter filter
  // Karena API Anda saat ini hanya menggunakan 'page', kita filter di frontend
}

const clearFilter = () => {
  searchQuery.value = '';
}

const showTopicDetail = (faq) => {
  selectedTopic.value = faq;
}

onMounted(() => {
  fetchFaqs(); // Ambil FAQ yang dipaginasi untuk "Popular Topics"
  fetchAllFaqsForCategories(); // Ambil semua FAQ (atau kategori) untuk "Explore by Service"
});
</script>

<style scoped>
/* Search Input Custom */
.input-group input.form-control {
  border-right: 0;
}
.input-group button.btn {
  border-left: 0;
  background-color: var(--bs-primary); /* Warna hijau default Bootstrap */
  color: white;
}
.input-group.shadow-sm {
  box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}
.input-group.rounded-pill {
  border-radius: 50px;
}

/* Popular Topics Card Style */
.card-hover {
  background-color: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 0.5rem;
  transition: all 0.3s ease;
  cursor: pointer;
  text-align: left;
  font-weight: 500;
  font-size: 1rem;
  color: #333;
  /* Button reset for card-like appearance */
  padding: 1rem;
  background-color: #fff;
  width: 100%;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.card-hover:hover {
  background-color: #f8f9fa; /* Light background on hover */
  border-color: #1d976c; /* Green border on hover */
  transform: translateY(-3px); /* Slight lift effect */
  box-shadow: 0 4px 8px rgba(0,0,0,.1);
}
.card-hover span {
  flex-grow: 1;
}
.card-hover i {
  color: #6c757d; /* Grey icon color */
}

/* Explore by Service Buttons */
.btn-square {
  min-width: 120px; 
  height: 60px; 
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  border-radius: 0.75rem; 
  font-weight: 600;
  white-space: nowrap; 
  border: 1px solid #dee2e6;
  color: #343a40; 
  background-color: #f8f9fa; 
  transition: all 0.2s ease;
}

.btn-square.btn-outline-dark:hover,
.btn-square.active-category {
  background-color: #1d976c; 
  color: white;
  border-color: #1d976c;
  box-shadow: 0 2px 5px rgba(0,0,0,.15);
}

/* Pagination Style */
.page-item.active .page-link {
  background-color: #1d976c; 
  border-color: #1d976c;
  color: #fff;
}
.page-link {
  color: #1d976c; 
}
</style>