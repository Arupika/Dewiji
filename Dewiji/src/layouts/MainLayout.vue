<script setup>
import { RouterLink, RouterView } from 'vue-router'
const items = [
  { to: '/',          name: 'Home' },
  { to: '/destination', name: 'Destinasi' },
  { to: '/carrent',name: 'Rental Mobil' },
  { to: '/package', name: 'Paket Liburan' },
  { to: '/comment', name: 'Kritik & Saran' },
  { to: '/login', name: 'Login' },
]
</script>

<template>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark gradient-navbar sticky-top">
    <div class="container">
      <RouterLink class="navbar-brand" to="/">
        <img src="@/assets/Dewiji logo.png" alt="Dewiji Logo" style="height: 90px;" />
      </RouterLink>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li v-for="i in items.slice(0, -1)" :key="i.to" class="nav-item">
            <RouterLink class="nav-link" :to="i.to">{{ i.name }}</RouterLink>
          </li>
          <li class="nav-item auth-links">
            <div class="auth-container">
              <RouterLink class="auth-link login" :to="items[items.length-1].to">{{ items[items.length-1].name }}</RouterLink>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Transisi Halaman -->
  <transition name="fade-page" mode="out-in">
    <RouterView />
  </transition>

  <!-- Footer -->
  <footer class="gradient-footer text-center text-white py-3">
    <div>Copyright © 2025 Dewiji.</div>
    <div>All rights reserved || Created with ❤️ by Dewiji Team</div>
  </footer>
</template>

<style>
.fade-page-enter-active,
.fade-page-leave-active {
  transition: all 0.4s ease;
}
.fade-page-enter-from {
  opacity: 0; transform: translateY(20px);
}
.fade-page-leave-to {
  opacity: 0; transform: translateY(-20px);
}
.gradient-navbar {
  background: linear-gradient(135deg, #00c896, #00cfff);
}

.gradient-footer {
  background: linear-gradient(135deg, #00c896, #00cfff);
}

/* Aktifkan efek saat nav-link aktif */
.nav-link.router-link-exact-active {
  font-weight: bold;
  color: #ffe600 !important;
}
.gradient-navbar {
  background: linear-gradient(135deg, #00c896, #00cfff);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
.navbar-nav .nav-link {
  font-size: 1.1rem;
  font-weight: 500;
  padding-left: 1rem;
  padding-right: 1rem;
}
.navbar-nav .nav-link:hover {
  color: #ffe600 !important;
  text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
}

/* Tambahan styling untuk auth links */
.auth-links {
  margin-left: 1rem;
}

.auth-container {
  display: flex;
  background: rgba(255, 255, 255, 0.1);
  padding: 0.5rem;
  border-radius: 50px;
  backdrop-filter: blur(5px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.auth-link {
  padding: 0.5rem 1.5rem;
  border-radius: 50px;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.3s ease;
}

.auth-link.login {
  background: #ffe600;
  color: #006769;
}

.auth-link.login:hover {
  background: #ffd700;
  box-shadow: 0 0 10px rgba(255, 230, 0, 0.5);
}

.auth-link.router-link-exact-active {
  transform: scale(0.95);
  box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.2);
}
</style>