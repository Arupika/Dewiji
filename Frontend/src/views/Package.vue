<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center">
        <h1 class="mb-4 fw-bold display-5">Pilih Paket Liburan</h1>
        <p class="lead">Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan. Tentunya kamu masih bisa custom paket wisata!</p>
      </div>
    </div>

    <div class="mb-4 container">
      <input
        type="text"
        class="form-control rounded-pill"
        placeholder="Cari paket liburan..."
        v-model="searchQuery"
      />
    </div>

    <div class="row g-4">
      <div class="col-md-4" v-for="(trip, index) in filteredTrips" :key="trip.id">
        <div class="card h-100 shadow-sm">
          <img :src="trip.gambar[0]" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" />
          <div class="card-body">
            <h5 class="card-title fw-bold">Paket {{ index + 1 }}</h5>

            <div class="mb-3">
              <span class="badge bg-success bg-opacity-10 text-success me-2"
                v-for="(dest, i) in trip.destinasi.slice(0, 2)" :key="i">
                {{ dest.split(',')[0] }}
              </span>
              <span v-if="trip.destinasi.length > 2" class="badge bg-secondary bg-opacity-10 text-secondary">
                +{{ trip.destinasi.length - 2 }} lainnya
              </span>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Harga:</h6>
              <div v-for="(harga, tipe) in trip.harga" :key="tipe" class="d-flex justify-content-between mb-1">
                <span>{{ tipe }}:</span>
                <span>
                  <del class="text-muted small me-2">{{ harga.lama }}</del>
                  <strong class="text-success">{{ harga.diskon }}</strong>
                </span>
              </div>
            </div>

            <div v-if="trip.deskripsi" class="mb-3">
              <h6 class="fw-bold mb-2">Deskripsi:</h6>
              <p class="card-text small">{{ trip.deskripsi }}</p>
            </div>

            <button
              class="btn btn-success w-100 rounded-pill fw-bold"
              @click="showBookingModal(trip, index)">
              <i class="bi bi-whatsapp me-2"></i>Booking Sekarang
            </button>
          </div>
        </div>
      </div>

      <div v-if="filteredTrips.length === 0" class="col-12 text-center py-5">
        <p class="lead">Tidak ada paket yang ditemukan sesuai dengan pencarian Anda.</p>
      </div>
    </div>

    <!-- Modal Pemesanan -->
    <div v-if="selectedPackage" class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5)" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">Paket {{ selectedPackageIndex + 1 }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <img :src="selectedPackage.gambar[0]" class="img-fluid rounded" style="max-height: 200px" />
            </div>

            <form @submit.prevent="submitBooking">
              <div class="mb-3">
                <label class="form-label fw-bold">Tipe Mobil</label>
                <select class="form-select" v-model="bookingData.tipeMobil" required>
                  <option v-for="(harga, tipe) in selectedPackage.harga" :key="tipe" :value="tipe">
                    {{ tipe }} - {{ harga.diskon }}
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Tour</label>
                <input type="date" class="form-control" v-model="bookingData.tanggal" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" v-model="bookingData.nama" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Nomor WhatsApp</label>
                <input type="tel" class="form-control" v-model="bookingData.whatsapp" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Catatan Tambahan</label>
                <textarea class="form-control" v-model="bookingData.catatan" rows="2"></textarea>
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
import { ref, computed, onMounted } from 'vue'
import api from '@/api'
import Swal from 'sweetalert2'

const trips = ref([])
const searchQuery = ref('')
const selectedPackage = ref(null)
const selectedPackageIndex = ref(null)

const bookingData = ref({
  tipeMobil: '',
  tanggal: '',
  jumlahOrang: 1,
  nama: '',
  whatsapp: '',
  catatan: ''
})

const fetchTrips = async () => {
  try {
    const res = await api.get('/api/pakets')
    trips.value = res.data.data.data
  } catch (err) {
    console.error('Gagal memuat paket:', err)
  }
}

onMounted(fetchTrips)

const filteredTrips = computed(() => {
  const query = searchQuery.value.toLowerCase()
  return trips.value.filter(trip =>
    trip.destinasi.join(' ').toLowerCase().includes(query) ||
    (trip.deskripsi && trip.deskripsi.toLowerCase().includes(query))
  )
})

const showBookingModal = (trip, index) => {
  selectedPackage.value = trip
  selectedPackageIndex.value = index
  const tomorrow = new Date()
  tomorrow.setDate(tomorrow.getDate() + 1)
  bookingData.value.tanggal = tomorrow.toISOString().split('T')[0]
  bookingData.value.tipeMobil = Object.keys(trip.harga)[0]
}

const closeModal = () => {
  selectedPackage.value = null
  selectedPackageIndex.value = null
  bookingData.value = {
    tipeMobil: '',
    tanggal: '',
    jumlahOrang: 1,
    nama: '',
    whatsapp: '',
    catatan: ''
  }
}

const submitBooking = () => {
  const selectedPrice = selectedPackage.value.harga[bookingData.value.tipeMobil].diskon

  Swal.fire({
    title: 'Pemesanan Berhasil!',
    html: `
      <div class="text-start">
        <p><strong>Paket:</strong> ${selectedPackageIndex.value + 1}</p>
        <p><strong>Tipe Mobil:</strong> ${bookingData.value.tipeMobil} (${selectedPrice})</p>
        <p><strong>Tanggal:</strong> ${bookingData.value.tanggal}</p>
        <p><strong>Nama:</strong> ${bookingData.value.nama}</p>
        <p><strong>WhatsApp:</strong> ${bookingData.value.whatsapp}</p>
        ${bookingData.value.catatan ? `<p><strong>Catatan:</strong> ${bookingData.value.catatan}</p>` : ''}
      </div>
    `,
    icon: 'success',
    confirmButtonText: 'Tutup',
    customClass: {
      popup: 'rounded-3'
    }
  })

  sendWhatsAppMessage()
  closeModal()
}

const sendWhatsAppMessage = () => {
  const message = `Halo Dewiji Explore, saya ingin memesan:

📌 *Paket ${selectedPackageIndex.value + 1}*
📍 Destinasi: ${selectedPackage.value.destinasi.join(', ')}
🚗 Tipe Mobil: ${bookingData.value.tipeMobil}
💰 Harga: ${selectedPackage.value.harga[bookingData.value.tipeMobil].diskon}
📅 Tanggal: ${bookingData.value.tanggal}
👤 Nama: ${bookingData.value.nama}
📱 WhatsApp: ${bookingData.value.whatsapp}
${bookingData.value.catatan ? `✏️ Catatan: ${bookingData.value.catatan}` : ''}

Mohon info lebih lanjut. Terima kasih.`

  const encoded = encodeURIComponent(message)
  window.open(`https://wa.me/6281348680937?text=${encoded}`, '_blank')
}
</script>
