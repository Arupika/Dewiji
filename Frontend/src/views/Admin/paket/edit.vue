<script setup>
import { ref, onMounted, watch } from 'vue' // Tambahkan watch
import { useRouter, useRoute } from 'vue-router'
import api from '@/api' // Pastikan ini adalah instance Axios yang sudah dikonfigurasi dengan token
import Swal from 'sweetalert2' // Import SweetAlert2

const router = useRouter()
const route = useRoute()
const paketId = route.params.id // Ambil ID paket dari URL

// ===========================================
// NEW STATE FOR FORM FIELDS (Sama seperti Create.vue)
// ===========================================
const form = ref({
  nama: '', // BARU: Field nama paket
  destinasi: [''], // Array of strings
  harga: [ // BARU: Array of objects for prices
    { tipe: '', lama: '', diskon: '' }
  ],
  termasuk: [''], // Array of strings
  tidak_termasuk: [''], // Array of strings
  deskripsi: '',
  gambar: null, // File object for new image upload
  gambarPreview: null, // For preview of new image
  gambarUrlLama: null, // For displaying existing image from backend (accessor URL)
});

const errors = ref({}); // For backend validation errors
const successMessage = ref(''); // For success notification

// ===========================================
// HANDLERS FOR DYNAMIC FIELDS (DESTINASI, TERMASUK, TIDAK TERMASUK)
// ===========================================
// BARIS DIUBAH: addField sekarang menerima langsung array
const addField = (array) => array.push(''); 
// BARIS DIUBAH: removeField sekarang menerima langsung array
const removeField = (array, index) => {
  if (array.length > 1) {
    array.splice(index, 1);
  } else {
    array[0] = ''; // Jika hanya satu, kosongkan saja
  }
};

// ===========================================
// HANDLERS FOR DYNAMIC PRICE FIELDS
// ===========================================
const addPriceField = () => {
  form.value.harga.push({ tipe: '', lama: '', diskon: '' });
};
const removePriceField = (index) => {
  if (form.value.harga.length > 1) { // Always keep at least one price field
    form.value.harga.splice(index, 1);
  } else {
    // Optionally clear the last field if only one remains
    form.value.harga[0] = { tipe: '', lama: '', diskon: '' };
  }
};

// ===========================================
// HANDLER FOR IMAGE UPLOAD
// ===========================================
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file && file.type.startsWith('image/')) {
    form.value.gambar = file;
    // Untuk preview gambar baru
    const reader = new FileReader();
    reader.onload = (event) => {
      form.value.gambarPreview = event.target.result;
    };
    reader.readAsDataURL(file);
    errors.value.gambar = null; // Clear image error if file is selected
  } else {
    form.value.gambar = null;
    form.value.gambarPreview = null;
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan File',
      text: 'Mohon pilih file gambar (JPEG, PNG, JPG, GIF, SVG).'
    });
  }
};

// ===========================================
// FETCH PAKET DATA ON MOUNT
// ===========================================
onMounted(async () => {
  try {
    const res = await api.get(`/api/pakets/${paketId}`);
    const data = res.data.data; // Data paket dari API

    // Isi form dengan data yang diambil
    form.value.nama = data.nama || '';
    form.value.destinasi = Array.isArray(data.destinasi) && data.destinasi.length > 0 ? data.destinasi : [''];
    
    // Pastikan harga diisi sebagai array of objects
    form.value.harga = Array.isArray(data.harga) && data.harga.length > 0 ? data.harga : [{ tipe: '', lama: '', diskon: '' }];

    form.value.termasuk = Array.isArray(data.termasuk) && data.termasuk.length > 0 ? data.termasuk : [''];
    form.value.tidak_termasuk = Array.isArray(data.tidak_termasuk) && data.tidak_termasuk.length > 0 ? data.tidak_termasuk : [''];
    form.value.deskripsi = data.deskripsi || '';
    form.value.gambarUrlLama = data.gambar; // Simpan URL gambar lama untuk ditampilkan

  } catch (err) {
    console.error('Gagal memuat data paket:', err);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Memuat Data',
      text: 'Terjadi kesalahan saat memuat data paket. Mohon coba lagi.'
    }).then(() => {
      router.push('/admin/Dashboard'); // Redirect jika gagal memuat
    });
  }
});

