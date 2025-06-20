<template>
  <!-- Register Section -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center">
        <h1 class="mb-4 fw-bold display-5">Registrasi Akun</h1>
        <p class="lead">Buat akun untuk mengakses semua fitur Dewiji</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body p-5">
            <form @submit.prevent="handleRegister">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Nama Lengkap</label>
                  <input type="text" class="form-control" v-model="registerData.nama" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" class="form-control" v-model="registerData.email" required />
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Nomor WhatsApp</label>
                  <input type="tel" class="form-control" v-model="registerData.phone" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Tanggal Lahir</label>
                  <input type="date" class="form-control" v-model="registerData.birthDate" required />
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Password</label>
                  <input type="password" class="form-control" v-model="registerData.password" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-bold">Konfirmasi Password</label>
                  <input type="password" class="form-control" v-model="registerData.confirmPassword" required />
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Alamat</label>
                <textarea class="form-control" rows="3" v-model="registerData.alamat" required></textarea>
              </div>

              <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" v-model="registerData.agreeTerms" required />
                <label class="form-check-label">Saya menyetujui syarat dan ketentuan yang berlaku</label>
              </div>

              <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-3">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
              </button>

              <div class="text-center mt-3">
                <p>Sudah punya akun?
                  <a href="#" @click.prevent="showLoginPage">Masuk disini</a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

axios.defaults.withCredentials = true; // Pastikan untuk mengirim cookie dengan setiap permintaan 
axios.defaults.withXSRFToken = true; // Pastikan untuk mengirim token CSRF jika diperlukan  
axios.defaults.baseURL = "http://localhost:8000"; // Ganti dengan URL API backend Anda
export default {
  data() {
    return {
      registerData: {
        name: '',           // Ini harusnya 'name' untuk nama lengkap, bukan 'nama'
        email: '',
        phone: '',
        birth_date: '',     // Ubah dari 'birthDate' menjadi 'birth_date' agar konsisten dengan backend
        password: '',
        confirmPassword: '',
        address: '',        // Ubah dari 'alamat' menjadi 'address' agar konsisten dengan backend
        agreeTerms: false
      }
    };
  },
  methods: {
    async handleRegister() {
      console.log("Mencoba melakukan registrasi...");
      try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");

        const response = await axios.post("http://localhost:8000/register", { // Fortify route untuk register adalah '/register'
          name: this.registerData.name,
          email: this.registerData.email,
          phone: this.registerData.phone,
          birth_date: this.registerData.birth_date, // Pastikan ini dikirim
          password: this.registerData.password,
          password_confirmation: this.registerData.confirmPassword, // Fortify expect 'password_confirmation'
          address: this.registerData.address // Pastikan ini dikirim
        });

        console.log("Registrasi berhasil:", response.data);
        alert("Registrasi berhasil!");
        // Mungkin redirect ke halaman login atau dashboard
        this.$router.push('/login'); // Contoh: redirect ke halaman login
      } catch (error) {
        console.error("Error saat registrasi:", error.response?.data || error.message);
        if (error.response && error.response.status === 422) {
          // Tangani error validasi dari Fortify
          const errors = error.response.data.errors;
          let errorMessage = "Registrasi gagal:\n";
          for (const key in errors) {
            errorMessage += `- ${errors[key].join(', ')}\n`;
          }
          alert(errorMessage);
        } else {
          alert("Terjadi kesalahan saat registrasi. Silakan coba lagi.");
        }
      }
    },
    showLoginPage() {
      this.$router.push('/login');
    }
  }
};
</script>


<style scoped>
/* Tambahan style opsional jika perlu */
</style>
