<template>
  <div v-if="showLogin">
    <div class="login-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-body p-5">
                <h2 class="text-center mb-4">Login</h2>
                <form @submit.prevent="handleLogin">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      v-model="loginForm.email"
                      required
                    >
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="loginForm.password"
                      required
                    >
                  </div>
                  <button type="submit" class="btn btn-success w-100 mb-3">Login</button>
                  <div class="text-center">
                    <p>Belum punya akun? 
                      <a href="#" @click.prevent="showRegister">Daftar disini</a>
                    </p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else>
    <div class="container py-5">
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-8 text-center">
            <h1 class="mb-4 fw-bold display-5">Registrasi Akun</h1>
            <p class="lead">Buat akun untuk mengakses semua fitur Dewiji</p>
          </div>
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
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Nama Lengkap"
                      v-model="registerData.nama"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      placeholder="Email Anda"
                      v-model="registerData.email"
                      required
                    />
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor WhatsApp</label>
                    <input
                      type="tel"
                      class="form-control"
                      placeholder="0812xxxxxxx"
                      v-model="registerData.phone"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal Lahir</label>
                    <input
                      type="date"
                      class="form-control"
                      v-model="registerData.birthDate"
                      required
                    />
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      placeholder="Password"
                      v-model="registerData.password"
                      required
                    />
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Konfirmasi Password</label>
                    <input
                      type="password"
                      class="form-control"
                      placeholder="Ulangi Password"
                      v-model="registerData.confirmPassword"
                      required
                    />
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold">Alamat</label>
                  <textarea
                    class="form-control"
                    rows="3"
                    placeholder="Alamat Lengkap"
                    v-model="registerData.alamat"
                    required
                  ></textarea>
                </div>

                <div class="mb-4 form-check">
                  <input
                    type="checkbox"
                    class="form-check-input"
                    id="agreeTerms"
                    v-model="registerData.agreeTerms"
                    required
                  />
                  <label class="form-check-label" for="agreeTerms">
                    Saya menyetujui syarat dan ketentuan yang berlaku
                  </label>
                </div>

                <button
                  type="submit"
                  class="btn btn-success w-100 rounded-pill fw-bold py-3"
                >
                  <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </button>

                <div class="text-center mt-3">
                  <p>
                    Sudah punya akun?
                    <a href="#" @click.prevent="showLogin">Masuk disini</a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  setup() {
    const showLogin = ref(true);
    
    const loginForm = ref({
      email: '',
      password: ''
    });

    const registerData = ref({
      nama: "",
      email: "",
      phone: "",
      birthDate: "",
      password: "",
      confirmPassword: "",
      alamat: "",
      agreeTerms: false,
    });

    const handleLogin = () => {
      if (loginForm.value.email === 'user@example.com' && loginForm.value.password === 'password123') {
        Swal.fire({
          icon: 'success',
          title: 'Login Successful',
          text: 'Redirecting to dashboard...',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: 'Invalid email or password. Please try again.',
        });
      }
    };

    const handleRegister = () => {
      if (registerData.value.password !== registerData.value.confirmPassword) {
        Swal.fire(
          "Error",
          "Password dan konfirmasi password tidak sama!",
          "error"
        );
        return;
      }

      if (!registerData.value.agreeTerms) {
        Swal.fire("Error", "Anda harus menyetujui syarat dan ketentuan!", "error");
        return;
      }

      Swal.fire(
        "Registrasi Berhasil!",
        "Akun Anda telah berhasil dibuat. Silakan login.",
        "success"
      );

      // Reset form and show login
      registerData.value = {
        nama: "",
        email: "",
        phone: "",
        birthDate: "",
        password: "",
        confirmPassword: "",
        alamat: "",
        agreeTerms: false,
      };
      
      showLogin.value = true;
    };

    const showRegister = () => {
      showLogin.value = false;
    };

    return {
      showLogin,
      loginForm,
      registerData,
      handleLogin,
      handleRegister,
      showRegister
    };
  },
};
</script>

<style scoped>
.login-section {
  background-color: #f8f9fa;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.login-section .card,
.register-section .card {
  border-radius: 10px;
  border: none;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.login-section .card-body {
  padding: 2rem;
}

.login-section .form-label,
.register-section .form-label {
  font-weight: bold;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
  transition: all 0.3s ease;
}

.btn-success:hover {
  background-color: #218838;
  border-color: #1e7e34;
}

.display-5 {
  font-size: 2.5rem;
  color: #343a40;
}

.lead {
  font-size: 1.1rem;
  color: #6c757d;
}

.form-control,
.form-select {
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  border: 1px solid #ced4da;
}

.form-control:focus,
.form-select:focus {
  border-color: #28a745;
  box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
}

.form-check-input:checked {
  background-color: #28a745;
  border-color: #28a745;
}

.text-center a {
  color: #28a745;
  text-decoration: none;
  font-weight: 500;
}

.text-center a:hover {
  text-decoration: underline;
}
</style>