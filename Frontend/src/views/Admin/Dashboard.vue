<script setup>
// --- Impor Modul ---
import { ref, onMounted, watch } from 'vue'; // // Fungsi inti Vue untuk data reaktif, lifecycle, dan pengawasan.
import { useRouter } from 'vue-router'; // // Untuk navigasi antar halaman.
import api from '@/api'; // // Instance Axios untuk request ke API.
import Swal from 'sweetalert2'; // // Untuk menampilkan notifikasi pop-up yang interaktif.

// --- State (Data Reaktif) ---
const router = useRouter(); // // Mendapatkan instance router.
const activeTab = ref('user'); // // Menyimpan nama tab yang sedang aktif. Defaultnya 'user'. INI KUNCI UTAMA.
const dataList = ref([]); // // Menyimpan daftar data (user, mobil, dll) yang akan ditampilkan di tabel.
const pagination = ref({ current_page: 1, last_page: 1 }); // // Menyimpan informasi paginasi dari API.
const assetUrl = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'; // // URL dasar untuk aset gambar.

// // Objek untuk memetakan nama tab ke endpoint API-nya, agar kode lebih rapi dan dinamis.
const endpoints = {
  user: '/api/users',
  mobil: '/api/mobils',
  destinasi: '/api/destinasis',
  paket: '/api/pakets',
  faq: '/api/faqs'
};

// --- Fungsi-Fungsi ---
// // Fungsi keamanan untuk memvalidasi apakah pengguna adalah admin dan sudah login.
// Fungsi untuk melakukan validasi akses
const validateAdminAccess = () => {
  const token = localStorage.getItem('auth_token'); // // Ambil role dari penyimpanan lokal.
  const role = localStorage.getItem('user_role'); // // Ambil role dari penyimpanan lokal.

  // // Jika tidak ada token, paksa pengguna kembali ke halaman login.
  if (!token) {
    // Jika tidak ada token, berarti belum login
    Swal.fire({
      icon: 'error',
      title: 'Akses Ditolak!',
      text: 'Anda harus login untuk mengakses halaman ini.',
      confirmButtonText: 'Login'
    }).then(() => {
      router.push('/Auth/Login'); // Arahkan ke halaman login
    });
    return false; // // Hentikan eksekusi lebih lanjut.
  }

  // // Jika role bukan 'admin', paksa pengguna kembali ke halaman utama.
  if (role !== 'admin') {
    // Jika ada token tapi role bukan admin
    Swal.fire({
      icon: 'error',
      title: 'Akses Ditolak!',
      text: 'Anda tidak memiliki izin untuk mengakses halaman ini.',
      confirmButtonText: 'Kembali'
    }).then(() => {
      router.push('/'); // Arahkan ke halaman utama atau halaman lain
    });
    return false; // // Hentikan eksekusi lebih lanjut.
  }

  return true; // User adalah admin dan sudah login
};

// // Fungsi utama untuk mengambil data dari API berdasarkan tab yang aktif.
const fetchData = async (type, page = 1) => {
  // Hanya ambil data jika user memiliki akses admin
  if (!validateAdminAccess()) {
    return; // Berhenti eksekusi jika validasi gagal
  }

  try {
    const res = await api.get(`${endpoints[type]}?page=${page}`);
    dataList.value = res.data.data.data || [];
    pagination.value = {
      current_page: res.data.data.current_page,
      last_page: res.data.data.last_page
    };
  } catch (error) {
    // Menangani error dari API (misal 401/403 jika token expired di tengah sesi)
    if (error.response && error.response.status === 401) {
      Swal.fire({
        icon: 'warning',
        title: 'Sesi Habis',
        text: 'Sesi Anda telah berakhir. Silakan login kembali.',
        confirmButtonText: 'Login Sekarang'
      }).then(() => {
        // Hapus token lokal dan arahkan ke login
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_role');
        router.push('/Auth/Login');
      });
    } else if (error.response && error.response.status === 403) {
       Swal.fire({
        icon: 'error',
        title: 'Akses Ditolak!',
        text: 'Anda tidak memiliki izin untuk melakukan aksi ini.',
        confirmButtonText: 'Oke'
      });
    } else {
      console.error('Fetch error:', error);
      dataList.value = [];
      Swal.fire({
        icon: 'error',
        title: 'Gagal Memuat Data',
        text: 'Terjadi kesalahan saat memuat data. Mohon coba lagi.',
      });
    }
  }
};

const changePage = (page) => {
  fetchData(activeTab.value, page);
};

const deleteItem = async (id) => {
  if (!validateAdminAccess()) { // Pastikan akses admin sebelum delete
    return;
  }
  if (!confirm("Yakin ingin menghapus data ini?")) return;

  try {
    await api.delete(`${endpoints[activeTab.value]}/${id}`);
    Swal.fire({
      icon: 'success',
      title: 'Berhasil Dihapus!',
      text: 'Data berhasil dihapus.',
      showConfirmButton: false,
      timer: 1500
    });
    fetchData(activeTab.value, pagination.value.current_page);
  } catch (error) {
    if (error.response && error.response.status === 401) {
      Swal.fire({ icon: 'warning', title: 'Sesi Habis', text: 'Sesi Anda telah berakhir. Silakan login kembali.' }).then(() => {
        localStorage.removeItem('auth_token'); localStorage.removeItem('user_role'); router.push('/Auth/Login');
      });
    } else if (error.response && error.response.status === 403) {
       Swal.fire({ icon: 'error', title: 'Akses Ditolak!', text: 'Anda tidak memiliki izin untuk melakukan aksi ini.' });
    } else {
      console.error("Gagal hapus:", error);
      Swal.fire({ icon: 'error', title: 'Gagal Hapus', text: 'Terjadi kesalahan saat menghapus data.' });
    }
  }
};

