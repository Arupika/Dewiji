<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/api';

const router = useRouter();

const destinasi = ref(['']);
const harga = ref(['']);
const termasuk = ref(['']);
const tidak_termasuk = ref(['']);
const deskripsi = ref('');
const gambar = ref(null);
const errors = ref([]);
const successMessage = ref('');

const handleFileChange = (e) => {
  gambar.value = e.target.files[0];
};

const addField = (array) => array.push('');
const removeField = (array, index) => array.splice(index, 1);

const storePaket = async () => {
  const formData = new FormData();
  destinasi.value.forEach((d) => formData.append('destinasi[]', d));
  harga.value.forEach((h) => formData.append('harga[]', h));
  termasuk.value.forEach((t) => formData.append('termasuk[]', t));
  tidak_termasuk.value.forEach((nt) => formData.append('tidak_termasuk[]', nt));
  formData.append('deskripsi', deskripsi.value);
  if (gambar.value) {
    formData.append('gambar', gambar.value);
  }

  try {
    const res = await api.post('/api/pakets', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    successMessage.value = res.data.message || 'Paket berhasil ditambahkan!';
    setTimeout(() => router.push('/admin/Dashboard'), 1500);
  } catch (err) {
    errors.value = err.response?.data || {};
    console.error(err);
  }
};
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Tambah Paket Wisata</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="storePaket">
      <!-- Destinasi -->
      <div class="mb-3">
        <label>Destinasi</label>
        <div v-for="(d, index) in destinasi" :key="'d' + index" class="d-flex gap-2 mb-2">
          <input v-model="destinasi[index]" class="form-control" placeholder="Contoh: Pantai Parangtritis" />
          <button type="button" class="btn btn-danger" @click="removeField(destinasi, index)" v-if="destinasi.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(destinasi)">+ Tambah Destinasi</button>
      </div>

      <!-- Harga -->
      <div class="mb-3">
        <label>Harga</label>
        <div v-for="(h, index) in harga" :key="'h' + index" class="d-flex gap-2 mb-2">
          <input v-model="harga[index]" class="form-control" placeholder="Contoh: 150K / pax" />
          <button type="button" class="btn btn-danger" @click="removeField(harga, index)" v-if="harga.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(harga)">+ Tambah Harga</button>
      </div>

      <!-- Termasuk -->
      <div class="mb-3">
        <label>Fasilitas Termasuk</label>
        <div v-for="(t, index) in termasuk" :key="'t' + index" class="d-flex gap-2 mb-2">
          <input v-model="termasuk[index]" class="form-control" placeholder="Contoh: Transportasi" />
          <button type="button" class="btn btn-danger" @click="removeField(termasuk, index)" v-if="termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(termasuk)">+ Tambah Termasuk</button>
      </div>

      <!-- Tidak Termasuk -->
      <div class="mb-3">
        <label>Fasilitas Tidak Termasuk</label>
        <div v-for="(nt, index) in tidak_termasuk" :key="'nt' + index" class="d-flex gap-2 mb-2">
          <input v-model="tidak_termasuk[index]" class="form-control" placeholder="Contoh: Tiket masuk pribadi" />
          <button type="button" class="btn btn-danger" @click="removeField(tidak_termasuk, index)" v-if="tidak_termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(tidak_termasuk)">+ Tambah Tidak Termasuk</button>
      </div>

      <!-- Deskripsi -->
      <div class="mb-3">
        <label>Deskripsi Paket</label>
        <textarea v-model="deskripsi" class="form-control" rows="4" placeholder="Jelaskan paket wisata secara ringkas..."></textarea>
      </div>

      <!-- Gambar -->
      <div class="mb-3">
        <label>Gambar</label>
        <input type="file" class="form-control" @change="handleFileChange" />
      </div>

      <button class="btn btn-primary">Simpan</button>
    </form>
  </div>
</template>
