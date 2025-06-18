<template>
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
                  <input
                    type="email"
                    class="form-control"
                    v-model="loginForm.email"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control"
                    v-model="loginForm.password"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-success w-100 mb-3">
                  Login
                </button>
                <div class="text-center">
                  <p>Belum punya akun?
                    <a href="#" @click.prevent="goToRegister">Daftar disini</a>
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
export default {
  data() {
    return {
      loginForm: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    handleLogin() {
      // Lakukan permintaan ke backend
      console.log('Data login:', this.loginForm);
      // Tambahkan axios.post('/api/login', this.loginForm) jika sudah ada endpoint
    },
    goToRegister() {
      // Berpindah ke halaman register (misalnya via router atau emit ke parent)
      //this.$emit('show-register'); // gunakan ini kalau komponen dikelola oleh parent
      // atau jika pakai Vue Router:
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
/* Tambahkan style tambahan jika perlu */
</style>
