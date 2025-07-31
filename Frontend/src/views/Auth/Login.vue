<template>
  <div class="login-page d-flex align-items-center justify-content-center">
    <div class="login-card p-5 shadow-lg">
      <h2 class="text-center fw-bold mb-2 text-light">LOGIN</h2>
      <p class="text-center text-light opacity-75 mb-4">Login ke akun Dewiji Anda</p>

      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label text-light">Email</label>
          <input type="email" class="form-control input-custom" :class="{'is-invalid': errors.email}" v-model="loginForm.email" required />
          <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Password</label>
          <input type="password" class="form-control input-custom" :class="{'is-invalid': errors.password}" v-model="loginForm.password" required />
          <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
        </div>

        <button type="submit" class="btn btn-gradient w-100 rounded-pill fw-semibold py-2">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>

        <p class="text-center mt-3 text-light">
          Belum punya akun?
          <router-link to="/Auth/Register" class="text-warning text-decoration-none fw-semibold">Daftar di sini</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

// Konfigurasi Axios global
// Pastikan ini sesuai dengan BASE_URL API Laravel Anda
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000";

const router = useRouter();

const loginForm = ref({
  email: '',
  password: ''
});

const errors = ref({}); // Untuk menyimpan error validasi dari backend

const handleLogin = async () => {
  errors.value = {}; // Reset errors on each submission attempt
  try {
    // Meminta CSRF cookie dari Laravel Sanctum
    await axios.get('/sanctum/csrf-cookie');
    
    // Mengirim permintaan login
    const response = await axios.post('/api/login', loginForm.value);
    
    // Menyimpan token autentikasi dan role pengguna ke localStorage
    localStorage.setItem('auth_token', response.data.access_token);
    // Asumsi backend mengirimkan 'user' object yang berisi 'role'
    localStorage.setItem('user_role', response.data.user.role); 
    
    // Menampilkan pesan sukses menggunakan SweetAlert2
    Swal.fire({
      icon: 'success',
      title: 'Login Berhasil!',
      text: 'Anda berhasil masuk ke akun Dewiji Anda.',
      showConfirmButton: false,
      timer: 1500
    });

    // Mengarahkan pengguna berdasarkan role
    if (response.data.user.role === 'admin') {
      router.push('/Admin/Dashboard'); // Arahkan ke dashboard admin
    } else {
      router.push('/'); // Arahkan ke halaman utama untuk pengguna biasa
    }
  } catch (error) {
    // === START DEBUGGING SNIPPET ===
    console.error("Login error object:", error); 
    console.log("Error response status:", error.response?.status); 
    console.log("Error response data:", error.response?.data);
    // === END DEBUGGING SNIPPET ===

    let errorMessage = 'Terjadi kesalahan yang tidak terduga saat login.'; // Pesan error default

    // Periksa apakah ada respons dari server
    if (error.response) {
      if (error.response.status === 401) {
        // Penanganan khusus untuk error autentikasi (email/password salah)
        errorMessage = 'Email atau password salah. Mohon periksa kembali.';
        // Jika backend mengirimkan error validasi di samping 401 (misal: "email is required")
        // Ini tidak biasa untuk 401, tapi bisa saja terjadi jika validasi kustom
        if (error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
      } else if (error.response.status === 422) {
          // Penanganan khusus untuk error validasi Laravel (misal: field kosong)
          errors.value = error.response.data.errors;
          let detailedErrors = '<ul>';
          for (const key in errors.value) {
              detailedErrors += `<li>${errors.value[key][0]}</li>`;
          }
          detailedErrors += '</ul>';
          Swal.fire({
              icon: 'error',
              title: 'Login Gagal!',
              html: `
                  <p>Terdapat kesalahan input. Silakan periksa kembali formulir Anda.</p>
                  <div class="text-start">${detailedErrors}</div>
              `
          });
          return; // Penting: Hentikan eksekusi di sini agar tidak menampilkan SweetAlert ganda
      } else if (error.response.data && error.response.data.message) {
        // Untuk error lain dari backend yang memiliki pesan kustom
        errorMessage = error.response.data.message;
      }
    } else {
      // Penanganan error jika tidak ada respons dari server (misal: masalah jaringan)
      errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
    }

    // Tampilkan SweetAlert untuk semua jenis error kecuali 422 (yang sudah ditangani di atas)
    // dan juga jika `error.response` ada
    if (error.response?.status !== 422) {
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: errorMessage
        });
    }
  }
};

// Watcher untuk membersihkan pesan error validasi saat pengguna mulai mengetik kembali
watch(loginForm.value, () => {
  errors.value = {};
}, { deep: true }); // Menggunakan deep watch karena loginForm adalah objek

</script>

<style scoped>
/* Gaya untuk halaman login */
.login-page {
  min-height: 100vh;
  background: url('@/assets/merapi.png') no-repeat center center/cover;
  font-family: 'Poppins', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

/* Gaya untuk kartu login */
.login-card {
  width: 100%;
  max-width: 500px;
  border-radius: 20px;
  background: rgba(15, 15, 30, 0.8); /* Latar belakang semi-transparan gelap */
  backdrop-filter: blur(16px); /* Efek blur untuk latar belakang */
  border: 1px solid rgba(255, 255, 255, 0.15); /* Border transparan */
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25); /* Shadow */
  padding: 2rem;
}

/* Gaya untuk input kustom */
.input-custom {
  background-color: transparent;
  border: none;
  border-bottom: 2px solid rgba(255, 255, 255, 0.4); /* Garis bawah transparan */
  color: #ffffff !important; /* Warna teks putih */
  border-radius: 0; /* Tanpa border-radius */
  padding: 12px 8px;
  font-size: 1rem;
  caret-color: white; /* Warna kursor putih */
  transition: border-color 0.3s ease;
}

.input-custom:focus {
  border-color: #ffc107; /* Warna kuning saat fokus */
  box-shadow: none;
  outline: none;
  background-color: transparent;
}

/* Gaya untuk label form */
.form-label {
  font-weight: 500;
  font-size: 1rem;
  margin-bottom: 4px;
}

/* Gaya untuk tombol login dengan gradient */
.btn-gradient {
  background: linear-gradient(to right, #ffa500, #ff6f61); /* Gradient orange-red */
  color: white;
  border: none;
  transition: background 0.3s ease, transform 0.2s ease;
}

.btn-gradient:hover {
  background: linear-gradient(to right, #ff8c00, #ff4e42); /* Gradient yang sedikit lebih gelap saat hover */
  transform: scale(1.02); /* Efek membesar sedikit */
}

/* Gaya untuk link "Daftar di sini" */
a.text-warning:hover {
  color: #ffc107 !important; /* Warna kuning saat hover */
  text-decoration: underline;
}

/* Gaya untuk pesan feedback invalid (dari Bootstrap) */
.invalid-feedback {
  color: #dc3545; /* Merah Bootstrap */
  font-size: 0.875em;
  margin-top: 0.25rem;
}

.is-invalid {
  border-color: #dc3545 !important; /* Border merah untuk input invalid */
}
</style>