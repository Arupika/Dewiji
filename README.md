# 🌄 Wisata Destinasi Yogyakarta

Website ini dibuat untuk memperkenalkan berbagai destinasi wisata populer dan menarik di *Daerah Istimewa Yogyakarta. Dibangun menggunakan teknologi modern seperti **HTML, **CSS, **Bootstrap, dan **Vue.js, website ini dirancang agar **responsif, **menarik secara visual, dan **mudah digunakan*.

-----

## ✨ Fitur Utama

  - Daftar destinasi wisata populer di Yogyakarta
  - Tampilan responsif menggunakan Bootstrap 5
  - Komponen Vue.js untuk manajemen data destinasi
  - Gambar dan deskripsi singkat untuk setiap lokasi wisata
  - Desain antarmuka yang bersih dan modern
  - *Backend API dengan Laravel*: Menyediakan data destinasi, rental mobil, dan paket liburan.

-----

## 🛠 Teknologi yang Digunakan

  - *Frontend*:
      - *HTML5*
      - *CSS3*
      - *Bootstrap 5*
      - *Vue.js 3* (menggunakan CDN, tanpa build tool)
  - *Backend*:
      - *Laravel 12*
      - *PHP*
      - *MySQL/PostgreSQL* (atau database lain yang didukung Laravel)

-----

## 📂 Struktur Proyek
.
├── backend/                  # Folder untuk aplikasi Laravel (backend)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── .env.example
│   ├── artisan
│   ├── composer.json
│   └── ... (file Laravel lainnya)
├── src/                      # Folder untuk aplikasi frontend Vue.js
│   ├── assets/
│   ├── components/
│   │   └── icons/
│   ├── layouts/
│   ├── router/
│   ├── views/
│   │   ├── CarRent.vue
│   │   ├── Destination.vue
│   │   ├── Faq.vue
│   │   ├── Home.vue
│   │   └── Package.vue
│   ├── App.vue
│   └── main.js
├── index.html                # File HTML utama frontend
├── style.css                 # File CSS global frontend
├── app.js                    # File JavaScript utama frontend (jika ada)
└── README.md

-----

## 🚀 Cara Menjalankan

Untuk menjalankan proyek ini, Anda perlu menyiapkan *backend Laravel* dan *frontend Vue.js* secara terpisah.

### 1\. Setup Backend (Laravel)

1.  *Masuk ke direktori backend:*

    bash
    cd backend
    

2.  *Instal dependensi Composer:*

    bash
    composer install
    

3.  *Salin file konfigurasi environment:*

    bash
    cp .env.example .env
    

4.  *Atur kunci aplikasi Laravel:*

    bash
    php artisan key:generate
    

5.  *Konfigurasi Database:*
    Buka file .env dan sesuaikan pengaturan database Anda (misalnya DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6.  *Jalankan migrasi database (dan seeder jika ada data dummy):*

    bash
    php artisan migrate
    # php artisan db:seed (jika Anda memiliki seeder)
    

7.  *Jalankan server pengembangan Laravel:*

    bash
    php artisan serve
    

    Backend API akan berjalan di http://127.0.0.1:8000 (atau port lain yang ditentukan).

### 2\. Setup Frontend (Vue.js)

1.  *Kembali ke direktori root proyek:*

    bash
    cd ..
    

2.  *Pastikan file-file frontend ada di direktori root:*
    Pastikan index.html, style.css, app.js (jika digunakan), dan folder src/ berada di direktori utama proyek Anda.

3.  **Buka file index.html di browser:**
    Cukup klik dua kali file index.html atau buka dengan browser Anda.

    > *Catatan*: Frontend Vue.js diatur untuk menggunakan CDN, sehingga tidak memerlukan instalasi npm atau server pengembangan Node.js terpisah untuk frontend. Namun, pastikan API backend Laravel Anda sudah berjalan agar data dapat dimuat.

-----

## 🗺 Sumber Referensi

Website ini terinspirasi dari blog [Yogyakarta Explore](https://www.yogyakartaexplore.com/blog) yang menyajikan informasi wisata di Jogja secara lengkap dan menarik.

-----

## 👨‍💻 Tim Pengembang

Website ini dikembangkan sebagai bagian dari tugas mata kuliah *Pemrograman Web* oleh tim mahasiswa/i:

  - *Irzha Fahrizaldy* - 23.11.5385
  - *Samuel Jari Hartako* - 23.11.5389
  - *Rayyis Hammam Mukhayyar* - 23.11.5405
  - *Ilham Bintang Saputra* - 23.11.5432
  - *Halimatussadiyah Lola Putri* - 23.11.5398
  - *Chintya Sheila Masterina* - 23.11.5404

-----

Terima kasih telah mengunjungi website kami.
*Semoga bermanfaat bagi para wisatawan yang ingin menjelajahi keindahan Yogyakarta\!*