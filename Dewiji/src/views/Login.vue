<template>
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
                
                <!-- Tambahkan tombol Registerasi -->
                <RouterLink 
                  to="/registerasi" 
                  class="btn btn-outline-success w-100"
                >
                  Registerasi
                </RouterLink>
              </form>
              
              <!-- Atau alternatif teks link -->
              <div class="text-center mt-3">
                <p>
                  Belum punya akun? 
                  <RouterLink to="/registerasi" class="text-success">
                    Daftar disini
                  </RouterLink>
                </p>
              </div>
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
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();
    const loginForm = ref({
      email: '',
      password: ''
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

    return {
      loginForm,
      handleLogin,
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

.login-section .card {
  border-radius: 10px;
  border: none;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.login-section .card-body {
  padding: 2rem;
}

.login-section .form-label {
  font-weight: bold;
}

.login-section .btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.login-section .btn-success:hover {
  background-color: #218838;
  border-color: #1e7e34;
}

.login-section .btn-outline-success {
  color: #28a745;
  border-color: #28a745;
}

.login-section .btn-outline-success:hover {
  background-color: #28a745;
  color: white;
}

.text-success {
  color: #28a745 !important;
  text-decoration: none;
  font-weight: 500;
}

.text-success:hover {
  text-decoration: underline;
}
</style>