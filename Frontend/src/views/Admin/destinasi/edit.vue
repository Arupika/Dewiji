<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '@/api';

const router = useRouter();
const route = useRoute();

const nama = ref('');
const deskripsi = ref('');
const location = ref('');
const kategori = ref(['']);
const harga = ref(['']);
const jamOperasional = ref('');
const gambar = ref(null);
const previewGambar = ref('');
const errors = ref([]);
const successMessage = ref('');

// Get existing destinasi
onMounted(async () => {
  try {
    const res = await api.get(`/api/destinasis/${route.params.id}`);
    const data = res.data.data;
    nama.value = data.nama;
    deskripsi.value = data.deskripsi;
    location.value = data.location;
    kategori.value = Array.isArray(data.kategori) ? data.kategori : [data.kategori];
    harga.value = Array.isArray(data.harga) ? data.harga : [data.harga];
    jamOperasional.value = data.jamOperasional;
    previewGambar.value = data.gambar_url || '';
  } catch (err) {
    console.error('Gagal load data:', err);
  }
});

const handleFileChange = (e) => {
  gambar.value = e.target.files[0];
};

const addKategori = () => kategori.value.push('');
const removeKategori = (index) => kategori.value.splice(index, 1);

const addHarga = () => harga.value.push('');
const removeHarga = (index) => harga.value.splice(index, 1);

const updateDestinasi = async () => {
  const formData = new FormData();
  formData.append('nama', nama.value);
  formData.append('deskripsi', deskripsi.value);
  formData.append('location', location.value);
  kategori.value.forEach(k => formData.append('kategori[]', k));
  harga.value.forEach(h => formData.append('harga[]', h));
  formData.append('jamOperasional', jamOperasional.value);
  if (gambar.value) formData.append('gambar', gambar.value);
  formData.append('_method', 'PATCH');

  try {
    const response = await api.post(`/api/destinasis/${route.params.id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    successMessage.value = response.data.message || 'Destinasi berhasil diperbarui!';
    setTimeout(() => router.push('/admin/Dashboard'), 1500);
  } catch (err) {
    errors.value = err.response?.data || {};
    console.error('Gagal update:', err);
  }
};
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Edit Destinasi</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="updateDestinasi">
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
        <input type="text" class="form-control" v-model="jamOperasional" />
        <small class="text-danger" v-if="errors.jamOperasional">{{ errors.jamOperasional[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar</label>
        <input type="file" class="form-control" @change="handleFileChange" />
        <small class="text-danger" v-if="errors.gambar">{{ errors.gambar[0] }}</small>
        <div v-if="previewGambar" class="mt-2">
          <img :src="previewGambar" class="img-fluid" style="max-height: 200px;" />
        </div>
      </div>

      <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
  </div>
</template>
