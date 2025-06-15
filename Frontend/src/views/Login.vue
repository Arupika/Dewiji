<template>
  <div v-if="showLogin">
    <!-- Login Section -->
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
                    <input type="email" class="form-control" v-model="loginForm.email" required />
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" v-model="loginForm.password" required />
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
  </div>
</template>

<script setup>
import { ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";

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

const handleLogin = async () => {
  try {
    const response = await axios.post("http://127.0.0.1:8000/api/login", {
      email: loginForm.value.email,
      password: loginForm.value.password,
    });

    Swal.fire({
      icon: "success",
      title: "Login berhasil",
      text: "Selamat datang kembali!",
      timer: 1500,
      showConfirmButton: false,
    });

    // Simpan token / redirect kalau mau
  } catch (error) {
    Swal.fire("Login Gagal", "Email atau password salah", "error");
  }
};

const handleRegister = async () => {
  if (registerData.value.password !== registerData.value.confirmPassword) {
    Swal.fire("Error", "Password dan konfirmasi tidak sama!", "error");
    return;
  }

  if (!registerData.value.agreeTerms) {
    Swal.fire("Error", "Anda harus menyetujui syarat dan ketentuan!", "error");
    return;
  }

  try {
    await axios.post("http://127.0.0.1:8000/api/register", {
      name: registerData.value.nama,
      email: registerData.value.email,
      password: registerData.value.password,
      phone: registerData.value.phone,
      birth_date: registerData.value.birthDate,
      address: registerData.value.alamat,
    });

    Swal.fire("Registrasi Berhasil!", "Silakan login.", "success");

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

    showLogin.value = true;
  } catch (error) {
    let message = "Terjadi kesalahan saat registrasi.";
    if (error.response && error.response.data.errors) {
      message = Object.values(error.response.data.errors).flat().join(', ');
    }
    Swal.fire("Gagal Registrasi", message, "error");
  }
};

const showRegister = () => {
  showLogin.value = false;
};

const showLoginPage = () => {
  showLogin.value = true;
};
</script>
