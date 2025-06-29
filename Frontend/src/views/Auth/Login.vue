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

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000"; // Pastikan ini sesuai dengan BASE_URL API Laravel kamu

const router = useRouter();

const loginForm = ref({
  email: '',
  password: ''
});

const errors = ref({}); // Untuk menyimpan error validasi dari backend

const handleLogin = async () => {
  errors.value = {}; // Reset errors on each submit
  try {
    await axios.get('/sanctum/csrf-cookie');
    const response = await axios.post('/api/login', loginForm.value);
    
    // Simpan token dan user data
    localStorage.setItem('auth_token', response.data.access_token);
    // Asumsi backend mengirimkan 'user' object yang berisi 'role'
    localStorage.setItem('user_role', response.data.user.role); 
    
    Swal.fire({
      icon: 'success',
      title: 'Login Berhasil!',
      text: 'Anda berhasil masuk ke akun Dewiji Anda.',
      showConfirmButton: false,
      timer: 1500
    });

    // Redirect berdasarkan role
    if (response.data.user.role === 'admin') {
      router.push('/Admin/Dashboard'); // Path ke dashboard admin
    } else {
      router.push('/'); // Path ke halaman utama untuk user biasa (atau '/home')
    }
  } catch (error) {
    let errorMessage = 'Terjadi kesalahan saat login.';
    if (error.response?.status === 401) {
      errorMessage = 'Email atau password salah.';
      // Jika ada error validasi spesifik dari backend (misal: 'email' tidak valid)
      if (error.response.data.errors) {
        errors.value = error.response.data.errors;
      }
    } else if (error.response?.status === 422) { // Untuk error validasi Laravel
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
        return; // Hentikan eksekusi setelah menampilkan SweetAlert
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message;
    }
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal!',
      text: errorMessage
    });
  }
};

// Watcher untuk membersihkan error saat input berubah (opsional, tapi bagus untuk UX)
watch(loginForm.value, () => {
  errors.value = {};
}, { deep: true });

</script>

<style scoped>
.login-page {
  min-height: 100vh;
  background: url('@/assets/merapi.png') no-repeat center center/cover;
  font-family: 'Poppins', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
}

.login-card {
  width: 100%;
  max-width: 500px; /* Diperkecil sedikit karena form lebih sederhana */
  border-radius: 20px;
  background: rgba(15, 15, 30, 0.8);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  padding: 2rem;
}

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

.input-custom:focus {
  border-color: #ffc107;
  box-shadow: none;
  outline: none;
  background-color: transparent;
}

.form-label {
  font-weight: 500;
  font-size: 1rem;
  margin-bottom: 4px;
}

.btn-gradient {
  background: linear-gradient(to right, #ffa500, #ff6f61);
  color: white;
  border: none;
  transition: background 0.3s ease, transform 0.2s ease;
}

.btn-gradient:hover {
  background: linear-gradient(to right, #ff8c00, #ff4e42);
  transform: scale(1.02);
}

a.text-warning:hover {
  color: #ffc107 !important;
  text-decoration: underline;
}

/* Invalid feedback styling */
.invalid-feedback {
  color: #dc3545; /* Bootstrap red */
  font-size: 0.875em;
  margin-top: 0.25rem;
}

.is-invalid {
  border-color: #dc3545 !important;
}
</style>