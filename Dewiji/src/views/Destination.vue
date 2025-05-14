<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Destinasi Yogyakarta</h1>
    <div class="row g-4">
      <div class="col-md-4" v-for="(destinasi, index) in destinations" :key="index">
        <div class="card h-100 shadow-sm">
          <img :src="destinasi.gambar" class="card-img-top" :alt="destinasi.nama" />
          <div class="card-body">
            <h5 class="card-title">{{ destinasi.nama }}</h5>
            <p class="card-text" :class="{ 'text-truncate': !destinasi.showFull }">{{ destinasi.deskripsi }}</p>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <button class="btn btn-success btn-sm" @click="toggleDescription(index)">
              {{ destinasi.showFull ? 'Sembunyikan' : 'Cek Selengkapnya' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
