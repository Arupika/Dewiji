import { createRouter, createWebHistory } from 'vue-router'

import Home       from '@/views/Home.vue'
import Destination  from '@/views/Destination.vue'
import CarRent    from '@/views/CarRent.vue'
import Package  from '@/views/Package.vue'

const routes = [
  { path: '/',          name: 'Home',    component: Home },
  { path: '/destination', name: 'Destinasi', component: Destination },
  { path: '/carrent',name: 'Rental Mobil', component: CarRent },
  { path: '/package', name: 'Paket Liburan', component: Package },
  
]

export default createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior: () => ({ top: 0 })
})
