<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Rental Mobil Yogyakarta</h1>

    <div class="row g-4">
      <div class="col-md-4" v-for="(mobil, index) in daftarMobil" :key="index">
        <div class="card h-100 shadow-sm">
          <img :src="mobil.gambar" class="card-img-top" :alt="mobil.nama" />
          <div class="card-body">
            <h5 class="card-title">{{ mobil.nama }}</h5>
            <p class="card-text">{{ mobil.deskripsi }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">Rp {{ mobil.harga.toLocaleString() }}/hari</span>
            <button class="btn btn-success btn-sm" @click="showDetails(mobil)">Sewa Sekarang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal untuk Menampilkan Detail Pemesanan -->
    <div v-if="selectedMobil" class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ selectedMobil.nama }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>Deskripsi:</strong> {{ selectedMobil.deskripsi }}</p>
            <p><strong>Harga:</strong> Rp {{ selectedMobil.harga.toLocaleString() }}/hari</p>
            <p><strong>Rincian Penyewaan:</strong> Pilih durasi penyewaan mobil dan tanggal penjemputan.</p>

            <!-- Form Pemesanan -->
            <form @submit.prevent="submitOrder">
              <div class="mb-3">
                <label for="duration" class="form-label">Durasi Penyewaan (hari)</label>
                <input type="number" class="form-control" id="duration" v-model="duration" required min="1" />
              </div>
              <div class="mb-3">
                <label for="pickupDate" class="form-label">Tanggal Penjemputan</label>
                <input type="date" class="form-control" id="pickupDate" v-model="pickupDate" required />
              </div>
              <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SweetAlert2 from 'sweetalert2'
import avanza from '@/assets/avanza.png'
import xenia from '@/assets/xenia.png'
import innova from '@/assets/innova.png'
import brio from '@/assets/brio.png'
import ayla from '@/assets/calya.png'
import alphard from '@/assets/alphard.png'

const daftarMobil = [
  {
    nama: 'Toyota Avanza',
    deskripsi: 'Mobil keluarga nyaman dalam perjalanan wisata.',
    harga: 250000,
    gambar: avanza
  },
  {
    nama: 'Daihatsu Xenia',
    deskripsi: 'Irit dan sederhana untuk wisata di kota dan luar kota.',
    harga: 350000,
    gambar: xenia
  },
  {
    nama: 'Innova Reborn',
    deskripsi: 'Mobil premium dan mewah dengan kenyamanan ekstra.',
    harga: 400000,
    gambar: innova
  },
  {
    nama: 'Honda Brio',
    deskripsi: 'Mobil irit bahan bakar, cocok untuk perjalanan di dalam kota.',
    harga: 200000,
    gambar: brio
  },
  {
    nama: 'Daihatsu Ayla',
    deskripsi: 'City car irit dan ekonomis untuk aktivitas harian di kota.',
    harga: 250000,
    gambar: ayla
  },
  {
    nama: 'Toyota Alphard',
    deskripsi: 'MPV mewah dengan fitur lengkap dan kenyamanan tinggi.',
    harga: 1500000,
    gambar: alphard
  }
]

const selectedMobil = ref(null)
const duration = ref(1)
const pickupDate = ref('')

const showDetails = (mobil) => {
  selectedMobil.value = mobil
}

const closeModal = () => {
  selectedMobil.value = null
  duration.value = 1
  pickupDate.value = ''
}

const submitOrder = () => {
  SweetAlert2.fire({
    title: 'Pemesanan Berhasil!',
    text: `Anda telah memesan ${selectedMobil.value.nama} selama ${duration.value} hari, tanggal penjemputan: ${pickupDate.value}`,
    icon: 'success',
    confirmButtonText: 'Tutup',
    customClass: {
      popup: 'popup-success'
    }
  })
  
  closeModal()
}
</script>

<style scoped>
.modal {
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
}

.popup-success {
  background-color: #28a745; /* Warna hijau sukses */
  color: white;
  border-radius: 10px;
}
</style>
