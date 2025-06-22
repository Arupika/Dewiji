<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '@/api'

const router = useRouter()
const route = useRoute()

const destinasi = ref([''])
const harga = ref([''])
const termasuk = ref([''])
const tidak_termasuk = ref([''])
const deskripsi = ref('')
const gambar = ref(null)
const errors = ref([])
const successMessage = ref('')

const handleFileChange = (e) => {
  gambar.value = e.target.files[0]
}

const addField = (array) => array.push('')
const removeField = (array, index) => array.splice(index, 1)

onMounted(async () => {
  try {
    const res = await api.get(`/api/pakets/${route.params.id}`)
    const data = res.data.data

    destinasi.value = Array.isArray(data.destinasi) ? data.destinasi : [data.destinasi]
    harga.value = Array.isArray(data.harga) ? data.harga : [data.harga]
    termasuk.value = Array.isArray(data.termasuk) ? data.termasuk : [data.termasuk]
    tidak_termasuk.value = Array.isArray(data.tidak_termasuk) ? data.tidak_termasuk : [data.tidak_termasuk]
    deskripsi.value = data.deskripsi
  } catch (err) {
    console.error(err)
  }
})

const updatePaket = async () => {
  const formData = new FormData()
  destinasi.value.forEach(d => formData.append('destinasi[]', d))
  harga.value.forEach(h => formData.append('harga[]', h))
  termasuk.value.forEach(t => formData.append('termasuk[]', t))
  tidak_termasuk.value.forEach(nt => formData.append('tidak_termasuk[]', nt))
  formData.append('deskripsi', deskripsi.value)
  if (gambar.value) formData.append('gambar', gambar.value)
  formData.append('_method', 'PATCH')

  try {
    const res = await api.post(`/api/pakets/${route.params.id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    successMessage.value = res.data.message || 'Paket berhasil diupdate!'
    setTimeout(() => router.push('/admin/Dashboard'), 1500)
  } catch (err) {
    errors.value = err.response?.data || {}
    console.error(err)
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Edit Paket Wisata</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="updatePaket">
      <!-- Array fields sama seperti Create.vue -->
      <div class="mb-3">
        <label>Destinasi</label>
        <div v-for="(d, index) in destinasi" :key="'d' + index" class="d-flex gap-2 mb-2">
          <input v-model="destinasi[index]" class="form-control" />
          <button type="button" class="btn btn-danger" @click="removeField(destinasi, index)" v-if="destinasi.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(destinasi)">+ Tambah Destinasi</button>
      </div>

      <div class="mb-3">
        <label>Harga</label>
        <div v-for="(h, index) in harga" :key="'h' + index" class="d-flex gap-2 mb-2">
          <input v-model="harga[index]" class="form-control" />
          <button type="button" class="btn btn-danger" @click="removeField(harga, index)" v-if="harga.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(harga)">+ Tambah Harga</button>
      </div>

      <div class="mb-3">
        <label>Fasilitas Termasuk</label>
        <div v-for="(t, index) in termasuk" :key="'t' + index" class="d-flex gap-2 mb-2">
          <input v-model="termasuk[index]" class="form-control" />
          <button type="button" class="btn btn-danger" @click="removeField(termasuk, index)" v-if="termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(termasuk)">+ Tambah Termasuk</button>
      </div>

      <div class="mb-3">
        <label>Fasilitas Tidak Termasuk</label>
        <div v-for="(nt, index) in tidak_termasuk" :key="'nt' + index" class="d-flex gap-2 mb-2">
          <input v-model="tidak_termasuk[index]" class="form-control" />
          <button type="button" class="btn btn-danger" @click="removeField(tidak_termasuk, index)" v-if="tidak_termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(tidak_termasuk)">+ Tambah Tidak Termasuk</button>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea v-model="deskripsi" class="form-control" rows="4"></textarea>
      </div>

      <div class="mb-3">
        <label>Gambar (Opsional)</label>
        <input type="file" class="form-control" @change="handleFileChange" />
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</template>
