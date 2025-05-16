<template>
    <div class="container py-5">
      <!-- Hero Section -->
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-8 text-center">
            <h1 class="mb-4 fw-bold display-5">Rental Mobil Yogyakarta</h1>
            <p class="lead">Temukan mobil terbaik untuk kebutuhan perjalanan Anda di Jogja dan sekitarnya. Kami menyediakan berbagai pilihan mobil dengan harga terjangkau dan pelayanan terbaik.</p>
          </div>
        </div>
      </div>

      <!-- Car Rental Cards -->
      <div class="row g-4">
        <div class="col-md-4" v-for="(mobil, index) in daftarMobil" :key="index">
          <div class="card h-100 shadow-sm">
            <div class="card-img-top">
              <img :src="mobil.gambar" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" :alt="mobil.nama" />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-bold">{{ mobil.nama }}</h5>
              
              <div class="mb-3">
                <span class="badge bg-success bg-opacity-10 text-success me-2" v-for="(fitur, i) in mobil.fitur" :key="i">
                  {{ fitur }}
                </span>
              </div>
              
              <p class="card-text small">{{ mobil.deskripsi }}</p>
              
              <div class="mb-3">
                <h6 class="fw-bold mb-2">Harga Sewa:</h6>
                <div class="d-flex justify-content-between">
                  <span>Per Hari:</span>
                  <span class="text-success fw-bold">Rp {{ mobil.harga.toLocaleString() }}</span>
                </div>
                <div class="d-flex justify-content-between" v-if="mobil.harga12jam">
                  <span>12 Jam:</span>
                  <span class="text-success fw-bold">Rp {{ mobil.harga12jam.toLocaleString() }}</span>
                </div>
              </div>
              
              <div class="mb-3">
                <h6 class="fw-bold mb-2">Termasuk:</h6>
                <ul class="list-unstyled small">
                  <li v-for="item in mobil.termasuk" :key="item" class="mb-1">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 text-center pt-0">
              <button 
                class="btn btn-success w-100 rounded-pill fw-bold"
                @click="showDetails(mobil)"
              >
                <i class="bi bi-car-front me-2"></i>Sewa Sekarang
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Booking Modal -->
      <div v-if="selectedMobil" class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5)" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-3">
            <div class="modal-header border-0">
              <h5 class="modal-title fw-bold">{{ selectedMobil.nama }}</h5>
              <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="text-center mb-4">
                <img :src="selectedMobil.gambar" class="img-fluid rounded" style="max-height: 200px" :alt="selectedMobil.nama" />
              </div>
              
              <div class="mb-4">
                <h6 class="fw-bold border-bottom pb-2">Detail Penyewaan</h6>
                <div class="row">
                  <div class="col-6 mb-2">
                    <span class="text-muted small">Harga/hari</span>
                    <div class="fw-bold">Rp {{ selectedMobil.harga.toLocaleString() }}</div>
                  </div>
                  <div class="col-6 mb-2" v-if="selectedMobil.harga12jam">
                    <span class="text-muted small">Harga 12 jam</span>
                    <div class="fw-bold">Rp {{ selectedMobil.harga12jam.toLocaleString() }}</div>
                  </div>
                  <div class="col-12 mb-2">
                    <span class="text-muted small">Kapasitas</span>
                    <div class="fw-bold">{{ selectedMobil.kapasitas }} orang</div>
                  </div>
                </div>
              </div>
              
              <form @submit.prevent="submitOrder">
                <div class="mb-3">
                  <label class="form-label fw-bold">Paket Penyewaan</label>
                  <select class="form-select" v-model="paketSewa" required>
                    <option value="harian">Sewa Harian (24 Jam)</option>
                    <option value="12jam" v-if="selectedMobil.harga12jam">Sewa 12 Jam</option>
                  </select>
                </div>
                
                <div class="mb-3">
                  <label class="form-label fw-bold">Tanggal Pengambilan</label>
                  <input type="date" class="form-control" v-model="pickupDate" required />
                </div>
                
                <div class="mb-3" v-if="paketSewa === 'harian'">
                  <label class="form-label fw-bold">Durasi (hari)</label>
                  <input type="number" class="form-control" v-model="duration" min="1" required />
                </div>
                
                <div class="mb-3">
                  <label class="form-label fw-bold">Lokasi Pengambilan</label>
                  <select class="form-select" v-model="lokasiAmbil" required>
                    <option value="kantor">Kantor Kami (Jl. Ngiringsi, Sleman)</option>
                    <option value="bandara">Bandara Adisucipto</option>
                    <option value="stasiun">Stasiun Tugu</option>
                    <option value="hotel">Hotel (wilayah Jogja)</option>
                  </select>
                </div>
                
                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2">
                  <i class="bi bi-whatsapp me-2"></i>Konfirmasi Pemesanan
                </button>
              </form>
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
  import { ref } from 'vue'
  import Swal from 'sweetalert2'

  // Import gambar lokal
