<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '@/api'

const router = useRouter()
const route = useRoute()

const nama = ref('')
const deskripsi = ref('')
const harga = ref('')
const harga12jam = ref('')
const kapasitas = ref('')
const fitur = ref([''])
const termasuk = ref([''])
const gambar = ref(null)
const errors = ref({})
const successMessage = ref('')

onMounted(async () => {
  try {
    const res = await api.get(`/api/mobils/${route.params.id}`)
    const data = res.data.data
    nama.value = data.nama
    deskripsi.value = data.deskripsi
    harga.value = data.harga
    harga12jam.value = data.harga12jam
    kapasitas.value = data.kapasitas
    fitur.value = data.fitur ?? ['']
    termasuk.value = data.termasuk ?? ['']
  } catch (err) {
    console.error(err)
  }
})

const handleFileChange = (e) => {
  gambar.value = e.target.files[0]
}

const addField = (array) => array.push('')
const removeField = (array, index) => array.splice(index, 1)

const updateMobil = async () => {
  errors.value = {}

  const formData = new FormData()
  formData.append('nama', nama.value)
  formData.append('deskripsi', deskripsi.value)
  formData.append('harga', harga.value)
  formData.append('harga12jam', harga12jam.value)
  formData.append('kapasitas', kapasitas.value)
  fitur.value.forEach(f => formData.append('fitur[]', f))
  termasuk.value.forEach(t => formData.append('termasuk[]', t))
  if (gambar.value) formData.append('gambar', gambar.value)
  formData.append('_method', 'PATCH')

  try {
    const res = await api.post(`/api/mobils/${route.params.id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    successMessage.value = res.data.message || 'Mobil berhasil diperbarui!'
    setTimeout(() => router.push('/Admin/Dashboard'), 1500)
  } catch (err) {
    errors.value = err.response?.data || {}
  }
}
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Edit Mobil</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="updateMobil">
      <div class="mb-3">
        <label>Nama</label>
        <input v-model="nama" class="form-control" />
        <small class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Deskripsi</label>
        <textarea v-model="deskripsi" class="form-control" rows="3"></textarea>
        <small class="text-danger" v-if="errors.deskripsi">{{ errors.deskripsi[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Harga 24 Jam</label>
        <input v-model="harga" class="form-control" />
        <small class="text-danger" v-if="errors.harga">{{ errors.harga[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Harga 12 Jam</label>
        <input v-model="harga12jam" class="form-control" />
        <small class="text-danger" v-if="errors.harga12jam">{{ errors.harga12jam[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Kapasitas</label>
        <input v-model="kapasitas" class="form-control" />
        <small class="text-danger" v-if="errors.kapasitas">{{ errors.kapasitas[0] }}</small>
      </div>

      <!-- Fitur -->
      <div class="mb-3">
        <label>Fitur</label>
        <div v-for="(f, index) in fitur" :key="'f' + index" class="d-flex gap-2 mb-2">
          <input v-model="fitur[index]" class="form-control" placeholder="Contoh: AC" />
          <button type="button" class="btn btn-danger" @click="removeField(fitur, index)" v-if="fitur.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(fitur)">+ Tambah Fitur</button>
        <small class="text-danger" v-if="errors.fitur">{{ errors.fitur[0] }}</small>
      </div>

      <!-- Termasuk -->
      <div class="mb-3">
        <label>Termasuk</label>
        <div v-for="(t, index) in termasuk" :key="'t' + index" class="d-flex gap-2 mb-2">
          <input v-model="termasuk[index]" class="form-control" placeholder="Contoh: Sopir" />
          <button type="button" class="btn btn-danger" @click="removeField(termasuk, index)" v-if="termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(termasuk)">+ Tambah Termasuk</button>
        <small class="text-danger" v-if="errors.termasuk">{{ errors.termasuk[0] }}</small>
      </div>

      <div class="mb-3">
        <label>Gambar (Opsional)</label>
        <input type="file" class="form-control" @change="handleFileChange" />
        <small class="text-danger" v-if="errors.gambar">{{ errors.gambar[0] }}</small>
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</template>
