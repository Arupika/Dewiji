<template>
  <div>
    <!-- Main Content -->
    <div class="container py-5">
      <!-- Hero Section -->
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-md-8 text-center">
            <h1 class="mb-4 fw-bold display-5">Pilih Paket Liburan</h1>
            <p class="lead">Cari referensi wisata di Jogja? Kamu bisa langsung pilih paket yang sudah kami sediakan. Tentunya kamu masih bisa custom paket wisata!</p>
          </div>
        </div>
      </div>

      <!-- Trip Packages -->
      <div class="row g-4">
        <div class="col-md-4" v-for="(trip, index) in trips" :key="index">
          <div class="card h-100 shadow-sm">
            <div class="card-img-top">
              <img :src="trip.gambar[0]" class="w-100 rounded-top" style="height: 200px; object-fit: cover;" />
            </div>
            <div class="card-body">
              <h5 class="card-title fw-bold">Paket {{ index + 1 }}</h5>
              <div class="mb-3">
                <span class="badge bg-success bg-opacity-10 text-success me-2" v-for="(dest, i) in trip.destinasi.slice(0, 2)" :key="i">
                  {{ dest.split(',')[0] }}
                </span>
                <span v-if="trip.destinasi.length > 2" class="badge bg-secondary bg-opacity-10 text-secondary">
                  +{{ trip.destinasi.length - 2 }} lainnya
                </span>
              </div>
              <div class="mb-3">
                <h6 class="fw-bold mb-2">Harga:</h6>
                <div v-for="(harga, tipe) in trip.harga" :key="tipe" class="d-flex justify-content-between mb-1">
                  <span>{{ tipe }}:</span>
                  <span>
                    <del class="text-muted small me-2">{{ harga.lama }}</del>
                    <strong class="text-success">{{ harga.diskon }}</strong>
                  </span>
                </div>
              </div>
              <hr />
              <div class="mb-3">
                <h6 class="fw-bold mb-2">Termasuk:</h6>
                <ul class="list-unstyled small">
                  <li v-for="item in trip.termasuk" :key="item" class="mb-1">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ item }}
                  </li>
                </ul>
              </div>
              <div>
                <h6 class="fw-bold mb-2">Tidak Termasuk:</h6>
                <ul class="list-unstyled small">
                  <li v-for="item in trip.tidakTermasuk" :key="item" class="mb-1">
                    <i class="bi bi-x-circle-fill text-danger me-2"></i>{{ item }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-footer bg-white border-top-0 text-center pt-0">
              <button 
                class="btn btn-success w-100 rounded-pill fw-bold"
                @click="showBookingModal(trip, index)"
              >
                <i class="bi bi-whatsapp me-2"></i>Booking Sekarang
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Booking Modal -->
    <div v-if="selectedPackage" class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5)" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3">
          <div class="modal-header border-0">
            <h5 class="modal-title fw-bold">Paket {{ selectedPackageIndex + 1 }}</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <img :src="selectedPackage.gambar[0]" class="img-fluid rounded" style="max-height: 200px" />
            </div>
            
            <div class="mb-4">
              <h6 class="fw-bold border-bottom pb-2">Detail Destinasi</h6>
              <ul class="list-unstyled">
                <li v-for="(dest, i) in selectedPackage.destinasi" :key="i" class="mb-1">
                  <i class="bi bi-geo-alt text-success me-2"></i>{{ dest }}
                </li>
              </ul>
            </div>
            
            <div class="mb-4">
              <h6 class="fw-bold border-bottom pb-2">Harga Paket</h6>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Tipe Mobil</th>
                      <th class="text-end">Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(harga, tipe) in selectedPackage.harga" :key="tipe">
                      <td>{{ tipe }}</td>
                      <td class="text-end">{{ harga.diskon }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
            <form @submit.prevent="submitBooking">
              <div class="mb-3">
                <label class="form-label fw-bold">Tipe Mobil</label>
                <select class="form-select" v-model="bookingData.tipeMobil" required>
                  <option v-for="(harga, tipe) in selectedPackage.harga" :key="tipe" :value="tipe">
                    {{ tipe }} - {{ harga.diskon }}
                  </option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Tour</label>
                <input type="date" class="form-control" v-model="bookingData.tanggal" required />
              </div>
              
              <div class="mb-3">
                <label class="form-label fw-bold">Jumlah Orang</label>
                <input type="number" class="form-control" v-model="bookingData.jumlahOrang" min="1" required />
              </div>
              
              <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" v-model="bookingData.nama" required />
              </div>
              
              <div class="mb-3">
                <label class="form-label fw-bold">Nomor WhatsApp</label>
                <input type="tel" class="form-control" v-model="bookingData.whatsapp" required />
              </div>
              
              <div class="mb-3">
                <label class="form-label fw-bold">Catatan Tambahan</label>
                <textarea class="form-control" v-model="bookingData.catatan" rows="2"></textarea>
              </div>
              
              <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2">
                <i class="bi bi-whatsapp me-2"></i>Konfirmasi Pemesanan
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-light pt-5 pb-4">
      <div class="container">
        <div class="row g-4">
          <!-- Tentang Kami -->
          <div class="col-lg-3 col-md-6">
            <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Tentang Kami</h5>
            <p class="small"><strong>Dewiji Explore</strong> menyediakan sewa mobil berkualitas, aman, dan nyaman dengan harga yang cukup terjangkau serta menyediakan paket-paket wisata di Jogja dan sekitarnya.</p>
          </div>
        
          <!-- Kontak Kami -->
          <div class="col-lg-3 col-md-6">
            <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Kontak Kami</h5>
            <ul class="list-unstyled small">
              <li class="mb-2">
                <i class="bi bi-geo-alt-fill text-success me-2"></i>
                Jl. Ngiringsi, Sleman, Yogyakarta 12345
              </li>
              <li class="mb-2">
                <i class="bi bi-telephone-fill text-success me-2"></i>
                081212344321
              </li>
              <li class="mb-2">
                <i class="bi bi-envelope-fill text-success me-2"></i>
                yogyakartaDewiji@gmail.com
              </li>
            </ul>
          </div>
        
          <!-- Navigasi -->
          <div class="col-lg-3 col-md-6">
            <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Navigasi</h5>
            <ul class="list-unstyled small">
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Home</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">destinasi</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Rental Mobil</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Paket Liburan</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-success">Kritik & Saran</a></li>
            </ul>
          </div>
        
          <!-- Sosial Media -->
          <div class="col-lg-3 col-md-6">
            <h5 class="fw-bold border-start border-success border-4 ps-3 mb-3">Sosial Media</h5>
            <p class="small">Ikuti kami di media sosial untuk mendapatkan penawaran terbaik!</p>
            <div class="d-flex gap-3">
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
                <i class="bi bi-tiktok"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle hover-success">
                <i class="bi bi-whatsapp"></i>
              </a>
            </div>
          </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center small text-muted">
          &copy; 2023 Dewiji Explore. All Rights Reserved.
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
  data() {
    return {
      selectedPackage: null,
      selectedPackageIndex: null,
      bookingData: {
        tipeMobil: '',
        tanggal: '',
        jumlahOrang: 1,
        nama: '',
        whatsapp: '',
        catatan: ''
      },
      trips: [
        // Trip 1
        {
          destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
          gambar: ["https://fatek.umsu.ac.id/wp-content/uploads/2023/06/Candi-Borobudur-Makna-Yang-Terkandung-di-Dalamnya.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Parkir & Tiket masuk", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
        },
        // Trip 2
        {
          destinasi: ["Jeep Lava Tour Merapi", "Bhumi Merapi", "Candi Prambanan", "Tebing Breksi"],
          gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit621414gsm/events/2021/11/08/6e05e1ed-f436-4ad2-8047-df0fddd7c4e6-1636341004194-3b67f1c7cfca7dbe27b13769c6c58816.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Parkir & Tiket masuk", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
        },
        // Trip 3
        {
          destinasi: ["Goa Pindul", "Sri Gethuk Waterfall", "Hutan Pinus Pengger", "Obelix Hills"],
          gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/original/events/2020/12/22/49a96f72-c387-4c50-bb85-02c381fc0195-1608638257347-9999a67ed9efb83861d0057a525f891c.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Parkir & Tiket masuk", "Biaya rafting", "Pengeluaran pribadi"]
        },
        // Trip 4
        {
          destinasi: ["Pantai Parangtritis", "Gumuk Pasir", "Hutan Mangrove"],
          gambar: ["https://cdn.paradisotour.co.id/wp-content/uploads/2024/07/Gumuk-Pasir-Parangkusumo.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 500.000", diskon: "Rp 450.000" },
            "Innova Reborn": { lama: "Rp 750.000", diskon: "Rp 700.000" },
            "Hiace 15 seat": { lama: "Rp 1.200.000", diskon: "Rp 1.150.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 5
        {
          destinasi: ["Kalibiru", "Waduk Sermo", "Kebun Teh Nglinggo"],
          gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
            "Innova Reborn": { lama: "Rp 850.000", diskon: "Rp 800.000" },
            "Hiace 15 seat": { lama: "Rp 1.300.000", diskon: "Rp 1.250.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 6
        {
          destinasi: ["Pantai Indrayanti", "Pantai Pok Tunggal", "Bukit Bintang"],
          gambar: ["https://enimekspres.bacakoran.co/upload/9c66d5431fab94d3935bfda47ca150cb.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 580.000", diskon: "Rp 530.000" },
            "Innova Reborn": { lama: "Rp 830.000", diskon: "Rp 780.000" },
            "Hiace 15 seat": { lama: "Rp 1.280.000", diskon: "Rp 1.230.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 7
        {
          destinasi: ["Keraton Yogyakarta", "Taman Sari", "Malioboro"],
          gambar: ["https://assets-a1.kompasiana.com/items/album/2023/09/15/keraton-yogyakarta-650405b908a8b526932b67e2.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 520.000", diskon: "Rp 480.000" },
            "Innova Reborn": { lama: "Rp 770.000", diskon: "Rp 720.000" },
            "Hiace 15 seat": { lama: "Rp 1.200.000", diskon: "Rp 1.150.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 8
        {
          destinasi: ["Taman Pintar", "Gembira Loka Zoo", "Kids Fun Park"],
          gambar: ["https://www.1001malam.com/travel/wp-content/uploads/2016/08/Taman-Pintar-Sumbre-afiaanwas-blogspotcom.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 580.000", diskon: "Rp 530.000" },
            "Innova Reborn": { lama: "Rp 830.000", diskon: "Rp 780.000" },
            "Hiace 15 seat": { lama: "Rp 1.280.000", diskon: "Rp 1.230.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 9
        {
          destinasi: ["Goa Jomblang", "Goa Grubug", "Air Terjun Sri Gethuk"],
          gambar: ["https://www.goa-jomblang.com/wp-content/uploads/2015/12/slider3.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 650.000", diskon: "Rp 600.000" },
            "Innova Reborn": { lama: "Rp 900.000", diskon: "Rp 850.000" },
            "Hiace 15 seat": { lama: "Rp 1.360.000", diskon: "Rp 1.310.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 10
        {
          destinasi: ["Pantai Drini", "Pantai Krakal", "Pantai Slili"],
          gambar: ["https://desabanjarejo.gunungkidulkab.go.id/assets/files/artikel/sedang_1709553342Pantai-Drini-Yogyakarta.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
            "Innova Reborn": { lama: "Rp 850.000", diskon: "Rp 800.000" },
            "Hiace 15 seat": { lama: "Rp 1.300.000", diskon: "Rp 1.250.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 11
        {
          destinasi: ["Masjid Gedhe Kauman", "Museum Sonobudoyo", "Kotagede Heritage"],
          gambar: ["https://campatour.com/wp-content/uploads/2019/11/Masjid-Gedhe-Kauman.jpg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 530.000", diskon: "Rp 480.000" },
            "Innova Reborn": { lama: "Rp 780.000", diskon: "Rp 730.000" },
            "Hiace 15 seat": { lama: "Rp 1.220.000", diskon: "Rp 1.170.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 12
        {
          destinasi: ["Kalibiru Zipline", "Puncak Suroloyo", "Ekowisata Tinalah"],
          gambar: ["https://balistarisland.com/wp-content/uploads/2024/03/kalibiru-800x600.webp"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 620.000", diskon: "Rp 570.000" },
            "Innova Reborn": { lama: "Rp 870.000", diskon: "Rp 820.000" },
            "Hiace 15 seat": { lama: "Rp 1.320.000", diskon: "Rp 1.270.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 13
        {
          destinasi: ["Candi Ijo", "Candi Plaosan", "Museum Affandi"],
          gambar: ["https://atourin.obs.ap-southeast-3.myhuaweicloud.com/images/destination/sleman/candi-ijo-profile1697015604.jpeg?x-image-process=image/resize,p_100,limit_1/imageslim"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 570.000", diskon: "Rp 520.000" },
            "Innova Reborn": { lama: "Rp 820.000", diskon: "Rp 770.000" },
            "Hiace 15 seat": { lama: "Rp 1.270.000", diskon: "Rp 1.220.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 14
        {
          destinasi: ["Air Terjun Kedung Pedut", "Ekowisata Kalibiru", "Taman Sungai Mudal"],
          gambar: ["https://bob.kemenparekraf.go.id/wp-content/uploads/2024/05/Kabupaten-Kulonprogo-85.-Air-Terjun-Kedung-Pedut.png"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 640.000", diskon: "Rp 590.000" },
            "Innova Reborn": { lama: "Rp 890.000", diskon: "Rp 840.000" },
            "Hiace 15 seat": { lama: "Rp 1.360.000", diskon: "Rp 1.310.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        },
        // Trip 15
        {
          destinasi: ["Studio Alam Gamplong", "Desa Batik Giriloyo", "Desa Wisata Kasongan"],
          gambar: ["https://www.bakpiamutiarajogja.com/wp-content/uploads/2023/05/Studio-Alam-Gamplong-Jogja.jpeg"],
          harga: {
            "Avanza/Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
            "Innova Reborn": { lama: "Rp 850.000", diskon: "Rp 800.000" },
            "Hiace 15 seat": { lama: "Rp 1.300.000", diskon: "Rp 1.250.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        }
      ]
    }
  },
  methods: {
    showBookingModal(trip, index) {
      this.selectedPackage = trip
      this.selectedPackageIndex = index
      
      // Set default values
      const tomorrow = new Date()
      tomorrow.setDate(tomorrow.getDate() + 1)
      this.bookingData.tanggal = tomorrow.toISOString().split('T')[0]
      
      // Set first car type as default
      const carTypes = Object.keys(trip.harga)
      if (carTypes.length > 0) {
        this.bookingData.tipeMobil = carTypes[0]
      }
    },
    closeModal() {
      this.selectedPackage = null
      this.selectedPackageIndex = null
      this.resetForm()
    },
    resetForm() {
      this.bookingData = {
        tipeMobil: '',
        tanggal: '',
        jumlahOrang: 1,
        nama: '',
        whatsapp: '',
        catatan: ''
      }
    },
    submitBooking() {
      // Get selected price
      const selectedPrice = this.selectedPackage.harga[this.bookingData.tipeMobil].diskon
      
      // Show success message
      Swal.fire({
        title: 'Pemesanan Berhasil!',
        html: `
          <div class="text-start">
            <p><strong>Paket:</strong> ${this.selectedPackageIndex + 1}</p>
            <p><strong>Tipe Mobil:</strong> ${this.bookingData.tipeMobil} (${selectedPrice})</p>
            <p><strong>Tanggal:</strong> ${this.bookingData.tanggal}</p>
            <p><strong>Jumlah Orang:</strong> ${this.bookingData.jumlahOrang}</p>
            <p><strong>Nama:</strong> ${this.bookingData.nama}</p>
            <p><strong>WhatsApp:</strong> ${this.bookingData.whatsapp}</p>
            ${this.bookingData.catatan ? `<p><strong>Catatan:</strong> ${this.bookingData.catatan}</p>` : ''}
          </div>
        `,
        icon: 'success',
        confirmButtonText: 'Tutup',
        customClass: {
          popup: 'rounded-3'
        }
      })

      // In a real app, you would send this data to your backend or WhatsApp API
      this.sendWhatsAppMessage()
      
      // Close modal and reset form
      this.closeModal()
    },
    sendWhatsAppMessage() {
      // Format WhatsApp message
      const packageNumber = this.selectedPackageIndex + 1
      const destinasi = this.selectedPackage.destinasi.join(', ')
      const price = this.selectedPackage.harga[this.bookingData.tipeMobil].diskon
      
      const message = `Halo Dewiji Explore, saya ingin memesan:
      
📌 *Paket ${packageNumber}* 
📍 Destinasi: ${destinasi}
🚗 Tipe Mobil: ${this.bookingData.tipeMobil}
💰 Harga: ${price}
📅 Tanggal: ${this.bookingData.tanggal}
👥 Jumlah Orang: ${this.bookingData.jumlahOrang}
👤 Nama: ${this.bookingData.nama}
📱 WhatsApp: ${this.bookingData.whatsapp}
${this.bookingData.catatan ? `✏️ Catatan: ${this.bookingData.catatan}` : ''}

Mohon info lebih lanjut untuk proses pemesanan. Terima kasih.`

      // Encode message for WhatsApp URL
      const encodedMessage = encodeURIComponent(message)
      
      // Open WhatsApp with pre-filled message
      window.open(`https://wa.me/6281212344321?text=${encodedMessage}`, '_blank')
    }
  }
}
</script>

<style scoped>
.hover-success:hover {
  color: #198754 !important;
  border-color: #198754 !important;
}

.card {
  border-radius: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
  border: none;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
}

.card-img-top {
  overflow: hidden;
}

.card-img-top img {
  transition: transform 0.5s ease;
}

.card:hover .card-img-top img {
  transform: scale(1.05);
}

.btn-success {
  transition: all 0.3s ease;
  padding: 0.5rem 1rem;
}

.btn-success:hover {
  background-color: #157347;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
}

.border-success {
  border-color: #198754 !important;
}

.modal-content {
  border: none;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .display-5 {
    font-size: 2rem;
  }
  
  .lead {
    font-size: 1rem;
  }
}
</style>