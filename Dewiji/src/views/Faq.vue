<template>
    <div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 text-center">
      <h1 class="mb-4 fw-bold display-5">FAQ</h1>
      <p class="lead">Temukan Jawaban Dari Pertanyaan Anda Disini</p>
    </div>
  </div>

  <div class="mb-4 container">
    <div class="input-group">
      <input 
        type="text" 
        class="form-control rounded-start-pill"
        placeholder="Ketik topik anda (misal: rental mobil, refund)"
        v-model="searchQuery"
        @input="filterFAQs"
      />
      <button class="btn btn-outline-secondary rounded-end-pill search-button" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </button>
    </div>
  </div>
</div>


    <div class="faq-content">
      <section class="popular-topics">
        <h2>Popular Topics</h2>
        <div class="topic-list">
          <div 
            class="topic-item" 
            v-for="topic in filteredPopularTopics" 
            :key="topic.id"
            @click="showTopicDetail(topic)"
          >
            <p>{{ topic.title }}</p>
            <span class="chevron">></span>
          </div>
        </div>
      </section>

      <section class="product-categories">
        <h2>Explore by Service</h2>
        <div class="category-grid">
          <div 
            class="category-card" 
            v-for="category in categories" 
            :key="category.id"
            @click="filterByCategory(category)"
          >
            <h3>{{ category.name }}</h3>
          </div>
        </div>
      </section>
    </div>

    <!-- Topic Detail Modal -->
    <div class="modal" v-if="selectedTopic">
      <div class="modal-content">
        <button class="close-button" @click="selectedTopic = null">&times;</button>
        <h2>{{ selectedTopic.title }}</h2>
        <div class="topic-detail">
          <p>{{ selectedTopic.answer }}</p>
          <div class="helpful-section" v-if="selectedTopic">
            <p>Was this helpful?</p>
            <button 
              class="helpful-button" 
              @click="rateHelpfulness(true)"
              :class="{ active: helpfulness === true }"
            >
              Yes
            </button>
            <button 
              class="helpful-button" 
              @click="rateHelpfulness(false)"
              :class="{ active: helpfulness === false }"
            >
              No
            </button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  name: 'FAQPage',
  data() {
    return {
      searchQuery: '',
      selectedTopic: null,
      helpfulness: null,
      popularTopics: [
        {
          id: 1,
          title: 'Cara Rental Mobil',
          answer: 'Untuk Rental Mobil Anda dapat mengunjungi halaman Rental Mobil yang tersedia di website kami. Pilih mobil yang Anda ingin sewa lalu Anda dapat mengisi beberapa form yang tersedia. Setelah itu Anda akan kami arahkan ke Kontak WhatsApp kami untuk proses lebih lanjut.',
          category: 'car-rental'
        },
        {
          id: 2,
          title: 'Cara Membatalkan dan Refund Paket Liburan',
          answer: 'Anda dapat melakukan Pembatalan melalui konfirmasi di Kontak WhatsApp kami, pembatalan dilakukan sesuai Kebijakan yang telah ditetapkan. Refund memerlukan proses 1 - 7 Hari Kerja',
          category: ['vacation-packages', 'refunds']
        },
        {
          id: 3,
          title: 'Cara Booking Ulang Rental Mobil',
          answer: 'Untuk merubah booking Rental Mobil Anda dapat menghubungi Kontak WhatsApp kami dan melakukan konfirmasi dengan Admin kami. Perubahan dapat dikenakan charge tambahan sesuai kesepakatan. ',
          category: 'car-rental'
        },
        {
          id: 4,
          title: 'Cakupan Paket Liburan',
          answer: 'Harga Paket Liburan yang tertera pada halaman Paket Liburan hanya mencakup biaya rental mobil, bbm dan sopir. Untuk tiket masuk, biaya makan dan lain sebagainya, Anda dapat melakukan pemesanan secara mandiri atau menambahkan pada kolom Catatan tambahan pada Formulir yang tersedia untuk kami bantu pemesanannya.',
          category: 'vacation-packages'
        },
        {
          id: 5,
          title: 'Cara Memeasan Paket Liburan',
          answer: 'Untuk memesan Paket Liburan Anda dapat mengunjungi halaman Paket Liburan yang tersedia di website kami. Anda dapat memilih paket paket yang tersedia dan mengisi beberapa formulir yang tersedia. Lalu Anda akan kami arahkan ke kontak WhatsApp kami dan melakukan proses pemesanan lebih lanjut.',
          category: 'vacation-packages'
        },
        {
          id: 6,
          title: 'Cara Menambahkan Pelayanan Tamabahan Pada Paket Liburan',
          answer: 'Anda dapat menambahkan layanan tambahan seperti tambahan destinasi, antar-jemput bandara, atau akomodasi khusus dengan menambahkan pada form catatan tambahan atau menghubungi layanan pelanggan kami melalui kontak WhatsApp kami.',
          category: 'vacation-packages'
        },
        {
          id: 7,
          title: 'Kebijakan Pembatalan',
          answer: 'Kebijakan pembatalan berbeda-beda tergantung pada penyedia layanan. Secara umum, pembatalan yang dilakukan lebih dari 48 jam sebelum tanggal pemesanan akan mendapatkan pengembalian dana penuh. Pembatalan yang terlambat mungkin akan dikenakan biaya.',
          category: 'general'
        }
      ],
      categories: [
        { id: 1, name: 'Rental Mobil', slug: 'car-rental' },
        { id: 2, name: 'Paket Liburan', slug: 'vacation-packages' },
        { id: 3, name: 'Asuransi Travel', slug: 'insurance' },
        { id: 4, name: 'Metode Pembayaran', slug: 'payments' },
        { id: 5, name: 'Akun & Profile', slug: 'account' },
        { id: 6, name: 'Pembatalan', slug: 'cancellations' },
        { id: 7, name: 'Refunds', slug: 'refunds' },
        { id: 8, name: 'Contact Support', slug: 'support' }
      ],
      filteredPopularTopics: []
    }
  },
  created() {
    this.filteredPopularTopics = [...this.popularTopics];
  },
  methods: {
    filterFAQs() {
      if (!this.searchQuery) {
        this.filteredPopularTopics = [...this.popularTopics];
        return;
      }
      
      const query = this.searchQuery.toLowerCase();
      this.filteredPopularTopics = this.popularTopics.filter(topic => 
        topic.title.toLowerCase().includes(query) || 
        topic.answer.toLowerCase().includes(query)
      );
    },
    filterByCategory(category) {
      this.filteredPopularTopics = this.popularTopics.filter(topic => 
        topic.category.includes(category.slug)
      );
      this.searchQuery = '';
    },
    showTopicDetail(topic) {
      this.selectedTopic = topic;
      this.helpfulness = null;
    },
    rateHelpfulness(isHelpful) {
      this.helpfulness = isHelpful;
      // Here you would typically send this feedback to your backend
      console.log(`Feedback for "${this.selectedTopic.title}": ${isHelpful ? 'Helpful' : 'Not Helpful'}`);
    }
  }
}
</script>