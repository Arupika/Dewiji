<script setup>
import { RouterLink, RouterView, useRoute, useRouter } from 'vue-router'; // Impor useRoute dan useRouter
import { ref, onMounted, watch } from 'vue'; // Impor ref, onMounted, watch
import axios from 'axios'; // Impor axios
import Swal from 'sweetalert2'; // Impor SweetAlert2

// Konfigurasi axios secara global untuk Sanctum dan base URL
// PENTING: Lakukan ini hanya SEKALI di file global seperti main.js/main.ts atau di layout utama
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000"; // Pastikan ini sesuai dengan BASE_URL API Laravel kamu

const route = useRoute(); // Inisialisasi useRoute
const router = useRouter(); // Inisialisasi useRouter

const isLoggedIn = ref(false); // State untuk status login
const userRole = ref(null); // State untuk role user

// Daftar item navigasi
const navItems = [
  { to: '/', name: 'Home', showAlways: true },
  { to: '/destination', name: 'Destinasi', showAlways: true },
  { to: '/carrent', name: 'Rental Mobil', showAlways: true },
  { to: '/package', name: 'Paket Liburan', showAlways: true },
  { to: '/comment', name: 'FAQ', showAlways: true },
  { to: '/team', name: 'Tim', showAlways: true },
  // Login item akan diganti secara dinamis atau disembunyikan
  // { to: '/Auth/login', name: 'Login', showLoggedIn: false } // Ini dihapus dari daftar karena akan dinamis
];

// Fungsi untuk memeriksa status login dan role dari localStorage
const checkLoginStatus = () => {
  const token = localStorage.getItem('auth_token');
  const role = localStorage.getItem('user_role');
  if (token && role) {
    isLoggedIn.value = true;
    userRole.value = role;
  } else {
    isLoggedIn.value = false;
    userRole.value = null;
  }
};

// Axios Interceptor untuk melampirkan token di setiap request
axios.interceptors.request.use(config => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, error => {
  return Promise.reject(error);
});

// Axios Interceptor untuk menangani respons 401/403 (Opsional tapi direkomendasikan)
axios.interceptors.response.use(response => response, async error => {
  if (error.response && error.response.status === 401 && isLoggedIn.value) {
    // Jika token tidak valid atau kadaluarsa, lakukan logout otomatis
    Swal.fire({
      icon: 'warning',
      title: 'Sesi Habis',
      text: 'Sesi Anda telah berakhir atau token tidak valid. Silakan login kembali.',
      confirmButtonText: 'Login Sekarang'
    }).then(() => {
      handleLogout(true); // Panggil logout, true untuk skip notifikasi sukses logout
    });
  }
  return Promise.reject(error);
});


// Fungsi untuk logout
const handleLogout = async (silent = false) => {
  try {
    // Kirim request POST ke endpoint logout Laravel
    await axios.post('/api/logout'); 
    
    // Hapus token dan role dari localStorage di frontend
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_role');
    isLoggedIn.value = false; // Perbarui status login di UI
    userRole.value = null;

    if (!silent) { // Tampilkan SweetAlert jika tidak dalam mode silent (misal, dari interceptor)
      Swal.fire({
        icon: 'success',
        title: 'Logout Berhasil!',
        text: 'Anda telah berhasil keluar.',
        showConfirmButton: false,
        timer: 1500
      });
    }

    // Redirect ke halaman login
    router.push('/Auth/Login'); 
  } catch (error) {
    let errorMessage = 'Terjadi kesalahan saat logout. Mohon coba lagi.';
    if (error.response && error.response.data && error.response.data.message) {
      errorMessage = error.response.data.message;
    }
    
    // Meskipun ada error dari server, kita tetap menghapus token lokal
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_role');
    isLoggedIn.value = false;
    userRole.value = null;
    
    if (!silent) { // Tampilkan SweetAlert jika tidak dalam mode silent
      Swal.fire({
        icon: 'error',
        title: 'Logout Gagal!',
        text: errorMessage + '\nAnda telah keluar dari sesi lokal Anda.'
      });
    }

    // Tetap redirect ke halaman login
    router.push('/Auth/Login'); 
  }
};

// Cek status login saat komponen dimuat
onMounted(() => {
  checkLoginStatus();
});

// Cek status login setiap kali rute berubah (misal: setelah login/register)
watch(route, () => {
  checkLoginStatus();
});

// Fungsi bantuan untuk menavigasi ke dashboard admin
const goToAdminDashboard = () => {
  router.push('/admin/dashboard');
};
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark gradient-navbar sticky-top">
    <div class="container">
      <RouterLink class="navbar-brand" to="/">
        <img src="@/assets/Dewiji logo.png" alt="Dewiji Logo" style="height: 70px;" />
      </RouterLink>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li v-for="item in navItems" :key="item.to" class="nav-item">
            <RouterLink class="nav-link" :to="item.to">{{ item.name }}</RouterLink>
          </li>

          <li class="nav-item" v-if="isLoggedIn && userRole === 'admin'">
            <a class="nav-link" href="#" @click.prevent="goToAdminDashboard">Dashboard Admin</a>
          </li>

          <li class="nav-item auth-links">
            <div class="auth-container">
              <template v-if="!isLoggedIn">
                <RouterLink class="auth-link login" to="/Auth/Login">Login</RouterLink>
              </template>
              <template v-else>
                <button class="auth-link logout" @click="handleLogout">Logout</button>
              </template>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <transition name="fade-page" mode="out-in">
    <RouterView />
  </transition>

  <footer class="gradient-navbar text-center text-white py-3">
    <div>Copyright © 2025 Dewiji.</div>
    <div>All rights reserved || Created with ❤️ by Dewiji Team</div>
  </footer>
</template>

<style scoped>
/* Tambahan style untuk tombol logout agar mirip tombol login */
.auth-links .auth-container .logout {
  background: linear-gradient(to right, #dc3545, #b82c3b); /* Warna merah untuk logout */
  color: white;
  border: none;
  border-radius: 50px; /* Rounded pill */
  padding: 8px 20px;
  text-decoration: none;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
  display: inline-block; /* Agar padding dan margin bekerja */
  line-height: normal; /* Untuk posisi vertikal teks yang tepat */
}

.auth-links .auth-container .logout:hover {
  background: linear-gradient(to right, #c82333, #a72431);
  transform: scale(1.02);
}

.auth-links .auth-container .login {
  background: linear-gradient(to right, #ffc107, #ff9800); /* Ubah warna login agar sedikit berbeda */
  color: white;
  border: none;
  border-radius: 50px;
  padding: 8px 20px;
  text-decoration: none;
  font-weight: 600;
  display: inline-block;
  line-height: normal;
  transition: background 0.3s ease, transform 0.2s ease;
}

.auth-links .auth-container .login:hover {
  background: linear-gradient(to right, #e0a800, #e68a00);
  transform: scale(1.02);
}




.navbar-brand img {
  height: 70px;
}


/* Transisi Halaman */
.fade-page-enter-active,
.fade-page-leave-active {
  transition: opacity 0.5s ease;
}

.fade-page-enter-from,
.fade-page-leave-to {
  opacity: 0;
}
</style>