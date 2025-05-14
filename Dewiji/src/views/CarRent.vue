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
    deskripsi: 'Mobil keluarga nyaman dalam perjalanan wisata.',
    harga: 250000,
    gambar: avanza
  },
  {
    nama: 'Daihatsu Xenia',
    deskripsi: 'Irit dan sederhana untuk wisata di kota dan luar kota.',
    harga: 350000,
    gambar: xenia
  },
  {
    nama: 'Innova Reborn',
    deskripsi: 'Mobil premium dan Mewah dengan kenyamanan ekstra.',
    harga: 400000,
    gambar: innova
  },
  {
    nama: 'Honda Brio',
    deskripsi: 'Mobil irit bahan bakar, cocok untuk perjalanan di dalam kota.',
    harga: 200000,
    gambar: brio
  },
  {
    nama: 'Daihatsu Ayla',
    deskripsi: 'City car irit dan ekonomis untuk aktivitas harian di kota.',
    harga: 250000,
    gambar: ayla
  },
  {
    nama: 'Toyota Alphard',
    deskripsi: 'MPV mewah dengan fitur yang lengkap dan kenyamanan tinggi.',
    harga: 1500000,
    gambar: alphard
  }
]
</script>
