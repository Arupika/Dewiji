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
export default {
  data() {
    return {
      registerData: {
        nama: '',
        email: '',
        phone: '',
        birthDate: '',
        password: '',
        confirmPassword: '',
        alamat: '',
        agreeTerms: false
      }
    };
  },
  methods: {
    handleRegister() {
      if (this.registerData.password !== this.registerData.confirmPassword) {
        alert('Password dan konfirmasi password tidak cocok.');
        return;
      }

      // Kirim data ke API (contoh)
      console.log('Data registrasi:', this.registerData);

      // Tambahkan logika penyimpanan / permintaan ke backend

      // Setelah berhasil register, arahkan ke login
      this.$router.push('/login');
    },
    showLoginPage() {
      // Ganti tampilan ke halaman login
      this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
/* Tambahan style opsional jika perlu */
</style>
