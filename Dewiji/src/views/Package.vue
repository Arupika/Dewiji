<template>
  <div class="container py-5">
    <h1 class="mb-4 text-center fw-bold">Paket Liburan</h1>
    <div class="row g-4">
      <div class="col-md-4" v-for="(trip, index) in trips" :key="index">
        <div class="card h-100 shadow-sm">
          <div class="card-img-top grid grid-cols-2 gap-1 p-2">
            <img v-for="(img, i) in trip.gambar" :key="i" :src="img" class="w-100 rounded" />
          </div>
          <div class="card-body">
            <h5 class="card-title fw-bold">Trip {{ index + 1 }}</h5>
            <ul>
              <li v-for="dest in trip.destinasi" :key="dest">✅ {{ dest }}</li>
            </ul>
            <hr />
            <div>
              <strong>Harga :</strong>
              <ul>
                <li v-for="(harga, tipe) in trip.harga" :key="tipe">
                  {{ tipe }}: <del>{{ harga.lama }}</del> <strong>{{ harga.diskon }}</strong>
                </li>
              </ul>
            </div>
            <div>
              <strong>Termasuk:</strong>
              <ul><li v-for="item in trip.termasuk" :key="item">{{ item }}</li></ul>
              <strong>Tidak Termasuk:</strong>
              <ul><li v-for="item in trip.tidakTermasuk" :key="item">{{ item }}</li></ul>
            </div>
          </div>
          <div class="card-footer text-center">
            <button class="btn btn-outline-success w-100">📱 BOOK NOW</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
data() {
    return {
    trips: [
        // Trip 1
        {
        destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
        gambar: ["https://fatek.umsu.ac.id/wp-content/uploads/2023/06/Candi-Borobudur-Makna-Yang-Terkandung-di-Dalamnya.jpg"],
        harga: {
            "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
        },
        termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
        tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
        },
        // Trip 2
        {
          destinasi: ["Jeep Lava Tour Merapi", "Bhumi Merapi", "Candi Prambanan", "Tebing Breksi"],
          gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit621414gsm/events/2021/11/08/6e05e1ed-f436-4ad2-8047-df0fddd7c4e6-1636341004194-3b67f1c7cfca7dbe27b13769c6c58816.jpg"],
          harga: {
            "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Parkir, Tiket masuk objek wisata", "Biaya makan supir & sewa jeep", "Pengeluaran pribadi"]
        },
        // Trip 3
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
        // Trip 4
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
        // Trip 5
        {
          destinasi: ["Kalibiru", "Waduk Sermo", "Kebun Teh Nglinggo"],
          gambar: ["https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2022/02/11/253e2394-2e8c-4ff1-84f6-697a173bfe36-1644582202846-5f8fdcb08b487a22c588a769d69fbd4e.jpg"],
          harga: {
            "Avanza & Xenia": { lama: "Rp 600.000", diskon: "Rp 550.000" },
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
            "Avanza & Xenia": { lama: "Rp 580.000", diskon: "Rp 530.000" },
            "Innova Reborn": { lama: "Rp 830.000", diskon: "Rp 780.000" },
            "Hiace 15 seat": { lama: "Rp 1.280.000", diskon: "Rp 1.230.000" }
          },
          termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
          tidakTermasuk: ["Tiket masuk", "Biaya makan", "Pengeluaran pribadi"]
        }
      ]
    };
  }
};
</script>

<style scoped>
.hero-section {
  background: linear-gradient(135deg, #00c896, #00cfff);
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>