<template>
    <div class="container py-5">
      <!-- Header -->
      <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center">
          <h1 class="mb-4 fw-bold">Pilih Paket Liburan</h1>
          <p>Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan.Tentunya kamu masih bisa custom paket wisata!</p>
      </div>
    </div>

      <!-- List Trip Cards -->
      <div class="row g-4">
        <div class="col-md-4" v-for="(trip, index) in trips" :key="index">
          <div class="card h-100 shadow-sm">
            <div class="card-img-top grid grid-cols-2 gap-1 p-2">
              <img
                v-for="(img, i) in trip.gambar"
                :key="i"
                :src="img"
                class="w-100 rounded"
                alt="gambar trip"
              />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-bold">Trip {{ index + 1 }}</h5>
              <ul>
                <li v-for="dest in trip.destinasi" :key="dest">✅ {{ dest }}</li>
              </ul>
              <hr />
              <div>
                <strong>Harga:</strong>
                <ul>
                  <li v-for="(harga, tipe) in trip.harga" :key="tipe">
                    {{ tipe }}: <del>{{ harga.lama }}</del> <strong>{{ harga.diskon }}</strong>
                  </li>
                </ul>
              </div>
              <div>
                <strong>Termasuk:</strong>
                <ul>
                  <li v-for="item in trip.termasuk" :key="item">{{ item }}</li>
                </ul>
                <strong>Tidak Termasuk:</strong>
                <ul>
                  <li v-for="item in trip.tidakTermasuk" :key="item">{{ item }}</li>
                </ul>
              </div>
            </div>
            <div class="card-footer text-center">
              <button class="btn btn-outline-success w-100">📱 Booking Sekarang</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- Footer -->
  <footer class="bg-dark text-light pt-5 mt-5">
    <div class="container">
      <div class="row">
        <!-- Tentang Kami -->
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold border-start border-4 ps-2">Tentang Kami</h5>
          <p>
            <strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman
            dengan harga yang cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan
            sekitarnya. </p>
        </div>

        <!-- Kontak Kami -->
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold border-start border-4 ps-2">Kontak Kami</h5>
          <p>Jl. Ngiringsi<br />Seleman, Yogyakarta<br />Yogyakarta 12345</p>
          <p>📞 081212344321</p>
          <p>✉️ yogyakartaDewiji@gmail.com</p>
        </div>

        <!-- Navigasi -->
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold border-start border-4 ps-2">Navigasi</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-light text-decoration-none">Destinasi</a></li>
            <li><a href="#" class="text-light text-decoration-none">Rental Mobil</a></li>
            <li><a href="#" class="text-light text-decoration-none">Paket Liburan</a></li>
            <li><a href="#" class="text-light text-decoration-none">Kritik & Saran</a></li>
          </ul>
        </div>

        <!-- Sosial Media -->
        <div class="col-md-3 mb-4">
          <h5 class="fw-bold border-start border-4 ps-2">Sosial Media</h5>
          <div class="d-flex gap-2">
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
              <i class="bi bi-tiktok"></i>
            </a>
            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
              <i class="bi bi-instagram"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  </template>

  <script>
  export default {
    data() {
      return {
        trips: [
          {
          destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
          gambar: [ "https://fatek.umsu.ac.id/wp-content/uploads/2023/06/Candi-Borobudur-Makna-Yang-Terkandung-di-Dalamnya.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["Jeep Lava Tour Merapi", "Bhumi Merapi", "Candi Prambanan", "Tebing Breksi"],
            gambar: [ "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit621414gsm/events/2021/11/08/6e05e1ed-f436-4ad2-8047-df0fddd7c4e6-1636341004194-3b67f1c7cfca7dbe27b13769c6c58816.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
            },
            {
              destinasi: ["Goa Pindul", "Sri Gethuk Waterfall", "Hutan Pinus Pengger", "Obelix Hills"],
              gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/original/events/2020/12/22/49a96f72-c387-4c50-bb85-02c381fc0195-1608638257347-9999a67ed9efb83861d0057a525f891c.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
              },
              termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
              tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya rafting", "Pengeluaran pribadi"]
            },
          {
            destinasi: ["Pantai Parangtritis", "Gumuk Pasir", "Hutan Mangrove"],
            gambar: ["https://cdn.paradisotour.co.id/wp-content/uploads/2024/07/Gumuk-Pasir-Parangkusumo.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 500.000", diskon: "Rp 450.000" },
              "Innova Reborn": { lama: "Rp 750.000", diskon: "Rp 700.000" },
              "Hiace 15 seat": { lama: "Rp 1.200.000", diskon: "Rp 1.150.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["Kalibiru", "Waduk Sermo", "Kebun Teh Nglinggo"],
            gambar: [
              "https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg"
            ],
            harga: {
              "Avanza & Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
              "Innova Reborn": { lama: "Rp 850.000", diskon: "Rp 800.000" },
              "Hiace 15 seat": { lama: "Rp 1.300.000", diskon: "Rp 1.250.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["Pantai Indrayanti", "Pantai Pok Tunggal", "Bukit Bintang"],
            gambar: [
              "https://enimekspres.bacakoran.co/upload/9c66d5431fab94d3935bfda47ca150cb.jpg"
            ],
            harga: {
              "Avanza & Xenia": { lama: "Rp 580.000", diskon: "Rp 530.000" },
              "Innova Reborn": { lama: "Rp 830.000", diskon: "Rp 780.000" },
              "Hiace 15 seat": { lama: "Rp 1.280.000", diskon: "Rp 1.230.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
          },
          //2#
          {
          destinasi: ["Bhumi Merapi", "Svargabumi", "Candi Borobudur", "Jeep Lava Tour Merapi"],
          gambar: [ "https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2023/07/28/Agrowisata-Bhumi-Merapi-702682784.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["Tebing Breksi", "Bhumi Merapi", "Candi Prambanan", "Jeep Lava Tour Merapi"],
            gambar: [ "https://www.yogyes.com/id/yogyakarta-tourism-object/other/tebing-breksi/1.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
          },
          {
              destinasi: ["Obelix Hills", "Sri Gethuk Waterfall", "Hutan Pinus Pengger", "Goa Pindul"],
              gambar: ["https://www.yogyes.com/id/yogyakarta-tourism-object/other/obelix-hills/1.jpg"],
            harga: {
              "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
              "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
              "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
              },
              termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
              tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya rafting", "Pengeluaran pribadi"]
          },
          {
              destinasi: ["Gereja Ayam", "Punthuk Setumbu", "Candi Borobudur", "Jeep Lava Tour Merapi"],
              gambar: ["https://asset-2.tstatic.net/travel/foto/bank/images/bukit-rhema-atau-gereja-ayam.jpg"],
              harga: {
              "Avanza & Xenia": { lama: "Rp 580.000", diskon: "Rp 530.000" },
              "Innova Reborn": { lama: "Rp 830.000", diskon: "Rp 780.000" },
              "Hiace 15 seat": { lama: "Rp 1.280.000", diskon: "Rp 1.230.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Sewa jeep", "Biaya makan", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["Watu Tapak", "Candi Ijo", "Tebing Breksi", "Obelix Hills"],
            gambar: ["https://cdn.idntimes.com/content-images/community/2024/01/img-4966-f5c2c8b7273debf19ff82eaf2fe8f775-02acc01c109eebed72eae1de13a29346.jpeg"],
            harga: {
            "Avanza & Xenia": { lama: "Rp 560.000", diskon: "Rp 510.000" },
            "Innova Reborn": { lama: "Rp 810.000", diskon: "Rp 760.000" },
            "Hiace 15 seat": { lama: "Rp 1.260.000", diskon: "Rp 1.210.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
          },
          {
            destinasi: ["HeHa Ocean View", "Cave Tubing Kalisuci", "Pantai Timang", "Goa Pindul"],
            gambar: ["https://cdn.rri.co.id/berita/Jakarta/o/1728296083732-1000514118/7o0fb3a7boyiwbc.jpeg"],
            harga: {
            "Avanza & Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
            "Innova Reborn": { lama: "Rp 850.000", diskon: "Rp 800.000" },
            "Hiace 15 seat": { lama: "Rp 1.300.000", diskon: "Rp 1.250.000" }
            },
            termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
            tidakTermasuk: ["Tiket masuk", "Biaya tubing & gondola", "Pengeluaran pribadi"]
        }
        ]
      };
    }
  };
  </script>

  <style scoped>
  .hero-section  {
  background:  linear-gradient(135deg, #00c896, #00cfff);
  min-height:  80vh;
  display:  flex;
  align-items:  center;
  justify-content:  center;
  }

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f5f7fa;
  color: #333;
}

h1, h5 {
  color: #00b894;
}

p {
  color: #555;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(135deg, #00c896, #00cfff);
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
}

/* Card Customization */
.card {
  border-radius: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
  background-color: #fff;
  border: none;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}

.card-img-top img {
  height: 200px;
  object-fit: cover;
  border-radius: 0.5rem;
}

.card-title {
  color: #2d3436;
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.card-body ul {
  padding-left: 1.25rem;
  list-style: none;
}

.card-body ul li::before {
  content: "\2714\0020"; /* Unicode checkmark */
  color: #00b894;
  font-weight: bold;
  display: inline-block;
  margin-right: 0.5rem;
}

.card-footer button {
  transition: all 0.3s ease;
  font-weight: bold;
  border-radius: 0.75rem;
  font-size: 1rem;
  padding: 0.6rem 1.25rem;
}

.card-footer button:hover {
  background-color: #00b894;
  color: white;
  transform: scale(1.02);
  box-shadow: 0 5px 10px rgba(0, 184, 148, 0.4);
}

/* Footer */
footer {
  background: #2d3436;
  color: white;
  padding-top: 3rem;
}

footer h5 {
  color: #00cec9;
  font-weight: bold;
  margin-bottom: 1rem;
}

footer p, footer ul li {
  color: #ccc;
  font-size: 0.95rem;
}

footer ul li a:hover {
  color: #00cec9;
  text-decoration: underline;
}

footer .btn-outline-light:hover {
  background-color: #00cec9;
  border-color: #00cec9;
}

/* Responsive tweaks */
@media (max-width: 768px) {
  .card-img-top img {
    height: 150px;
  }
}
</style>