<template>
  <div class="faq-container">
    <header class="faq-header">
      <h1>FAQ</h1>
      <p class="subtitle">Temukan Jawaban Dari Pertanyaan Anda Disini</p>
      
      <div class="search-box">
        <input 
          type="text" 
          placeholder="Type your topic here (e.g. rental mobil, refund)"
          v-model="searchQuery"
          @input="filterFAQs"
        >
        <button class="search-button">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>
      </div>
    </header>

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

<style scoped>
.faq-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  font-family: 'Arial', sans-serif;
  color: #333;
}

.faq-header {
  text-align: center;
  margin-bottom: 3rem;
}

.faq-header h1 {
  font-size: 2.5rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 1.2rem;
  color: #7f8c8d;
  margin-bottom: 2rem;
}

.search-box {
  display: flex;
  max-width: 600px;
  margin: 0 auto;
  border: 1px solid #ddd;
  border-radius: 30px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search-box input {
  flex: 1;
  padding: 1rem 1.5rem;
  border: none;
  font-size: 1rem;
  outline: none;
}

.search-button {
  background: linear-gradient(135deg, #00c896, #00cfff);
  color: white;
  border: none;
  padding: 0 1.5rem;
  cursor: pointer;
  transition: background 0.3s ease;
}

.search-button:hover {
   transform: scale(1.02);
  background: linear-gradient(135deg, #00a87d, #00b8e6);
}

.popular-topics {
  margin-bottom: 3rem;
}

.popular-topics h2, .product-categories h2 {
  font-size: 1.5rem;
  color: #2c3e50;
  margin-bottom: 1.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #eee;
}

.topic-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1rem;
}

.topic-item {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.topic-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.topic-item p {
  margin: 0;
  font-weight: 500;
}

.chevron {
  color: #7f8c8d;
  font-weight: bold;
}

.category-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 1.5rem;
}

.category-card {
  background: white;
  padding: 1.5rem 1rem;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  text-align: center;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.category-card h3 {
  margin: 0;
  font-size: 1rem;
  color: #2c3e50;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  max-width: 600px;
  width: 90%;
  max-height: 80vh;
  overflow-y: auto;
  position: relative;
}

.close-button {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #7f8c8d;
}

.topic-detail {
  margin-top: 1rem;
}

.helpful-section {
  margin-top: 2rem;
  padding-top: 1rem;
  border-top: 1px solid #eee;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.helpful-section p {
  margin: 0;
}

.helpful-button {
  padding: 0.5rem 1rem;
  border: 1px solid #ddd;
  background: white;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s;
}

.helpful-button:hover {
  background: #f5f5f5;
}

.helpful-button.active {
  background: #3498db;
  color: white;
  border-color: #3498db;
}

@media (max-width: 768px) {
  .category-grid {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
  }
  
  .topic-list {
    grid-template-columns: 1fr;
  }
}
</style>