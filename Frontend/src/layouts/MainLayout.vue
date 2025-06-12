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
  <footer class="gradient-navbar text-center text-white py-3">
    <div>Copyright © 2025 Dewiji.</div>
    <div>All rights reserved || Created with ❤️ by Dewiji Team</div>
  </footer>
</template>
