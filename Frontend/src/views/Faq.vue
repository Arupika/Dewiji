<template>
  <div class="container py-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-8 text-center">
        <h1 class="fw-bold display-5">FAQ</h1>
        <p class="lead">Temukan jawaban dari pertanyaan Anda di sini</p>
      </div>
    </div>

    <div class="mb-4">
      <input
        type="text"
        class="form-control rounded-pill"
        placeholder="Cari topik (misal: refund, rental mobil)"
        v-model="searchQuery"
      />
    </div>

    <section class="mb-5">
      <h4 class="fw-semibold mb-3">Popular Topics</h4>
      <div class="list-group shadow-sm">
        <button
          class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
          v-for="faq in filteredFaqs"
          :key="faq.id"
          @click="showTopicDetail(faq)"
        >
          {{ faq.title }}
          <i class="bi bi-chevron-right"></i>
        </button>
        <div v-if="!filteredFaqs.length" class="text-muted text-center py-3">Tidak ada hasil ditemukan.</div>
      </div>
    </section>

    <section>
      <h4 class="fw-semibold mb-3">Explore by Service</h4>
      <div class="d-flex flex-wrap gap-2">
        <button
          class="btn btn-outline-success btn-sm rounded-pill"
          v-for="cat in categories"
          :key="cat.slug"
          @click="filterByCategory(cat.slug)"
          :class="{ active: searchQuery === cat.slug }"
        >
          {{ cat.name }}
        </button>
        <button
          v-if="searchQuery"
          class="btn btn-outline-secondary btn-sm rounded-pill"
          @click="clearFilter"
        >
          Tampilkan Semua
        </button>
      </div>
    </section>

    <!-- Pagination -->
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

  <!-- Modal -->
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

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '@/api'

const faqs = ref([])
const searchQuery = ref('')
const selectedTopic = ref(null)
const pagination = ref({ current_page: 1, last_page: 1 })

const fetchFaqs = async (page = 1) => {
  try {
    const res = await api.get(`/api/faqs?page=${page}`)
    faqs.value = res.data.data.data || res.data.data
    pagination.value = {
      current_page: res.data.data.current_page,
      last_page: res.data.data.last_page,
    }
  } catch (err) {
    console.error('Gagal memuat FAQ:', err)
  }
}

const changePage = (page) => {
  pagination.value.current_page = page
  fetchFaqs(page)
}

const filteredFaqs = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return faqs.value.filter(faq =>
    faq.title.toLowerCase().includes(query) ||
    faq.answer.toLowerCase().includes(query)
  )
})

const categories = computed(() => {
  const unique = {}
  faqs.value.forEach(faq => {
    const cat = faq.category
    if (Array.isArray(cat)) {
      cat.forEach(c => unique[c] = true)
    } else {
      unique[cat] = true
    }
  })
  return Object.keys(unique).map(slug => ({
    slug,
    name: slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase())
  }))
})

const filterByCategory = (slug) => {
  searchQuery.value = slug
}

const clearFilter = () => {
  searchQuery.value = ''
}

const showTopicDetail = (faq) => {
  selectedTopic.value = faq
}

onMounted(() => fetchFaqs())
</script>

<style scoped>
.page-item.active .page-link {
  background-color: #198754;
  border-color: #198754;
  color: #fff;
}
</style>
