// router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import Home           from '@/views/Home.vue'
import Destination    from '@/views/Destination.vue'
import CarRent        from '@/views/CarRent.vue'
import Package        from '@/views/Package.vue'
import Comment        from '@/views/Faq.vue'
import Team           from '@/views/Tim.vue'
import Login          from '@/views/Auth/Login.vue'
import Register       from '@/views/Auth/Register.vue'
import Dashboard      from '@/views/Admin/Dashboard.vue'

// Admin User
import CreateUser     from '@/views/Admin/user/create.vue'
import EditUser       from '@/views/Admin/user/edit.vue'

// Admin Paket
import CreatePaket    from '@/views/Admin/paket/create.vue'
import EditPaket      from '@/views/Admin/paket/edit.vue'

// Admin Mobil
import CreateMobil    from '@/views/Admin/mobil/create.vue'
import EditMobil      from '@/views/Admin/mobil/edit.vue'

// Admin FAQ
import CreateFaq      from '@/views/Admin/faq/create.vue'
import EditFaq        from '@/views/Admin/faq/edit.vue'

// Admin Destinasi
import CreateDestinasi from '@/views/Admin/destinasi/create.vue'
import EditDestinasi   from '@/views/Admin/destinasi/edit.vue'

const routes = [
  { path: '/',                 name: 'Home',             component: Home },
  { path: '/destination',      name: 'Destination',      component: Destination },
  { path: '/carrent',          name: 'CarRent',          component: CarRent },
  { path: '/package',          name: 'Package',          component: Package },
  { path: '/comment',          name: 'Comment',          component: Comment },
  { path: '/team',             name: 'Team',             component: Team },
  { path: '/Auth/login',            name: 'Login',            component: Login },
  { path: '/Auth/register',         name: 'Register',         component: Register },

  // Admin Routes
  { path: '/Admin/dashboard',       name: 'Dashboard',         component: Dashboard },
  { path: '/Admin/user/create',     name: 'User.Create',       component: CreateUser },
  { path: '/Admin/user/edit/:id',   name: 'User.Edit',         component: EditUser, props: true },

  { path: '/Admin/paket/create',    name: 'Paket.Create',      component: CreatePaket },
  { path: '/Admin/paket/edit/:id',  name: 'Paket.Edit',        component: EditPaket, props: true },

  { path: '/Admin/mobil/create',    name: 'Mobil.Create',      component: CreateMobil },
  { path: '/Admin/mobil/edit/:id',  name: 'Mobil.Edit',        component: EditMobil, props: true },

  { path: '/Admin/faq/create',      name: 'Faq.Create',        component: CreateFaq },
  { path: '/Admin/faq/edit/:id',    name: 'Faq.Edit',          component: EditFaq, props: true },

  { path: '/Admin/destinasi/create', name: 'Destinasi.Create', component: CreateDestinasi },
  { path: '/Admin/destinasi/edit/:id', name: 'Destinasi.Edit', component: EditDestinasi, props: true },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior: () => ({ top: 0 })
})

export default router