// ===========================================
// UPDATE PAKET DATA
// ===========================================
const updatePaket = async () => {
  errors.value = {}; // Reset errors

  const formData = new FormData();
  formData.append('nama', form.value.nama);
  formData.append('deskripsi', form.value.deskripsi);
  
  // Destinasi
  form.value.destinasi.forEach((d, index) => {
    if (d.trim() !== '') {
      formData.append(`destinasi[${index}]`, d);
    }
  });

  // Harga
  form.value.harga.forEach((h, index) => {
    if (h.tipe.trim() !== '' && h.diskon.trim() !== '') {
      formData.append(`harga[${index}][tipe]`, h.tipe);
      if (h.lama.trim() !== '') {
        formData.append(`harga[${index}][lama]`, h.lama);
      }
      formData.append(`harga[${index}][diskon]`, h.diskon);
    }
  });

  // Termasuk
  form.value.termasuk.forEach((t, index) => {
    if (t.trim() !== '') {
      formData.append(`termasuk[${index}]`, t);
    }
  });

  // Tidak Termasuk
  form.value.tidak_termasuk.forEach((nt, index) => {
    if (nt.trim() !== '') {
      formData.append(`tidak_termasuk[${index}]`, nt);
    }
  });
  
  // Gambar baru (jika ada)
  if (form.value.gambar) {
    formData.append('gambar', form.value.gambar);
  }
  
  // PENTING: Untuk method PATCH/PUT di Laravel dengan FormData
  formData.append('_method', 'PATCH'); 

  try {
    const res = await api.post(`/api/pakets/${paketId}`, formData, { // Pakai POST dengan _method:PATCH
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    successMessage.value = res.data.message || 'Paket berhasil diupdate!';
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: successMessage.value,
      showConfirmButton: false,
      timer: 1500
    }).then(() => {
      router.push('/admin/Dashboard');
    });
  } catch (err) {
    let errorMessage = 'Terjadi kesalahan saat mengupdate paket.';
    if (err.response && err.response.status === 422) {
      errors.value = err.response.data.errors; // Pastikan akses ke errors.data.errors
      errorMessage = 'Terdapat kesalahan input. Silakan periksa kembali formulir Anda.';
      
      let detailedErrors = '<ul>';
      for (const key in errors.value) {
        detailedErrors += `<li>${errors.value[key][0]}</li>`;
      }
      detailedErrors += '</ul>';

      Swal.fire({
        icon: 'error',
        title: 'Gagal Update!',
        html: `
          <p>${errorMessage}</p>
          <div class="text-start">${detailedErrors}</div>
        `
      });
    } else if (err.response && err.response.data && err.response.data.message) {
      errorMessage = err.response.data.message;
      Swal.fire({ icon: 'error', title: 'Gagal Update!', text: errorMessage });
    } else {
      console.error(err);
      Swal.fire({ icon: 'error', title: 'Gagal Update!', text: 'Terjadi kesalahan server atau jaringan.' });
    }
  }
};

// Watcher untuk membersihkan pesan error saat form berubah (deep watch diperlukan)
watch(form, () => {
  errors.value = {};
}, { deep: true });
</script>

