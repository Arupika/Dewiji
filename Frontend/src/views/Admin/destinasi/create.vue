<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()

const nama = ref('')
const deskripsi = ref('')
const location = ref('')
const kategori = ref(['']) // array dengan satu input awal
const harga = ref([''])    // array dengan satu input awal
const jamOperasional = ref('')
const gambar = ref('')
const errors = ref({})
const successMessage = ref('')

const handleFileChange = (event) => {
  gambar.value = event.target.files[0]
}

const addKategori = () => kategori.value.push('')
const removeKategori = (index) => kategori.value.splice(index, 1)

const addHarga = () => harga.value.push('')
const removeHarga = (index) => harga.value.splice(index, 1)

const storeDestinasi = async () => {
  errors.value = {}

  const formData = new FormData()
  formData.append('nama', nama.value)
  formData.append('deskripsi', deskripsi.value)
  formData.append('location', location.value)
  kategori.value.forEach(k => formData.append('kategori[]', k))
  harga.value.forEach(h => formData.append('harga[]', h))
  formData.append('jamOperasional', jamOperasional.value)

  if (gambar.value) {
    formData.append('gambar', gambar.value)
  }

  try {
    const response = await api.post('/api/destinasis', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    successMessage.value = response.data.message || 'Destinasi berhasil disimpan!'
    setTimeout(() => {
      router.push('/admin/Dashboard')
    }, 1500)
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data
    } else {
      console.error('Full error:', error)
      alert('Terjadi kesalahan server.')
    }
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Tambah Destinasi</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="storeDestinasi">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" v-model="nama" />
        <small class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" v-model="deskripsi" rows="4"></textarea>
        <small class="text-danger" v-if="errors.deskripsi">{{ errors.deskripsi[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Lokasi</label>
        <input type="text" class="form-control" v-model="location" />
        <small class="text-danger" v-if="errors.location">{{ errors.location[0] }}</small>
      </div>

      <!-- Kategori -->
<div class="mb-3">
  <label class="form-label">Kategori</label>
  <div v-for="(k, index) in kategori" :key="index" class="d-flex mb-2 gap-2">
    <input type="text" class="form-control" v-model="kategori[index]" placeholder="contoh: Wisata Alam" />
    <button type="button" class="btn btn-danger" @click="removeKategori(index)" v-if="kategori.length > 1">Hapus</button>
  </div>
  <button type="button" class="btn btn-sm btn-secondary" @click="addKategori">+ Tambah Kategori</button>
  <small class="text-danger" v-if="errors.kategori">{{ errors.kategori[0] }}</small>
</div>

<!-- Harga -->
<div class="mb-3">
  <label class="form-label">Harga</label>
  <div v-for="(h, index) in harga" :key="index" class="d-flex mb-2 gap-2">
    <input type="text" class="form-control" v-model="harga[index]" placeholder="contoh: 10K - 15K" />
    <button type="button" class="btn btn-danger" @click="removeHarga(index)" v-if="harga.length > 1">Hapus</button>
  </div>
  <button type="button" class="btn btn-sm btn-secondary" @click="addHarga">+ Tambah Harga</button>
  <small class="text-danger" v-if="errors.harga">{{ errors.harga[0] }}</small>
</div>


      <div class="mb-3">
        <label class="form-label">Jam Operasional</label>
        <input type="text" class="form-control" v-model="jamOperasional" placeholder="08.00 - 17.00" />
        <small class="text-danger" v-if="errors.jamOperasional">{{ errors.jamOperasional[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar</label>
        <!-- ✅ Ini yang kamu minta -->
        <input type="file" class="form-control" @change="handleFileChange($event)">
        <small class="text-danger" v-if="errors.gambar">{{ errors.gambar[0] }}</small>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>
