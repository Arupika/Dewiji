<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api'

const router = useRouter()
const activeTab = ref('user')
const dataList = ref([])
const pagination = ref({ current_page: 1, last_page: 1 })
const assetUrl = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'

const endpoints = {
  user: '/api/users',
  mobil: '/api/mobils',
  destinasi: '/api/destinasis',
  paket: '/api/pakets',
  faq: '/api/faqs'
}

const fetchData = async (type, page = 1) => {
  try {
    const res = await api.get(`${endpoints[type]}?page=${page}`)
    dataList.value = res.data.data.data || []
    pagination.value = {
      current_page: res.data.data.current_page,
      last_page: res.data.data.last_page
    }
  } catch (error) {
    console.error(error)
    dataList.value = []
  }
}

const changePage = (page) => {
  fetchData(activeTab.value, page)
}

const deleteItem = async (id) => {
  if (!confirm("Yakin ingin menghapus data ini?")) return

  try {
    await api.delete(`${endpoints[activeTab.value]}/${id}`)
    fetchData(activeTab.value, pagination.value.current_page)
  } catch (error) {
    console.error("Gagal hapus:", error)
    alert("Terjadi kesalahan saat menghapus data.")
  }
}

const handleEdit = (id) => {
  router.push(`/Admin/${activeTab.value}/edit/${id}`)
}

watch(activeTab, (val) => fetchData(val))
onMounted(() => fetchData(activeTab.value))
</script>

<template>
  <div class="container mt-5 mb-5">
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
        <table class="table table-bordered">
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
              <th>Nama</th>
              <th>Harga</th>
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
            <!-- USER -->
            <tr v-if="activeTab === 'user'" v-for="(item, i) in dataList" :key="i">
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

            <!-- MOBIL -->
            <tr v-if="activeTab === 'mobil'" v-for="(item, i) in dataList" :key="i">
              <td>
                <img v-if="item.gambar" :src="item.gambar" alt="mobil"
                  style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
              </td>
              <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
              <td>{{ item.nama }}</td>
              <td>{{ item.harga }}</td>
              <td>{{ item.termasuk }}</td>
              <td>
                <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
              </td>
            </tr>

            <!-- DESTINASI -->
            <tr v-if="activeTab === 'destinasi'" v-for="(item, i) in dataList" :key="i">
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

            <!-- PAKET -->
            <tr v-if="activeTab === 'paket'" v-for="(item, i) in dataList" :key="i">
              <td>
                <img v-if="item.gambar" :src="item.gambar" alt="paket"
                  style="width: 180px; height: 120px; object-fit: cover; border-radius: 10px;" />
              </td>
              <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
              <td>{{ item.destinasi?.join(', ') || '-' }}</td>
              <td>{{ item.harga?.join(', ') || '-' }}</td>
              <td>
                <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
              </td>
            </tr>

            <!-- FAQ -->
            <tr v-if="activeTab === 'faq'" v-for="(item, i) in dataList" :key="i">
              <td>#{{ (pagination.current_page - 1) * 5 + i + 1 }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.answer }}</td>
              <td>{{ item.category }}</td>
              <td>
                <button class="btn btn-sm btn-primary me-1" @click="handleEdit(item.id)">Edit</button>
                <button class="btn btn-sm btn-danger" @click="deleteItem(item.id)">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>

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
</template>