<template>
  <div class="container mt-5">
    <h3 class="mb-3">Edit Paket Wisata</h3>

    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <form @submit.prevent="updatePaket">
      <div class="mb-3">
        <label class="form-label">Nama Paket</label>
        <input v-model="form.nama" class="form-control" placeholder="Contoh: Paket Jelajah Merapi" :class="{'is-invalid': errors.nama}" />
        <small class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Destinasi</label>
        <div v-for="(d, index) in form.destinasi" :key="'d' + index" class="input-group mb-2">
          <input v-model="form.destinasi[index]" class="form-control" placeholder="Contoh: Candi Borobudur" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.destinasi, index)" v-if="form.destinasi.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(form.destinasi)">+ Tambah Destinasi</button>
        <small class="text-danger" v-if="errors['destinasi.0']">{{ errors['destinasi.0'][0] }}</small> </div>

      <div class="mb-3">
        <label class="form-label">Harga Paket</label>
        <div v-for="(price, index) in form.harga" :key="'price' + index" class="card p-3 mb-2 shadow-sm">
          <div class="row g-2">
            <div class="col-md-4">
              <label class="form-label small">Tipe Harga</label>
              <input v-model="price.tipe" class="form-control" placeholder="Contoh: Dewasa / Innova Reborn" :class="{'is-invalid': errors[`harga.${index}.tipe`]}" />
              <small class="text-danger" v-if="errors[`harga.${index}.tipe`]">{{ errors[`harga.${index}.tipe`][0] }}</small>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Harga Lama (Opsional)</label>
              <input v-model="price.lama" class="form-control" placeholder="Contoh: Rp 2.000.000" :class="{'is-invalid': errors[`harga.${index}.lama`]}" />
              <small class="text-danger" v-if="errors[`harga.${index}.lama`]">{{ errors[`harga.${index}.lama`][0] }}</small>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Harga Diskon (Wajib)</label>
              <input v-model="price.diskon" class="form-control" placeholder="Contoh: Rp 1.500.000" :class="{'is-invalid': errors[`harga.${index}.diskon`]}" required />
              <small class="text-danger" v-if="errors[`harga.${index}.diskon`]">{{ errors[`harga.${index}.diskon`][0] }}</small>
            </div>
          </div>
          <div class="d-flex justify-content-end mt-2" v-if="form.harga.length > 1">
            <button type="button" class="btn btn-sm btn-danger" @click="removePriceField(index)">Hapus Harga</button>
          </div>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addPriceField()">+ Tambah Tipe Harga</button>
        <small class="text-danger" v-if="errors['harga.0.tipe'] || errors['harga.0.diskon']">Pastikan setidaknya ada satu tipe harga yang valid.</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Fasilitas Termasuk</label>
        <div v-for="(t, index) in form.termasuk" :key="'t' + index" class="input-group mb-2">
          <input v-model="form.termasuk[index]" class="form-control" placeholder="Contoh: Transportasi" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.termasuk, index)" v-if="form.termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(form.termasuk)">+ Tambah Termasuk</button>
        <small class="text-danger" v-if="errors['termasuk.0']">{{ errors['termasuk.0'][0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Fasilitas Tidak Termasuk</label>
        <div v-for="(nt, index) in form.tidak_termasuk" :key="'nt' + index" class="input-group mb-2">
          <input v-model="form.tidak_termasuk[index]" class="form-control" placeholder="Contoh: Tiket masuk pribadi" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.tidak_termasuk, index)" v-if="form.tidak_termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(form.tidak_termasuk)">+ Tambah Tidak Termasuk</button>
        <small class="text-danger" v-if="errors['tidak_termasuk.0']">{{ errors['tidak_termasuk.0'][0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi Paket</label>
        <textarea v-model="form.deskripsi" class="form-control" rows="4" placeholder="Jelaskan isi paket secara singkat..." :class="{'is-invalid': errors.deskripsi}"></textarea>
        <small class="text-danger" v-if="errors.deskripsi">{{ errors.deskripsi[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar</label>
        <input type="file" class="form-control" @change="handleFileChange" :class="{'is-invalid': errors.gambar}" />
        <small class="text-danger" v-if="errors.gambar">{{ errors.gambar[0] }}</small>
        <div v-if="form.gambarUrlLama && !form.gambarPreview" class="mt-2">
            <p class="mb-1">Gambar saat ini:</p>
            <img :src="form.gambarUrlLama" alt="Gambar Paket Lama" style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
        </div>
        <div v-if="form.gambarPreview" class="mt-2">
            <p class="mb-1">Preview Gambar Baru:</p>
            <img :src="form.gambarPreview" alt="Preview Gambar Baru" style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 1px solid #ddd;">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</template>

<style scoped>
/* Tambahan styling jika diperlukan */
.form-label.small {
  font-size: 0.85em;
  margin-bottom: 0.25rem;
}
.card.p-3 {
  border: 1px solid #e0e0e0;
}
.input-group > .form-control {
  flex-grow: 1; /* Pastikan input mengambil ruang yang tersedia */
}
.input-group .btn {
  flex-shrink: 0; /* Mencegah tombol mengecil */
}
.is-invalid {
  border-color: #dc3545 !important;
}
.text-danger small { /* Mengubah .invalid-feedback, .text-danger small menjadi satu */
  color: #dc3545;
  font-size: 0.875em;
  margin-top: 0.25rem;
  display: block; /* Agar selalu di baris baru */
}
</style>