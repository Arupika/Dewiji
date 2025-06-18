// router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import Home        from '@/views/Home.vue'
import Destination from '@/views/Destination.vue'
import CarRent     from '@/views/CarRent.vue'
import Package     from '@/views/Package.vue'
import Comment     from '@/views/Faq.vue'
import Team        from '@/views/Tim.vue'
import Login       from '@/views/Auth/Login.vue'
import Register from '@/views/Auth/Register.vue'
import Dashboard from '@/views/Auth/Dashboard.vue'

const routes = [
  { path: '/',            name: 'Home',         component: Home },
  { path: '/destination', name: 'Destination',  component: Destination },
  { path: '/carrent',     name: 'CarRent',      component: CarRent },
  { path: '/package',     name: 'Package',      component: Package },
  { path: '/comment',     name: 'Comment',      component: Comment },
  { path: '/team',        name: 'Tim',          component: Team },
  { path: '/login',       name: 'Login',        component: Login },
  { path: '/register',    name: 'Register',     component: Register },
  { path: '/dashboard',   name: 'Dashboard',   component: Dashboard },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior: () => ({ top: 0 })
})

export default router