import avanza from '@/assets/avanza.png'
import xenia from '@/assets/xenia.png'
import innova from '@/assets/innova.png'
import brio from '@/assets/brio.png'
import calya from '@/assets/calya.png'
import alphard from '@/assets/alphard.png'

  export default {
    setup() {
      // Data mobil yang tersedia untuk disewa
      const daftarMobil = [
        {
          nama: 'Toyota Avanza',
          deskripsi: 'Mobil keluarga MPV dengan 7 kursi yang nyaman untuk perjalanan wisata.',
          harga: 350000,
          harga12jam: 250000,
          fitur: ['7 Kursi', 'AC', 'Matic'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam'],
          kapasitas: 7,
          gambar: avanza
        },
        {
          nama: 'Daihatsu Xenia',
          deskripsi: 'MPV irit bahan bakar dengan desain modern dan kabin yang luas.',
          harga: 300000,
          harga12jam: 220000,
          fitur: ['7 Kursi', 'AC', 'Matic'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam'],
          kapasitas: 7,
          gambar: xenia
        },
        {
          nama: 'Toyota Innova Reborn',
          deskripsi: 'MPV premium dengan kenyamanan ekstra dan fitur lengkap untuk perjalanan jarak jauh.',
          harga: 600000,
          harga12jam: 400000,
          fitur: ['7 Kursi', 'AC', 'Matic', 'Premium'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam', 'Air Mineral'],
          kapasitas: 7,
          gambar: innova
        },
        {
          nama: 'Honda Brio',
          deskripsi: 'City car irit bahan bakar dengan desain compact, cocok untuk perjalanan dalam kota.',
          harga: 250000,
          fitur: ['5 Kursi', 'AC', 'Matic'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam'],
          kapasitas: 5,
          gambar: brio
        },
        {
          nama: 'Toyota Calya',
          deskripsi: 'MPV ekonomis dengan kabin luas dan irit bahan bakar, cocok untuk keluarga.',
          harga: 300000,
          harga12jam: 220000,
          fitur: ['7 Kursi', 'AC', 'Matic'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam'],
          kapasitas: 7,
          gambar: calya
        },
        {
          nama: 'Toyota Alphard',
          deskripsi: 'MPV mewah dengan fitur lengkap dan kenyamanan premium untuk perjalanan eksklusif.',
          harga: 1500000,
          harga12jam: 1000000,
          fitur: ['7 Kursi', 'AC', 'Matic', 'Premium', 'TV'],
          termasuk: ['Mobil + Supir', 'BBM', 'Durasi 24 Jam', 'Air Mineral', 'Snack'],
          kapasitas: 7,
          gambar: alphard
        }
      ]

      // Variabel untuk modal pemesanan
      const selectedMobil = ref(null)
      const duration = ref(1)
      const pickupDate = ref('')
      const paketSewa = ref('harian')
      const lokasiAmbil = ref('kantor')

      // Menampilkan modal detail mobil
      const showDetails = (mobil) => {
        selectedMobil.value = mobil
        // Set default pickup date to tomorrow
        const tomorrow = new Date()
        tomorrow.setDate(tomorrow.getDate() + 1)
        pickupDate.value = tomorrow.toISOString().split('T')[0]
      }

      // Menutup modal
      const closeModal = () => {
        selectedMobil.value = null
        duration.value = 1
        pickupDate.value = ''
        paketSewa.value = 'harian'
        lokasiAmbil.value = 'kantor'
      }

      // Mengirim form pemesanan
      const submitOrder = () => {
        const harga = paketSewa.value === 'harian' 
          ? selectedMobil.value.harga * duration.value
          : selectedMobil.value.harga12jam
        
        Swal.fire({
          title: 'Pemesanan Berhasil!',
          html: `
            <div class="text-start">
              <p><strong>Mobil:</strong> ${selectedMobil.value.nama}</p>
              <p><strong>Paket:</strong> ${paketSewa.value === 'harian' ? 'Sewa Harian' : 'Sewa 12 Jam'}</p>
              <p><strong>Durasi:</strong> ${paketSewa.value === 'harian' ? duration.value + ' hari' : '12 jam'}</p>
              <p><strong>Tanggal:</strong> ${pickupDate.value}</p>
              <p><strong>Lokasi:</strong> ${getLokasiText(lokasiAmbil.value)}</p>
              <p><strong>Total Harga:</strong> Rp ${harga.toLocaleString()}</p>
            </div>
          `,
          icon: 'success',
          confirmButtonText: 'Tutup',
          customClass: {
            popup: 'rounded-3'
          }
        })

        closeModal()
      }

      // Helper untuk teks lokasi
      const getLokasiText = (value) => {
        switch(value) {
          case 'bandara': return 'Bandara Adisucipto'
          case 'stasiun': return 'Stasiun Tugu'
          case 'hotel': return 'Hotel (wilayah Jogja)'
          default: return 'Kantor Kami (Jl. Ngiringsi, Sleman)'
        }
      }

      return {
        daftarMobil,
        selectedMobil,
        duration,
        pickupDate,
        paketSewa,
        lokasiAmbil,
        showDetails,
        closeModal,
        submitOrder
      }
    }
  }
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

  .border-success {
    border-color: #198754 !important;
  }

  .modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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
  </style>