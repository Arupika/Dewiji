<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Rental Mobil Yogyakarta</h1>

    <div class="row g-4">
      <div class="col-md-4" v-for="(mobil, index) in daftarMobil" :key="index">
        <div class="card h-100 shadow-sm">
          <img :src="mobil.gambar" class="card-img-top" :alt="mobil.nama" />
          <div class="card-body">
            <h5 class="card-title">{{ mobil.nama }}</h5>
            <p class="card-text">{{ mobil.deskripsi }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="fw-bold text-primary">Rp {{ mobil.harga.toLocaleString() }}/hari</span>
            <button class="btn btn-success btn-sm">Sewa Sekarang</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import avanza from '@/assets/avanza.png'
import xenia from '@/assets/xenia.png'
import innova from '@/assets/innova.png'
import brio from '@/assets/brio.png'
import ayla from '@/assets/calya.png'
import alphard from '@/assets/alphard.png'

const daftarMobil = [
  {
    nama: 'Toyota Avanza',
    deskripsi: 'Mobil keluarga nyaman untuk perjalanan wisata.',
    harga: 350000,
    gambar: avanza
  },
  {
    nama: 'Daihatsu Xenia',
    deskripsi: 'Irit dan cocok untuk wisata kota dan luar kota.',
    harga: 330000,
    gambar: xenia
  },
  {
    nama: 'Innova Reborn',
    deskripsi: 'Mobil premium dengan kenyamanan ekstra.',
    harga: 500000,
    gambar: innova
  },
  {
    nama: 'Honda Brio',
    deskripsi: 'Mobil kompak, irit bahan bakar, cocok untuk perjalanan kota.',
    harga: 300000,
    gambar: brio
  },
  {
    nama: 'Daihatsu Ayla',
    deskripsi: 'City car mungil dan ekonomis untuk aktivitas harian.',
    harga: 280000,
    gambar: ayla
  },
  {
    nama: 'Toyota Alphard',
    deskripsi: 'MPV mewah dengan fitur lengkap dan kenyamanan tinggi.',
    harga: 1200000,
    gambar: alphard
  }
]
</script>
