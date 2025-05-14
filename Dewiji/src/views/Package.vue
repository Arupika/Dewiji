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
            <strong>Harga:</strong>
            <ul>
                <li v-for="(harga, tipe) in trip.harga" :key="tipe">{{ tipe }}: <del>{{ harga.lama }}</del> <strong>{{ harga.diskon }}</strong></li>
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
            <button class="btn btn-outline-success w-100">
            📱 BOOK NOW
            </button>
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
        {
        destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
        gambar: [
            "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80"
        ],
        harga: {
            "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
        },
        termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
        tidakTermasuk: [
            "Parkir, Tiket masuk objek wisata",
            "Biaya makan supir & sewa jeep",
            "Pengeluaran pribadi"
        ]
        },
        {
        destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
        gambar: [
            "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80"
        ],
        harga: {
            "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
        },
        termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
        tidakTermasuk: [
            "Parkir, Tiket masuk objek wisata",
            "Biaya makan supir & sewa jeep",
            "Pengeluaran pribadi"
        ]
        },
        {
        destinasi: ["Candi Borobudur", "Svargabumi", "Bhumi Merapi", "Jeep Lava Tour Merapi"],
        gambar: [
            "https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80"
        ],
        harga: {
            "Avanza & Xenia": { lama: "Rp 550.000", diskon: "Rp 500.000" },
            "Innova Reborn": { lama: "Rp 800.000", diskon: "Rp 750.000" },
            "Hiace 15 seat": { lama: "Rp 1.250.000", diskon: "Rp 1.200.000" }
        },
        termasuk: ["Mobil + Supir + BBM", "Durasi 12 Jam"],
        tidakTermasuk: [
            "Parkir, Tiket masuk objek wisata",
            "Biaya makan supir & sewa jeep",
            "Pengeluaran pribadi"
        ]
        },
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