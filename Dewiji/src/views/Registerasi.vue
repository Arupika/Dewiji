<template>
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
                  <a href="#" @click.prevent="switchToLogin">Masuk disini</a>
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
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  setup() {
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

      // Simulate successful registration
      Swal.fire(
        "Registrasi Berhasil!",
        "Akun Anda telah berhasil dibuat. Silakan login.",
        "success"
      );

      // Reset form
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
    };

    const switchToLogin = () => {
      // Function to navigate to the login page
      console.log("Switch to login");
      // In a real application, you would use Vue Router here:
      // router.push('/login');
    };

    return {
      registerData,
      handleRegister,
      switchToLogin,
    };
  },
};
</script>

<style scoped>
.display-5 {
  font-size: 2.5rem;
  color: #343a40;
}

.lead {
  font-size: 1.1rem;
  color: #6c757d;
}

.card {
  border: none;
  border-radius: 0.5rem;
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

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
  transition: all 0.3s ease;
}

.btn-success:hover {
  background-color: #218838;
  border-color: #1e7e34;
  transform: translateY(-2px);
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