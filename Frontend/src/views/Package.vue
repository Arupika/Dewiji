<template>
  <div class="container py-5">
    <Transition name="fade" appear>
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <h1 class="mb-4 fw-bold display-5">Pilih Paket Liburan</h1>
          <p class="lead">Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan. Tentunya kamu masih bisa custom paket wisata!</p>
        </div>
      </div>
    </Transition>

    <Transition name="fade" appear>
      <div class="mb-4 container">
        <input
          type="text"
          class="form-control rounded-pill"
          placeholder="Cari paket liburan..."
          v-model="searchQuery"
        />
      </div>
    </Transition>

    <TransitionGroup name="list" tag="div" class="row g-4 w-100">
      <div class="col-md-4" v-for="(trip, index) in filteredTrips" :key="trip.id">
        <div class="card h-100 shadow-sm">
          <img :src="trip.gambar || 'https://via.placeholder.com/400x300?text=No+Image'" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" />
          <div class="card-body">
            <h5 class="card-title fw-bold">{{ trip.nama || `Paket ${index + 1}` }}</h5>

            <div class="mb-3">
              <span class="badge bg-success bg-opacity-10 text-success me-2"
                v-for="(dest, i) in (trip.destinasi || []).slice(0, 2)" :key="i">
                {{ dest.split(',')[0] }}
              </span>
              <span v-if="(trip.destinasi || []).length > 2" class="badge bg-secondary bg-opacity-10 text-secondary">
                +{{ trip.destinasi.length - 2 }} lainnya
              </span>
            </div>

            <div class="mb-3">
              <h6 class="fw-bold mb-2">Harga:</h6>
              <div v-for="(hargaItem, i) in (trip.harga || [])" :key="i" class="d-flex justify-content-between mb-1">
                <span>{{ hargaItem.tipe || 'Harga' }}:</span>
                <span>
                  <del v-if="hargaItem.lama" class="text-muted small me-2">{{ hargaItem.lama }}</del>
                  <strong class="text-success">{{ hargaItem.diskon || 'N/A' }}</strong>
                </span>
              </div>
            </div>

            <div class="mb-3" v-if="(trip.termasuk || []).length > 0">
              <h6 class="fw-bold mb-1">Termasuk:</h6>
              <ul class="list-unstyled mb-0 ms-3"> <li v-for="(item, i) in (trip.termasuk || []).slice(0, 2)" :key="i" class="small">
                  <i class="bi bi-check-circle-fill text-success me-1"></i>{{ item }}
                </li>
                <li v-if="(trip.termasuk || []).length > 2" class="small text-muted">
                  +{{ trip.termasuk.length - 2 }} lainnya
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="(trip.tidak_termasuk || []).length > 0">
              <h6 class="fw-bold mb-1">Tidak Termasuk:</h6>
              <ul class="list-unstyled mb-0 ms-3">
                <li v-for="(item, i) in (trip.tidak_termasuk || []).slice(0, 2)" :key="i" class="small">
                  <i class="bi bi-x-circle-fill text-danger me-1"></i>{{ item }}
                </li>
                <li v-if="(trip.tidak_termasuk || []).length > 2" class="small text-muted">
                  +{{ trip.tidak_termasuk.length - 2 }} lainnya
                </li>
              </ul>
            </div>

            <div v-if="trip.deskripsi" class="mb-3">
              <h6 class="fw-bold mb-2">Deskripsi:</h6>
              <p class="card-text small description-clamp">{{ trip.deskripsi }}</p>
            </div>

            <button
              class="btn btn-success w-100 rounded-pill fw-bold"
              @click="showBookingModal(trip)">
              <i class="bi bi-whatsapp me-2"></i>Booking Sekarang
            </button>
          </div>
        </div>
      </div>

      <div v-if="filteredTrips.length === 0" class="col-12 text-center py-5">
        <p class="lead">Tidak ada paket yang ditemukan sesuai dengan pencarian Anda.</p>
      </div>
    </TransitionGroup>

    <div
      v-if="showModal"
      class="modal fade"
      :class="{ 'show d-block': showModal }"
      tabindex="-1"
      role="dialog"
      aria-modal="true"
      :style="{
        backgroundColor: showModal ? 'rgba(0,0,0,0.5)' : '',
        zIndex: showModal ? 1060 : 'auto',
        overflowY: 'auto'
      }"
      @click.self="closeModal">

      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">{{ selectedPackage.nama || 'Detail Paket' }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <img
                :src="selectedPackage.gambar || 'https://via.placeholder.com/600x400?text=No+Image'"
                class="img-fluid rounded modal-image"
                alt="Foto paket"
              />
            </div>

            <div class="mb-3">
              <strong>Destinasi:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(dest, idx) in (selectedPackage.destinasi || [])" :key="idx">
                  <i class="bi bi-geo-alt-fill text-success me-2"></i>{{ dest }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.harga && selectedPackage.harga.length">
              <strong>Harga:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(hargaItem, idx) in selectedPackage.harga" :key="idx">
                  <span>{{ hargaItem.tipe }}: <del v-if="hargaItem.lama" class="text-muted small me-2">{{ hargaItem.lama }}</del><strong class="text-success">{{ hargaItem.diskon || 'N/A' }}</strong></span>
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.termasuk && selectedPackage.termasuk.length">
              <strong>Sudah Termasuk:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(item, idx) in selectedPackage.termasuk" :key="idx">
                  <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.tidak_termasuk && selectedPackage.tidak_termasuk.length">
              <strong>Tidak Termasuk:</strong>
              <ul class="list-unstyled mt-2">
                <li v-for="(item, idx) in selectedPackage.tidak_termasuk" :key="idx">
                  <i class="bi bi-x-circle-fill text-danger me-2"></i>{{ item }}
                </li>
              </ul>
            </div>

            <div class="mb-3" v-if="selectedPackage.deskripsi">
              <strong>Deskripsi:</strong>
              <p style="white-space: pre-line;">{{ selectedPackage.deskripsi || '-' }}</p>
            </div>

            <hr />
            <form @submit.prevent="submitBooking">
              <div class="mb-3" v-if="selectedPackage.harga && selectedPackage.harga.length > 0">
                <label class="form-label fw-bold">Pilih Jenis Harga</label>
                <select class="form-control" v-model="bookingData.tipeHarga" required>
                  <option disabled value="">Pilih salah satu harga</option>
                  <option v-for="(hargaItem, idx) in selectedPackage.harga" :key="idx" :value="hargaItem.tipe">
                    {{ hargaItem.tipe }} - {{ hargaItem.diskon }}
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

              <hr class="my-4">
              <h5 class="fw-bold text-center mb-3">Selesaikan Pembayaran Anda</h5>
              <div class="text-center mb-3">
                <QRCode
                  :value="qrPaymentText"
                  :size="200"
                  level="H"
                  class="mx-auto border p-2 rounded"
                />
              </div>
              <p class="text-center text-muted small mb-3">Scan QRIS ini untuk melakukan pembayaran.</p>

              <div class="text-center mb-4">
                  <p class="fw-bold mb-1">Atau Transfer Manual:</p>
                  <p class="mb-0">Bank: {{ bsiBankDetails.bankName }}</p>
                  <p class="mb-0">No. Rekening: {{ bsiBankDetails.accountNumber }}</p>
                  <p class="mb-0">A.N.: {{ bsiBankDetails.accountName }}</p>
                  <p class="mt-2 text-danger small">Mohon lakukan pembayaran sesuai Total Harga Estimasi.</p>
                  <p class="text-info small fw-bold">
                      *Sertakan bukti transfer di kolom chat WhatsApp.
                  </p>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Total Harga Estimasi</label>
                <p class="form-control-plaintext fw-bold text-success display-6">
                  Rp {{ Number(calculatedPackagePrice).toLocaleString('id-ID') }}
                </p>
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
        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Tentang Kami</h5>
          <p class="small"><strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman dengan harga yang cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan sekitarnya.</p>
        </div>

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

        <div class="col-lg-3 col-md-6">
          <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Sosial Media</h5>
          <p class="small">Ikuti kami di media sosial untuk mendapatkan penawaran terbaik!</p>
          <div class="d-flex gap-3">
            <a href="https://www.facebook.com/namapagekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="https://www.tiktok.com/@usernamekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-tiktok"></i>
            </a>
            <a href="https://www.instagram.com/usernamekamu" target="_blank" class="btn btn-outline-light btn-sm rounded-circle hover-success">
              <i class="bi bi-instagram"></i>
            </a>
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
import { ref, computed, onMounted, watch } from 'vue'
import api from '@/api'
import Swal from 'sweetalert2'
import QRCode from 'qrcode.vue' // <--- Pastikan ini diimpor!

const trips = ref([])
const searchQuery = ref('')
const showModal = ref(false)
const selectedPackage = ref(null)

const bookingData = ref({
  tipeHarga: '',
  tanggal: '',
  jumlahOrang: 1, // Tambahan field jumlahOrang jika ada
  nama: '',
  whatsapp: '',
  catatan: ''
})

// ===============================================================
// Data untuk QR Pembayaran (QRIS dan BSI) - Sama seperti CarRent.vue
// PENTING: Ganti nilai ini dengan string QRIS ASLI Anda.
// Jika Anda tidak memiliki string QRIS, Anda bisa menggunakan nomor rekening bank.
const qrPaymentText = ref('Transfer Bank BSI: 7213052386 A.N. irzha fahrizaldy'); // GANTI DENGAN DATA ASLI ANDA

const bsiBankDetails = {
  bankName: 'Bank Syariah Indonesia (BSI)',
  accountNumber: '7213052386', // Contoh: '7123456789'
  accountName: 'irzha fahrizaldy'        // Contoh: 'PT. Dewiji Explore'
}

// Nomor WhatsApp untuk konfirmasi booking
const whatsappContactNumber = '6281348680937'; // Contoh: '6281348680937'
// ===============================================================

// Computed property untuk menghitung total harga paket
const calculatedPackagePrice = computed(() => {
  if (!selectedPackage.value || !bookingData.value.tipeHarga) {
    return 0;
  }
  const selectedPriceObject = selectedPackage.value.harga.find(
    price => price.tipe === bookingData.value.tipeHarga
  );
  if (!selectedPriceObject || !selectedPriceObject.diskon) {
    return 0;
  }
  // Menghilangkan karakter non-digit dan mengonversi ke float
  const price = parseFloat(String(selectedPriceObject.diskon).replace(/[^0-9,-]+/g, "").replace(/,/g, ".")) || 0;
  // Jika ada jumlah orang, kalikan
  const total = price * (bookingData.value.jumlahOrang || 1);
  return total;
});


const fetchTrips = async () => {
  try {
    const res = await api.get('/api/pakets')
    trips.value = res.data.data.data
  } catch (err) {
    console.error('Gagal memuat paket:', err)
    Swal.fire({
      icon: 'error',
      title: 'Gagal Memuat Paket',
      text: 'Terjadi kesalahan saat memuat daftar paket liburan.'
    });
  }
}

onMounted(fetchTrips)

const filteredTrips = computed(() => {
  const query = searchQuery.value.toLowerCase().trim()
  return trips.value.filter(trip =>
    (trip.nama && trip.nama.toLowerCase().includes(query)) ||
    (trip.destinasi && trip.destinasi.join(' ').toLowerCase().includes(query)) ||
    (trip.deskripsi && trip.deskripsi.toLowerCase().includes(query)) ||
    (trip.harga && trip.harga.some(h => (h.tipe && h.tipe.toLowerCase().includes(query)) || (h.diskon && String(h.diskon).toLowerCase().includes(query)))) ||
    (trip.termasuk && trip.termasuk.some(t => t.toLowerCase().includes(query))) ||
    (trip.tidak_termasuk && trip.tidak_termasuk.some(nt => nt.toLowerCase().includes(query)))
  )
})

const showBookingModal = (trip) => {
  selectedPackage.value = trip
  showModal.value = true

  const tomorrow = new Date()
  tomorrow.setDate(tomorrow.getDate() + 1)
  bookingData.value.tanggal = tomorrow.toISOString().split('T')[0]

  // Reset booking data for a new booking
  bookingData.value.tipeHarga = ''; // Reset tipeHarga
  bookingData.value.jumlahOrang = 1; // Reset jumlahOrang
  bookingData.value.nama = '';
  bookingData.value.whatsapp = '';
  bookingData.value.catatan = '';

  // Set default selected price if available
  if (selectedPackage.value.harga && selectedPackage.value.harga.length > 0) {
    bookingData.value.tipeHarga = selectedPackage.value.harga[0].tipe;
  } else {
    bookingData.value.tipeHarga = '';
  }

  document.body.classList.add('modal-open');
  document.body.style.overflow = 'hidden';
}

const closeModal = () => {
  showModal.value = false
  selectedPackage.value = null

  bookingData.value = {
    tipeHarga: '',
    tanggal: '',
    jumlahOrang: 1,
    nama: '',
    whatsapp: '',
    catatan: ''
  }

  document.body.classList.remove('modal-open');
  document.body.style.overflow = '';
}

const submitBooking = () => {
  // Construct WhatsApp message
  const selectedPriceObject = selectedPackage.value.harga.find(
    price => price.tipe === bookingData.value.tipeHarga
  );
  const priceDisplay = selectedPriceObject ? selectedPriceObject.diskon : 'Harga tidak tersedia';
  const oldPriceDisplay = selectedPriceObject && selectedPriceObject.lama ? ` (Harga normal: ${selectedPriceObject.lama})` : '';

  const message = `Halo Dewiji Explore, saya ingin memesan:

📌 *Paket ${selectedPackage.value.nama}*
📍 Destinasi: ${(selectedPackage.value.destinasi || []).join(', ')}

👥 Jumlah Orang: ${bookingData.value.jumlahOrang}
💰 Harga Per Orang (${bookingData.value.tipeHarga}): ${priceDisplay}${oldPriceDisplay}
💲 Total Harga Estimasi: Rp ${Number(calculatedPackagePrice.value).toLocaleString('id-ID')}
📅 Tanggal Tour: ${bookingData.value.tanggal}
👤 Nama: ${bookingData.value.nama}
📱 WhatsApp: ${bookingData.value.whatsapp}
${(selectedPackage.value.termasuk && selectedPackage.value.termasuk.length) ? `✅ Termasuk: ${selectedPackage.value.termasuk.join(', ')}\n` : ''}
${(selectedPackage.value.tidak_termasuk && selectedPackage.value.tidak_termasuk.length) ? `❌ Tidak Termasuk: ${selectedPackage.value.tidak_termasuk.join(', ')}\n` : ''}
${selectedPackage.value.deskripsi ? `📝 Deskripsi Paket: ${selectedPackage.value.deskripsi}\n` : ''}
${bookingData.value.catatan ? `✏️ Catatan Pribadi: ${bookingData.value.catatan}` : ''}

Saya sudah melakukan pembayaran melalui ${bsiBankDetails.bankName} (${bsiBankDetails.accountNumber} A.N. ${bsiBankDetails.accountName}) atau QRIS. Mohon konfirmasi pemesanan saya. Terima kasih.`

  const encoded = encodeURIComponent(message)
  window.open(`https://wa.me/${whatsappContactNumber}?text=${encoded}`, '_blank') // GUNAKAN VARIABEL WHATSAPP

  // Tampilkan SweetAlert konfirmasi akhir setelah membuka WhatsApp
  Swal.fire({
    title: 'Pemesanan Berhasil!',
    text: 'Mohon tunggu konfirmasi dari kami melalui WhatsApp.', // <--- TEKS BARU
    icon: 'success',
    confirmButtonText: 'Oke',
    allowOutsideClick: false
  }).then(() => {
    closeModal();
  });
}

// sendWhatsAppMessage dihapus karena logikanya digabung ke submitBooking

watch(showModal, (newValue) => {
  if (!newValue) {
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
  }
});
</script>

<style scoped>
/* Animasi Fade */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Animasi List Item (untuk kartu paket) */
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(30px);
}

/* Penting: Untuk TransitionGroup, pastikan elemen yang di-v-for memiliki posisi relatif */
.list-leave-active {
  position: absolute;
}

.list-move {
  transition: transform 0.5s ease;
}

/* Kustomisasi Modal */
body.modal-open {
  overflow: hidden !important;
  padding-right: var(--bs-modal-padding) !important;
}

/* Penyesuaian gambar di dalam modal */
.modal-image {
  width: 100%;
  height: 200px; /* Disesuaikan agar tidak terlalu besar di modal */
  object-fit: contain;
  background-color: #f0f0f0;
}

/* Custom CSS untuk deskripsi multi-baris dengan elipsis */
.description-clamp {
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Tampilkan hingga 3 baris */
  line-clamp: 3; /* Standard property for compatibility */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  min-height: 3.8em; /* Sesuaikan dengan line-height * jumlah baris (misal 1.2em * 3 = 3.6em) */
  line-height: 1.2em; /* Sesuaikan line-height agar konsisten */
}
</style>