// // Fungsi untuk mengarahkan ke halaman edit.
const handleEdit = (id) => {
  if (!validateAdminAccess()) { // // Cek akses sebelum edit.
    return;
  }
  router.push(`/Admin/${activeTab.value}/edit/${id}`);
};

// --- Pengawas dan Lifecycle ---
// // Mengawasi perubahan pada 'activeTab'. Setiap kali 'activeTab' berubah (karena user klik tab lain),
// // fungsi fetchData akan otomatis dipanggil dengan nama tab yang baru.
watch(activeTab, (val) => fetchData(val));

// // Dijalankan saat komponen pertama kali dimuat.
onMounted(() => {
  if (validateAdminAccess()) { // Panggil validasi saat komponen dimuat
    fetchData(activeTab.value);
  }
});
</script>

<template>
  <div class="container mt-5 mb-5">
    <Transition name="fade" appear>
      <div> 
        <h2 class="mb-4">Dashboard Data</h2>

        <ul class="nav nav-tabs mb-4">
          <li class="nav-item" v-for="tab in ['user', 'mobil', 'destinasi', 'paket', 'faq']" :key="tab">
            <button class="nav-link" :class="{ active: activeTab === tab }" @click="activeTab = tab">
              {{ tab.toUpperCase() }}
            </button>
          </li>
        </ul>

        <div class="card border-0 rounded shadow">
          <router-link :to="`/Admin/${activeTab}/create`" class="btn btn-success mb-3">
            Add New {{ activeTab.toUpperCase() }}
          </router-link>

          <div class="card-body table-responsive">
            <Transition name="fade" mode="out-in">
              <table class="table table-bordered" :key="activeTab"> 
                <thead class="bg-dark text-white">
                  <tr v-if="activeTab === 'user'">
                    <th>Foto</th>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-if="activeTab === 'mobil'">
                    <th>Foto</th>
                    <th>#</th>
                    <th>Nama Mobil</th>
                    <th>Harga</th>
                    <th>Termasuk</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-if="activeTab === 'destinasi'">
                    <th>Foto</th>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-if="activeTab === 'paket'">
                    <th>Gambar</th>
                    <th>#</th>
                    <th>Nama Liburan</th>
                    <th>Destinasi</th>
                    <th>Aksi</th>
                  </tr>
                  <tr v-if="activeTab === 'faq'">
                    <th>#</th>
                    <th>Judul</th>
                    <th>Jawaban</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <template v-if="dataList.length > 0">
                    <tr v-if="activeTab === 'user'" v-for="(item, i) in dataList" :key="item.id || i">
                      <td>
                        <img v-if="item.gambar" :src="item.gambar" alt="user"
                          style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
                      </td>
                      <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
                      <td>{{ item.name }}</td>
                      <td>{{ item.email }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
                      </td>
                    </tr>

                    <tr v-if="activeTab === 'mobil'" v-for="(item, i) in dataList" :key="item.id || i">
                      <td>
                        <img v-if="item.gambar" :src="item.gambar" alt="mobil"
                          style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
                      </td>
                      <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
                      <td>{{ item.nama }}</td>
                      <td>{{ item.harga }}</td>
                      <td>{{ item.termasuk?.join(', ') || '-' }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
                      </td>
                    </tr>

                    <tr v-if="activeTab === 'destinasi'" v-for="(item, i) in dataList" :key="item.id || i">
                      <td>
                        <img v-if="item.gambar" :src="item.gambar" alt="destinasi"
                          style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
                      </td>
                      <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
                      <td>{{ item.nama }}</td>
                      <td>{{ item.location }}</td>
                      <td>{{ item.deskripsi }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
                      </td>
                    </tr>

                    <tr v-if="activeTab === 'paket'" v-for="(item, i) in dataList" :key="item.id || i">
                      <td>
                        <img v-if="item.gambar" :src="item.gambar" alt="paket"
                          style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
                      </td>
                      <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
                       <td>{{ item.nama }}</td>
                      <td>{{ item.destinasi?.join(', ') || '-' }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
                      </td>
                    </tr>

                    <tr v-if="activeTab === 'faq'" v-for="(item, i) in dataList" :key="item.id || i">
                      <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
                      <td>{{ item.title }}</td>
                      <td>{{ item.answer }}</td>
                      <td>{{ item.category }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
                      </td>
                    </tr>
                  </template>
                  <tr v-else>
                      <td :colspan="activeTab === 'faq' ? 5 : 6" class="text-center text-muted py-4">Data tidak tersedia.</td>
                  </tr>
                </tbody>
              </table>
            </Transition>

            <nav v-if="pagination.last_page > 1">
              <ul class="pagination">
                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                  <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">Previous</a>
                </li>
                <li v-for="page in pagination.last_page" :key="page" class="page-item"
                  :class="{ active: page === pagination.current_page }">
                  <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                  <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div> 
    </Transition>
  </div>
</template>

<style scoped>
/* // Aturan untuk animasi fade saat elemen muncul/hilang. */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Animasi untuk transisi item dalam tabel (optional, but good practice) */
/* Karena ini adalah baris tabel (tr) yang di-v-for, kita bisa menggunakan TransitionGroup */
/* Namun, untuk tabel, TransitionGroup agak tricky karena posisi absolute.
   Untuk kasus ini, fade pada keseluruhan tabel lebih mudah dan efektif. */
/* Jika kamu ingin animasi per baris, akan butuh setup lebih kompleks di tbody. */
</style>