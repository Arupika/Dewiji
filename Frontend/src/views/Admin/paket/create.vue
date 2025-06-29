<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api' // Pastikan ini adalah instance Axios yang sudah dikonfigurasi dengan token
import Swal from 'sweetalert2' // Import SweetAlert2

const router = useRouter()

// ===========================================
// NEW STATE FOR FORM FIELDS
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
  gambar: null, // File object for image
  gambarPreview: null, // For image preview
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
// HANDLERS FOR DYNAMIC PRICE FIELDS (sudah benar)
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
    // Untuk preview gambar
    const reader = new FileReader();
    reader.onload = (event) => {
      form.value.gambarPreview = event.target.result;
    };
    reader.readAsDataURL(file);
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
// STORE PAKET DATA
// ===========================================
const storePaket = async () => {
  errors.value = {}; // Reset errors

  const formData = new FormData();
  formData.append('nama', form.value.nama); // BARU: Tambahkan nama
  formData.append('deskripsi', form.value.deskripsi); // Tambahkan deskripsi
  
  // Destinasi (array of strings)
  form.value.destinasi.forEach((d, index) => {
    if (d.trim() !== '') { // Hanya tambahkan jika tidak kosong
      formData.append(`destinasi[${index}]`, d);
    }
  });

  // Harga (array of objects)
  form.value.harga.forEach((h, index) => {
    // Pastikan tipe dan diskon tidak kosong untuk setiap item harga
    if (h.tipe.trim() !== '' && h.diskon.trim() !== '') {
      formData.append(`harga[${index}][tipe]`, h.tipe);
      if (h.lama.trim() !== '') {
        formData.append(`harga[${index}][lama]`, h.lama);
      }
      formData.append(`harga[${index}][diskon]`, h.diskon);
    }
  });

  // Termasuk (array of strings)
  form.value.termasuk.forEach((t, index) => {
    if (t.trim() !== '') {
      formData.append(`termasuk[${index}]`, t);
    }
  });

  // Tidak Termasuk (array of strings)
  form.value.tidak_termasuk.forEach((nt, index) => {
    if (nt.trim() !== '') {
      formData.append(`tidak_termasuk[${index}]`, nt);
    }
  });
  
  // Gambar
  if (form.value.gambar) {
    formData.append('gambar', form.value.gambar);
  }

  try {
    const res = await api.post('/api/pakets', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    successMessage.value = res.data.message || 'Paket berhasil ditambahkan!';
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
    let errorMessage = 'Terjadi kesalahan saat menyimpan paket.';
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
        title: 'Gagal Menyimpan!',
        html: `
          <p>${errorMessage}</p>
          <div class="text-start">${detailedErrors}</div>
        `
      });
    } else if (err.response && err.response.data && err.response.data.message) {
      errorMessage = err.response.data.message;
      Swal.fire({ icon: 'error', title: 'Gagal Menyimpan!', text: errorMessage });
    } else {
      console.error(err);
      Swal.fire({ icon: 'error', title: 'Gagal Menyimpan!', text: 'Terjadi kesalahan server atau jaringan.' });
    }
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
      <div class="mb-3">
        <label class="form-label">Nama Paket</label>
        <input v-model="form.nama" class="form-control" placeholder="Contoh: Paket Jelajah Merapi" :class="{'is-invalid': errors.nama}" />
        <small class="text-danger" v-if="errors.nama">{{ errors.nama[0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Destinasi</label>
        <div v-for="(d, i) in form.destinasi" :key="'d' + i" class="input-group mb-2">
          <input v-model="form.destinasi[i]" class="form-control" placeholder="Contoh: Candi Borobudur" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.destinasi, i)" v-if="form.destinasi.length > 1">Hapus</button>
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
        <div v-for="(t, i) in form.termasuk" :key="'t' + i" class="input-group mb-2">
          <input v-model="form.termasuk[i]" class="form-control" placeholder="Contoh: Transportasi" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.termasuk, i)" v-if="form.termasuk.length > 1">Hapus</button>
        </div>
        <button type="button" class="btn btn-sm btn-secondary" @click="addField(form.termasuk)">+ Tambah Termasuk</button>
        <small class="text-danger" v-if="errors['termasuk.0']">{{ errors['termasuk.0'][0] }}</small>
      </div>

      <div class="mb-3">
        <label class="form-label">Fasilitas Tidak Termasuk</label>
        <div v-for="(nt, i) in form.tidak_termasuk" :key="'nt' + i" class="input-group mb-2">
          <input v-model="form.tidak_termasuk[i]" class="form-control" placeholder="Contoh: Tiket masuk pribadi" />
          <button type="button" class="btn btn-outline-danger" @click="removeField(form.tidak_termasuk, i)" v-if="form.tidak_termasuk.length > 1">Hapus</button>
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
        <div v-if="form.gambarPreview" class="mt-2">
            <img :src="form.gambarPreview" alt="Preview Gambar" style="max-width: 200px; max-height: 150px; border-radius: 8px;">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
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