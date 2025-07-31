<template>
  <div class="register-page d-flex align-items-center justify-content-center">
    <div class="register-card p-5 shadow-lg">
      <h2 class="text-center fw-bold mb-2 text-light">REGISTER AKUN BARU</h2>
      <p class="text-center text-light opacity-75 mb-4">Daftar untuk akses fitur Dewiji</p>

      <form @submit.prevent="handleRegister">
        <div class="mb-3">
          <label class="form-label text-light">Nama Lengkap</label>
          <input type="text" class="form-control input-custom" :class="{'is-invalid': errors.name}" v-model="form.name" required />
          <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Email</label>
          <input type="email" class="form-control input-custom" :class="{'is-invalid': errors.email}" v-model="form.email" required />
          <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Password</label>
          <input type="password" class="form-control input-custom" :class="{'is-invalid': errors.password}" v-model="form.password" required />
          <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Konfirmasi Password</label>
          <input type="password" class="form-control input-custom" :class="{'is-invalid': form.password !== form.confirmPassword && form.confirmPassword !== ''}" v-model="form.confirmPassword" required />
          <div v-if="form.password !== form.confirmPassword && form.confirmPassword !== ''" class="invalid-feedback">
            Password dan konfirmasi password tidak cocok.
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Nomor Telepon (Opsional)</label>
          <input type="tel" class="form-control input-custom" :class="{'is-invalid': errors.phone}" v-model="form.phone" />
          <div v-if="errors.phone" class="invalid-feedback">{{ errors.phone[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Tanggal Lahir (Opsional)</label>
          <input type="date" class="form-control input-custom" :class="{'is-invalid': errors.birthDate}" v-model="form.birthDate" />
          <div v-if="errors.birthDate" class="invalid-feedback">{{ errors.birthDate[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Jenis Kelamin (Opsional)</label>
          <select class="form-select input-custom" :class="{'is-invalid': errors.sex}" v-model="form.sex">
            <option value="">Pilih</option>
            <option value="male">Laki-laki</option>
            <option value="female">Perempuan</option>
          </select>
          <div v-if="errors.sex" class="invalid-feedback">{{ errors.sex[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Alamat (Opsional)</label>
          <textarea class="form-control input-custom" :class="{'is-invalid': errors.address}" v-model="form.address" rows="2"></textarea>
          <div v-if="errors.address" class="invalid-feedback">{{ errors.address[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Foto Profil (Opsional)</label>
          <input type="file" class="form-control input-custom" :class="{'is-invalid': errors.gambar}" @change="handleFileChange" accept="image/*" />
          <div v-if="errors.gambar" class="invalid-feedback">{{ errors.gambar[0] }}</div>
          <small v-if="form.gambarPreview" class="text-light mt-2 d-block">
            <img :src="form.gambarPreview" alt="Gambar Preview" style="max-width: 100px; max-height: 100px; border-radius: 5px;" />
          </small>
        </div>
        
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="agreeTerms" v-model="form.agreeTerms" required>
          <label class="form-check-label text-light" for="agreeTerms">
            Saya menyetujui <a href="#" class="text-warning text-decoration-none fw-semibold">Syarat & Ketentuan</a>
          </label>
          <div v-if="errors.agreeTerms" class="text-danger small mt-1">{{ errors.agreeTerms[0] }}</div>
        </div>

        <button type="submit" class="btn btn-gradient w-100 rounded-pill fw-semibold py-2">
          <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
        </button>

        <p class="text-center mt-3 text-light">
          Sudah punya akun?
          <router-link to="/Auth/Login" class="text-warning text-decoration-none fw-semibold">Masuk di sini</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
// --- Impor Modul ---
import { ref, watch } from 'vue'; // // 'ref' untuk data reaktif, 'watch' untuk mengamati perubahan data.
import axios from 'axios'; // // Library untuk melakukan request HTTP ke API.
import { useRouter } from 'vue-router'; // // Untuk navigasi antar halaman.
import Swal from 'sweetalert2'; // // Library untuk notifikasi pop-up yang interaktif.

// --- Konfigurasi Axios ---
axios.defaults.withCredentials = true; // // Mengizinkan pengiriman cookie antar domain (penting untuk otentikasi).
axios.defaults.baseURL = "http://localhost:8000"; // // URL dasar untuk semua request API.

// --- State (Data Reaktif) ---
const router = useRouter(); // // Mendapatkan instance router.

// // Objek untuk menampung semua data yang diisi pengguna di formulir.
const form = ref({
  name: '',
  email: '',
  phone: '',
  birthDate: '',
  role: 'user', // // Role default, tidak perlu diisi pengguna.
  sex: '',
  address: '',
  password: '',
  confirmPassword: '', // // Hanya untuk validasi, tidak dikirim ke server.
  agreeTerms: false,
  gambar: null, // // Akan menyimpan File object dari input.
  gambarPreview: null // // Akan menyimpan URL pratinjau gambar.
});
const errors = ref({}); // // Objek untuk menyimpan error validasi dari backend.

// --- Fungsi-Fungsi ---

// // Fungsi yang dipanggil saat pengguna memilih file gambar.
const handleFileChange = (event) => {
  const file = event.target.files[0]; // // Ambil file pertama yang dipilih.
  if (file) {
    form.value.gambar = file; // // Simpan File object untuk dikirim ke server.
    const reader = new FileReader(); // // Buat FileReader untuk membaca file.
    reader.onload = (e) => {
      // // Setelah file berhasil dibaca, simpan hasilnya (URL base64) ke 'gambarPreview'.
      form.value.gambarPreview = e.target.result;
    };
    reader.readAsDataURL(file); // // Mulai proses pembacaan file.
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

// // Fungsi utama yang dieksekusi saat formulir di-submit.
const handleRegister = async () => {
  errors.value = {}; // Reset errors on each submit

  // // 1. Validasi Frontend: Cek dulu di sisi klien sebelum mengirim ke server.
  if (form.value.password !== form.value.confirmPassword) {
    Swal.fire({
      icon: 'error',
      title: 'Registrasi Gagal!',
      text: 'Password dan konfirmasi password tidak cocok.'
    });
    return; // // Hentikan eksekusi jika tidak cocok.
  }

  // Validasi persetujuan terms di frontend
  if (!form.value.agreeTerms) {
    Swal.fire({
      icon: 'error',
      title: 'Registrasi Gagal!',
      text: 'Anda harus menyetujui Syarat & Ketentuan.'
    });
    errors.value.agreeTerms = ['Anda harus menyetujui Syarat & Ketentuan.']; 
    return; // // Hentikan eksekusi jika belum setuju.
  }

 // // 2. Persiapan Data: Buat objek FormData karena ada file yang akan dikirim.
  const formData = new FormData();
    // // Looping melalui setiap properti di object 'form' untuk ditambahkan ke 'formData'.
  for (const key in form.value) {
    // Lewati confirmPassword dan gambarPreview karena tidak perlu dikirim ke backend
    if (key === 'confirmPassword' || key === 'gambarPreview') {
      continue;
    }
    // Field 'gambar' adalah File object
    if (key === 'gambar' && form.value.gambar) {
      formData.append(key, form.value[key]);
    } 
    // Untuk agreeTerms, kirim '1' atau '0' (Laravel akan mengkonversi ke boolean)
    else if (key === 'agreeTerms') {
      formData.append(key, form.value.agreeTerms ? '1' : '0');
    }
    // Untuk field lain (string, date, number), tambahkan jika tidak kosong/null
    else if (form.value[key] !== null && form.value[key] !== '') {
      formData.append(key, form.value[key]);
    }
  }
  
  try {
    // Kirim data registrasi ke endpoint API users (POST /api/users)
    const res = await axios.post('/api/users', formData, { 
      headers: {
        'Content-Type': 'multipart/form-data' // Penting untuk pengiriman file
      }
    });

    Swal.fire({
      icon: 'success',
      title: 'Registrasi Berhasil!',
      text: res.data.message || 'Akun Anda berhasil dibuat. Silakan login.',
      showConfirmButton: false,
      timer: 2000
    });
    router.push('/Auth/Login'); // Redirect ke halaman login setelah registrasi berhasil
  } catch (error) {
    let title = 'Registrasi Gagal!';
    let text = 'Terjadi kesalahan saat registrasi. Mohon coba lagi.';
    let htmlContent = ''; 

    if (error.response) {
      // Server merespons (bukan error jaringan)
      if (error.response.status === 422) {
        // Error validasi dari Laravel (Status 422)
        errors.value = error.response.data.errors; // Simpan error ke ref errors
        
        // --- LOGIKA BARU UNTUK EMAIL DUPLIKAT ---
        let emailAlreadyTaken = false;
        if (errors.value.email && errors.value.email.includes('The email has already been taken.')) {
          emailAlreadyTaken = true;
        }

        if (emailAlreadyTaken) {
          // Pesan spesifik untuk email yang sudah terdaftar
          Swal.fire({
            icon: 'error',
            title: 'Registrasi Gagal!',
            text: 'Email ini sudah terdaftar. Mohon gunakan email lain.',
          });
        } else {
          // Logika untuk error validasi lainnya (selain email duplikat)
          text = 'Terdapat kesalahan input. Silakan periksa kembali formulir Anda.';
          htmlContent = '<ul>';
          for (const key in errors.value) {
            if (key === 'password' && errors.value[key].includes('The password field confirmation does not match.')) {
                htmlContent += `<li>Password dan konfirmasi password tidak cocok.</li>`;
            } else {
                htmlContent += `<li>${errors.value[key][0]}</li>`; // Ambil pesan error pertama
            }
          }
          htmlContent += '</ul>';

          Swal.fire({
            icon: 'error',
            title: title,
            html: `
              <p>${text}</p>
              <div class="text-start">${htmlContent}</div>
            `
          });
        }
        return; // Penting: Berhenti eksekusi setelah SweetAlert ditampilkan
      } else if (error.response.data && error.response.data.message) {
        // Error lain dari backend dengan pesan spesifik (misal status 500 dengan pesan custom)
        text = error.response.data.message;
      } else {
        // Error server non-validasi (misal 500 Internal Server Error tanpa pesan custom)
        text = `Server error: ${error.response.status}. Mohon coba lagi nanti.`;
      }
    } else if (error.request) {
      // Request terkirim tapi tidak ada respons (misal server tidak berjalan, CORS block)
      text = 'Tidak ada respons dari server. Pastikan server berjalan dan koneksi internet Anda stabil.';
    } else {
      // Error lain (misal, masalah jaringan klien sebelum request terkirim)
      text = 'Terjadi kesalahan jaringan atau konfigurasi. Mohon periksa koneksi Anda.';
    }

    // Tampilkan SweetAlert untuk error non-validasi (jika belum return di 422)
    Swal.fire({
      icon: 'error',
      title: title,
      text: text
    });
  }
};

// Watcher untuk membersihkan error saat input berubah (demi UX yang lebih baik)
watch(form.value, () => {
  errors.value = {};
}, { deep: true });

</script>

<style scoped>
/* // Mengatur background dan layout utama halaman. */
/* BACKGROUND DAN KARTU SAMA DENGAN LOGIN */
.register-page {
  min-height: 100vh;
  background: url('@/assets/merapi.png') no-repeat center center/cover;
  font-family: 'Poppins', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

/* // Memberi gaya pada kartu form, termasuk efek transparan (frosted glass). */
.register-card {
  width: 100%;
  max-width: 700px; 
  border-radius: 20px;
  background: rgba(15, 15, 30, 0.8);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  padding: 2rem;
  max-height: 90vh; /* // Batasi tinggi kartu agar bisa di-scroll di layar kecil. */
  overflow-y: auto; /* // Aktifkan scroll vertikal jika konten melebihi tinggi. */
}

/* // Gaya kustom untuk input field agar transparan dengan garis bawah. */
/* INPUT FIELD STYLES (SAMA DENGAN LOGIN) */
.input-custom {
  background-color: transparent;
  border: none;
  border-bottom: 2px solid rgba(255, 255, 255, 0.4);
  color: #ffffff !important;
  border-radius: 0;
  padding: 12px 8px;
  font-size: 1rem;
  caret-color: white;
  transition: border-color 0.3s ease;
}

/* // Efek saat input field aktif (di-klik/fokus). */
.input-custom:focus {
  border-color: #ffc107;
  box-shadow: none;
  outline: none;
  background-color: transparent;
}

/* Style untuk select dan textarea */
.input-custom.form-select,
.input-custom.form-control[rows] {
  border: 1px solid rgba(255, 255, 255, 0.4); 
  border-radius: 0.25rem;
}

.input-custom.form-select option {
  background-color: rgba(15, 15, 30, 0.9); 
  color: #ffffff;
}

.form-label {
  font-weight: 500;
  font-size: 1rem;
  margin-bottom: 4px;
  display: block; /* Pastikan label display block agar small invalid feedback di bawah */
}

/* BUTTON STYLES (SAMA DENGAN LOGIN) */
.btn-gradient {
  background: linear-gradient(to right, #ffa500, #ff6f61);
  color: white;
  border: none;
  transition: background 0.3s ease, transform 0.2s ease;
}

/* // Efek hover pada tombol. */
.btn-gradient:hover {
  background: linear-gradient(to right, #ff8c00, #ff4e42);
  transform: scale(1.02); /* // Sedikit memperbesar tombol. */
}

/* LINK STYLES (SAMA DENGAN LOGIN) */
a.text-warning:hover {
  color: #ffc107 !important;
  text-decoration: underline;
}

/* INVALID FEEDBACK STYLES (SAMA DENGAN LOGIN) */
.invalid-feedback {
  color: #dc3545; 
  font-size: 0.875em;
  margin-top: 0.25rem;
  display: block; /* Penting agar pesan error selalu tampil di bawah input */
}

/* // Memberi border merah pada input yang tidak valid. */
.is-invalid {
  border-color: #dc3545 !important;
}

/* CHECKBOX STYLES (SAMA DENGAN LOGIN) */
.form-check-input {
  background-color: transparent;
  border: 1px solid rgba(255, 255, 255, 0.4);
}

/* // Gaya kustom untuk checkbox. */
.form-check-input:checked {
  background-color: #ffc107;
  border-color: #ffc107;
}
</style>